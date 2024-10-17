<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Viewvotercard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $data = [];

        $data['voters'] = $this->db->order_by('id', 'desc')->get('voter_details')->result_array();

        $data['languages'] = $this->db->get('language')->result_array();

        if($this->input->post() != NULL)
        {
            $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

            $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

            $input = [
                'from_date' => $from_date,
                'to_date' => $to_date,
                'epic_no' => $this->input->post('epic_no')
            ];

            // echo "<pre>"; print_r($input); die;

            if(!empty($input['epic_no']))
            {
                $data['voters'] = $this->db->order_by('id', 'desc')->get_where('voter_details', ['epic_no' => $input['epic_no']])->result_array();
            } else {
                $data['voters'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM voter_details WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
            }
        }
        $this->load->view('viewvotercard', $data);
    }
}


