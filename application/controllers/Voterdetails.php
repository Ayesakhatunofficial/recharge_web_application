<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Voterdetails extends CI_Controller
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

        $result = [];

        if ($this->input->post() != NULL) {
            $this->load->library('simple_html_dom');

            // $file_name = $_FILES['inputfile']['name'];

            if (isset($_FILES['inputfile']['name'])) {
                
                $config = [
                    'upload_path' => './votercard/voter_nvsp_uploads/',
                    'allowed_types' => 'html',
                    'file_name' => $_FILES['inputfile']['name']
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('inputfile'))) {

                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $data['inputfile'] = $this->upload->data();
                }

                $file = $data['inputfile']['full_path'];

                $url = file_get_html($file, true);

                if (!empty($url)) {
                    foreach ($url->find('.border_black_bottom') as $div_class) {
                        foreach ($div_class->find('#state') as $state) {
                            $result['state'] = $state->value;
                        }

                        foreach ($div_class->find('#st_code') as $st_code) {
                            $result['st_code'] = $st_code->value;
                        }

                        foreach ($div_class->find('#ac_no') as $ac_no) {
                            $result['ac_no'] = $ac_no->value;
                        }

                        foreach ($div_class->find('#ac_name') as $ac_name) {
                            $result['ac_name'] = $ac_name->value;
                        }

                        foreach ($div_class->find('#parliment + td') as $parliment) {
                            $result['parliment'] = $parliment->plaintext;
                        }

                        foreach ($div_class->find('#name') as $name) {
                            $result['name'] = $name->value;
                        }

                        foreach ($div_class->find('#gender') as $gender) {
                            $result['gender'] = $gender->value;
                        }

                        foreach ($div_class->find('#epic_no+td') as $epic_no) {
                            $result['epic_no'] = $epic_no->plaintext;
                        }

                        foreach ($div_class->find('#rln_name') as $rln_name) {
                            $result['father_name'] = $rln_name->value;
                        }

                        foreach ($div_class->find('#part_no') as $part_no) {
                            $result['part_no'] = $part_no->value;
                        }

                        foreach ($div_class->find('#part_name') as $part_name) {
                            $result['part_name'] = $part_name->value;
                        }

                        foreach ($div_class->find('#slno_inpart') as $slno_inpart) {
                            $result['serial_no'] = $slno_inpart->value;
                        }

                        foreach ($div_class->find('#ps_name') as $ps_name) {
                            $result['polling_station'] = $ps_name->value;
                        }

                        foreach ($div_class->find('input[name=polling_date]') as $polling_date) {
                            $result['polling_date'] = $polling_date->value;
                        }
                    }
                }
            }
            
            $data['result'] = $result;
        }

        $data['languages'] = $this->db->get('language')->result_array();

        if ($this->input->post('submitbtn') != 0) {
            
            //---------------------- photo -------------------//

           $ext = pathinfo($_FILES["profile_photo"]['name'], PATHINFO_EXTENSION);

           $new_name = uniqid('voter-' . date('d-m-Y') . '-') . '.' . $ext;

           $config = [
               'upload_path' => './votercard/profile_image/',
               'allowed_types' => 'gif|jpg|png',
               'file_name' => $new_name
           ];

           $this->upload->initialize($config);

           $this->load->library('upload', $config);

           if (!($this->upload->do_upload('profile_photo'))) {

               $data['upload_error'] = $this->upload->display_errors();
           } else {
               $data['profile_photo'] = $this->upload->data();
           }

           date_default_timezone_set('Asia/Kolkata');
           $date = date('d-m-Y');

           $input = [
            'profile_photo' => $data['profile_photo']['file_name'],
            'language' => $this->input->post('language'),
            'epic_no' => $this->input->post('epic_no'),
            'name' => $this->input->post('name'),
            'full_name_local_language' => $this->input->post('full_name_local_language'),
            'f_h_type' => $this->input->post('f_h_type'),
            'f_h_name' => $this->input->post('f_h_name'),
            'f_h_name_local_language' => $this->input->post('f_h_name_local_language'),
            'gender' => $this->input->post('gender'),
            'dob' => $this->input->post('dob'),
            'assembly' => $this->input->post('assembly'),   
            'assembly_local' => $this->input->post('assembly_local'),
            'part_no' => $this->input->post('part_no'),
            'part_name' => $this->input->post('part_name'),
            'part_name_local' => $this->input->post('part_name_local'),   
            'address' => $this->input->post('address'),   
            'address_local_language' => $this->input->post('address_local_language'),  
            'create_date' => $date,

            //---------- testing print option ----------//

            'is_pay_print' => 1,
            'is_pay_print1' => 1,
            'is_pay_e_print' => 1,
            'is_pay_print2' => 1

           ];

        //    echo "<pre>"; print_r($input); die;

           if(!empty($input))
           {
            $this->db->insert('voter_details', $input);

            $error = $this->db->error();

            if($error['code'] == 0)
            {
                redirect('viewvotercard', 'refresh');
            }
           }
        }

        $this->load->view('voterdetails', $data);
    }
}
