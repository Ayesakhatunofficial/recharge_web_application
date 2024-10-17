<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Editusers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        $data = [];

        $input = [];

        $query_acctype = $this->db->get('user_type');
        $data['account_types'] = $query_acctype->result_array();

        $query_plan = $this->db->get('plans');
        $data['plans'] = $query_plan->result_array();

        $query_state = $this->db->get('state');
        $data['states'] = $query_state->result_array();

        if ($this->uri->segment(3) != NULL) {
            $id = $this->uri->segment(3);

            $query = $this->db->get_where('users', ['id' => $id]);

            $data['userdata'] = $query->row_array();

            // echo "<pre>"; print_r($data['userdata']); die("users here");

            // var_dump($data['result']['adhar_front']) ; die('uid');

        }
        // echo "<pre>"; print_r($data['result']); die("users here");


        if ($this->input->post() != NULL) {

            //----------- create USER ID ----------------//

            $query_user_id = $this->db->query('SELECT COUNT(id) AS total_rows FROM users');

            $res = $query_user_id->result_array();

            $lastid = $res[0]['total_rows'] + 1;

            $userid = 'UID' . str_pad($lastid, 3, '0', STR_PAD_LEFT);

            // echo "<pre>"; print_r($res); die("count id result");

            //---------------------- File Upload -----------------------//

            date_default_timezone_set('Asia/Kolkata');
            // $date = date('d-m-y H:i:s');

            //---------------------- adhar_front -------------------//

            // $ext = pathinfo($_FILES["adhar_front"]['name'], PATHINFO_EXTENSION);

            // $new_name = uniqid('adhar_front-' . date('d-m-Y') . '-') . '.' . $ext;

            // $config = [
            //     'upload_path' => './uploads',
            //     'allowed_types' => 'gif|jpg|png',
            //     'file_name' => $new_name
            // ];

            // $this->upload->initialize($config);

            // $this->load->library('upload', $config);

            // if (!($this->upload->do_upload('adhar_front'))) {

            //     $data['upload_error'] = $this->upload->display_errors();
            // } else {
            //     $data['adhar_front'] = $this->upload->data();
            // }

            // if ($_FILES['adhar_front']['name'] == "") {
            //     $data['adhar_front'] = $data['result']['adhar_front'];
            // }

            // echo $data['upload_data']['full_path']; die("fulll path");

            // echo "<pre>"; print_r($data['adhar_front']); die("file name");

            //------------------- adhar_back --------------------//

            // $ext = pathinfo($_FILES["adhar_back"]['name'], PATHINFO_EXTENSION);

            // $new_name = uniqid('adhar_back-' . date('d-m-Y') . '-') . '.' . $ext;

            // $config = [
            //     'upload_path' => './uploads',
            //     'allowed_types' => 'gif|jpg|png',
            //     'file_name' => $new_name
            // ];

            // $this->upload->initialize($config);

            // $this->load->library('upload', $config);

            // if (!($this->upload->do_upload('adhar_back'))) {

            //     $data['upload_error'] = $this->upload->display_errors();
            // } else {
            //     $data['adhar_back'] = $this->upload->data();
            // }

            // if ($_FILES['adhar_back']['name'] == "") {
            //     $data['adhar_back'] = $data['result']['adhar_back'];
            // }

            // echo "<pre>"; print_r($data['adhar_back']); die("file name");

            //------------------- pan_image --------------------//

            // $ext = pathinfo($_FILES["pan_image"]['name'], PATHINFO_EXTENSION);

            // $new_name = uniqid('pan-' . date('d-m-Y') . '-') . '.' . $ext;

            // $config = [
            //     'upload_path' => './uploads',
            //     'allowed_types' => 'gif|jpg|png',
            //     'file_name' => $new_name
            // ];

            // $this->upload->initialize($config);

            // $this->load->library('upload', $config);

            // if (!($this->upload->do_upload('pan_image'))) {

            //     $data['upload_error'] = $this->upload->display_errors();
            // } else {
            //     $data['pan_image'] = $this->upload->data();
            // }

            // if ($_FILES['pan_image']['name'] == "") {
            //     $data['pan_image'] = $data['result']['pan_image'];
            // }

            //------------------- photo --------------------//

            // $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);

            // $new_name = uniqid('photo-' . date('d-m-Y') . '-') . '.' . $ext;

            // $config = [
            //     'upload_path' => './uploads',
            //     'allowed_types' => 'gif|jpg|png',
            //     'file_name' => $new_name
            // ];

            // $this->upload->initialize($config);

            // $this->load->library('upload', $config);

            // if (!($this->upload->do_upload('photo'))) {

            //     $data['upload_error'] = $this->upload->display_errors();
            // } else {
            //     $data['photo'] = $this->upload->data();
            // }

            // if ($_FILES['photo']['name'] == "") {
            //     $data['photo'] = $data['result']['photo'];
            // }

            //------------------- bank_passbook_image --------------------//

            // $ext = pathinfo($_FILES["bank_passbook_image"]['name'], PATHINFO_EXTENSION);

            // $new_name = uniqid('bank_passbook-' . date('d-m-Y') . '-') . '.' . $ext;

            // $config = [
            //     'upload_path' => './uploads',
            //     'allowed_types' => 'gif|jpg|png',
            //     'file_name' => $new_name
            // ];

            // $this->upload->initialize($config);

            // $this->load->library('upload', $config);

            // if (!($this->upload->do_upload('bank_passbook_image'))) {

            //     $data['upload_error'] = $this->upload->display_errors();
            // } else {
            //     $data['bank_passbook_image'] = $this->upload->data();
            // }

            // if ($_FILES['bank_passbook_image']['name'] == "") {
            //     $data['bank_passbook_image'] = $data['result']['bank_passbook_image'];
            // }


            // echo $assigned_by ; die;

            $input = [
                'id' => $this->input->post('id'),
                'account_type' => $this->input->post('account_type'),
                'name' => $this->input->post('name'),
                // 'father_name' => $this->input->post('father_name'),
                // 'dob' => $this->input->post('dob'),
                // 'firm_name' => $this->input->post('firm_name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'pan' => $this->input->post('pan'),
                'adhar' => $this->input->post('adhar'),
                'gender' => $this->input->post('gender'),
                // 'plan' => $this->input->post('plan'),
                // 'gst' => $this->input->post('gst'),
                // 'bank_name' => $this->input->post('bank_name'),
                // 'ifsc' => $this->input->post('ifsc'),
                // 'bank_acc_holder' => $this->input->post('bank_acc_holder'),
                // 'branch_name' => $this->input->post('branch_name'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'address' => $this->input->post('address'),
                'pin' => $this->input->post('pin'),
                // 'adhar_front' => ($_FILES['adhar_front']['name'] == "")? $data['result']['adhar_front'] : $data['adhar_front']['file_name'],
                // 'adhar_back' => ($_FILES['adhar_back']['name'] == "")? $data['result']['adhar_back'] : $data['adhar_back']['file_name'],
                // 'pan_image' => ($_FILES['pan_image']['name'] == "")? $data['result']['pan_image'] : $data['pan_image']['file_name'],
                // 'photo' => ($_FILES['photo']['name'] == "")? $data['result']['photo'] : $data['photo']['file_name'],
                // 'bank_passbook_image' => ($_FILES['bank_passbook_image']['name'] == "")? $data['result']['bank_passbook_image'] : $data['bank_passbook_image']['file_name'],
                'status' => $this->input->post('status'),
            ];

            if ($this->input->post('password')) {
                $input['password'] = md5($this->input->post('password'));
            }

            if ($this->input->post('create_by')) {
                $input['create_by'] = $this->input->post('create_by');
            }

            // echo "<pre>";
            // print_r($input);
            // die("input here");

            if ($input != NULL) {
                // echo "<pre>"; print_r($input); die("input here");
                $this->db->where('id',  $input['id']);
                $this->db->update('users', $input);

                // $affectedRows = $this->db->affected_rows();

                // if($affectedRows)
                // {
                redirect('viewusers', 'refresh');
                // }
                // else
                // {
                //     die("update query failed");
                // }
            }
        }

        $this->load->view('editusers', $data);
    }
}
