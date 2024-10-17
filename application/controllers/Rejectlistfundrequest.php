<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Rejectlistfundrequest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $input = [];

        $input = [
            'remarks' => $this->input->post("remarks"),
            'status' => -1,
        ];

        if(!empty($input))
        {
            $this->db->where(['id' => $id]);
            $this->db->update('listfundrequest', $input);

            $error = $this->db->error();

            if($error['code'] == 0)
            {
                redirect('listfundrequest', 'refresh');
            }
        }
    }
}









