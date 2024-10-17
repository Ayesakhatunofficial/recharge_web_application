<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Viewrationcard extends CI_Controller
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

        $data['rations'] = $this->db->get('ration_details')->result_array();

        if($this->input->post() != NULL)
        {
            $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

            $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

            $input = [
                'from_date' => $from_date,
                'to_date' => $to_date,
                'ration_no' => $this->input->post('ration_no')
            ];

            // echo "<pre>"; print_r($input); die;

            if(!empty($input['ration_no']))
            {
                $data['rations'] = $this->db->order_by('id', 'desc')->get_where('ration_details', ['ration_no' => $input['ration_no']])->result_array();
            } else {
                $data['rations'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM ration_details WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
            }
        }

        $this->load->view('viewrationcard', $data);
    }
}






