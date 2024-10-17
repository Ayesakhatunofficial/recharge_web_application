<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Deleteusers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        if ($this->uri->segment(3) != NULL) {
            $id = $this->uri->segment(3);

            $input = ['is_deleted' => 1];

            $this->db->where(['id' => $id]);
            $this->db->delete('users');

            $affectedRows = $this->db->affected_rows();

            if ($affectedRows) {
                redirect('viewusers');
            } else {
                die("delete users query failed");
            }
        }
        // $this->loads->view("addservices");
    }
}
