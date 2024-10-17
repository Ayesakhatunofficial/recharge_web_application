<?php
class Terms extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        $this->load->helper(array('form', 'url',));

        $this->load->library('form_validation');
    }

    public function index()
    {
        $terms  = $this->db->get('terms_and_conditions')->row_array();

        if (!is_null($terms)) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $terms
            ];

            echo json_encode($response);
        }
    }
}
