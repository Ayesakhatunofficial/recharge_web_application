<?php
defined('BASEPATH') or exit('No direct scriptaccess allowed');

class Deleteutilityapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $this->db->delete('tbl_utility_api', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewutilityapi', 'refresh');
        } else {
            die("delete API failed");
        }
    }
}
