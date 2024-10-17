<?php

class Wallethistory extends CI_Controller
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

        $mobile = $user['mobile'];

        $history = $this->db->order_by('id', 'desc')->get_where('wallet_balance_history', ['from_mobile' => $mobile])->result_array();

        if ($this->input->post() != NULL) {

            $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

            $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

            $history = $this->db->order_by('id', 'desc')->query("SELECT * FROM wallet_balance_history WHERE from_mobile = $mobile AND date BETWEEN '{$from_date}' AND '{$to_date}'")->result_array();
        }

        foreach ($history as $row) {
            $data[] = [
                'number' => $row['mobile'],
                'user_type' => $row['user_type'],
                'date' => $row['date'],
                'time' => $row['time'],
                'cr_dr' => $row['cr_dr'],
                'amount' => $row['amount'],
                'balance' => $row['balance'],
                'remarks' => $row['remarks']

            ];
        }
        $response = [
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ];

        echo json_encode($response);
    }
}
