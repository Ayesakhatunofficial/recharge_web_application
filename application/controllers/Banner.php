<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($this->input->post()) {
            $ext = pathinfo($_FILES["banner"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('banner-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './uploads',
                'allowed_types' => 'jpeg|jpg|png',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('banner'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['banner'] = $this->upload->data();
            }

            $input = [
                'banner' => $data['banner']['file_name'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result =  $this->db->insert('tb_banner', $input);

            if ($result) {
                redirect('viewbanner', 'refresh');
            } else {
                die("insert query failed");
            }
        }
        $this->load->view('banner');
    }

    public function edit($id)
    {
        $data = [];
        $data['banner_data'] = $this->db->get_where('tb_banner', ['id' => $id])->row_array();
        if ($this->input->post()) {

            
            $ext = pathinfo($_FILES["banner"]['name'], PATHINFO_EXTENSION);
            // echo $ext; die;

            $new_name = uniqid('banner-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './uploads',
                'allowed_types' => 'jpeg|jpg|png',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('banner'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['banner'] = $this->upload->data();
            }

            

            if ($data['banner']['file_name'] != '') {
                // print_r($data['banner_data']['banner']); die;
                unlink(FCPATH . 'uploads/' . $data['banner_data']['banner']);
            }

            $input = [
                'banner' => ($_FILES["banner"]['name'] == "") ? $data['banner_data']['banner'] : $data['banner']['file_name'],
                'updated_at' => date('Y-m-d H:i:s')
            ];



            $this->db->where(['id' => $id]);
            $result =  $this->db->update('tb_banner', $input);

            if ($result) {
                redirect('viewbanner', 'refresh');
            } else {
                die("insert query failed");
            }
        }
        $this->load->view('editbanner', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tb_banner', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewbanner', 'refresh');
        } else {
            die("delete news failed");
        }
    }
}
