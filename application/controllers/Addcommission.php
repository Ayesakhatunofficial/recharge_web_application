<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addcommission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    // public function index()
    // {
    //     if ($_SESSION['role'] == 'super_admin') {
    //         $query_usertype = $this->db->get('user_type');
    //         $data['user_types'] = $query_usertype->result_array();

    //         $query_plan = $this->db->get("plans");
    //         $data['plans'] = $query_plan->result_array();

    //         $query_service = $this->db->get('services');
    //         $data['services'] = $query_service->result_array();

    //         // echo "<pre>"; print_r($data['services']); die;

    //         $query_mob_op = $this->db->get('tbl_operator');
    //         $data['mob_operators'] = $query_mob_op->result_array();

    //         // print_r($data['mob_operators']); die;

    //         $input = [];

    //         if ($this->input->post() != NULL) {
    //             $input = [
    //                 'user_type' => $this->input->post('user_type'),
    //                 // 'plan' => $this->input->post('plan'),
    //                 // 'service' => $this->input->post('service'),
    //                 'mob_operator' => $this->input->post('mob_operator'),
    //                 // 'commission_type' => $this->input->post('commission_type'),
    //                 'fp_amount' => $this->input->post('fp_amount'),
    //                 // 'from_amount' => $this->input->post('from_amount'),
    //                 // 'to_amount' => $this->input->post('to_amount'),
    //                 // 'tds_gst' => $this->input->post('tds_gst'),
    //                 // 'chain_type' => $this->input->post('chain_type'),
    //                 // 'transaction_type' => $this->input->post('transaction_type'),
    //                 // 'specific_user' => $this->input->post('specific_user')
    //             ];

    //             echo "<pre>";
    //             print_r($input);
    //             die('Here input');

    //             if (!empty($input)) {
    //                 $insert = $this->db->insert('commission', $input);

    //                 $affectedRows = $this->db->affected_rows();

    //                 if ($affectedRows) {
    //                     redirect('viewcommission', 'refresh');
    //                 } else {
    //                     die("insert query failed");
    //                 }
    //             }
    //         }

    //         $this->load->view('addcommission', $data);
    //     } else {
    //         redirect('Login', 'refresh');
    //     }
    // }

    public function index()
    {
        if ($_SESSION['role'] == 'super_admin') {
            $query_usertype = $this->db->get('user_type');
            $data['user_types'] = $query_usertype->result_array();

            $query_plan = $this->db->get("plans");
            $data['plans'] = $query_plan->result_array();

            // $query_service = $this->db->get('services');
            // $data['services'] = $query_service->result_array();

            // $query_mob_op = $this->db->get('tbl_operator');
            // $data['mob_operators'] = $query_mob_op->result_array();

            if ($this->input->post()) {
                $role = $_SESSION['role'];
                $input = [
                    'user_type' => $this->input->post('user_type'),
                    'user_id' => $this->input->post('user'),
                    'service' => $this->input->post('service_name'),
                    'mob_operator' => $this->input->post('mob_operator'),
                    'commission_type' => $this->input->post('commission_type'),
                    'fp_amount' => $this->input->post('fp_amount'),
                    'created_by' => $role
                ];

                // Debugging: Output the input data
                // echo "<pre>";
                // print_r($input);
                // die;

                if (!empty($input)) {
                    $insert = $this->db->insert('commission', $input);

                    if ($insert) {
                        redirect('viewcommission', 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }

            $this->load->view('addcommission', $data);
        } else if ($_SESSION['slug'] == 'admin') {
            $data = [];
            $data['user_types'] = $this->db->query("SELECT * from user_type where slug != 'admin'")->result_array();

            if ($this->input->post()) {
                $id = $_SESSION['user_id'];
                $input = [
                    'user_type' => $this->input->post('user_type'),
                    'user_id' => $this->input->post('user'),
                    'service' => $this->input->post('service_name'),
                    'mob_operator' => $this->input->post('mob_operator'),
                    'commission_type' => $this->input->post('commission_type'),
                    'fp_amount' => $this->input->post('fp_amount'),
                    'created_by' => $id
                ];

                // Debugging: Output the input data
                // echo "<pre>";
                // print_r($input);
                // die;

                if (!empty($input)) {
                    $insert = $this->db->insert('commission', $input);

                    if ($insert) {
                        redirect('viewcommission', 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }


            $this->load->view('addcommission', $data);
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function getUser()
    {

        $user_type = $this->input->post('user_type');

        // Get the user_type_id
        $users_id = $this->db->get_where('user_type', ['slug' => $user_type])->row_array();
        $user_type_id = $users_id['id'];

        if (isset($_SESSION['role'])) {
            $this->db->where('account_type', $user_type_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);

            $users = $this->db->get('users')->result_array();
        } else if ($_SESSION['slug'] == 'admin') {
            $id = $_SESSION['user_id'];

            $this->db->where('account_type', $user_type_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            $this->db->where('created_by_id', $id);

            $users = $this->db->get('users')->result_array();
        }
        // Get users based on the conditions


        $opt = "<option value=''>Select User</option>";
        foreach ($users as $user) {
            $opt .= "<option value='" . $user['id'] . "'>" . $user['name'] . " - " . $user['mobile'] . "</option>";
        }

        // Return the options as JSON
        echo json_encode(['options' => $opt]);
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
