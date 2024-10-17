<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_action extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        $input = [];

        $data = [];

        if ($this->input->post() != NULL) {
            $input = [
                'menu_id' => $this->input->post('menu'),
                'action_name' => $this->input->post('action_name'),
                'action_url' => $this->input->post('action_url')
            ];

            // echo "<pre>";
            // print_r($input);

            // var_dump($ipt);
            // die("<br> here");

            if ($input != NULL) {

                //-------------------- Insert ----------------------//

                $insert = $this->db->insert('menu_action', $input);

                if ($insert) {
                    redirect(base_url('menu_action'), 'refresh');
                } else {
                    die("insert query failed");
                }
            }
        }

        $query = $this->db->order_by('id', 'desc')->get('menu_action');

        $data['rows'] = $query->result_array();

        // echo "<pre>"; print_r($data['rows']); die("pop");

        $data['menus'] = $this->db->get('menu')->result_array();

        // echo "<pre>"; print_r($data['menus']); die;

        $this->load->view('menu_action', $data);
    }
}
