<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Printadhar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $data = [];

        $data['adhar'] = $this->db->get_where('aadhar_details', ['id' => $id])->row_array();

        $this->load->view('printadhar', $data);
    }
}