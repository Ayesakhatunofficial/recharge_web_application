<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Loanpayreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Loan_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['loanpay_reports'] = $this->Loan_model->getLoanPayData();
            }

            if (isset($_SESSION['slug'])) {
                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Loan_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    if (!is_null($merge) && !empty($merge)) {

                        $data['loanpay_reports'] = $this->Loan_model->getLoanDataByMobile($merge);
                    }
                } else {
                    $data['loanpay_reports'] = $this->Loan_model->getLoanData($pay_by);
                }
            }

            $data['operators'] = $this->Loan_model->getService();
            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;

                if (isset($_SESSION['role'])) {

                    $data['loanpay_reports'] = $this->Loan_model->getLoanPayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!empty($merge)) {

                            $data['loanpay_reports'] = $this->Loan_model->getLoanReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['loanpay_reports'] = $this->Loan_model->getLoanReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('loanpayreport', $data);
        } else {
            redirect('userlogin');
        }
    }
}
