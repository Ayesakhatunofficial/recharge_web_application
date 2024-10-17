<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Creditcardreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Creditcard_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['creditcard_reports'] = $this->Creditcard_model->getCreditcardPayData();
            }

            if (isset($_SESSION['slug'])) {

                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $mobile[] = $_SESSION['mobile'];

                    $users = $this->Creditcard_model->getSubordinateUsers($admin_id);

                    $merge = array_merge($users, $mobile);

                    // print_r($users); die;

                    if (!is_null($merge) && !empty($merge)) {

                        $data['creditcard_reports'] = $this->Creditcard_model->getCreditcardDataByMobile($merge);
                    }
                } else {

                    $data['creditcard_reports'] = $this->Creditcard_model->getCreditcardData($pay_by);
                }
            }

            $data['operators'] = $this->Creditcard_model->getService();

            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;

                if (isset($_SESSION['role'])) {

                    $data['creditcard_reports'] = $this->Creditcard_model->getCreditcardPayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!empty($merge)) {

                            $data['creditcard_reports'] = $this->Creditcard_model->getCreditcardReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['creditcard_reports'] = $this->Creditcard_model->getCreditcardReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('creditcardreport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
