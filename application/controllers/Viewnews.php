<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewnews extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];
            $data['news'] = $this->db->get_where('tb_news', ['created_by' => $role])->result_array();
        } else if ($_SESSION['slug'] == 'admin') {

            $user_id = $_SESSION['user_id'];
            $data['news'] = $this->db->get_where('tb_news', ['created_by' => $user_id])->result_array();
        }
        $this->load->view('viewnews', $data);
    }
}
