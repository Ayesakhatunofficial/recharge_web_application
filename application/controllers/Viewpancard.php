<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Viewpancard extends CI_Controller
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

        $data['pans'] = $this->db->order_by('id', 'desc')->get('pan_details')->result_array();

        $data['languages'] = $this->db->get('language')->result_array();

        if($this->uri->segment(3) != NULL)
        {
            $id = $this->uri->segment(3);

            $data['actions'] = $this->db->query("SELECT * FROM menu_action WHERE menu_id = $id AND action_name <> 'View'")->result_array();
        }

        if($this->input->post() != NULL)
        {
            $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

            $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

            $input = [
                'from_date' => $from_date,
                'to_date' => $to_date,
                'pan_no' => $this->input->post('pan_no')
            ];

            // echo "<pre>"; print_r($input); die;

            if(!empty($input['pan_no']))
            {
                $data['pans'] = $this->db->order_by('id', 'desc')->get_where('pan_details', ['pan_no' => $input['pan_no']])->result_array();
            } else {
                $data['pans'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM pan_details WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
            }
        }

        $this->load->view('viewpancard', $data);
    }
}
