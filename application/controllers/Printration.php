<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Printration extends CI_Controller
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

        $data['ration'] = $this->db->get_where('ration_details', ['id' => $id])->row_array();

        $this->load->view('printration', $data);
    }
}