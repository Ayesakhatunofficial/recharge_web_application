<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewbanner extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        $data['banners'] = $this->db->get('tb_banner')->result_array();
        $this->load->view('viewbanner', $data);
    }
}
