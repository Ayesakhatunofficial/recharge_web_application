<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Municiplereport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Municiple_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['municiple_reports'] = $this->Municiple_model->getMunicipleData();
            }

            if (isset($_SESSION['slug'])) {
                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Municiple_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);
                    // print_r($users); die;

                    if (!is_null($merge) && !empty($merge)) {

                        $data['municiple_reports'] = $this->Municiple_model->getMunicipleDataByMobile($merge);
                    }
                } else {

                    $data['municiple_reports'] = $this->Municiple_model->getServiceData($pay_by);
                }
            }

            $data['operators'] = $this->Municiple_model->getService();

            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;
                if (isset($_SESSION['role'])) {

                    $data['municiple_reports'] = $this->Municiple_model->getMuniciplePayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!empty($merge)) {

                            $data['municiple_reports'] = $this->Municiple_model->getMunicipleReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['municiple_reports'] = $this->Municiple_model->getMunicipleReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('municiplereport', $data);
        } else {
            redirect('userlogin');
        }
    }
}
