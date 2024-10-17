<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Signin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');

        $this->load->library('session');
    }

    public function index()
    {

        if ($this->input->post() != NULL) {
            $data = [
                'mobile' => $this->input->post('mobile'),
                'password' => md5($this->input->post('password'))
            ];
        }

        if ($data != NULL) {

            $sql = $this->db->get_where('users', ['mobile' => $data['mobile'], 'password' => $data['password'], 'status' => 1, 'is_deleted' => 0])->row_array();

            $query = $this->db->get_where('user_type', ['id' => $sql['account_type']]);

            $result = $query->row_array();

            $error = $this->db->error();

            if ($error['code'] == 0) {
                $_SESSION['user_id'] = $sql['id'];
                $_SESSION['first_name'] = $sql['name'];
                $_SESSION['mobile'] = $sql['mobile'];
                $_SESSION['email'] = $sql['email'];
                $_SESSION['user_type'] = $result['user_type'];
                $_SESSION['slug'] = $result['slug'];
                $_SESSION['created_by_id'] = $sql['created_by_id'];
                $_SESSION['created_by'] = $sql['create_by'];
                $_SESSION['wallet'] = $sql['wallet'];
                $_SESSION['user_code'] = $sql['user_id'];

                if (isset($_SESSION['user_type'])) {
                    redirect('dashboard', 'refresh');
                } else {

                    redirect('signin', 'refresh');
                }
            }
        }


        $this->load->view('signin');
    }
}
