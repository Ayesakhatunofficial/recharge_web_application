<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Apirechargereport extends CI_Controller
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

        $data['apibalhists'] = $this->db->order_by('id', 'desc')->get('tbl_recharge_api_history')->result_array();

        if ($this->input->post() != NULL) {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $mobile = $this->input->post('mobile');
            $user_type = $this->input->post('user_type');
            $user = $this->input->post('user');

            if (!empty($from_date && $to_date) && empty($mobile && $user_type && $user)) {
                $data['apibalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM tbl_recharge_api_history WHERE date BETWEEN '{$from_date}' AND '{$to_date}'")->result_array();
            }

            if (!empty($mobile) && empty($from_date && $to_date && $user_type && $user)) {

                $data['apibalhists'] = $this->db->order_by('id', 'desc')->get_where('tbl_recharge_api_history', ['number' => $mobile])->result_array();
            }

            if (!empty($user_type && $user) && empty($mobile && $to_date && $from_date)) {

                $data['apibalhists'] = $this->db->order_by('id', 'desc')->get_where('tbl_recharge_api_history', ['user_mobile' => $user])->result_array();
            }

            if (!empty($from_date && $to_date && $mobile) && empty($user_type && $user)) {
                $data['apibalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM tbl_recharge_api_history WHERE date BETWEEN '{$from_date}' AND '{$to_date}' AND number = $mobile ")->result_array();
            }

            if (!empty($from_date && $to_date && $user_type && $user) && empty($mobile)) {
                $data['apibalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM tbl_recharge_api_history WHERE date BETWEEN '{$from_date}' AND '{$to_date}' AND user_mobile = $user ")->result_array();
            }
        }

        $this->load->view('apirechargereport', $data);
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
