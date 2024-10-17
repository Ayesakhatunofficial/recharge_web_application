<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('RoleModel');
    }

    public function index(){
        //echo 'error';die;
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('role/addrole');
        $this->load->view('includes/footer');
    }
}
