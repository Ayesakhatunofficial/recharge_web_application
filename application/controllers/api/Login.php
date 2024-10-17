<?php

class Login extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        $this->load->helper(array('form', 'url', ));

        $this->load->library('form_validation');
    }

    public function index()
    {

        $this->form_validation->set_rules('mobile_number', 'Mobile Number', array(
            'required',
            'numeric',
            array('unique_mobile', function ($str) {
                return $this->unique_mobile($str);
            })
        ));

        $this->form_validation->set_rules('password', 'Password', array(
            'required',
            array('unique_pass', function ($str) {
                $mobileNumber = $this->input->post('mobile_number');
                return $this->unique_pass($str, $mobileNumber);
            })
        ));

        $this->form_validation->set_message('unique_mobile', "The Mobile Number Doesn't exists.");

        $this->form_validation->set_message('unique_pass', "The Password Doesn't match.");

        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $error_messages = str_replace(["<br>", "\n"], '', $error_messages);

            $response = [
                'is_status' => false,
                'message' => $error_messages,
            ];

            echo json_encode($response);
        } else {

            $mobile = $this->input->post('mobile_number');

            $user = $this->db->get_where('users', ['mobile' => $mobile])->row();

            $auth_token = generateAuthToken($user);

            $response = [
                'status' => true,
                'message' => 'user Login successful',
                'data' => $auth_token,
            ];

            echo json_encode($response);
        }
    }

    private function unique_mobile($value)
    {
        $result = $this->db->get_where('users', ['mobile' => $value])->row();

        return !is_null($result);
    }

    private function unique_pass($value, $mobile)
    {
        $result = $this->db->get_where('users', ['mobile' => $mobile])->row();

        if (!is_null($result)) {
            $password = md5($value);

            if ($result->password != $password) {
                return false;
            } else {
                return true;
            }
        }
    }
}
