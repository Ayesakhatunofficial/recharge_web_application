<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Showcommission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($_SESSION['slug'] || $_SESSION['role']) {

            if ($_SESSION['slug']) {

                $admin_id = $_SESSION['user_id'];

                $data['commissions'] = $this->db->get_where('show_commission', ['created_by' => $admin_id])->result_array();
            } else if ($_SESSION['role']) {

                $created_by = $_SESSION['role'];

                $data['commissions'] = $this->db->get_where('show_commission', ['created_by' => $created_by])->result_array();
            }

            // echo '<pre>';
            // print_r($data['commissions']);
            // die;

            $this->load->view('showcommission', $data);
        } else {
            redirect('userlogin');
        }
    }

    public function add()
    {
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
                print_r($data['upload_error']);
                die;
                $this->load->view('add_showcommission', $data);
            }

            if ($_SESSION['role']) {

                $created_by = $_SESSION['role'];
            } else if ($_SESSION['slug']) {

                $created_by = $_SESSION['user_id'];
            }

            $input = [
                'service' => $this->input->post('service_name'),
                'operator_code' => $this->input->post('operator'),
                'op_logo' => $data['op_logo']['file_name'],
                'type' => $this->input->post('commission_type'),
                'amount' => $this->input->post('amount'),
                'created_by' => $created_by,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // print_r($input);
            // die;

            $result = $this->db->insert('show_commission', $input);

            if ($result) {
                redirect('showcommission');
            } else {
                redirect('showcommission/add');
            }
        }
        $this->load->view('add_showcommission');
    }


    public function edit($id)
    {
        $data['commission'] = $this->db->get_where('show_commission', ['id' => $id])->row_array();

        if ($data['commission']['service'] == 'mobile') {
            $data['operators'] = $this->db->get_where('tbl_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'dth') {
            $data['operators'] = $this->db->get_where('tbl_dth_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'electric') {
            $data['operators'] = $this->db->get_where('tbl_services', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'postpaid') {
            $data['operators'] = $this->db->get_where('tbl_postpaid_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'fastag') {
            $data['operators'] = $this->db->get_where('tbl_fastag_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'loan') {
            $data['operators'] = $this->db->get_where('tbl_loan_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'lpg_gas') {
            $data['operators'] = $this->db->get_where('tbl_lpg_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'insurance') {
            $data['operators'] = $this->db->get_where('tbl_insurance_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'broadband') {
            $data['operators'] = $this->db->get_where('tbl_broadband_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'municiple') {
            $data['operators'] = $this->db->get_where('tbl_municiple_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'credit') {
            $data['operators'] = $this->db->get_where('tbl_creditcard_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'landline') {
            $data['operators'] = $this->db->get_where('tbl_landline_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'cable') {
            $data['operators'] = $this->db->get_where('tbl_cable_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        } else if ($data['commission']['service'] == 'subscription') {
            $data['operators'] = $this->db->get_where('tbl_subscription_operator', ['opcode' => $data['commission']['operator_code']])->row_array();
        }


        if ($this->input->post() != NULL) {

            $com = $this->db->get_where('show_commission', ['id' => $id])->row_array();

            if ($_FILES["op_logo"]['name'] != '') {

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
                    print_r($data['upload_error']);
                    die;
                }

                unlink(FCPATH . 'operator_image/' . $com['op_logo']);
            }

            $input = [
                'op_logo' => isset($data['op_logo']['file_name']) ? $data['op_logo']['file_name'] : $com['op_logo'],
                'type' => $this->input->post('commission_type'),
                'amount' => $this->input->post('amount'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->where('id', $id);
            $result = $this->db->update('show_commission', $input);

            if ($result) {
                redirect('showcommission');
            }
        }

        $this->load->view('edit_showcommission', $data);
    }


    public function delete($id)
    {
        $this->db->delete('show_commission', ['id' => $id]);

        redirect('showcommission');
    }



    public function getOperator()
    {
        $service = $this->input->post('service');
        // echo $service; 
        if ($service == "mobile") {
            $operators = $this->db->get('tbl_operator')->result_array();
            // print_r($operators) ;
        }
        if ($service == "dth") {
            $operators = $this->db->get('tbl_dth_operator')->result_array();
        }
        if ($service == 'electric') {
            $operators = $this->db->get('tbl_services')->result_array();
        }
        if ($service == 'postpaid') {
            $operators = $this->db->get('tbl_postpaid_operator')->result_array();
        }

        if ($service == 'loan') {
            $operators = $this->db->get('tbl_loan_operator')->result_array();
        }

        if ($service == 'fastag') {
            $operators = $this->db->get('tbl_fastag_operator')->result_array();
        }

        if ($service == 'lpg_gas') {
            $operators = $this->db->get('tbl_lpg_operator')->result_array();
        }

        if ($service == 'insurance') {
            $operators = $this->db->get('tbl_insurance_operator')->result_array();
        }

        if ($service == 'broadband') {
            $operators = $this->db->get('tbl_broadband_operator')->result_array();
        }

        if ($service == 'municiple') {
            $operators = $this->db->get('tbl_municiple_operator')->result_array();
        }

        if ($service == 'credit') {
            $operators = $this->db->get('tbl_creditcard_operator')->result_array();
        }

        if ($service == 'landline') {
            $operators = $this->db->get('tbl_landline_operator')->result_array();
        }

        if ($service == 'cable') {
            $operators = $this->db->get('tbl_cable_operator')->result_array();
        }

        if ($service == 'subscription') {
            $operators = $this->db->get('tbl_subscription_operator')->result_array();
        }

        $opt = "<option value=''>Select Operator</option>";
        $opt .= "<option value='all'>All</option>";
        foreach ($operators as $operator) {
            $opt .= "<option value='" . $operator['opcode'] . "'>" . $operator['operator'] . "</option>";
        }

        echo json_encode(['options' => $opt]);
    }
}
