<?php 
defined('BASEPATH') or exit('No direct script accessed allowed');

class Busbooking extends CI_Controller
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

        if($this->input->post() != NULL)
        {
            // date_default_timezone_set('Asia/Kolkata');
            // $date = date('d-m-y H:i:s');

            $input = [
                'from_place' => $this->input->post('from_place'),
                'to_place' => $this->input->post('to_place'),
                'journey_date' => $this->input->post('journey_date')
            ];
        }

        if(!empty($input))
        {
            $insert = $this->db->insert('journey_info', $input);

            $error = $this->db->error();

            if($error['code'] == 0)
            {
                redirect('busbooking', 'refresh');
            }
            else
            {
                die("serch failed");
            }
        }

        $this->load->view('busbooking', $data);
    }

    public function getCities(){
        $key = 8777846136;
        $secret = 27117432;
        $ch = curl_init();
        $apiUrl = 'http://api.seatseller.travel/cities';

        // ECHO $apiUrl; die;

        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        if (!empty($response)) {
            echo $response;
        } else {
            echo 'Empty or invalid response received.';
        }
    }
}