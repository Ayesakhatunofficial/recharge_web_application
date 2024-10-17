<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deleteoffers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $this->db->delete('offers', ['id' => $id]);

        $error = $this->db->error();

        if($error['code'] == 0)
        {
            redirect('offers', 'refresh');
        }
        else
        {
            die('failed to delete offers');
        }
    }
}
