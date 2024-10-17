<?php

class Signup extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
    }


    public function index()
    {

        $this->form_validation->set_rules('full_name', 'Full Name', 'required');

        $this->form_validation->set_rules('mobile_number', 'Mobile Number', array(
            'required',
            'numeric',
            array('unique_mobile', function ($str) {
                return $this->unique_mobile($str);
            })
        ));

        $this->form_validation->set_rules('email', 'Email', 'required');

        $this->form_validation->set_rules('state', 'State', 'required');

        $this->form_validation->set_rules('city', 'City', 'required');

        $this->form_validation->set_rules('address', 'Address', 'required');

        $this->form_validation->set_rules('gender', 'Gender', 'required');

        $this->form_validation->set_rules('password', 'Password', 'required');

        $this->form_validation->set_rules('pan_card_number', 'Pan Card Number', array(
            'required',
            array('unique_pan', function ($str) {
                return $this->unique_pan($str);
            })
        ));

        $this->form_validation->set_rules('aadhar_card_number', 'Aadhar Card Number', array(
            'required',
            array('unique_adhar', function ($str) {
                return $this->unique_adhar($str);
            })
        ));


        $this->form_validation->set_message('unique_mobile', 'The Mobile Number already exists.');
        $this->form_validation->set_message('unique_pan', 'The Pan Number already exists.');
        $this->form_validation->set_message('unique_adhar', 'The Aadhar Number already exists.');

        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $error_messages = str_replace(["<br>", "\n"], '', $error_messages);

            $response = [
                'is_success' => false,
                'message' => $error_messages,
            ];

            echo json_encode($response);
        } else {

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

            $input_data = [
                'user_id' => $userid,
                'account_type' => $user_type['id'],
                'name' => $this->input->post('full_name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile_number'),
                'gender' => $this->input->post('gender'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'pin' => $this->input->post('pin_code'),
                'address' => $this->input->post('address'),
                'pan' => $this->input->post('pan_card_number'),
                'adhar' => $this->input->post('aadhar_card_number'),
                'password' => md5($this->input->post('password')),
                'status' => 1,
                'create_by' => 'super_admin'
            ];

            $result = $this->db->insert('users', $input_data);

            if ($result) {
                $response = [
                    'is_success' => true,
                    'message' => 'User Created Successfully',
                ];

                echo json_encode($response);
            } else {
                $response = [
                    'is_success' => false,
                    'message' => 'User not created',
                ];

                echo json_encode($response);
            }
        }
    }

    private function unique_mobile($value)
    {
        $result = $this->db->get_where('users', ['mobile' => $value])->row();

        return is_null($result);
    }

    private function unique_pan($value)
    {
        $result = $this->db->get_where('users', ['pan' => $value])->row();

        return is_null($result);
    }

    private function unique_adhar($value)
    {
        $result = $this->db->get_where('users', ['adhar' => $value])->row();

        return is_null($result);
    }
}
