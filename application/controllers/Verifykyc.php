<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifykyc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url', 'download');
    }

    public function index()
    {
        $data = [];

        if($this->uri->segment(3) != NULL)
        {
            $id = $this->uri->segment(3);

            $query = $this->db->get_where('users', ['id' => $id]);

            $data['result'] = $query->row_array();

            // echo "<pre>"; print_r($data['result']); die("result array");
        }

        // if($data['result']['is_kyc_verified'] == 1)

        // $this->load->view('includes/header', $data);

        $this->load->view('verifykyc', $data);
    }
}