<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Recharge_model');
        // $this->load->library('curl');
    }

    public function index()
    {
        $status = $this->input->get('status');
        $opid = $this->input->get('opid');
        $clientid = $this->input->get('yourtransid');
        $number = $this->input->get('number');
        $amount = $this->input->get('amount');
        $msg = $this->input->get('message');

        date_default_timezone_set('Asia/Kolkata');
        $data = array(
            'status' => $status,
            'opt_trans_id' => $opid,
            'trans_id' => $clientid,
            'number' => $number,
            'amount' => $amount,
            'message' => $msg,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->db->where('trans_id', $clientid);
        $this->db->update('tbl_recharge', $data);
    }

    public function Utility()
    {
        $status = $this->input->get('StatusMsg');
        $OprID = $this->input->get('OprID');
        $TrnID = $this->input->get('TrnID');
        $DP = $this->input->get('DP');
        $DR = $this->input->get('DR');
        $ClientRefNo = $this->input->get('ClientRefNo');

        date_default_timezone_set('Asia/Kolkata');
        $data = array(
            'status_msg' => $status,
            'operator_id' => $OprID,
            'trans_id' => $TrnID,
            'dp' => $DP,
            'dr' => $DR,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_electric_bill_pay', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_postpaid', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_fastag_recharge', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_loan_payment', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('lpg_gas_payment', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_insurance_pay', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_municiple_pay', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_creditcard', $data);

        $this->db->where('ref_no', $ClientRefNo);
        $this->db->update('tbl_broadband', $data);

        $balance = $this->db->get('tbl_utility_balance')->row_array();
        $api_balance = $balance['balance'];
        // echo $api_balance; die;
        $current_balance = $api_balance + $DR;

        $history = [
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'amount' => $DR,
            'balance' => $current_balance,
            'cr_dr' => 'Credit',
            'remarks' => 'Margin'
        ];

        $this->db->insert('tbl_utility_api_history', $history);
    }
}
