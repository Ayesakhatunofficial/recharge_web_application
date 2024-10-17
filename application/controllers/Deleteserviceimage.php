<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Deleteserviceimage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        $id = $_POST['imgId']; 

        // echo $id; die("del serv img");

        $query = $this->db->query("SELECT * FROM service_image WHERE id = $id")->row_array();

        // echo "<pre>"; print_r($query); die("query");

        unlink(dirname(dirname(__DIR__)) . '/service_image/' . $query['image']);

        $this->db->where(['id' => $id]);
        $this->db->delete('service_image');

        $affectedRows = $this->db->affected_rows();

        if ($affectedRows) {
            echo json_encode([
                'res' => 'success',
                'id' => $_POST['imgId']
            ]); ;
        } else {
            echo json_encode(['res' => "delete users query failed"]);
        }
    }
}
