<?php
class State extends CI_Controller
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
        $states = $this->db->get('state')->result();

        if (!is_null($states)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $states
            ];

            echo json_encode($respond);
        }
    }
}
