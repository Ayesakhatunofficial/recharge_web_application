<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index($id = NULL)
    {

        if ($_SESSION['role'] || $_SESSION['slug'] == 'admin') {
            $data = [];

            if ($id) {
                $data['notifications'] = $this->db->get_where('notifications', ['id' => $id])->row_array();
            }

            if ($this->input->post() != NULL) {

                if ($_SESSION['role']) {

                    $updated_by = $_SESSION['role'];
                } else if ($_SESSION['slug']) {

                    $updated_by = $_SESSION['user_id'];
                }

                if ($this->input->post('id')) {

                    $input = [
                        'notification' => $this->input->post('notification'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => $updated_by
                    ];

                    if (!empty($input)) {
                        $this->db->where('id', $this->input->post('id'));

                        $result = $this->db->update('notifications', $input);

                        if ($result) {

                            redirect('notifications/view');
                        }
                    }
                } else {


                    $input = [
                        'notification' => $this->input->post('notification'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $updated_by
                    ];


                    if (!empty($input)) {
                        $result = $this->db->insert('notifications', $input);

                        if ($result) {

                            redirect('notifications/view');
                        }
                    }
                }
            }


            $this->load->view('notifications', $data);
        } else {
            redirect('userlogin');
        }
    }


    public function view()
    {
        if ($_SESSION['role'] || $_SESSION['slug'] == 'admin') {


            if ($_SESSION['role']) {

                $data['notifications'] = $this->db->get('notifications')->result_array();
                
            } else if ($_SESSION['slug'] == 'admin') {

                $user_id = $_SESSION['user_id'];

                $data['notifications'] = $this->db->get_where('notifications', ['created_by' => $user_id])->result_array();
            }

            $this->load->view('viewnotifications', $data);
        } else {
            redirect('userlogin');
        }
    }

    public function delete($id)
    {
        $this->db->delete('notifications', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {

            redirect('notifications/view', 'refresh');
        } else {

            die("delete news failed");
        }
    }
}
