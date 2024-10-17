<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Viewpanfinder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $data['panfinders'] = $this->db->order_by('id', 'desc')->get('panfinder')->result_array();

        // echo "<pre>"; print_r($data['dl_nos']); die;

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
                'adhar_no' => $this->input->post('adhar_no')
            ];

            // echo "<pre>"; print_r($input); die;

            if(!empty($input['adhar_no']))
            {
                $data['panfinders'] = $this->db->order_by('id', 'desc')->get_where('panfinder', ['dl_no' => $input['dl_no']])->result_array();
            } else {
                $data['panfinders'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM panfinder WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
            }
        }

        $this->load->view('viewpanfinder', $data);
    }
}