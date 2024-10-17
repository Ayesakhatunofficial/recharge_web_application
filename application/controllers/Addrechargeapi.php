<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addrechargeapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($_SESSION['role'] == 'super_admin') {

            if ($this->input->post()) {
                $input = [
                    'purpose' => $this->input->post('purpose'),
                    'url' => $this->input->post('api_url')
                ];

                // Debugging: Output the input data
                // echo "<pre>";
                // print_r($input);
                // die;

                if (!empty($input)) {
                    $insert = $this->db->insert('tbl_recharge_api', $input);

                    if ($insert) {
                        redirect('viewrechargeapi', 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }

            $this->load->view('addrechargeapi');
        } else {
            redirect('Login', 'refresh');
        }
    }
}
