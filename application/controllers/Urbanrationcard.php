<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Urbanrationcard extends CI_Controller
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

        $data['states'] = $this->db->get('state')->result_array();

        if ($this->input->post() != NULL) {

            //---------------------- family_photo -------------------//

            $ext = pathinfo($_FILES["family_photo"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('Ufamily_photo-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './rationcard',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('family_photo'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['family_photo'] = $this->upload->data();
            }

            //---------------------- family_photo -------------------//

            $ext = pathinfo($_FILES["sign_photo"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('Usign-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './rationcard',
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

            // echo $data['upload_data']['full_path']; die("fulll path");

            // echo "<pre>"; print_r($data['adhar_front']); die("file name");

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y');

            $input = [
                'ration_type' => 'Urban',
                'ration_no' => $this->input->post('ration_no'),
                'full_name' => $this->input->post('full_name'),
                'father_name' => $this->input->post('father_name'),
                'block' => $this->input->post('block'),
                'panchayat' => $this->input->post('panchayat'),
                'village' => $this->input->post('village'),
                'state' => $this->input->post('state'),
                'district' => $this->input->post('district'),
                'family_photo' => $data['family_photo']['file_name'],
                'sign_photo' => $data['sign_photo']['file_name'],
                'create_date' => $date
            ];

            if (!empty($input)) {
                $insert = $this->db->insert('ration_details', $input);

                $error = $this->db->error();

                if ($error['code'] == 0) {
                    redirect('viewrationcard', 'refresh');
                }
            }
        }

        $this->load->view('urbanrationcard', $data);
    }
}
