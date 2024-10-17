<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Printpannsdl extends CI_Controller
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

        $data['pan'] = $this->db->get_where('pan_details', ['id' => $id])->row_array();

        $this->load->view('printpannsdl', $data);
    }
}