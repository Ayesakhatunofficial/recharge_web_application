<?php
class Profile extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        validJWT();

        $this->load->helper(array('form', 'url',));

        $this->load->library('form_validation');
    }

    public function index()
    {
        $user = authuser();

        $user_id = $user['id'];

        $result = $this->db->query("SELECT 
        user_type.user_type, 
        user_type.slug, 
        users.*
        FROM users
        JOIN user_type ON user_type.id = users.account_type
        WHERE users.id = $user_id")->row();

        if (!is_null($result)) {
            $data = [
                'id' => $result->id,
                'user_type' => $result->user_type,
                'name' => $result->name,
                'mobile_number' => $result->mobile,
                'email' => $result->email,
                'address' => $result->address,
                'city' => $result->city,
                'pincode' => $result->pin,
                'password' => $result->password,
                'wallet' => $result->wallet,
                'profile_photo' => 'https://recharge.desuntechnologies.com/uploads/' . $result->photo
            ];

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $data
            ];
        }


        echo json_encode($response);
    }


    public function edit()
    {
        $profile = authuser();

        $user_id = $profile['id']; 

        $this->form_validation->set_rules('name', 'Name', 'required');

        $this->form_validation->set_rules('email', 'Email', 'required');

        $this->form_validation->set_rules('address', 'Address', 'required');

        $this->form_validation->set_rules('city', 'City', 'required');

        $this->form_validation->set_rules('password', 'Password', 'required');

        $this->form_validation->set_rules('pincode', 'Pincode', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = [
                'is_success' => false,
                'message' => 'Validation error',
                'error' => $this->form_validation->error_array()
            ];

            echo json_encode($response);
        } else {

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            $city = $this->input->post('city');
            $pincode = $this->input->post('pincode');

            //----------- user get data  ----------//

            $user = $this->db->get_where('users', ['id' => $user_id])->row();

            //-----------   password   -----------//

            $password = $this->input->post('password');

            if ($password == $user->password) {
                $password = $password;
            } else {
                $password = md5($password);
            }

            //----------   image -----------//

            $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);

            $new_name = uniqid('A-' . date('d-m-Y') . '-') . '.' . $ext;

            $config = [
                'upload_path' => './uploads',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if (!($this->upload->do_upload('profile_photo'))) {

                $data['upload_error'] = $this->upload->display_errors();

                echo json_encode($data['upload_error']);
            } else {

                $data['profile_photo'] = $this->upload->data();
            }

            $photo = isset($data['profile_photo']['file_name']) ? $data['profile_photo']['file_name'] : $user->photo;

            $data = [
                'name' => $name,
                'email' =>  $email,
                'city' => $city,
                'password' => $password,
                'address' => $address,
                'pin' => $pincode,
                'photo' => $photo
            ];

            // echo json_encode($data); die;
            // echo $user_id; die;

            $this->db->where('id', $user_id); // Simplified where condition
            $result = $this->db->update('users', $data);

            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Profile Update Successfully'
                ];

                echo json_encode($response);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Profile not updated'
                ];

                echo json_encode($response);
            }
        }
    }
}
