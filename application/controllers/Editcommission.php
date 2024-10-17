<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Editcommission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index($id)
    {
        
        $data['user_types'] = $this->db->get('user_type')->result_array();
        $data['plans'] = $this->db->get('plans')->result_array();
        $data['services'] = $this->db->get('services')->result_array();
        $data['mob_operators'] = $this->db->get('tbl_operator')->result_array();

        $data['commission'] = $this->db->get_where('commission', ['id' => $id])->row_array();

        if ($data['commission']['service'] == 'mobile') {
            $data['operators'] = $this->db->get_where('tbl_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'dth') {
            $data['operators'] = $this->db->get_where('tbl_dth_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'electric') {
            $data['operators'] = $this->db->get_where('tbl_services', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'postpaid') {
            $data['operators'] = $this->db->get_where('tbl_postpaid_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'fastag') {
            $data['operators'] = $this->db->get_where('tbl_fastag_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'loan') {
            $data['operators'] = $this->db->get_where('tbl_loan_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'lpg_gas') {
            $data['operators'] = $this->db->get_where('tbl_lpg_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'insurance') {
            $data['operators'] = $this->db->get_where('tbl_insurance_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'broadband') {
            $data['operators'] = $this->db->get_where('tbl_broadband_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'municiple') {
            $data['operators'] = $this->db->get_where('tbl_municiple_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'credit') {
            $data['operators'] = $this->db->get_where('tbl_creditcard_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        } else if ($data['commission']['service'] == 'landline') {
            $data['operators'] = $this->db->get_where('tbl_landline_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        }else if ($data['commission']['service'] == 'cable') {
            $data['operators'] = $this->db->get_where('tbl_cable_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        }else if ($data['commission']['service'] == 'subscription') {
            $data['operators'] = $this->db->get_where('tbl_subscription_operator', ['opcode' => $data['commission']['mob_operator']])->row_array();
        }

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $input = [
                'id' => $this->input->post('id'),
                'user_type' => $this->input->post('user_type'),
                'plan' => $this->input->post('plan'),
                // 'service' => $this->input->post('service_name'),
                'commission_type' => $this->input->post('commission_type'),
                // 'mob_operator' => $this->input->post('mob_operator'),
                'fp_amount' => $this->input->post('fp_amount'),
                // 'from_amount' => $this->input->post('from_amount'),
                // 'to_amount' => $this->input->post('to_amount'),
                // 'tds_gst' => $this->input->post('tds_gst'),
                // 'chain_type' => $this->input->post('chain_type'),
                // 'transaction_type' => $this->input->post('transaction_type'),
                // 'specific_user' => $this->input->post('specific_user')
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $input['id']]);
                $this->db->update('commission', $input);

                //---------------- Last query ----------------//
                // print_r($this->db->last_query()); die;

                //-------------- affected rows ----------------//
                // $affectedRows = $this->db->affected_rows();

                // echo $affectedRows; die;

                //---------------- error in db ----------------//
                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Commission update query failed");
                } else {
                    redirect('viewcommission', 'refresh');
                }
            }
        }

        $this->load->view('editcommission', $data);
    }
}
