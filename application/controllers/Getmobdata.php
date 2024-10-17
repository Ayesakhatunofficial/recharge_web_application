<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Getmobdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        // echo $_POST['mob'];

        $data = [];

        $data['bal'] = $this->db->get_where('users', ['mobile' => $_POST['mob']])->row_array();

        echo json_encode([
            'responce' => 'success',
            'bal' => $data['bal']['wallet']
        ]);
    }
}