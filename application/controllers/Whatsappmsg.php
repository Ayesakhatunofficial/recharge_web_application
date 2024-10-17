<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Whatsappmsg extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $curl = curl_init();

        // Set the URL to fetch
        curl_setopt($curl, CURLOPT_URL, "https://www.airtel.in/recharge-online?icid=header");

        // Return the transfer as a string
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Execute the session
        $result = curl_exec($curl);

        // Close the cURL session
        curl_close($curl);

        // Output the result
        echo $result;
    }
}
