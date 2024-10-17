<?php

class Walletrecharge extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        validJWT();

        $this->load->helper(array('form', 'url', ));

        $this->load->library('form_validation');
    }

    public function index()
    {

        $this->form_validation->set_rules('amount', 'Amount', 'required');

        $this->form_validation->set_rules('utr_no', 'UTR Number', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = [
                'is_success' => false,
                'message' => 'Validation error',
                'error' => $this->form_validation->error_array()
            ];

            echo json_encode($response);
        } else {
            $user = authuser();

            $user_type = $this->db->get_where('user_type', ['id' => $user['account_type']])->row_array();

            $userType = $user_type['user_type'];

            $date = date('d-m-Y');
            $time = date('H:m:s');

            $created_by = $user['create_by'];

            $created_by_id = $user['created_by_id'];

            if ($created_by == 'super_admin') {
                $created_by_id = $created_by;
            }

            $input = [
                'mobile' => $user['mobile'],
                'username' => $user['id'],
                'user_type' => $userType,
                'amount' => $this->input->post('amount'),
                'txn_no' => $this->input->post('utr_no'),
                'create_date' => $date,
                'create_time' => $time,
                'status' => 0,
                'remarks' => $this->input->post('narration'),
                'user_create' => $created_by_id,
            ];

            $insert = $this->db->insert('listfundrequest', $input);

            if ($insert) {
                $response = [
                    'status' => true,
                    'message' => 'Request Submit Successfully'
                ];

                echo json_encode($response);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Request not Submitted'
                ];

                echo json_encode($response);
            }



        }






    }

    public function history()
    {
        $user = authuser();

        $user_id = $user['id'];

        $history = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['username' => $user_id])->result_array();

        $response = [
            'status' => true,
            'message' => 'Success',
            'data' => $history,
            'status_code' => "1 -> approve, 0 -> pending, -1 -> rejected "
        ];

        echo json_encode($response);

    }


}
