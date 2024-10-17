<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Panfinder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $data = [];
        $input = [];

        // echo "<pre>"; print_r($this->input->post()); die;

        if ($this->input->post() != NULL) {

            //---------------------- photo -------------------//

            $ext = pathinfo($_FILES["adhar_front_photo"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('adhar_front_photo-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './pan_uploads',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('adhar_front_photo'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['adhar_front_photo'] = $this->upload->data();
            }

            //---------------------- Signature photo -------------------//

            $ext = pathinfo($_FILES["adhar_back_photo"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('adhar_back_photo-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './pan_uploads',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('adhar_back_photo'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['adhar_back_photo'] = $this->upload->data();
            }

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y');

            $input = [
                'adhar_no' => $this->input->post('adhar_no'),
                'full_name' => $this->input->post('full_name'),
                'father_name' => $this->input->post('father_name'),
                'adhar_front_photo' => $data['adhar_front_photo']['file_name'],
                'adhar_back_photo' => $data['adhar_back_photo']['file_name'],
                'create_date' => $date
            ];

            if (!empty($input)) {
                $this->db->insert('panfinder', $input);

                $error = $this->db->error();

                if ($error['code'] == 0) {
                    redirect('viewpanfinder', 'refresh');
                } else {
                    die("insert query failed");
                }
            } else {
                die('please fill all fields');
            }
        }

        // $this->load->view('panfinder', $data);

        $this->load->view('panfinder');
    }
}
