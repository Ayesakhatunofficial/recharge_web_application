<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Newadharcard extends CI_Controller
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

        if ($this->input->post() != NULL) 
        {
           //---------------------- photo -------------------//

           $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);

           $new_name = uniqid('photo-' . date('d-m-Y') . '-') . '.' . $ext;

           $config = [
               'upload_path' => './adhar_uploads',
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

           date_default_timezone_set('Asia/Kolkata');
           $date = date('d-m-Y');

            $input = [
                'adhar_no' => $this->input->post('adhar_no'),
                'photo' => $data['photo']['file_name'],
                'dob' => $this->input->post('dob'),
                'full_name' => $this->input->post('full_name'),
                'full_name_local_language' => $this->input->post('full_name_local_language'),
                'gender' => $this->input->post('gender'),
                'gender_local_language' => $this->input->post('gender_local_language'),
                'address' => $this->input->post('address'),
                'address_local_language' => $this->input->post('address_local_language'),
                'language' => $this->input->post('language'),
                'create_date' => $date,

                //---------- testing print option ----------//

                'is_pay_print1' => 1,
                'is_pay_print2' => 1
            ];

            if(!empty($input))
            {
                $this->db->insert('aadhar_details', $input);

                $error = $this->db->error();

                if($error['code'] == 0)
                {
                    redirect('viewadharcard', 'refresh');
                }
                else
                {
                    die("insert query failed");
                }
            }
            else
            {
                die('please fill all fields');
            }
        }

        $this->load->view('newadharcard', $data);
    }
}
