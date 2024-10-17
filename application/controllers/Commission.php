<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Commission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($_SESSION['slug']) {

            $created_by_id = $_SESSION['created_by_id'];
            $create_by = $_SESSION['created_by']; //d

            $user_1 = $this->db->get_where('users', ['id' => $created_by_id])->row(); //d
            $user_1_createdById = $user_1->created_by_id;
            $user_1_type = $user_1->create_by; //sd

            $user_2 = $this->db->get_where('users', ['id' => $user_1_createdById])->row(); //sd
            $user_2_createdById = $user_2->created_by_id;
            $user_2_type = $user_2->create_by; //a

            if ($create_by == 'admin') {

                $data['commissions'] = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => $created_by_id])->result_array();
            } elseif ($user_1_type == 'admin') {

                $data['commissions'] = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => $user_1_createdById])->result_array();
            } elseif ($user_2_type == 'admin') {

                $data['commissions']  = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => $user_2_createdById])->result_array();
            } else {
                $data['commissions'] = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => 'super_admin'])->result_array();
            }

            $this->load->view('commission', $data);
        } else {
            redirect('userlogin');
        }
    }
}
