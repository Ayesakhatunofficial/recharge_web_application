<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offersstatus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $ipt = [];

        // $ipt['id'] = $id;

        $status = $this->db->get_where('offers', ['id' => $id])->row_array();

        if($status['status'] == 1)
        {
            $this->db->where(['id' => $id]);
            $this->db->update('offers', ['status' => 0]);

            $error = $this->db->error();

            if($error['code'] == 0)
            {
                redirect('offers', 'refresh');
            }
            else
            {
                die('status update failed');
            }
        }
        else
        {
            $this->db->where(['id' => $id]);
            $this->db->update('offers', ['status' => 1]);

            $error = $this->db->error();

            if($error['code'] == 0)
            {
                redirect('offers', 'refresh');
            }
            else
            {
                die('status update failed');
            }
        }
    }
}
