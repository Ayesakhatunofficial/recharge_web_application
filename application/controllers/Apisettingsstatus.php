<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apisettingsstatus extends CI_Controller
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

        $ipt['id'] = $id;

        $status = $this->db->get_where('api_settings', ['id' => $id])->row_array();

        if($status['status'] == 1)
        {
            $this->db->where(['id' => $id]);
            $this->db->update('api_settings', ['status' => 0]);

            $affectedRows = $this->db->affected_rows();

            if($affectedRows)
            {
                redirect('apisettings', 'refresh');
            }
            else
            {
                echo "status query failed";
            }
        }
        else
        {
            $this->db->where(['id' => $id]);
            $this->db->update('api_settings', ['status' => 1]);

            $affectedRows = $this->db->affected_rows();

            if($affectedRows)
            {
                redirect('apisettings', 'refresh');
            }
            else
            {
                echo "status query failed";
            }
        }
    }
}