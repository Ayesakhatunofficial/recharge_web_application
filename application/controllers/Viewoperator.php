<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewoperator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {

        if ($_SESSION['role']) {
            //    $query_commission = $this->db->get('commission');
            //    $data['commissions'] = $query_commission->result_array();

            $data['operators'] = $this->db->order_by('id', 'desc')->get('tbl_operator')->result_array();
            $data['dth_operators'] = $this->db->order_by('id', 'desc')->get('tbl_dth_operator')->result_array();
            $data['electric_operators'] = $this->db->order_by('id', 'desc')->get('tbl_services')->result_array();
            $data['postpaid_operators'] = $this->db->order_by('id', 'desc')->get('tbl_postpaid_operator')->result_array();
            $data['loan_operators'] = $this->db->order_by('id', 'desc')->get('tbl_loan_operator')->result_array();
            $data['fastag_operators'] = $this->db->order_by('id', 'desc')->get('tbl_fastag_operator')->result_array();
            $data['lpg_gas_operators'] = $this->db->order_by('id', 'desc')->get('tbl_lpg_operator')->result_array();
            $data['insurance_operators'] = $this->db->order_by('id', 'desc')->get('tbl_insurance_operator')->result_array();
            $data['broadband_operators'] = $this->db->order_by('id', 'desc')->get('tbl_broadband_operator')->result_array();
            $data['municiple_operators'] = $this->db->order_by('id', 'desc')->get('tbl_municiple_operator')->result_array();
            $data['creditcard_operators'] = $this->db->order_by('id', 'desc')->get('tbl_creditcard_operator')->result_array();
            $data['landline_operators'] = $this->db->order_by('id', 'desc')->get('tbl_landline_operator')->result_array();
            $data['cable_operators'] = $this->db->order_by('id', 'desc')->get('tbl_cable_operator')->result_array();
            $data['subscription_operators'] = $this->db->order_by('id', 'desc')->get('tbl_subscription_operator')->result_array();



            // echo "<pre>"; print_r($data['commissions']); die("abc");

            $this->load->view('viewoperator', $data);
        } else {

            redirect('login');
        }
    }
}
