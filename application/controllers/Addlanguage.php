<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addlanguage extends CI_Controller
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

        if ($this->input->post() != NULL) {

            $ipt['id'] = $this->input->post('id');

            $input = [
                'language' => $this->input->post('language'),
                'language_code' => $this->input->post('language_code'),
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
                    $this->db->update('language', $input);

                    $affectedRows = $this->db->affected_rows();

                    if ($affectedRows == 1) {
                        redirect(base_url('addlanguage'), 'refresh');
                    } else {
                        die("update query failed");
                    }
                }
            } else {
                if ($input != NULL) {

                    //-------------------- Insert ----------------------//

                    $insert = $this->db->insert('language', $input);

                    if ($insert) {
                        redirect(base_url('addlanguage'), 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }
        }

        $query = $this->db->get('language');

        $data['rows'] = $query->result_array();

        // echo "<pre>"; print_r($data['rows']); die("pop");

        if ($this->uri->segment(3) != NULL) {

            $id = $this->uri->segment(3);

            $query = $this->db->get_where('language', ['id' => $id]);

            $data['result'] = $query->row_array();

            // echo "<pre>"; print_r($data['result']); die('edit result here');
        }

        //-------------------- Delete -----------------------//

        if ($this->uri->segment(4) == 'del') {
            $id_del = $this->uri->segment(3);

            $this->db->delete('language', ['id' => $id_del]);

            $affectedRows = $this->db->affected_rows();

            if ($affectedRows == 1) {
                redirect(base_url('addlanguage'), 'refresh');
            } else {
                die("update query failed");
            }
        }

        $this->load->view('addlanguage', $data);
    }
}
