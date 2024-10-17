<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Editutilityapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index($id)
    {

        $data['utility_api'] = $this->db->get_where('tbl_utility_api', ['id' => $id])->row_array();

        $input = [];
        if ($this->input->post() != NULL) {
            $input = [
                'purpose' => $this->input->post('purpose'),
                'url' => $this->input->post('api_url'),
            ];

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_utility_api', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("API update query failed");
                } else {
                    redirect('viewutilityapi', 'refresh');
                }
            }
        }

        $this->load->view('editutilityapi', $data);
    }
}
