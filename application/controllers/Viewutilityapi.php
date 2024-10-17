<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewutilityapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {

        $data['utility_apis'] = $this->db->order_by('id', 'desc')->get('tbl_utility_api')->result_array();

        $this->load->view('viewutilityapi', $data);
    }
}
