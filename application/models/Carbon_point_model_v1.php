<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carbon_point_model extends CI_Model
{
    private function normalize_phone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$phone);

        // 필요 시 82 국가번호 처리
        if (strpos($phone, '82') === 0 && strlen($phone) >= 11) {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }

    public function process_member_matches($requestNo, $rlvtDe, $sourceFile, array $members)
    {
        $matchedCount = 0;
        $insertedCount = 0;
        $updatedDonationCount = 0;
        $skippedCount = 0;

        $this->db->trans_begin();

        try {
            foreach ($members as $member) {
                $mtchgId   = isset($member['mtchgId']) ? trim($member['mtchgId']) : '';
                $userName  = isset($member['usernm']) ? trim($member['usernm']) : '';
                $phone     = isset($member['moblphon']) ? $this->normalize_phone($member['moblphon']) : '';
                $mbrAditCd = isset($member['mbrAditCd']) ? trim($member['mbrAditCd']) : 'A';

                if ($mtchgId === '' || $phone === '') {
                    $skippedCount++;
                    continue;
                }

                $activeYn = ($mbrAditCd === 'D') ? 'N' : 'Y';

                $matchRow = [
                    'phone'       => $phone,
                    'user_name'   => $userName,
                    'mtchg_id'    => $mtchgId,
                    'request_no'  => $requestNo,
                    'rlvt_de'     => $rlvtDe,
                    'mbr_adit_cd' => $mbrAditCd,
                    'active_yn'   => $activeYn,
                    'raw_payload' => json_encode($member, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                ];

                // upsert 대체 처리
                $exists = $this->db->get_where('carbon_member_match', [
                    'request_no' => $requestNo,
                    'mtchg_id'   => $mtchgId
                ])->row_array();

                if ($exists) {
                    $this->db->where('id', $exists['id'])->update('carbon_member_match', $matchRow);
                } else {
                    $this->db->insert('carbon_member_match', $matchRow);
                    $insertedCount++;
                }

                if ($activeYn === 'Y') {
                    // 승인 완료 + 전화번호 일치하는 donation에 mtchg_id 반영
                    $this->db->set('mtchg_id', $mtchgId);
                    $this->db->set('carbon_request_no', $requestNo);
                    $this->db->set('carbon_rlvt_de', $rlvtDe);
                    $this->db->where('donor_phone', $phone);
                    $this->db->where('approved_yn', 'Y');
                    $this->db->where("(mtchg_id IS NULL OR mtchg_id = '')", null, false);
                    $this->db->update('donation');

                    $affected = $this->db->affected_rows();
                    if ($affected > 0) {
                        $matchedCount++;
                        $updatedDonationCount += $affected;
                    }
                }
            }

            $this->db->insert('carbon_file_history', [
                'file_type'       => 'MBR_INFO',
                'file_name'       => $sourceFile,
                'request_no'      => $requestNo,
                'rlvt_de'         => $rlvtDe,
                'process_status'  => 'DONE',
                'process_log'     => json_encode([
                    'matched_count' => $matchedCount,
                    'inserted_count' => $insertedCount,
                    'updated_donation_count' => $updatedDonationCount,
                    'skipped_count' => $skippedCount
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ]);

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('DB transaction failed');
            }

            $this->db->trans_commit();

            return [
                'matched_count' => $matchedCount,
                'inserted_count' => $insertedCount,
                'updated_donation_count' => $updatedDonationCount,
                'skipped_count' => $skippedCount
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();

            $this->db->insert('carbon_file_history', [
                'file_type'      => 'MBR_INFO',
                'file_name'      => $sourceFile,
                'request_no'     => $requestNo,
                'rlvt_de'        => $rlvtDe,
                'process_status' => 'FAIL',
                'process_log'    => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function get_export_rows($requestNo, $rlvtDe)
    {
        // rlvtDe를 승인일 기준으로 쓸 경우
        $sql = "
            SELECT
                d.mtchg_id AS mtchgId,
                'I0007' AS incntvCd,
                COUNT(*) AS acrsCo,
                0 AS dtlAcrs
            FROM donation d
            WHERE d.approved_yn = 'Y'
              AND d.mtchg_id IS NOT NULL
              AND d.mtchg_id <> ''
              AND DATE_FORMAT(d.approved_at, '%Y%m%d') = ?
              AND (d.carbon_status IS NULL OR d.carbon_status IN ('READY', 'FAIL'))
            GROUP BY d.mtchg_id
            ORDER BY d.mtchg_id ASC
        ";

        $rows = $this->db->query($sql, [$rlvtDe])->result_array();

        foreach ($rows as &$row) {
            $row['acrsCo'] = (int)$row['acrsCo'];
            $row['dtlAcrs'] = (int)$row['dtlAcrs'];
        }

        return $rows;
    }

    public function mark_exported($requestNo, $rlvtDe, $fileName, array $mtchgIds)
    {
        if (empty($mtchgIds)) {
            return 0;
        }

        $this->db->trans_begin();

        try {
            $this->db->set('carbon_status', 'EXPORTED');
            $this->db->set('carbon_export_file', $fileName);
            $this->db->set('carbon_exported_at', date('Y-m-d H:i:s'));
            $this->db->where_in('mtchg_id', $mtchgIds);
            $this->db->where('approved_yn', 'Y');
            $this->db->where("DATE_FORMAT(approved_at, '%Y%m%d') =", $rlvtDe, false);
            $this->db->update('donation');

            $affected = $this->db->affected_rows();

            $this->db->insert('carbon_file_history', [
                'file_type'      => 'ACRS',
                'file_name'      => $fileName,
                'request_no'     => $requestNo,
                'rlvt_de'        => $rlvtDe,
                'process_status' => 'DONE',
                'process_log'    => json_encode([
                    'exported_mtchg_ids' => $mtchgIds,
                    'affected_rows' => $affected
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ]);

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('DB transaction failed');
            }

            $this->db->trans_commit();

            return $affected;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw $e;
        }
    }
}