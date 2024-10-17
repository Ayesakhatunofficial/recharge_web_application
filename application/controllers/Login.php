<?php
defined('BASEPATH') or exit('No direct script access allowed');

// session_start();

class Login extends CI_Controller
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
        $this->load->view('Login');

        $data = [];

        if ($this->input->post() != NULL) {
            $data = [
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password'))
            ];
        }

        // echo "<pre>"; print_r($data); die;

        if ($data != NULL) {
            $email = $data['email'];
            $password = $data['password'];

            $query = $this->db->get_where('profile_info', ['email' => $email, 'password' => $password]);

            $result = $query->row_array();

            // print_r($this->db->last_query());

            // echo "<pre>"; print_r($result); die("HERE");

            $error = $this->db->error();

            if ($error['code'] == 0) {
               
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['role'] = $result['role'];
                
                // echo "<pre>"; print_r($_SESSION); die;

                $this->load->helper('url');

                if (isset($_SESSION['role']) && $_SESSION['role'] == 'super_admin') {
                    redirect('dashboard', 'refresh');
                } else {
                    redirect('Login', 'refresh');
                }
            }

           
        }
    }
}
