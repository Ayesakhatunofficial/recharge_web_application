<?php

class Support extends CI_Controller
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

    public function getServices()
    {
        $user = authuser();

        $account_type = $user['account_type'];

        $services = $this->db->get('services')->result_array();

        $user_type = $this->db->get_where('user_type', ['id' => $account_type])->row_array();

        $user_data = [
            'name' => $user['name'],
            'user_type' => $user_type['user_type'],
            'mobile' => $user['mobile'],
        ];

        $response = [
            'status' => true,
            'message' => 'Success',
            'problem_types' => $services,
            'user_data' => $user_data
        ];

        echo json_encode($response);
    }

    public function add()
    {
        $this->form_validation->set_rules('user_name', 'User Name', 'required');

        $this->form_validation->set_rules('user_type', 'User Type', 'required');

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        $this->form_validation->set_rules('problem_type', 'Problem Type', 'required');

        $this->form_validation->set_rules('query', 'Query', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = [
                'is_success' => false,
                'message' => 'Validation error',
                'error' => $this->form_validation->error_array()
            ];

            echo json_encode($response);
        } else {

            $user = authuser();

            $input = $this->input->post();

            $digits = 4;
            $support_id =  str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

            // print_r($_FILES['problem_photo']);
            // die;

            if (isset($_FILES['problem_photo'])) {

                $ext = pathinfo($_FILES["problem_photo"]['name'], PATHINFO_EXTENSION);

                $new_name = uniqid('support-' . date('d-m-Y') . '-') . '.' . $ext;
                // echo $new_name;
                // die;

                $config = [
                    'upload_path' => './uploads',
                    'allowed_types' => 'jpeg|jpg|png',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('problem_photo'))) {

                    $data['upload_error'] = $this->upload->display_errors();

                    echo json_encode($$data['upload_error']);
                } else {
                    $data['problem_photo'] = $this->upload->data();
                }
            }

            $input_data = [
                'support_id' => $support_id,
                'date' => date('Y-m-d'),
                'user_name' => $input['user_name'],
                'user_mobile' => $input['mobile'],
                'user_type' => $input['user_type'],
                'image' => $data['problem_photo']['file_name'],
                'problem_type' => $input['problem_type'],
                'query' => $input['query'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $user['id']
            ];


            $result =  $this->db->insert('support_tickets', $input_data);

            if ($result) {

                $response = [
                    'status' => true,
                    'message' => 'Support added successfully',
                ];

                echo json_encode($response);
            } else {

                $response = [
                    'status' => false,
                    'message' => 'Sopport not added'
                ];

                echo json_encode($response);
            }
        }
    }

    public function view()
    {
        $user = authuser();

        $id = $user['id'];

        $supports = $this->db->query(" SELECT 
                                            services.id, 
                                            services.service_name, 
                                            support_tickets.*
                                        FROM 
                                            support_tickets 
                                        JOIN services ON services.id = support_tickets.problem_type 
                                        WHERE support_tickets.created_by = $id 
                                        ORDER BY support_tickets.id 
                                        DESC")->result_array();



        if ($this->input->post() != NULL) {

            $from_date = $this->input->post('from_date');

            $to_date = $this->input->post('to_date');

            $supports = $this->db->query("SELECT 
                                                services.id, 
                                                services.service_name, 
                                                support_tickets.* 
                                            FROM support_tickets 
                                            JOIN services ON services.id = support_tickets.problem_type 
                                            WHERE support_tickets.created_by = $id 
                                            AND support_tickets.date BETWEEN '$from_date' AND '$to_date' 
                                            ORDER BY support_tickets.id 
                                            DESC")->result_array();
        }

        if (!is_null($supports)) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $supports,
                'image_url' => base_url() . 'uploads/'
            ];

            echo json_encode($response);
        }
    }

    public function getEditData()
    {
        $id = $this->input->get('id');

        $services = $this->db->get('services')->result_array();

        $support = $this->db->get_where('support_tickets', ['id' => $id])->row_array();

        if ($id) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'problem_type' => $services,
                'data' => $support,
                'image_url' => base_url() . 'uploads/'
            ];

            echo json_encode($response);
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('user_name', 'User Name', 'required');

        $this->form_validation->set_rules('id', 'Id', 'required');

        $this->form_validation->set_rules('user_type', 'User Type', 'required');

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        $this->form_validation->set_rules('problem_type', 'Problem Type', 'required');

        $this->form_validation->set_rules('query', 'Query', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = [
                'is_success' => false,
                'message' => 'Validation error',
                'error' => $this->form_validation->error_array()
            ];

            echo json_encode($response);
        } else {

            $user = authuser();

            $input = $this->input->post();

            $data['support'] = $this->db->get_where('support_tickets', ['id' => $input['id']])->row_array();

            if (isset($_FILES['problem_photo'])) {
                $ext = pathinfo($_FILES["problem_photo"]['name'], PATHINFO_EXTENSION);
                $new_name = uniqid('support-' . date('d-m-Y') . '-') . '.' . $ext;
                // echo $new_name;
                // die;

                $config = [
                    'upload_path' => './uploads',
                    'allowed_types' => 'jpeg|jpg|png',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('problem_photo'))) {

                    $data['upload_error'] = $this->upload->display_errors();

                    echo json_encode($data['upload_error']);
                } else {
                    $data['problem_photo'] = $this->upload->data();
                }

                if ($data['problem_photo']['file_name'] != '') {
                    // print_r($data['banner_data']['banner']); die;
                    unlink(FCPATH . 'uploads/' . $data['support']['image']);
                }
            }

            $input_data = [
                'image' => ($_FILES["problem_photo"]['name'] == "") ? $data['support']['image'] : $data['problem_photo']['file_name'],
                'problem_type' => $input['problem_type'],
                'query' => $input['query'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $user['id']
            ];

            $this->db->where('id', $input['id']);
            $result = $this->db->update('support_tickets', $input_data);

            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Update successfully',
                ];

                echo json_encode($response);
            } else {

                $response = [
                    'status' => false,
                    'message' => 'update not successfull'
                ];

                echo json_encode($response);
            }
        }
    }
}
