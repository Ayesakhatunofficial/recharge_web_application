<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
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
        $data['news'] = $this->db->get_where('tb_news', ['id' => $id])->row_array();

        if ($this->input->post()) {
            $news = $this->input->post('news');
            $id = $this->input->post('id');

            if (isset($_SESSION['role'])) {
                $created_by = $_SESSION['role'];
            } else if (isset($_SESSION['slug']) && $_SESSION['slug'] == 'admin') {
                $created_by = $_SESSION['user_id'];
            }

            if ($id == '') {
                $input = [
                    'news' => $news,
                    'created_by' => $created_by,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $result =  $this->db->insert('tb_news', $input);
            } else {

                $input = [
                    'news' => $news,
                    'created_by' => $created_by,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->db->where('id', $id);
                $result = $this->db->update('tb_news', $input);
            }


            if ($result) {
                redirect('viewnews', 'refresh');
            } else {
                die("insert query failed");
            }
        }
        $this->load->view('news', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tb_news', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewnews', 'refresh');
        } else {
            die("delete news failed");
        }
    }
}
