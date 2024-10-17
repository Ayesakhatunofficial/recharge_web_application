<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Viewdrivinglicense extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $data['dl_nos'] = $this->db->order_by('id', 'desc')->get('dl_details')->result_array();

        // echo "<pre>"; print_r($data['dl_nos']); die;

        if($this->input->post() != NULL)
        {
            $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

            $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

            $input = [
                'from_date' => $from_date,
                'to_date' => $to_date,
                'dl_no' => $this->input->post('dl_no')
            ];

            // echo "<pre>"; print_r($input); die;

            if(!empty($input['dl_no']))
            {
                $data['dl_nos'] = $this->db->order_by('id', 'desc')->get_where('dl_details', ['dl_no' => $input['dl_no']])->result_array();
            } else {
                $data['dl_nos'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM dl_details WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
            }
        }

        $this->load->view('viewdrivinglicense', $data);
    }
}