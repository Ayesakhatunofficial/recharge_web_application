<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewcommission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {

        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $role = $_SESSION['role'];
                $data['commissions'] = $this->db->order_by('id', 'desc')->get_where('commission', ['created_by' => $role])->result_array();
            } else if ($_SESSION['slug'] == 'admin') {
                $id = $_SESSION['user_id'];
                $data['commissions'] = $this->db->order_by('id', 'desc')->get_where('commission', ['created_by' => $id])->result_array();
            }



            // echo "<pre>"; print_r($data['commissions']); die("abc");

            $this->load->view('viewcommission', $data);
        } else {

            redirect('login');
        }
    }
}
