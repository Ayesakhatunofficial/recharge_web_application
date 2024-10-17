<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        if ($this->input->post() != NULL) {

            //------------custom code verify -----------//

            if ($this->input->post('custom_code')) {

                $custom_code = $this->input->post('custom_code');

                $cust_user = $this->db->get_where('users', ['custom_code' => $custom_code])->row_array();

                if (empty($cust_user)) {

                    $this->session->set_flashdata('error', 'Please Enter a valid Referral Code');
                    redirect('registration');
                } else {

                    $cust_user_type = $this->db->get_where('user_type', ['id' => $cust_user['account_type']])->row_array();
                }
            } else {

                redirect('registration');
            }

            //------------ end  ----------------//

            //----------- create USER ID ----------------//

            $query_user_id = $this->db->query('SELECT user_id FROM users');

            $res = $query_user_id->result_array();

            $userid = "";

            if (empty($res)) {
                $userid = "UID-001";
            } else {
                $last_element = end($res);

                $last = str_split($last_element['user_id'], 3);

                $lastid = $last[1] + 1;

                $userid = 'UID' . str_pad($lastid, 3, '0', STR_PAD_LEFT);
            }

            //----------------- end -------------------//



            $user_type = $this->db->get_where('user_type', ['slug' => 'reatiler'])->row_array();

            $input = [
                'account_type' => $user_type['id'],
                'user_id ' => $userid,
                'name' => $this->input->post('name'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'gender' => $this->input->post('gender'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'pin' => $this->input->post('pin'),
                'address' => $this->input->post('address'),
                'pan' => $this->input->post('pan'),
                'adhar' => $this->input->post('adhar'),
                'password' => md5($this->input->post('password')),
                'status' => 1,
                'create_by' => $cust_user_type['slug'],
                'created_by_id' => $cust_user['id'],
            ];

            if (!empty($input)) {
                $insert = $this->db->insert('users', $input);

                $affectedrows = $this->db->affected_rows();

                if ($affectedrows) {
                    redirect('signin', 'refresh');
                }
            }
        }

        $this->load->view('registration');
    }
}
