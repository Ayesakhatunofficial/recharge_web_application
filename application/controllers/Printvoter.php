<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Printvoter extends CI_Controller
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

        $data['voter'] = $this->db->get_where('voter_details', ['id' => $id])->row_array(); 

        // echo "<pre>"; print_r($data['voter']); die;

        $this->load->view('printvoter', $data);
    }
}