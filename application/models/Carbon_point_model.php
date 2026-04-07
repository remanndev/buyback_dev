<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carbon_point_model extends CI_Model
{
    private function normalize_phone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$phone);

        if (strpos($phone, '82') === 0 && strlen($phone) >= 11) {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }



    public function process_member_matches($requestNo, $rlvtDe, $sourceFile, array $members)
    {
        $matched_count   = 0; // 회원 기준 매칭 성공 수
        $unmatched_count = 0; // 회원 기준 매칭 실패 수
        $updated_count   = 0; // 실제 donation 업데이트 건수
        $skipped_count   = 0;

        $matched_rows   = [];
        $unmatched_rows = [];
        $skipped_rows   = [];

        $this->db->trans_begin();

        try {
            foreach ($members as $member) {
                $mtchgId   = isset($member['mtchgId']) ? trim($member['mtchgId']) : '';
                $usernm    = isset($member['usernm']) ? trim($member['usernm']) : '';
                $moblphon  = isset($member['moblphon']) ? $this->normalize_phone($member['moblphon']) : '';
                $mbrAditCd = isset($member['mbrAditCd']) ? trim($member['mbrAditCd']) : 'A';

                if ($mtchgId === '' || $moblphon === '') {
                    $skipped_count++;
                    $skipped_rows[] = [
                        'mtchgId'  => $mtchgId,
                        'usernm'   => $usernm,
                        'moblphon' => $moblphon,
                        'reason'   => 'mtchgId or moblphon is empty'
                    ];
                    continue;
                }

                if ($mbrAditCd === 'D') {
                    $skipped_count++;
                    $skipped_rows[] = [
                        'mtchgId'  => $mtchgId,
                        'usernm'   => $usernm,
                        'moblphon' => $moblphon,
                        'reason'   => 'member deleted'
                    ];
                    continue;
                }

                // 실적 인정 가능한 donation만 조회
                $rows = $this->db
                    ->select('d.idx, d.donor_name, d.cellphone, d.donor_phone, d.mtchg_id, d.handout_finish_date')
                    ->from('donation d')
                    ->join('donation_goods g', 'g.dn_idx = d.idx', 'inner')
                    ->where('d.donor_phone', $moblphon)
                    ->where('d.state_handout_finish', 1)      // 검수 완료
                    ->where('d.handout_finish_date IS NOT NULL', null, false) // 검수완료일 있음
                    ->where('d.delete IS NULL', null, false)  // 삭제 안됨
                    ->where('d.cancel IS NULL', null, false)  // 취소 안됨
                    ->where('d.mtchg_id IS NULL', null, false) // 아직 실적 매칭 안됨
                    ->where('g.gd_type', '스마트폰')
                    ->group_by('d.idx')
                    ->order_by('d.idx', 'ASC')
                    ->get()
                    ->result_array();

                if (!empty($rows)) {
                    foreach ($rows as $donation) {
                        $this->db->where('idx', $donation['idx']);
						/*
                        $this->db->update('donation', [
                            'mtchg_id' => $mtchgId
                        ]);
						*/
						$this->db->update('donation', [
							'mtchg_id'          => $mtchgId,
							'carbon_status'     => 'READY',
							'carbon_request_no' => $requestNo,
							'carbon_rlvt_de'    => $rlvtDe
						]);
						
                        $affected = $this->db->affected_rows();
                        $updated_count += $affected;

                        $matched_rows[] = [
                            'donation_idx'        => $donation['idx'],
                            'donor_name'          => $donation['donor_name'],
                            'cellphone'           => $donation['cellphone'],
                            'donor_phone'         => $donation['donor_phone'],
                            'handout_finish_date' => $donation['handout_finish_date'],
                            'mtchg_id'            => $mtchgId,
                            'affected_rows'       => $affected
                        ];
                    }

                    $matched_count++;
                } else {
                    $unmatched_count++;
                    $unmatched_rows[] = [
                        'mtchgId'   => $mtchgId,
                        'usernm'    => $usernm,
                        'moblphon'  => $moblphon,
                        'reason'    => 'no eligible donation with smartphone goods'
                    ];
                }
            }

            if ($this->db->trans_status() === false) {
                throw new Exception('DB transaction failed');
            }

            $this->db->trans_commit();

            return [
                'requestNo'       => $requestNo,
                'rlvtDe'          => $rlvtDe,
                'sourceFile'      => $sourceFile,
                'matched_count'   => $matched_count,
                'unmatched_count' => $unmatched_count,
                'updated_count'   => $updated_count,
                'skipped_count'   => $skipped_count,
                'matched_rows'    => $matched_rows,
                'unmatched_rows'  => $unmatched_rows,
                'skipped_rows'    => $skipped_rows
            ];

        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw $e;
        }
    }

	/**
	 * 참고.
	 * AND (d.carbon_status IS NULL OR d.carbon_status IN ('READY','FAIL'))
	*/
	public function get_export_rows($rlvtDe)
	{
		$sql = "
			SELECT
				d.mtchg_id AS mtchgId,
				'I0007' AS incntvCd,
				SUM(COALESCE(g.gd_amt, 0)) AS acrsCo,
				0 AS dtlAcrs
			FROM donation d
			INNER JOIN donation_goods g
				ON g.dn_idx = d.idx
			WHERE d.state_handout_finish = 1
			  AND d.handout_finish_date IS NOT NULL
			  AND d.delete IS NULL
			  AND d.cancel IS NULL
			  AND d.mtchg_id IS NOT NULL
			  AND d.mtchg_id <> ''
			  AND d.carbon_status IN ('READY', 'FAIL')
			  AND g.gd_type = '스마트폰'
			  AND DATE_FORMAT(d.handout_finish_date, '%Y%m%d') = ?
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

	public function mark_exported($rlvtDe, $fileName, array $mtchgIds)
	{
		if (empty($mtchgIds)) {
			return 0;
		}

		$this->db->trans_begin();

		try {
			$this->db
				->select('d.idx')
				->from('donation d')
				->join('donation_goods g', 'g.dn_idx = d.idx', 'inner')
				->where('d.state_handout_finish', 1)
				->where('d.handout_finish_date IS NOT NULL', null, false)
				->where('d.delete IS NULL', null, false)
				->where('d.cancel IS NULL', null, false)
				->where_in('d.mtchg_id', $mtchgIds)
				->where('g.gd_type', '스마트폰')
				->where("DATE_FORMAT(d.handout_finish_date, '%Y%m%d') = '{$rlvtDe}'", null, false)
				->group_by('d.idx');

			$rows = $this->db->get()->result_array();

			if (empty($rows)) {
				$this->db->trans_commit();
				return 0;
			}

			$idxList = array_column($rows, 'idx');

			$this->db->where_in('idx', $idxList);
			$this->db->update('donation', [
				'carbon_status'      => 'EXPORTED',
				'carbon_export_file' => $fileName,
				'carbon_exported_at' => date('Y-m-d H:i:s'),
				'carbon_fail_reason' => null
			]);

			$affected = $this->db->affected_rows();

			if ($this->db->trans_status() === false) {
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