<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Rejectdl extends CI_Controller
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

        if ($this->input->post() != NULL) {
            $input = [
                'status' => -1,
                'remarks' => $this->input->post('remarks')
            ];
        }

        $this->db->where(['id' => $id]);
        $this->db->update('dl_details', $input);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewdrivinglicense', 'refresh');
        }
    }
}
