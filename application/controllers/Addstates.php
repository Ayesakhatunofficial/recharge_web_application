<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addstates extends CI_Controller
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

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-y H:i:s');

            $input = [
                'state' => $this->input->post('state'),
                'state_code' => $this->input->post('state_code'),
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
                    $this->db->update('state', $input);

                    $affectedRows = $this->db->affected_rows();

                    if ($affectedRows == 1) {
                        redirect(base_url('addstates'), 'refresh');
                    } else {
                        die("update query failed");
                    }
                }
            } else {
                if ($input != NULL) {

                    //-------------------- Insert ----------------------//

                    $insert = $this->db->insert('state', $input);

                    if ($insert) {
                        redirect(base_url('addstates'), 'refresh');
                    } else {
                        die("insert query failed");
                    }
                }
            }
        }

        $query = $this->db->order_by('id', 'desc')->get('state');

        $data['rows'] = $query->result_array();

        // echo "<pre>"; print_r($data['rows']); die("pop");

        if ($this->uri->segment(3) != NULL) {

            $id = $this->uri->segment(3);

            $query = $this->db->get_where('state', ['id' => $id]);

            $data['result'] = $query->row_array();

            // echo "<pre>"; print_r($data['result']); die('edit result here');
        }

        //-------------------- Delete -----------------------//

        if ($this->uri->segment(4) == 'del') {
            $id_del = $this->uri->segment(3);

            $this->db->delete('state', ['id' => $id_del]);

            $affectedRows = $this->db->affected_rows();

            if ($affectedRows == 1) {
                redirect(base_url('addstates'), 'refresh');
            } else {
                die("update query failed");
            }
        }

        $this->load->view('addstates', $data);
    }
}
