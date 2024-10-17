<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Postpaidreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Postpaid_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['postpaid_reports'] = $this->Postpaid_model->getPostpaidPayData();
            }

            if (isset($_SESSION['slug'])) {
                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {
                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Postpaid_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    if (!is_null($merge) && !empty($merge)) {

                        $data['postpaid_reports'] = $this->Postpaid_model->getPostpaidDataByMobile($merge);
                    }
                } else {

                    $data['postpaid_reports'] = $this->Postpaid_model->getPostpaidData($pay_by);
                }
            }

            $data['operators'] = $this->Postpaid_model->getService();
            // print_r($data['operators']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;

                if (isset($_SESSION['role'])) {

                    $data['postpaid_reports'] = $this->Postpaid_model->getPostpaidPayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {
                        if (!empty($merge)) {

                            $data['postpaid_reports'] = $this->Postpaid_model->getPostpaidReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['postpaid_reports'] = $this->Postpaid_model->getPostpaidReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('postpaidreport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
