<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Apiutilityreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $query_usertype = $this->db->get('user_type');
        $data['user_types'] = $query_usertype->result_array();

        $data['apibalhists'] = $this->db->order_by('id', 'desc')->get('tbl_utility_api_history')->result_array();

        if ($this->input->post() != NULL) {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $cust_id = $this->input->post('cust_id');
            $user_type = $this->input->post('user_type');
            $user = $this->input->post('user');

            if (!empty($from_date && $to_date) && empty($cust_id && $user_type && $user)) {
                $data['apibalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM tbl_utility_api_history WHERE date BETWEEN '{$from_date}' AND '{$to_date}'")->result_array();
            }

            if (!empty($cust_id) && empty($from_date && $to_date && $user_type && $user)) {

                $data['apibalhists'] = $this->db->order_by('id', 'desc')->get_where('tbl_utility_api_history', ['customer_id' => $cust_id])->result_array();
            }

            if (!empty($user_type && $user) && empty($cust_id && $to_date && $from_date)) {

                $data['apibalhists'] = $this->db->order_by('id', 'desc')->get_where('tbl_utility_api_history', ['user_mobile' => $user])->result_array();
            }

            if (!empty($from_date && $to_date && $cust_id) && empty($user_type && $user)) {
                $data['apibalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM tbl_utility_api_history WHERE date BETWEEN '{$from_date}' AND '{$to_date}' AND customer_id = $cust_id ")->result_array();
            }

            if (!empty($from_date && $to_date && $user_type && $user) && empty($cust_id)) {
                $data['apibalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM tbl_utility_api_history WHERE date BETWEEN '{$from_date}' AND '{$to_date}' AND user_mobile = $user ")->result_array();
            }
        }

        $this->load->view('apiutilityreport', $data);
    }

    public function getUser()
    {
        $user_type = $this->input->post('user_type');

        // Get the user_type_id
        $users_id = $this->db->get_where('user_type', ['slug' => $user_type])->row_array();
        $user_type_id = $users_id['id'];

        // Get users based on the conditions
        $this->db->where('account_type', $user_type_id);
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);

        $users = $this->db->get('users')->result_array();

        $opt = "<option value=''>Select User</option>";
        foreach ($users as $user) {
            $opt .= "<option value='" . $user['mobile'] . "'>" . $user['name'] . " - " . $user['mobile'] . "</option>";
        }

        // Return the options as JSON
        echo json_encode(['options' => $opt]);
    }
}
