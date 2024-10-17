<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Apicommissionreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Recharge_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {


                $data['commission_reports'] = $this->Recharge_model->getComReport();
                // echo '<pre>';
                // print_r($data['commission_reports']); die;


                if ($this->input->post() != NULL) {
                    $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                    $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                    $data['commission_reports'] = $this->Recharge_model->getCommissionReport($from_date, $to_date);
                }
            }
            
            if (isset($_SESSION['slug'])) {


                $mobile = $_SESSION['mobile'];


                $data['commission_reports'] = $this->Recharge_model->getUserComReport($mobile);

                if ($this->input->post() != NULL) {
                    $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                    $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                    $data['commission_reports'] = $this->Recharge_model->getUserCommissionReport($from_date, $to_date, $mobile);
                }
            }

            $this->load->view('apicommissionreport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
