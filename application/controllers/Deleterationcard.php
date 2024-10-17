<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Deleterationcard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $this->db->delete('ration_details', ['id' => $id]);

        $error = $this->db->error();

        if($error['code'] == 0)
        {
            redirect('viewrationcard', 'refresh');
        }
    }
}
