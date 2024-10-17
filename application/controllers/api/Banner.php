<?php
class Banner extends CI_Controller
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

        $banners = $this->db->get('tb_banner')->result_array();

        if (!is_null($banners)) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $banners,
                'img_url' => base_url('uploads/')
            ];

            echo json_encode($response);
        }
    }
}
