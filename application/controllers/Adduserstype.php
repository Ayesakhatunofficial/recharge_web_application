<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adduserstype extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($_SESSION['role']) {
            $input = [];

            $ipt = [];

            $data = [];

            if ($this->input->post() != NULL) {

                $ipt['id'] = $this->input->post('id');

                date_default_timezone_set('Asia/Kolkata');
                $date = date('d-m-y H:i:s');

                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $this->input->post('user_type')), "_"));

                $input = [
                    'user_type' => $this->input->post('user_type'),
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
                        $this->db->update('user_type', $input);

                        $affectedRows = $this->db->affected_rows();

                        if ($affectedRows == 1) {
                            redirect(base_url('adduserstype'), 'refresh');
                        } else {
                            die("update query failed");
                        }
                    }
                } else {
                    if ($input != NULL) {

                        //-------------------- Insert ----------------------//

                        $insert = $this->db->insert('user_type', $input);

                        if ($insert) {
                            redirect(base_url('adduserstype'), 'refresh');
                        } else {
                            die("insert query failed");
                        }
                    }
                }
            }

            $query = $this->db->order_by('id', 'desc')->get('user_type');

            $data['rows'] = $query->result_array();

            // echo "<pre>"; print_r($data['rows']); die("pop");

            if ($this->uri->segment(3) != NULL) {

                $id = $this->uri->segment(3);

                $query = $this->db->get_where('user_type', ['id' => $id]);

                $data['result'] = $query->row_array();

                // echo "<pre>"; print_r($data['result']); die('edit result here');
            }

            //-------------------- Delete -----------------------//

            if ($this->uri->segment(4) == 'del') {
                $id_del = $this->uri->segment(3);

                $this->db->delete('user_type', ['id' => $id_del]);

                $affectedRows = $this->db->affected_rows();

                if ($affectedRows == 1) {
                    redirect(base_url('adduserstype'), 'refresh');
                } else {
                    die("update query failed");
                }
            }

            $this->load->view('adduserstype', $data);
        } else {
            redirect('login');
        }
    }
}
