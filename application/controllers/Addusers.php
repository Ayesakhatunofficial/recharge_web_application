<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addusers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');

        // $this->load->library('upload');

    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {
            $data = [];

            if (isset($_SESSION['role'])) {

                // echo "<pre>"; print_r($_SESSION); die("addusrers");

                if ($this->uri->segment(3) != NULL) {
                    $id = $this->uri->segment(3);

                    // echo $id; die;
                }

                $query_acc = $this->db->get('user_type');
                $data['account_types'] = $query_acc->result_array();

                $query_plan = $this->db->get('plans');
                $data['plans'] = $query_plan->result_array();

                $query_state = $this->db->get('state');
                $data['states'] = $query_state->result_array();

                //--------------- Insert ----------------------------//

                $input = [];

                $error = [];

                // echo "<pre>"; print_r($_POST); print_r($_FILES); die("here");

                if ($this->input->post() != NULL) {

                    //----------- create USER ID ----------------//

                    $query_user_id = $this->db->query('SELECT user_id FROM users');

                    $res = $query_user_id->result_array();

                    $userid = "";

                    if (empty($res)) {
                        $userid = "UID-001";
                    } else {
                        $last_element = end($res);

                        // $last = explode("-", $last_element['user_id']);

                        $last = str_split($last_element['user_id'], 3);


                        // echo "<pre>"; print_r($last) ; die;

                        // echo $last[1]; die;

                        $lastid = $last[1] + 1;

                        // echo $lastid; die("lastid");

                        $userid = 'UID' . str_pad($lastid, 3, '0', STR_PAD_LEFT);

                        // echo "<pre>"; print_r($userid); die("count id result");
                    }

                    //---------------------- File Upload -----------------------//

                    date_default_timezone_set('Asia/Kolkata');
                    // $date = date('d-m-y H:i:s');

                    //---------------------- adhar_front -------------------//

                    $ext = pathinfo($_FILES["adhar_front"]['name'], PATHINFO_EXTENSION);

                    $new_name = uniqid('adhar_front-' . date('d-m-Y') . '-') . '.' . $ext;

                    $config = [
                        'upload_path' => './uploads',
                        'allowed_types' => 'gif|jpg|png',
                        'file_name' => $new_name
                    ];

                    $this->upload->initialize($config);

                    $this->load->library('upload', $config);

                    if (!($this->upload->do_upload('adhar_front'))) {

                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $data['adhar_front'] = $this->upload->data();
                    }

                    // echo $data['upload_data']['full_path']; die("fulll path");

                    // echo "<pre>"; print_r($data['adhar_front']); die("file name");

                    //------------------- adhar_back --------------------//

                    $ext = pathinfo($_FILES["adhar_back"]['name'], PATHINFO_EXTENSION);

                    $new_name = uniqid('adhar_back-' . date('d-m-Y') . '-') . '.' . $ext;

                    $config = [
                        'upload_path' => './uploads',
                        'allowed_types' => 'gif|jpg|png',
                        'file_name' => $new_name
                    ];

                    $this->upload->initialize($config);

                    $this->load->library('upload', $config);

                    if (!($this->upload->do_upload('adhar_back'))) {

                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $data['adhar_back'] = $this->upload->data();
                    }

                    // echo "<pre>"; print_r($data['adhar_back']); die("file name");

                    //------------------- pan_image --------------------//

                    $ext = pathinfo($_FILES["pan_image"]['name'], PATHINFO_EXTENSION);

                    $new_name = uniqid('pan-' . date('d-m-Y') . '-') . '.' . $ext;

                    $config = [
                        'upload_path' => './uploads',
                        'allowed_types' => 'gif|jpg|png',
                        'file_name' => $new_name
                    ];

                    $this->upload->initialize($config);

                    $this->load->library('upload', $config);

                    if (!($this->upload->do_upload('pan_image'))) {

                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $data['pan_image'] = $this->upload->data();
                    }

                    //------------------- photo --------------------//

                    $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);

                    $new_name = uniqid('photo-' . date('d-m-Y') . '-') . '.' . $ext;

                    $config = [
                        'upload_path' => './uploads',
                        'allowed_types' => 'gif|jpg|png',
                        'file_name' => $new_name
                    ];

                    $this->upload->initialize($config);

                    $this->load->library('upload', $config);

                    if (!($this->upload->do_upload('photo'))) {

                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $data['photo'] = $this->upload->data();
                    }

                    //------------------- bank_passbook_image --------------------//

                    $ext = pathinfo($_FILES["bank_passbook_image"]['name'], PATHINFO_EXTENSION);

                    $new_name = uniqid('bank_passbook-' . date('d-m-Y') . '-') . '.' . $ext;

                    $config = [
                        'upload_path' => './uploads',
                        'allowed_types' => 'gif|jpg|png',
                        'file_name' => $new_name
                    ];

                    $this->upload->initialize($config);

                    $this->load->library('upload', $config);

                    if (!($this->upload->do_upload('bank_passbook_image'))) {

                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $data['bank_passbook_image'] = $this->upload->data();
                    }

                    $input = [
                        'account_type' => $this->input->post('account_type'),
                        'user_id ' => $userid,
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
                        'password' => md5($this->input->post('password')),

                        // 'adhar_front' => $data['adhar_front']['file_name'],
                        // 'adhar_back' => $data['adhar_back']['file_name'],
                        // 'pan_image' => $data['pan_image']['file_name'],
                        // 'photo' => $data['photo']['file_name'],
                        // 'bank_passbook_image' => $data['bank_passbook_image']['file_name'],
                        'status' => $this->input->post('status'),
                        'create_by' => $_SESSION['role'],
                    ];

                    if ($input != NULL) {
                        $insert = $this->db->insert('users', $input);

                        $affectedRows = $this->db->affected_rows();

                        if ($affectedRows) {
                            redirect('viewusers', 'refresh');
                        } else {
                            die("insert query failed");
                        }
                    }
                }
            } else if (isset($_SESSION['user_type'])) {

                $query_state = $this->db->get('state');
                $data['states'] = $query_state->result_array();

                if ($this->input->post() != NULL) {

                    //----------- create USER ID ----------------//

                    $query_user_id = $this->db->query('SELECT user_id FROM users');

                    $res = $query_user_id->result_array();

                    $userid = "";

                    if (empty($res)) {
                        $userid = "UID-001";
                    } else {
                        $last_element = end($res);

                        $last = str_split($last_element['user_id'], 3);

                        $lastid = $last[1] + 1;

                        $userid = 'UID' . str_pad($lastid, 3, '0', STR_PAD_LEFT);
                    }

                    //----------- state ---------------------//

                    $st = $this->input->post('state');

                    $state = $this->db->get_where('state', ['id' => $st])->row_array();

                    $input = [
                        'account_type' => $this->input->post('account_type'),
                        'user_id ' => $userid,
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'mobile' => $this->input->post('mobile'),
                        'state' => $state['state'],
                        'pan' => $this->input->post('pan'),
                        'adhar' => $this->input->post('adhar'),
                        'address' => $this->input->post('address'),
                        'pin' => $this->input->post('pin'),
                        'password' => md5($this->input->post('password')),
                        'status' => $this->input->post('status'),
                        'create_by' => $_SESSION['slug'],
                        'created_by_id' => $_SESSION['user_id']
                    ];

                    // echo "<pre>";
                    // print_r($input);
                    // die("addusers");

                    if (!empty($input)) {
                        $insert = $this->db->insert('users', $input);

                        $affected_row = $this->db->affected_rows();

                        if ($affected_row) {
                            redirect('viewusers', 'refresh');
                        } else {
                            die("insert query failed");
                        }
                    }
                }
            }

            $this->load->view('addusers', $data);
        } else {
            
            redirect('userlogin');
        }
    }
}
