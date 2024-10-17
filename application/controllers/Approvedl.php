<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Approvedl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $data = [];

        $output = [];

        if ($this->input->post() != NULL) {
            //---------------------- photo -------------------//

            $ext = pathinfo($_FILES["pdf_file"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('DL_PDF-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './DL_uploads',
                'allowed_types' => 'pdf',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('pdf_file'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['pdf_file'] = $this->upload->data();
            }

            $input = [
                'status' => 1,
                'pdf_file' => $data['pdf_file']['file_name']
            ];
    
            // echo "<pre>"; print_r($input); die;
    
            $this->db->where(['id' => $id]);
            $this->db->update('dl_details', $input);

            // print_r($this->db->last_query()); die;
    
            $error = $this->db->error();
    
            if ($error['code'] == 0) {
                redirect('viewdrivinglicense', 'refresh');
            }
        }

        

        // $output['pdf'] = $this->db->get_where('dl_details', ['id' => $id])->row_array();
        // $this->load->view('viewdrivinglicense', $output);
    }
}
