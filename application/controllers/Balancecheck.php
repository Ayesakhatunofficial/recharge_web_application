<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Balancecheck extends CI_Controller
{
    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        date_default_timezone_set('Asia/Kolkata');
        $token = 'FwBliKoRxs3r1uybiEx2';
        $userid = 12494;
        // echo $userid;die;
        $ch = curl_init();
        $url = 'https://status.rechargeexchange.com/API.asmx/BalanceNew?userid=' . $userid . '&token=' . $token;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        // echo $response;
        // die;

        $response = json_decode($response, true);

        $result = $this->db->get('tbl_balance')->row_array();
        $balance = $result['balance'];
        $api_balance = round($response['balance'], 3);

        // echo $balance;
        // echo $api_balance;

        if ($api_balance != $balance) {
            if ($balance < $response['balance']) {
                $amount = $response['balance'] - $balance;
                $history = [
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'amount' => $amount,
                    'balance' => $response['balance'],
                    'cr_dr' => 'Credit',
                    'remarks' => 'Amount Deposite',
                ];

                $this->db->insert('tbl_recharge_api_history', $history);
            }
            $data_1 = [
                'message' => $response['message'],
                'prev_balance' => $balance,
                'cur_balance' => $response['balance'],
                'created_at' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d')
            ];
            // print_r($data_1);

            if (!empty($data_1)) {
                $this->db->insert('tbl_balance_history', $data_1);
            }
        }


        $data = [
            'message' => $response['message'],
            'balance' => $response['balance'],
            'sell_balance' => $response['sellbalance'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // print_r($data);die;

        // echo $balance;
        // die;
        if ($result !== NULL) {
            $this->db->update('tbl_balance', $data);
        }
        if ($result == NULL) {
            $this->db->insert('tbl_balance', $data);
        }

        // print_r($data_1);

        // echo $response;
    }

    public function UtilityBalanceCheck()
    {
        $apiKey = 'boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ';
        $mobileNo = 8777846136;
        // echo $userid;die;
        $ch = curl_init();
        // $url = 'https://www.payoneapi.com/RechargeAPI/RechargeAPI.aspx?MobileNo=' . $mobileNo . '&APIKey=' . $apiKey . '&REQTYPE=BAL&RESPTYPE=JSON';
        $url = 'https://www.payoneapi.com/RechargeAPI/RechargeAPI.aspx?MobileNo=8777846136&APIKey=boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ&REQTYPE=BAL&RESPTYPE=JSON';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        // echo $response;
        // die;

        $response = json_decode($response, true);
        date_default_timezone_set('Asia/Kolkata');

        $result = $this->db->get('tbl_utility_balance')->row_array();
        $balance = $result['balance'];
        // $balance = 1000;
        $api_balance = round($response['DMRBALANCE'], 3);
        // echo $balance; die;

        if ($api_balance != $balance) {
            if ($api_balance > $balance) {
                $amount = $response['DMRBALANCE'] - $balance;
                $history = [
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'amount' => $amount,
                    'balance' => $response['DMRBALANCE'],
                    'cr_dr' => 'Credit',
                    'remarks' => 'Amount Deposite',
                ];
                $this->db->insert('tbl_utility_api_history', $history);
            }

            $data_1 = [
                'status_code' => $response['STATUSCODE'],
                'status_msg' => $response['STATUSMSG'],
                'prev_balance' => $balance,
                'cur_balance' => $response['DMRBALANCE'],
                'created_at' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d')
            ];
            // print_r($data_1); die;

            if (!empty($data_1)) {
                $this->db->insert('utility_balance_history', $data_1);
            }
        }

        $data = [
            'status_code' => $response['STATUSCODE'],
            'balance' => $response['DMRBALANCE'],
            'status_message' => $response['STATUSMSG'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        // $this->db->insert('tbl_utility_balance', $data);
        // print_r($data);
        // die;
        // $result = $this->Billpay_model->getBalanceData();

        // print_r($result);die;
        if ($result !== NULL) {
            $this->db->update('tbl_utility_balance', $data);
        }

        if ($result == NULL) {
            $this->db->insert('tbl_utility_balance', $data);
        }
    }
}
