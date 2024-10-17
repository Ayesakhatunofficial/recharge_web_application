<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apisettings extends CI_Controller
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
        $ipt = [];

        // $ipt['id'] = $id;

        $data['services'] = $this->db->get('services')->result_array();

        $data['api_settings'] = $this->db->get('api_settings')->result_array();

        if ($this->uri->segment(3) != NULL) {

            $id = $this->uri->segment(3);

            $query = $this->db->get_where('api_settings', ['id' => $id]);

            $data['result'] = $query->row_array();

            // echo "<pre>"; print_r($data['result']); die('edit result here');
        }

        //   echo "<pre>"; print_r($data['api_settings']); die;

        // echo "<pre>"; print_r($data['service']); die;

        if ($this->input->post() != NULL) {

            $ipt['id'] = $this->input->post('id');

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-y H:i:s');

            $input = [
                'service' => $this->input->post('service'),
                'secret_key' => $this->input->post('secret_key'),
                'authentication_key' => $this->input->post('authentication_key'),
                'live_test' => $this->input->post('live_test'),
                'create_date' => $date
            ];

            // echo "<pre>"; print_r($input); die;

            if (!empty($ipt['id'])) {

                //------------------ Update --------------------//

                if ($input != NULL) {
                    $id = $ipt['id'];

                    // echo $id; die("update id");
                    $this->db->where('id', $id);
                    $this->db->update('api_settings', $input);

                    $affectedRows = $this->db->affected_rows();

                    if ($affectedRows == 1) {
                        redirect('apisettings', 'refresh');
                    } else {
                        die("update query failed");
                    }
                }
            } else {
                if ($input != NULL) {

                    //-------------------- Insert ----------------------//

                    $insert = $this->db->insert('api_settings', $input);

                    $error = $this->db->error();

                    if ($error['code'] == 0) {
                        redirect('apisettings', 'refresh');
                    } else {
                        die('api settings insert fasiled');
                    }
                }
            }
        }

         //-------------------- Delete -----------------------//

         if ($this->uri->segment(4) == 'del') {
            $id_del = $this->uri->segment(3);

            $this->db->delete('api_settings', ['id' => $id_del]);

            $affectedRows = $this->db->affected_rows();

            if ($affectedRows == 1) {
                redirect(base_url('apisettings'), 'refresh');
            } else {
                die("update query failed");
            }
        }

        $this->load->view('apisettings', $data);
    }
}
