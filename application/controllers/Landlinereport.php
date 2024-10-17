<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Landlinereport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Landline_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {

                $data['landline_reports'] = $this->Landline_model->getLandlinePayData();
            }

            if (isset($_SESSION['slug'])) {

                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Landline_model->getSubordinateUsers($admin_id);

                    // print_r($users); die;

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    if (!empty($merge)) {

                        $data['landline_reports'] = $this->Landline_model->getLandlineDataByMobile($merge);
                    }
                } else {

                    $data['landline_reports'] = $this->Landline_model->getLandlineData($pay_by);
                }
            }

            $data['operators'] = $this->Landline_model->getService();
            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;

                if (isset($_SESSION['role'])) {

                    $data['landline_reports'] = $this->Landline_model->getLandlinePayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!empty($merge)) {

                            $data['landline_reports'] = $this->Landline_model->getLandlineReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['landline_reports'] = $this->Landline_model->getLandlineReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('landlinereport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
