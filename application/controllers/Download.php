<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url', 'download');
    }

    public function index()
    {
        $data = [];

        if($this->uri->segment(3) != NULL)
        {
            $id = $this->uri->segment(3);

            $query = $this->db->get_where('users', ['id' => $id]);

            $result = $query->row_array();

            // $name = base_url('uploads/'. $result['adhar_front']);

            $filePath = dirname(dirname(__DIR__)) . '/uploads';

            $this->load->helper('download');

            $item = $this->uri->segment(4);

            if($item == 'f')
            {
                force_download($filePath . '/' . $result['adhar_front'], null, TRUE);
            }

            if($item == 'b')
            {
                force_download($filePath . '/' . $result['adhar_front'], null, TRUE);
            }

            if($item == 'p')
            {
                force_download($filePath . '/' . $result['pan_image'], null, TRUE);
            }

            if($item == 'ph')
            {
                force_download($filePath . '/' . $result['photo'], null, TRUE);
            }

            if($item == 'pb')
            {
                force_download($filePath . '/' . $result['bank_passbook_image'], null, TRUE);
            } 
        }

        // $this->load->view('verifykyc', $data);
    }
}