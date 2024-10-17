<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Offers extends CI_Controller
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

        $data['services'] = $this->db->get('services')->result_array();

        // echo "<pre>"; print_r($data['services']); die('service');

        $data['offers'] = $this->db->get('offers')->result_array();

        $input = [];

        $ipt = [];

        if ($this->uri->segment(3) != NULL) {

            $id = $this->uri->segment(3);

            $query = $this->db->get_where('offers', ['id' => $id]);

            $data['result'] = $query->row_array();

            // echo "<pre>"; print_r($data['result']); die('edit result here');
        }

        if ($this->input->post() != NULL) {
            date_default_timezone_set('Asia/Kolkata');
            // $date = date('d-m-y H:i:s');

            $ext = pathinfo($_FILES["offer_image"]['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('offer_image-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './offer_image',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('offer_image'))) {

                $data['upload_error'] = $this->upload->display_errors();
            } else {
                $data['offer_image'] = $this->upload->data();
            }

            $ipt['id'] = $this->input->post('id');

            $input = [
                'service_category' => $this->input->post('service_category'),
                'offer_image' => ($_FILES['offer_image']['name'] == "") ? $data['result']['offer_image'] : $data['offer_image']['file_name'],
                'title' => $this->input->post('title'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'offer' => $this->input->post('offer'),
                'amount' => $this->input->post('amount'),
            ];

            if (!empty($ipt['id'])) {
                if (!empty($input)) {
                    $this->db->where(['id' => $ipt['id']]);
                    $this->db->update('offers', $input);

                    $error = $this->db->error();

                    if ($error['code'] == 0) {
                        redirect('offers', 'refresh');
                    } else {
                        die('update offers failed');
                    }
                }
            } else {
                if (!empty($input)) {
                    $insert = $this->db->insert('offers', $input);

                    $error = $this->db->error();

                    if ($error['code'] == 0) {
                        redirect('offers', 'refresh');
                    } else {
                        die("offers insert failed");
                    }
                }
            }
        }

        $this->load->view('offers', $data);
    }
}
