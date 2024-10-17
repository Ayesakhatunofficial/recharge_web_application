<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Privacy extends CI_Controller
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
            $data['privacy'] = $this->db->get_where('privacy_policy', ['id' => $id])->row_array();
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

                    $result = $this->db->update('privacy_policy', $input);

                    if ($result) {

                        redirect('privacy/view');
                    }
                }
            } else {


                $input = [
                    'url' => $this->input->post('url'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $_SESSION['role']
                ];


                if (!empty($input)) {
                    $result = $this->db->insert('privacy_policy', $input);

                    if ($result) {

                        redirect('privacy/view');
                    }
                }
            }
        }


        $this->load->view('privacy', $data);
    }


    public function view()
    {
        $data['privacy'] = $this->db->get('privacy_policy')->result_array();

        $this->load->view('viewprivacy', $data);
    }

    public function delete($id)
    {
        $this->db->delete('privacy_policy', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {

            redirect('privacy/view', 'refresh');
        } else {

            die("delete news failed");
        }
    }
}
