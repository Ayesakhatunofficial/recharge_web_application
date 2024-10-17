<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Newpancard extends CI_Controller
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

        $data['languages'] = $this->db->get('language')->result_array();

        // echo "<pre>"; print_r($this->input->post()); die;

        if ($this->input->post() != NULL) {
            if ($this->input->post('age') == '18-') {
                die('Sorry, You are not eligible to enroll for PAN Card');
            } else {
                //---------------------- photo -------------------//

                $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);

                $new_name = uniqid('photo-' . date('d-m-Y') . '-') . '.' . $ext;

                $config = [
                    'upload_path' => './pan_uploads',
                    'allowed_types' => 'gif|jpg|png',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('photo'))) {

                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $data['photo'] = $this->upload->data();
                }

                //---------------------- Signature photo -------------------//

                $ext = pathinfo($_FILES["sign_photo"]['name'], PATHINFO_EXTENSION);

                $new_name = uniqid('sign_photo-' . date('d-m-Y') . '-') . '.' . $ext;

                $config = [
                    'upload_path' => './pan_uploads',
                    'allowed_types' => 'gif|jpg|png',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('sign_photo'))) {

                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $data['sign_photo'] = $this->upload->data();
                }

                date_default_timezone_set('Asia/Kolkata');
                $date = date('d-m-Y');

                $input = [
                    'age_type' => $this->input->post('age_type'),
                    'pan_no' => $this->input->post('pan_no'),
                    'full_name' => $this->input->post('full_name'),
                    'father_name' => $this->input->post('father_name'),
                    'dob' => $this->input->post('dob'),
                    'gender' => $this->input->post('gender'),
                    'photo' => $data['photo']['file_name'],
                    'sign_photo' => $data['sign_photo']['file_name'],
                    'create_date' => $date,

                    //---------- testing print option ----------//

                    'is_pay_nsdl_print' => 1,
                    'is_pay_uti_print' => 1
                ];

                if (!empty($input)) {
                    $this->db->insert('pan_details', $input);

                    $error = $this->db->error();

                    if ($error['code'] == 0) {
                        redirect('viewpancard', 'refresh');
                    } else {
                        die("insert query failed");
                    }
                } else {
                    die('please fill all fields');
                }
            }
        }

        $this->load->view('newpancard', $data);
    }
}
