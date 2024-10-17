<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Terms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index($id = NULL)
    {
        $data = [];

        if ($id) {
            $data['terms'] = $this->db->get_where('terms_and_conditions', ['id' => $id])->row_array();
        }

        if ($this->input->post() != NULL) {

            if ($this->input->post('id')) {

                $input = [
                    'url' => $this->input->post('url'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $_SESSION['role']
                ];

                if (!empty($input)) {
                    $this->db->where('id', $this->input->post('id'));

                    $result = $this->db->update('terms_and_conditions', $input);

                    if ($result) {

                        redirect('terms/view');
                    }
                }
            } else {


                $input = [
                    'url' => $this->input->post('url'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $_SESSION['role']
                ];


                if (!empty($input)) {
                    $result = $this->db->insert('terms_and_conditions', $input);

                    if ($result) {

                        redirect('terms/view');
                    }
                }
            }
        }


        $this->load->view('terms', $data);
    }


    public function view()
    {
        $data['terms'] = $this->db->get('terms_and_conditions')->result_array();

        $this->load->view('viewterms', $data);
    }

    public function delete($id)
    {
        $this->db->delete('terms_and_conditions', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {

            redirect('terms/view', 'refresh');
        } else {

            die("delete news failed");
        }
    }
}
