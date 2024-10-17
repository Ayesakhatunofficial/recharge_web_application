<?php
class Privacy extends CI_Controller
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


    public function policy()
    {
        $privacy = $this->db->get('privacy_policy')->row_array();

        if (!is_null($privacy)) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $privacy,
            ];

            echo json_encode($response);
        }
    }
}
