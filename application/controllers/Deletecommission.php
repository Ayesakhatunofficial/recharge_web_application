<?php
defined('BASEPATH') or exit('No direct scriptaccess allowed');

class Deletecommission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $this->db->delete('commission', ['id' => $id]);

        $error = $this->db->error();

        if($error['code'] == 0)
        {
            redirect('viewcommission', 'refresh');
        }
        else
        {
            die("delete commission failed");
        }
    }
}