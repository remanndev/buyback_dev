<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyback_ros_api
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('buyback');
    }

    public function send_request($partner, $request)
    {
        $url = $this->resolve_url();
        $key = $this->resolve_key();

        if ($url === '' || $key === '') {
            return array(
                'success' => false,
                'ros_wa_id' => null,
                'request_payload' => '',
                'response_payload' => '',
                'error_message' => 'ROS endpoint or key is not configured.',
            );
        }

        if (!function_exists('curl_init')) {
            return array(
                'success' => false,
                'ros_wa_id' => null,
                'request_payload' => '',
                'response_payload' => '',
                'error_message' => 'cURL extension is not available.',
            );
        }

        $payload = $this->build_payload($partner, $request, $key);
        $request_payload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $response = $this->post_form($url, $payload);

        if (!$response['success']) {
            return array(
                'success' => false,
                'ros_wa_id' => null,
                'request_payload' => $request_payload,
                'response_payload' => $response['body'],
                'error_message' => $response['error_message'],
            );
        }

        $ros_wa_id = $this->extract_ros_wa_id($response['body']);
        if ($ros_wa_id === null) {
            return array(
                'success' => false,
                'ros_wa_id' => null,
                'request_payload' => $request_payload,
                'response_payload' => $response['body'],
                'error_message' => 'ROS response did not include a valid work request id.',
            );
        }

        return array(
            'success' => true,
            'ros_wa_id' => $ros_wa_id,
            'request_payload' => $request_payload,
            'response_payload' => $response['body'],
            'error_message' => '',
        );
    }

    protected function resolve_url()
    {
        return trim((string) $this->ci->config->item('buyback_ros_url'));
    }

    protected function resolve_key()
    {
        return trim((string) $this->ci->config->item('buyback_ros_key'));
    }

    protected function build_payload($partner, $request, $key)
    {
        $devices = isset($request['devices']) && is_array($request['devices']) ? $request['devices'] : array();
        $items = array();
        $item_labels = array();

        foreach ($devices as $device) {
            $label = trim(
                (isset($device['device']) ? $device['device'] : '') . ' ' .
                (isset($device['manufacturer']) ? $device['manufacturer'] : '') . ' ' .
                (isset($device['model']) ? $device['model'] : '')
            );
            $item_labels[] = trim($label) !== '' ? trim($label) : 'device';
            $items[] = array(
                'device_type' => isset($device['device']) ? $device['device'] : '',
                'manufacturer' => isset($device['manufacturer']) ? $device['manufacturer'] : '',
                'model_name' => isset($device['model']) ? $device['model'] : '',
                'condition_grade' => isset($device['condition']) ? $device['condition'] : '',
                'qty' => isset($device['qty']) ? (int) $device['qty'] : 1,
                'unit_price_value' => isset($device['unit_price_value']) ? (int) $device['unit_price_value'] : 0,
            );
        }

        return array(
            'id' => (int) $request['id'],
            'request_no' => isset($request['request_no']) ? $request['request_no'] : '',
            'partner' => isset($partner['name']) ? $partner['name'] : '',
            'partner_slug' => isset($partner['slug']) ? $partner['slug'] : '',
            'name' => isset($request['applicant_name']) ? $request['applicant_name'] : '',
            'phone' => isset($request['phone']) ? $request['phone'] : '',
            'items' => json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'itemstr' => implode(', ', $item_labels),
            'rmk' => isset($request['pickup_memo']) ? $request['pickup_memo'] : '',
            'visit_date' => isset($request['visit_date']) ? $request['visit_date'] : '',
            'visit_time' => isset($request['visit_time']) ? $request['visit_time'] : '',
            'pickup_location' => isset($request['pickup_location']) ? $request['pickup_location'] : '',
            'address' => trim(
                (isset($request['postcode']) ? $request['postcode'] : '') . ' ' .
                (isset($request['address1']) ? $request['address1'] : '') . ' ' .
                (isset($request['address2']) ? $request['address2'] : '')
            ),
            'bank_name' => isset($request['bank_name']) ? $request['bank_name'] : '',
            'account_number' => isset($request['account_number']) ? $request['account_number'] : '',
            'total_price_value' => isset($request['total_price_value']) ? (int) $request['total_price_value'] : 0,
            'key' => $key,
        );
    }

    protected function post_form($url, $data)
    {
        foreach ($data as $key => $value) {
            $value = str_replace(array("\r\n", "\r", "\n"), "\\n", (string) $value);
            $data[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
        }

        $post_field_string = http_build_query($data, '', '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        ));
        curl_setopt($ch, CURLOPT_POST, true);

        $body = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false || $error !== '') {
            return array(
                'success' => false,
                'body' => is_string($body) ? $body : '',
                'error_message' => $error !== '' ? $error : 'Unknown cURL error.',
            );
        }

        if ($http_code >= 400) {
            return array(
                'success' => false,
                'body' => $body,
                'error_message' => 'ROS request failed with HTTP ' . $http_code,
            );
        }

        return array(
            'success' => true,
            'body' => $body,
            'error_message' => '',
        );
    }

    protected function extract_ros_wa_id($response_body)
    {
        $trimmed = trim((string) $response_body);
        if ($trimmed === '') {
            return null;
        }

        if (ctype_digit($trimmed)) {
            return (int) $trimmed;
        }

        $decoded = json_decode($trimmed, true);
        if (is_array($decoded)) {
            foreach (array('ros_wa_id', 'wa_id', 'id') as $field) {
                if (isset($decoded[$field]) && is_numeric($decoded[$field])) {
                    return (int) $decoded[$field];
                }
            }
        }

        return null;
    }
}
