<?php
defined('BASEPATH') or exit('No direct scriptaccess allowed');

class Deleteoperator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $this->db->delete('tbl_operator', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function dth_delete($id)
    {
        $this->db->delete('tbl_dth_operator', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function electric_delete($id)
    {
        $this->db->delete('tbl_services', ['id' => $id]);

        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function postpaid_delete($id)
    {
        $this->db->delete('tbl_postpaid_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function loan_delete($id)
    {
        $this->db->delete('tbl_loan_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function fastag_delete($id)
    {
        $this->db->delete('tbl_fastag_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function lpg_gas_delete($id)
    {
        $this->db->delete('tbl_lpg_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function insurance_delete($id)
    {
        $this->db->delete('tbl_insurance_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function broadband_delete($id)
    {
        $this->db->delete('tbl_broadband_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function municiple_delete($id)
    {
        $this->db->delete('tbl_municiple_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function credit_delete($id)
    {
        $this->db->delete('tbl_creditcard_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function landline_delete($id)
    {
        $this->db->delete('tbl_landline_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function cable_delete($id)
    {
        $this->db->delete('tbl_cable_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }

    public function subscription_delete($id)
    {
        $this->db->delete('tbl_subscription_operator', ['id' => $id]);
        $error = $this->db->error();

        if ($error['code'] == 0) {
            redirect('viewoperator', 'refresh');
        } else {
            die("delete Operator failed");
        }
    }
}
