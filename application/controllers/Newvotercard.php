<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Newvotercard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('newvotercard');
    }
}
