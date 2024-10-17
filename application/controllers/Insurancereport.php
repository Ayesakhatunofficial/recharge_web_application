<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Insurancereport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Insurance_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['insurance_reports'] = $this->Insurance_model->getInsurancePayData();
            }

            if (isset($_SESSION['slug'])) {

                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {
                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Insurance_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    if (!is_null($merge) && !empty($merge)) {

                        $data['insurance_reports'] = $this->Insurance_model->getInsuranceDataByMobile($merge);
                    }
                } else {

                    $data['insurance_reports'] = $this->Insurance_model->getInsuranceData($pay_by);
                }
            }

            $data['operators'] = $this->Insurance_model->getService();
            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;

                if (isset($_SESSION['role'])) {

                    $data['insurance_reports'] = $this->Insurance_model->getInsurancePayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!empty($merge)) {

                            $data['insurance_reports'] = $this->Insurance_model->getInsuranceReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {
                        $data['insurance_reports'] = $this->Insurance_model->getInsuranceReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('insurancereport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
