<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index($user_code = NULL)
    {
        $data['user_code'] = $user_code;
        // echo $user_code; die;
        $input = [];

        if ($this->input->post() != NULL) {
            //  echo 'ayesa'; die;
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

            $user_type = $this->db->get_where('user_type', ['slug' => 'reatiler'])->row_array();
            if ($this->input->post('user_code') == '') {
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
                    'create_by' => 'super_admin',
                ];
            } else {
                $user_code = $this->input->post('user_code');
                // echo $user_code;
                $users = $this->db->get_where('users', ['user_id' => $user_code])->row_array();
                // print_r($users);
                if (!empty($users)) {
                    $account_type = $users['account_type'];
                    $type = $this->db->get_where('user_type', ['id' => $account_type])->row_array();
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
                    ];

                    if ($type['slug'] == 'reatiler') {
                        $input['create_by'] = $users['create_by'];
                        if ($users['create_by'] != 'super_admin') {
                            $input['created_by_id'] = $users['created_by_id'];
                        }
                    } else {
                        $input['create_by'] = $type['slug'];
                        $input['created_by_id'] = $users['id'];
                    }
                    // print_r($input); 
                } else {
                    redirect('signup');
                }
            }


            if (!empty($input)) {
                $insert = $this->db->insert('users', $input);

                $affectedrows = $this->db->affected_rows();

                if ($affectedrows) {
                    redirect('userlogin', 'refresh');
                }
            }
        }

        $this->load->view('signup', $data);
    }
}
