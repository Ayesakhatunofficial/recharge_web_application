<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kycapprove extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $input = [
            'is_adhar_verified' => 1,
            'is_pan_verified' => 1,
            'is_passbook_verified' => 1,
            'is_photo_verified' => 1,
            'is_kyc_verified' => 1
        ];

        // echo "<pre>"; print_r($input); die("kyc");

        $this->db->where('id', $id);
        $this->db->update('users', $input);

        $affectedRows = $this->db->affected_rows();

        if ($affectedRows == 1) {
            redirect(base_url('viewusers'), 'refresh');
        } else {
            die("update query failed");
        }
    }
}
