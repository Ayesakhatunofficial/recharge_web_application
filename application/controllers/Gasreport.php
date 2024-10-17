<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Gasreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Gas_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {
            if (isset($_SESSION['role'])) {
                $data['gas_reports'] = $this->Gas_model->getLPGPayData();
            }

            if (isset($_SESSION['slug'])) {

                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {
                    $admin_id = $_SESSION['user_id'];

                    // echo $admin_id; 

                    $users = $this->Gas_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    if (!is_null($merge) && !empty($merge)) {

                        $data['gas_reports'] = $this->Gas_model->getGasDataByMobile($merge);
                    }
                } else {

                    $data['gas_reports'] = $this->Gas_model->getLPGData($pay_by);
                }
            }

            $data['operators'] = $this->Gas_model->getService();
            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');


                if (isset($_SESSION['role'])) {

                    $data['gas_reports'] = $this->Gas_model->getLPGPayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!empty($merge)) {

                            $data['gas_reports'] = $this->Gas_model->getLpgReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['gas_reports'] = $this->Gas_model->getLPGReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('gasreport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
