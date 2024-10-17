<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);
        $status = $query->row_array();
        // echo "<pre>"; print_r($status); die;

        if($status['status'] == 1)
        {
            $this->db->where(['id' => $id]);
            $this->db->update('users', ['status' => 0]);

            $affectedRows = $this->db->affected_rows();

            if($affectedRows)
            {
                redirect('viewusers', 'refresh');
            }
            else
            {
                echo "status query failed";
            }
        }
        else
        {
            $this->db->where(['id' => $id]);
            $this->db->update('users', ['status' => 1]);

            $affectedRows = $this->db->affected_rows();

            if($affectedRows)
            {
                redirect('viewusers', 'refresh');
            }
            else
            {
                echo "status query failed";
            }
        }
    }
}
