<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Electricbillreport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Billpay_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['role'])) {
                $data['electric_reports'] = $this->Billpay_model->getBillPayData();
            }

            if (isset($_SESSION['slug'])) {
                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $mobile[] = $_SESSION['mobile'];

                    $users = $this->Billpay_model->getSubordinateUsers($admin_id);

                    $merge = array_merge($users, $mobile);

                    if (!empty($merge)) {

                        $data['electric_reports'] = $this->Billpay_model->getElectricDataByMobile($merge);
                    }
                } else {

                    $data['electric_reports'] = $this->Billpay_model->getElectricData($pay_by);
                }
            }

            $data['operators'] = $this->Billpay_model->getService();
            // print_r($data['recharge_reports']); die;

            if ($this->input->post() != NULL) {
                $from_date = date("Y-m-d", strtotime($this->input->post('from_date')));

                $to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
                $opcode = $this->input->post('operator');
                //  echo $to_date; die;
                if (isset($_SESSION['role'])) {
                    $data['electric_reports'] = $this->Billpay_model->getElectricReport($from_date, $to_date, $opcode);
                }

                if (isset($_SESSION['slug'])) {

                    if ($_SESSION['slug'] == 'admin') {
                        if (!empty($merge)) {

                            $data['electric_reports'] = $this->Billpay_model->getElectricBillReportByMobile($from_date, $to_date, $opcode, $merge);
                        }
                    } else {

                        $data['electric_reports'] = $this->Billpay_model->getElectricBillReport($from_date, $to_date, $opcode, $pay_by);
                    }
                }


                // print_r($data['electric_reports']); die;


                // $input = [
                //     'from_date' => $from_date,
                //     'to_date' => $to_date,
                //     'mobile' => $this->input->post('mobile')
                // ];

                // // echo "<pre>"; print_r($input); die;

                // if(!empty($input['mobile']))
                // {
                //     $data['wbalhists'] = $this->db->order_by('id', 'desc')->get_where('wallet_balance_history', ['mobile' => $input['mobile']])->result_array();
                // } else {
                //     $data['wbalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM wallet_balance_history WHERE date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
                // }
            }

            $this->load->view('electricbillreport', $data);
        } else {

            redirect('userlogin');
        }
    }
}
