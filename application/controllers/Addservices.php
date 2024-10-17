<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addservices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        $input = [];

        $ipt = [];

        $data = [];

        $service_image = [];

        if ($this->input->post() != NULL) {

            $ipt['id'] = $this->input->post('id');

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-y H:i:s');

            // echo "<pre>"; print_r($_FILES); die;

            

            $i = 0;

            foreach ($_FILES['serviceimage']['tmp_name'] as $val) {

                move_uploaded_file($val, 'service_image/' . $_FILES['serviceimage']['name'][$i]);

                $service_image = [
                    'service_name' => $this->input->post('service_name'),
                    'image' => $_FILES['serviceimage']['name'][$i]
                ];

                $this->db->insert('service_image', $service_image);

                $i++;
            }

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $this->input->post('service_name')), "_")) ;

            $input = [
                'service_name' => $this->input->post('service_name'),
                'slug' => $slug,
                'create_date' => $date,
                'status' => $this->input->post('status')
            ];

            // echo "<pre>";
            // print_r($input);

            // var_dump($ipt);
            // die("<br>here");

            if (!empty($ipt['id'])) {

                //------------------ Update --------------------//

                if ($input != NULL) {
                    $id = $ipt['id'];

                    // echo $id; die("update id");
                    $this->db->where('id', $id);
                    $this->db->update('services', $input);

                    $affectedRows = $this->db->affected_rows();

                    if ($affectedRows == 1) {
                        redirect(base_url('addservices'), 'refresh');
                    } else {
                        die("update query failed");
                    }
                }
            } else {
                if ($input != NULL) {

                    //-------------------- Insert ----------------------//

                    $insert = $this->db->insert('services', $input);

                    if ($insert) {
                        redirect(base_url('addservices'), 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }
        }

        $query = $this->db->get('services');

        $data['rows'] = $query->result_array();

        // echo "<pre>"; print_r($data['rows']); die("pop");

        if ($this->uri->segment(3) != NULL) {
            $id = $this->uri->segment(3);

            $query = $this->db->get_where('services', ['id' => $id]);

            $data['result'] = $query->row_array();

            // echo "<pre>"; print_r($data['result']); die;
        }

        //-------------------- Delete -----------------------//

        if ($this->uri->segment(4) == 'del') {
            $id_del = $this->uri->segment(3);

            $this->db->delete('services', ['id' => $id_del]);

            $affectedRows = $this->db->affected_rows();

            if ($affectedRows == 1) {
                $this->db->delete('service_image', ['service_name' => $data['result']['service_name']]);
                $affectedRows = $this->db->affected_rows();
                if ($affectedRows == 1) {
                    redirect(base_url('addservices'), 'refresh');
                } else {
                    die("delete-service-image query failed");
                }
            } else {
                die("delete query failed");
            }
        }

        $this->load->view('addservices', $data);
    }
}
