<?php

class Commission extends CI_Controller
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

        $this->load->model('Recharge_model');
    }

    public function index()
    {
        $user = authuser();

        $created_by_id = $user['created_by_id'];
        $create_by = $user['created_by']; //d

        $user_1 = $this->db->get_where('users', ['id' => $created_by_id])->row(); //d
        $user_1_createdById = $user_1->created_by_id;
        $user_1_type = $user_1->create_by; //sd

        $user_2 = $this->db->get_where('users', ['id' => $user_1_createdById])->row(); //sd
        $user_2_createdById = $user_2->created_by_id;
        $user_2_type = $user_2->create_by; //a

        if ($create_by == 'admin') {

            $commissions = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => $created_by_id])->result_array();
        } elseif ($user_1_type == 'admin') {

            $commissions = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => $user_1_createdById])->result_array();
        } elseif ($user_2_type == 'admin') {

            $commissions  = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => $user_2_createdById])->result_array();
        } else {
            $commissions = $this->db->order_by('id', 'desc')->get_where('show_commission', ['created_by' => 'super_admin'])->result_array();
        }

        $response = [
            'status' => true,
            'message' => 'Success',
            'data' => $commissions,
            'logo_url' => base_url('operator_image/')
        ];

        echo json_encode($response);
    }

    public function report()
    {
        $user = authuser();

        $mobile = $user['mobile'];

        $report = $this->Recharge_model->getUserComReport($mobile);

        if ($this->input->post() != NULL) {

            $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

            $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

            $report = $this->Recharge_model->getUserCommissionReport($from_date, $to_date, $mobile);
        }

        if (!is_null($report)) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $report
            ];

            echo json_encode($response);
        }
    }
}
