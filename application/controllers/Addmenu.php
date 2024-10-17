<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addmenu extends CI_Controller
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
                'menu_name' => $this->input->post('menu_name'),
                // 'url' => $this->input->post('url'),
                // 'is_parent' => $this->input->post('is_parent'),
                // 'parent_menu' => $this->input->post('parent_menu'),
            ];

            // echo "<pre>";
            // print_r($input);die;

            // var_dump($ipt);
            // die("<br> here");
            if ($input !== NULL) {

                //-------------------- Insert ----------------------//

                $insert = $this->db->insert('menu', $input);

                if ($insert) {
                    redirect(base_url('addmenu'), 'refresh');
                } else {
                    die("insert query failed");
                }
            }
        }

        $query = $this->db->order_by('id', 'desc')->get('menu');

        $data['rows'] = $query->result_array();

        // echo "<pre>"; print_r($data['rows']); die("pop");

        $data['parent_menus'] = $this->db->get('menu')->result_array();

        // echo "<pre>"; print_r($data['parent_menus']); die("pop");

        $this->load->view('addmenu', $data);
    }
}
