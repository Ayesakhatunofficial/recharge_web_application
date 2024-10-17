<?php
class Operator extends CI_Controller
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

    public function mobileOperator()
    {
        $mob_operator = $this->db->get('tbl_operator')->result();

        if (!is_null($mob_operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $mob_operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function dthOperator()
    {

        $dth_operator = $this->db->get('tbl_dth_operator')->result();

        if (!is_null($dth_operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $dth_operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }

    }

    public function electricOperator()
    {
        $electric_operator = $this->db->get('tbl_services')->result();

        if (!is_null($electric_operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $electric_operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function fastagOperator()
    {
        $fastag_operator = $this->db->get('tbl_fastag_operator')->result();

        if (!is_null($fastag_operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $fastag_operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }


    public function loanOperator()
    {
        $operator = $this->db->get('tbl_loan_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function insuranceOperator()
    {
        $operator = $this->db->get('tbl_insurance_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function broadbandOperator()
    {
        $operator = $this->db->get('tbl_broadband_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function postpaidOperator()
    {
        $operator = $this->db->get('tbl_postpaid_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function gasOperator()
    {
        $operator = $this->db->get('tbl_lpg_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function landlineOperator()
    {
        $operator = $this->db->get('tbl_landline_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function cableOperator()
    {
        $operator = $this->db->get('tbl_cable_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function creditcardOperator()
    {
        $operator = $this->db->get('tbl_creditcard_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function municipleOperator()
    {
        $operator = $this->db->get('tbl_municiple_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }

    public function subscriptionOperator()
    {
        $operator = $this->db->get('tbl_subscription_operator')->result();

        if (!is_null($operator)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $operator,
                'logo_base_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        }
    }
}
