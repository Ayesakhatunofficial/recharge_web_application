<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewwalletupi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {


        if (isset($_SESSION['role'])) {
            
            $data['upi_reports'] = $this->db->order_by('id', 'desc')->get('tb_virtualtxn')->result_array();

            if ($this->input->post() != NULL) {
                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $data['upi_reports'] = $this->db->query("SELECT * from `tb_virtualtxn` WHERE DATE_FORMAT(credited_at, '%Y-%m-%d')  BETWEEN '$from_date' AND '$to_date' ORDER BY id DESC")->result_array();
            }

            // echo "<pre>"; print_r($data['upi_reports']); die("abc");


            $this->load->view('viewwalletupi', $data);
        } else {
            redirect('login');
        }
    }
}
