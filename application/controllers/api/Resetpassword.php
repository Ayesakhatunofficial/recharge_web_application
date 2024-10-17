<?php
class Resetpassword extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        $this->load->helper(array('form', 'url',));

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

        $this->form_validation->set_rules('new_password', 'New Password', 'required');

        $this->form_validation->set_message('unique_mobile', "The Mobile Number doesn't exists.");

        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $error_messages = str_replace(["<br>", "\n"], '', $error_messages);

            $response = [
                'is_success' => false,
                'message' => $error_messages,
            ];

            echo json_encode($response);
        } else {

            $mobile  = $this->input->post('mobile_number');
            $new_pass = md5($this->input->post('new_password'));

            $data = [
                'password' => $new_pass
            ];

            $this->db->where('mobile', $mobile);
           $result = $this->db->update('users', $data);

           if($result){
            $respond = [
                'is_success' => true,
                'message' => 'Password update Successfully',
            ];
            echo json_encode($respond);
           }else{
            $respond = [
                'is_success' => false,
                'message' => 'Something went wrong',
            ];

            echo json_encode($respond);
           }
        }
    }

    private function unique_mobile($value)
    {
        $result = $this->db->get_where('users', ['mobile' => $value])->row();

        return !is_null($result);
    }
}
