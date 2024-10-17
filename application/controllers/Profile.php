<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }



    public function index()
    {
        $input = [];
        $data = [];
        $iptId = [];

        // echo $_SESSION['email']; die("profile page");

        // $data['roles'] = $this->db->get('user_type')->result_array();
        if (isset($_SESSION['role'])) {
            $data['super_admin'] = $this->db->get_where('profile_info', ['role' => 'super_admin'])->row_array();

            $data['result'] = $data['super_admin'];
        }
        //  echo "<pre>"; print_r($data['result']); die;

        if (isset($_SESSION['slug'])) {
            $data['user'] = $this->db->get_where('users', ['mobile' => $_SESSION['mobile']])->row_array();
        }

        if ($this->input->post() != NULL) {

            if (isset($_SESSION['role'])) {
                $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

                $new_name = uniqid('A-' . date('d-m-Y') . '-') . '.' . $ext;

                $config = [
                    'upload_path' => './profile_image',
                    'allowed_types' => 'jpeg|jpg|png',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('profile_image'))) {

                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $data['profile_image'] = $this->upload->data();
                }

                if ($data['super_admin']['password'] == $this->input->post('password')) {
                    $password = $data['super_admin']['password'];
                } else {
                    $password = md5($this->input->post('password'));
                }

                $iptId['id'] = $this->input->post('id');

                $input = [
                    'site_title' => $this->input->post('site_title'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => $password,
                    'profile_image' => ($_FILES['profile_image']['name'] == "") ? $data['super_admin']['profile_image'] : $data['profile_image']['file_name']
                ];

                // echo "<pre>"; print_r($input); echo $this->input->post('password'); die;

                if (!empty($iptId['id'])) {
                    if (!empty($input)) {
                        $this->db->where(['id' => $iptId['id']]);
                        $this->db->update('profile_info', $input);

                        $error = $this->db->error();

                        if ($error['code'] == 0) {
                            redirect('profile', 'refresh');
                        } else {
                            die("Add profile error");
                        }
                    }
                } else {
                    if (!empty($input)) {
                        $insert = $this->db->insert('profile_info', $input);

                        $error = $this->db->error();

                        if ($error['code'] == 0) {
                            redirect('profile', 'refresh');
                        } else {
                            die("Add profile error");
                        }
                    }
                }
            }

            if (isset($_SESSION['slug'])) {

                ////////////            profile image          //////////////////

                $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

                $new_name = uniqid('A-' . date('d-m-Y') . '-') . '.' . $ext;

                $config = [
                    'upload_path' => './uploads',
                    'allowed_types' => 'gif|jpg|png|jpeg',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('profile_image'))) {

                    $data['upload_error'] = $this->upload->display_errors();
                } else {

                    $data['profile_image'] = $this->upload->data();
                }

                //////////////            logo           ///////////////

                if ($_SESSION['slug'] == 'admin') {

                    // $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);

                    // $new_name = uniqid('L-' . date('d-m-Y') . '-') . '.' . $ext;

                    // $config = [
                    //     'upload_path' => './uploads',
                    //     'allowed_types' => 'gif|jpg|png|jpeg',
                    //     'file_name' => $new_name
                    // ];

                    // $this->upload->initialize($config);

                    // $this->load->library('upload', $config);

                    // if (!($this->upload->do_upload('logo'))) {

                    //     $data['upload_error'] = $this->upload->display_errors();
                    // } else {

                    //     $data['logo'] = $this->upload->data();
                    // }

                    ////////////     custom code       //////////

                    if ($this->input->post('custom_code') == '' && $data['user']['custom_code'] == '') {
                        $custom_code = $data['user']['name'] . substr($_SESSION['mobile'], -4);
                    } else {
                        $custom_code = $this->input->post('custom_code');
                    }
                }

                /////////       password ////////////

                if ($data['user']['password'] == $this->input->post('password')) {
                    $password = $data['user']['password'];
                } else {
                    $password = md5($this->input->post('password'));
                }

                $id = $this->input->post('id');

                $input = [
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'pin' => $this->input->post('pincode'),
                    'password' => $password,
                    'photo' => ($_FILES['profile_image']['name'] == "") ? $data['user']['photo'] : $data['profile_image']['file_name'],
                ];

                if ($_SESSION['slug'] == 'admin') {
                    // $input['logo'] = ($_FILES['logo']['name'] == "") ? $data['user']['logo'] : $data['logo']['file_name'];

                    $input['custom_code'] = isset($custom_code) ? $custom_code : $data['user']['custom_code'];

                    $input['title'] = $this->input->post('title');
                    $input['url'] = $this->input->post('url');
                }

                if (!empty($id)) {
                    if (!empty($input)) {
                        $this->db->where(['id' => $id]);
                        $this->db->update('users', $input);
                        $error = $this->db->error();

                        if ($error['code'] == 0) {
                            redirect('profile', 'refresh');
                        } else {
                            die("Add profile error");
                        }
                    }
                }
            }
        }
        $this->load->view('profile', $data);
    }
}
