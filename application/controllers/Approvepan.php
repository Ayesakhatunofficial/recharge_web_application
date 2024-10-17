<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Approvepan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $data = [];

        $output = [];

        if ($this->input->post() != NULL) {
           
            $input = [
                'status' => 1,
                'remarks' => $this->input->post('remarks')
            ];
    
            // echo "<pre>"; print_r($input); die;
    
            $this->db->where(['id' => $id]);
            $this->db->update('panfinder', $input);

            // print_r($this->db->last_query()); die;
    
            $error = $this->db->error();
    
            if ($error['code'] == 0) {
                redirect('viewpanfinder', 'refresh');
            }
        }
    }
}
