<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addoperator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($_SESSION['role'] == 'super_admin') {
            // echo FCPATH; die;
            $data = [];
            if ($this->input->post()) {

                $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
                // echo $ext; 
                $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
                // echo $new_name; die;
                $config = [
                    'upload_path' => FCPATH . 'operator_image',
                    'allowed_types' => 'gif|jpg|png|jpeg',
                    'file_name' => $new_name
                ];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('op_logo')) {
                    $data['op_logo'] = $this->upload->data();
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                    //    print_r($data['upload_error']); die;
                    $this->load->view('addoperator', $data);
                }


                $service = $this->input->post('service');

                $input = [
                    'opcode' => $this->input->post('op_code'),
                    'operator' => $this->input->post('op_name'),
                    'op_logo' => $data['op_logo']['file_name'],
                ];

                if (!empty($input)) {
                    if ($service == 'mobile') {
                        $insert = $this->db->insert('tbl_operator', $input);
                    }

                    if ($service == 'dth') {
                        $insert = $this->db->insert('tbl_dth_operator', $input);
                    }

                    if ($service == 'electric_bill') {
                        $insert = $this->db->insert('tbl_services', $input);
                    }

                    if ($service == 'postpaid') {
                        $insert = $this->db->insert('tbl_postpaid_operator', $input);
                    }

                    if ($service == 'fastag') {
                        $insert = $this->db->insert('tbl_fastag_operator', $input);
                    }

                    if ($service == 'loan') {
                        $insert = $this->db->insert('tbl_loan_operator', $input);
                    }

                    if ($service == 'lpg_gas') {
                        $insert = $this->db->insert('tbl_lpg_operator', $input);
                    }

                    if($service == 'insurance'){
                        $insert = $this->db->insert('tbl_insurance_operator', $input);
                    }

                    if($service == 'broadband'){
                        $insert = $this->db->insert('tbl_broadband_operator', $input);
                    }

                    if($service == 'municiple'){
                        $insert = $this->db->insert('tbl_municiple_operator', $input);
                    }

                    if($service == 'credit'){
                        $insert = $this->db->insert('tbl_creditcard_operator', $input);
                    }

                    if($service == 'landline'){
                        $insert = $this->db->insert('tbl_landline_operator', $input);
                    }

                    if($service == 'cable'){
                        $insert = $this->db->insert('tbl_cable_operator', $input);
                    }

                    if($service == 'subscription'){
                        $insert = $this->db->insert('tbl_subscription_operator', $input);
                    }

                    if ($insert) {
                        redirect('viewoperator', 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }

            $this->load->view('addoperator', $data);
        } else {
            redirect('Login', 'refresh');
        }
    }
}
