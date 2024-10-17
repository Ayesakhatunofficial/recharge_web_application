<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Newdrivinglicense extends CI_Controller
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
        $input = [];

        $data['states'] = $this->db->get('state')->result_array();

        if ($this->input->post() != NULL) {
            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y');
            
            $input = [
                'dl_no' => $this->input->post('dl_no'),
                'name' => $this->input->post('name'),
                'dob' => $this->input->post('dob'),
                'dto_office' => $this->input->post('dto_office'),
                'state' => $this->input->post('state'),
                'district' => $this->input->post('district'),
                'create_date' => $date
            ];

            if (!empty($input)) {
                $this->db->insert('dl_details', $input);

                $error = $this->db->error();

                if ($error['code'] == 0) {
                    redirect('viewdrivinglicense', 'refresh');
                } else {
                    die("insert query failed");
                }
            } else {
                die('please fill all fields');
            }
        }

        $this->load->view('newdrivinglicense', $data);
    }
}
