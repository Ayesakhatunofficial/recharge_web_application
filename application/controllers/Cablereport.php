<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Cablereport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Cable_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['cable_reports'] = $this->Cable_model->getCablePayData();
            }

            if (isset($_SESSION['slug'])) {

                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Cable_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);
                    // print_r($users); die;

                    if (!is_null($merge) && !empty($merge)) {

                        $data['cable_reports'] = $this->Cable_model->getCableDataByMobile($merge);
                    }
                } else {

                    $data['cable_reports'] = $this->Cable_model->getCableData($pay_by);
                }
            }

            $data['operators'] = $this->Cable_model->getService();
            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {

                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

                $opcode = $this->input->post('operator');

                //  echo $to_date; die;

                if (isset($_SESSION['role'])) {

                    $data['cable_reports'] = $this->Cable_model->getCablePayReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {

                        if (!is_null($merge) && !empty($merge)) {

                            $data['cable_reports'] = $this->Cable_model->getCableReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['cable_reports'] = $this->Cable_model->getCableReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }
            }

            $this->load->view('cablereport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
