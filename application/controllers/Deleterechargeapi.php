<?php
defined('BASEPATH') or exit('No direct scriptaccess allowed');

class Deleterechargeapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $this->db->delete('tbl_recharge_api', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewrechargeapi', 'refresh');
        } else {
            die("delete API failed");
        }
    }
}