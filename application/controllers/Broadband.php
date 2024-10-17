<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Broadband extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('Broadband_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            $data = [];
            if (isset($_SESSION['role'])) {
                $bill_data = $this->Broadband_model->getBroadbandPayData();
                $total_amount = $this->Broadband_model->totalAmount();
            }

            if (isset($_SESSION['slug'])) {
                $pay_by = $_SESSION['mobile'];

                if ($_SESSION['slug'] == 'admin') {

                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Broadband_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    // print_r($users); die;

                    if (!is_null($merge) && !empty($merge)) {

                        $bill_data = $this->Broadband_model->getBroadbandDataByMobile($merge);

                        $total_amount = $this->Broadband_model->totalBillAmountByMobile($merge);
                    }
                } else {
                    $bill_data = $this->Broadband_model->getBroadbandData($pay_by);
                    $total_amount = $this->Broadband_model->totalBillAmount($pay_by);
                }
            }
            $services = $this->Broadband_model->getService();

            $data = [
                'services' => $services,
                'bill_data' => $bill_data,
                'total_amount' => $total_amount,
            ];
            $this->load->view('includes/header');
            $this->load->view('includes/sidebar');
            $this->load->view('broadband', $data);
            $this->load->view('includes/footer');
        } else {

            redirect('userlogin');
        }
    }

    public function getCustomerInfo()
    {

        $ch = curl_init();
        $mobileNo = 8777846136;
        $apiKey = 'boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ';
        $serviceCode = $this->input->post('servicecode');
        $custNo = $this->input->post('broadband_no');

        $data = $this->Broadband_model->getData();
        $pincode = $data->pincode;
        $latitude = $data->latitude;
        $longitude = $data->longitude;
        //  echo $pincode; die;


        $apiUrl = 'https://www.payoneapi.com/RechargeAPI/RechargeAPI.aspx?MobileNo=' . $mobileNo . '&APIKey=' . $apiKey . '&REQTYPE=BILLINFO&SERCODE=' . $serviceCode . '&CUSTNO=' . $custNo . '&REFMOBILENO=' . $mobileNo . '&AMT=0&STV=0&FIELD1=0&FIELD2=0&FIELD3=0&FIELD4=0&FIELD5=0&PCODE=' . $pincode . '&LAT=' . $latitude . '&LONG=' . $longitude . '&RESPTYPE=JSON';

        // ECHO $apiUrl; die;

        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        if (!empty($response)) {
            echo $response;
        } else {
            echo 'Empty or invalid response received.';
        }
    }

    public function Payment()
    {
        $broadband_no = $this->input->post('broadband_no');
        $service_code = $this->input->post('service_code');
        $amount = $this->input->post('amount');
        $cust_name = $this->input->post('cust_name');
        $due_date = $this->input->post('due_date');

        if (empty($broadband_no) || empty($service_code) || empty($amount)) {
            $this->session->set_flashdata('error', 'Please fill in all the fields.');
            redirect('broadband');
        }

        if (isset($_SESSION['slug'])) {
            $id = $_SESSION['user_id'];
            $create_by = $_SESSION['created_by'];
            $created_by_id = $_SESSION['created_by_id'];
            $user_type = $_SESSION['user_type'];
            $slug = $_SESSION['slug'];
            $wallet = $this->db->get_where('users', ['id' => $id])->row_array();
            $wallet_balance = $wallet['wallet'];
            $pay_by = $_SESSION['mobile'];
        }

        if (isset($_SESSION['role'])) {
            $pay_by = $_SESSION['role'];

            $user_type = $_SESSION['role'];
        }

        $balance = $this->db->get('tbl_utility_balance')->row_array();
        $api_balance = $balance['balance'];

        $user_1 = $this->Creditcard_model->getUser($created_by_id);
        $user_1_createdById = $user_1->created_by_id;

        $user_1_type_id = $user_1->create_by;

        $user_2 = $this->Creditcard_model->getUser($user_1_createdById);
        $user_2_createdById = $user_2->created_by_id;

        $user_2_type_id = $user_2->create_by;

        if ($wallet_balance >= $amount && $api_balance >= $amount) {

            $data = $this->Broadband_model->getData();
            $pincode = $data->pincode;
            $latitude = $data->latitude;
            $longitude = $data->longitude;

            $mobileNo = 8777846136;
            $apiKey = 'boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ';
            $ref_no = mt_rand(1000000000, 9999999999);

            $payment_url = $this->Broadband_model->getApi();
            $api_url = $payment_url->url;


            $apiUrl = $api_url . 'MobileNo=' . $mobileNo . '&APIKey=' . $apiKey . '&REQTYPE=BILLPAY&REFNO=' . $ref_no . '&SERCODE=' . $service_code . '&CUSTNO=' . $broadband_no . '&REFMOBILENO=' . $mobileNo . '&AMT=' . $amount . '&STV=0&FIELD1=8777846136&PCODE=' . $pincode . '&LAT=' . $latitude . '&LONG=' . $longitude . '&RESPTYPE=JSON';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }

            curl_close($ch);

            $response = json_decode($response, true);


            if (isset($_SESSION['slug'])) {
                $service = 'broadband';
                $role_slug_id = 'super_admin';

                if (isset($created_by_id) && $create_by == 'admin') {
                    $commission_a = $this->Broadband_model->getCommission($service_code, $id, $slug, $service, $created_by_id);
                }
                if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                    $commission_b = $this->Broadband_model->getCommission($service_code, $id, $slug, $service, $user_1_createdById);
                }
                if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                    $commission_c = $this->Broadband_model->getCommission($service_code, $id, $slug, $service, $user_2_createdById);
                }

                $commission_d = $this->Broadband_model->getCommission($service_code, $id, $slug, $service, $role_slug_id);

                if (!is_null($commission_a)) {
                    $commission = $commission_a;
                } else if (!is_null($commission_b)) {
                    $commission = $commission_b;
                } else if (!is_null($commission_c)) {
                    $commission = $commission_c;
                } else {
                    $commission = $commission_d;
                }

                $commission_rate = $commission->fp_amount;

                if ($commission->created_by != 'super_admin') {
                    $admin_type = 'admin';

                    $admin_commission = $this->Broadband_model->getCommission($service_code, $commission->created_by, $admin_type, $service, $role_slug_id);

                    $admin_commission_rate = $admin_commission->fp_amount;
                }
            } else {
                $commission_rate = 0;
            }

            $data = [
                'date' => date('Y-m-d'),
                'broadband_number' => $broadband_no,
                'customer_name' => $cust_name,
                'service_code' => $service_code,
                'status_msg' => $response['STATUSMSG'],
                'amount' => $amount,
                'due_date' => $due_date,
                'ref_no' => $response['REFNO'],
                'trans_id' => $response['TRNID'],
                'trans_status' => $response['TRNSTATUSDESC'],
                'trans_status_code' => $response['TRNSTATUS'],
                'operator_id' => $response['OPRID'],
                'profit' => $commission_rate,
                'admin_commission' => $admin_commission_rate,
                'json_data' => json_encode($response),
                'pay_by' => $pay_by,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $result = $this->db->insert('tbl_broadband', $data);

            $status = $response['TRNSTATUS'];

            if ($status == 0 || $status == 4 || $status == 6) {
                $apiUrl1 = $api_url . 'MobileNo=' . urlencode($mobileNo) . '&APIKey=' . urlencode($apiKey) . '&REQTYPE=STATUS&REFNO=' . urlencode($ref_no) . '&RESPTYPE=JSON';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $apiUrl1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $res = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }

                curl_close($ch);

                $res = json_decode($res, true);

                $data_1 = [
                    'status_msg' => $res['STATUSMSG'],
                    'trans_status' => $res['TRNSTATUSDESC'],
                    'trans_status_code' => $res['TRNSTATUS'],
                    'operator_id' => $res['OPRID'],
                    'json_status_data' => json_encode($res),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->where('ref_no', $ref_no);
                $this->db->update('tbl_broadband', $data_1);
                $status = $res['TRNSTATUS'];
            }

            if (isset($_SESSION['slug'])) {
                if ($status == 1 || $status == 0) {
                    $updated_wallet_balance = $wallet_balance - $amount;

                    $wallet_data = [
                        'wallet' => $updated_wallet_balance,
                    ];

                    if (!empty($wallet_data)) {
                        $this->db->where(['id' => $id]);
                        $this->db->update('users', $wallet_data);
                    }

                    $input_data = [
                        'from_mobile' => $pay_by,
                        'mobile' => $broadband_no,
                        'user_type' => $user_type,
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Debit',
                        'amount' => $amount,
                        'balance' => $updated_wallet_balance,
                        'remarks' => 'For Broadband Pay'
                    ];

                    if (!empty($input_data)) {
                        $this->db->insert('wallet_balance_history', $input_data);
                    }
                }

                if ($status == 1) {
                    $new_wallet_balance = $updated_wallet_balance + $commission_rate;

                    $update_data = [
                        'wallet' => $new_wallet_balance,
                    ];

                    if (!empty($update_data)) {
                        $this->db->where(['id' => $id]);
                        $this->db->update('users', $update_data);
                    }

                    $input = [
                        'from_mobile' => $pay_by,
                        'mobile' => $broadband_no,
                        'user_type' => $user_type,
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Credit',
                        'amount' => $commission_rate,
                        'balance' => $new_wallet_balance,
                        'remarks' => 'Broadband Pay Profit'
                    ];
                    if (!empty($input)) {
                        $this->db->insert('wallet_balance_history', $input);
                    }

                    if (isset($create_by) && $created_by_id != 0) {
                        $service = 'broadband';
                        $role_slug_id = 'super_admin';

                        if (isset($created_by_id) && $create_by == 'admin') {
                            $commission1_a = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $created_by_id);
                        }
                        if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                            $commission1_b = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $user_1_createdById);
                        }
                        if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                            $commission1_c = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $user_2_createdById);
                        }

                        $commission1_d = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $role_slug_id);

                        if (!is_null($commission1_a)) {
                            $commission1 = $commission1_a;
                        } else if (!is_null($commission1_b)) {
                            $commission1 = $commission1_b;
                        } else if (!is_null($commission1_c)) {
                            $commission1 = $commission1_c;
                        } else {
                            $commission1 = $commission1_d;
                        }

                        $commission_rate_1 = $commission1->fp_amount;

                        $w_bal = $this->db->get_where('users', ['id' => $created_by_id])->row_array();
                        $bal = $w_bal['wallet'];

                        $userType_1 = $this->db->get_where('user_type', ['id' => $w_bal['account_type']])->row();

                        if ($userType_1->slug == 'admin') {
                            $commission_rate_1 = $admin_commission_rate - $commission_rate;
                            $new_bal = ($admin_commission_rate - $commission_rate) + $bal;
                        } else {
                            $new_bal = $commission_rate_1 + $bal;
                        }


                        $c_data = [
                            'wallet' => $new_bal,
                        ];


                        if (!empty($c_data)) {
                            $this->db->where(['id' => $created_by_id]);
                            $this->db->update('users', $c_data);
                        }

                        $input_1 = [
                            'from_mobile' => $w_bal['mobile'],
                            'mobile' => $broadband_no,
                            'user_type' => $create_by,
                            'date' => date('d-m-Y'),
                            'time' => date('H:m:s'),
                            'cr_dr' => 'Credit',
                            'amount' => $commission_rate_1,
                            'balance' => $new_bal,
                            'remarks' => 'Broadband Pay Profit'
                        ];

                        if (!empty($input_1)) {
                            $this->db->insert('wallet_balance_history', $input_1);
                        }

                        if ($user_1_createdById != 0) {

                            $c_by = $w_bal['create_by'];

                            $role_slug_id = 'super_admin';
                            $service = 'broadband';

                            if (isset($created_by_id) && $create_by == 'admin') {
                                $commission2_a = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $created_by_id);
                            }
                            if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                $commission2_b = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $user_1_createdById);
                            }
                            if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                $commission2_c = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $user_2_createdById);
                            }

                            $commission2_d = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $role_slug_id);

                            if (!is_null($commission2_a)) {
                                $commission2 = $commission2_a;
                            } else if (!is_null($commission2_b)) {
                                $commission2 = $commission2_b;
                            } else if (!is_null($commission2_c)) {
                                $commission2 = $commission2_c;
                            } else {
                                $commission2 = $commission2_d;
                            }

                            $commission_rate_2 = $commission2->fp_amount;

                            $w_bal_c = $this->db->get_where('users', ['id' => $w_bal['created_by_id']])->row_array();
                            $bal_1 = $w_bal_c['wallet'];


                            $userType_2 = $this->db->get_where('user_type', ['id' => $w_bal_c['account_type']])->row();

                            if ($userType_2->slug == 'admin') {

                                $commission_rate_2 = ($admin_commission_rate - $commission_rate - $commission_rate_1);
                                $new_bal_1 = $commission_rate_2 + $bal_1;
                            } else {
                                $new_bal_1 = $commission_rate_2 + $bal_1;
                            }

                            $c_data_1 = [
                                'wallet' => $new_bal_1,
                            ];


                            if (!empty($c_data_1)) {
                                $this->db->where(['id' => $w_bal['created_by_id']]);
                                $this->db->update('users', $c_data_1);
                            }

                            $input_2 = [
                                'from_mobile' => $w_bal_c['mobile'],
                                'mobile' => $broadband_no,
                                'user_type' => $c_by,
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Credit',
                                'amount' => $commission_rate_2,
                                'balance' => $new_bal_1,
                                'remarks' => 'Broadband Pay Profit'
                            ];

                            if (!empty($input_2)) {
                                $this->db->insert('wallet_balance_history', $input_2);
                            }

                            if ($user_2_createdById != 0) {

                                $c_by_1 = $w_bal_c['create_by'];

                                $role_slug_id = 'super_admin';
                                $service = 'broadband';

                                if (isset($created_by_id) && $create_by == 'admin') {
                                    $commission3_a = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $created_by_id);
                                }
                                if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                    $commission3_b = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $user_1_createdById);
                                }
                                if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                    $commission3_c = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $user_2_createdById);
                                }

                                $commission3_d = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $role_slug_id);

                                if (!is_null($commission3_a)) {
                                    $commission3 = $commission3_a;
                                } else if (!is_null($commission3_b)) {
                                    $commission3 = $commission3_b;
                                } else if (!is_null($commission3_c)) {
                                    $commission3 = $commission3_c;
                                } else {
                                    $commission3 = $commission3_d;
                                }

                                $commission_rate_3 = $commission3->fp_amount;

                                $w_bal_1 = $this->db->get_where('users', ['id' => $w_bal_c['created_by_id']])->row_array();
                                $bal_2 = $w_bal_1['wallet'];


                                $userType_3 = $this->db->get_where('user_type', ['id' => $w_bal_1['account_type']])->row();

                                if ($userType_3->slug == 'admin') {

                                    $commission_rate_3 = $admin_commission_rate - $commission_rate - $commission_rate_1 - $commission_rate_2;

                                    $new_bal_2 = ($commission_rate_3) + $bal_2;
                                } else {
                                    $new_bal_2 = $commission_rate_3 + $bal_2;
                                }


                                $c_data_2 = [
                                    'wallet' => $new_bal_2,
                                ];


                                if (!empty($c_data_2)) {
                                    $this->db->where(['id' => $w_bal_c['created_by_id']]);
                                    $this->db->update('users', $c_data_2);
                                }

                                $input_3 = [
                                    'from_mobile' => $w_bal_1['mobile'],
                                    'mobile' => $broadband_no,
                                    'user_type' => $c_by_1,
                                    'date' => date('d-m-Y'),
                                    'time' => date('H:m:s'),
                                    'cr_dr' => 'Credit',
                                    'amount' => $commission_rate_3,
                                    'balance' => $new_bal_2,
                                    'remarks' => 'Broadband Pay Profit'
                                ];

                                // print_r($input_3);

                                if (!empty($input_3)) {
                                    $this->db->insert('wallet_balance_history', $input_3);
                                }
                            }
                        }
                    }
                }
            }

            if ($status == 1) {
                $utility_balance = $this->db->get('tbl_utility_balance')->row_array();
                $api_balance = $utility_balance['balance'];
                $api_current_balance = $api_balance - $amount;

                if (isset($_SESSION['role'])) {
                    $user_mobile = '';
                    $user_type = $pay_by;
                } else if (isset($_SESSION['slug'])) {
                    $user_mobile = $pay_by;
                }

                $history = [
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'customer_id' => $broadband_no,
                    'customer_name' => $cust_name,
                    'amount' => $amount,
                    'balance' => $api_current_balance,
                    'cr_dr' => 'Debit',
                    'remarks' => 'For Broadband Pay',
                    'user_type' => $user_type,
                    'user_mobile' => $user_mobile,
                ];
                $this->db->insert('tbl_utility_api_history', $history);
            }

            if ($status == 1 || $status == 0) {
                $this->session->set_flashdata('success', 'Payment successful or Accepted.');
                redirect('broadband');
            } else {
                $this->session->set_flashdata('error', 'An error occurred during recharge.');
                redirect('broadband');
            }
        } else {
            $this->session->set_flashdata('error', 'Insufficient Balance , Please <a href=" walletrecharge "> Recharge Your Wallet </a>');
            redirect('broadband');
        }
    }

    public function status()
    {
        $mobileNo = 8777846136;
        $apiKey = 'boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ';
        $trans_status_codes = [0, 4, 5, 6];
        $pending_data = $this->db->where_in('trans_status_code', $trans_status_codes)->get('tbl_broadband')->result_array();

        $payment_url = $this->Broadband_model->getApi();
        $api_url = $payment_url->url;

        if (!empty($pending_data)) {
            foreach ($pending_data as $data) {
                $ref_no = $data['ref_no'];

                $apiUrl1 = $api_url . 'MobileNo=' . urlencode($mobileNo) . '&APIKey=' . urlencode($apiKey) . '&REQTYPE=STATUS&REFNO=' . urlencode($ref_no) . '&RESPTYPE=JSON';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $apiUrl1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $res = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }

                curl_close($ch);

                $res = json_decode($res, true);

                $data_1 = [
                    'status_msg' => $res['STATUSMSG'],
                    'trans_status' => $res['TRNSTATUSDESC'],
                    'trans_status_code' => $res['TRNSTATUS'],
                    'operator_id' => $res['OPRID'],
                    'json_status_data' => json_encode($res),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->where('ref_no', $ref_no);
                $this->db->update('tbl_broadband', $data_1);
                $status = $res['TRNSTATUS'];

                $pay_by = $data['pay_by'];

                $user_data = $this->db->get_where('users', ['mobile' => $pay_by])->row_array();
                $wallet_balance = $user_data['wallet'];

                $user_type_id = $user_data['account_type'];
                $user_type_data = $this->db->get_where('user_type', ['id' => $user_type_id])->row_array();

                $created_by_id = $user_data['created_by_id'];
                $create_by = $user_data['create_by'];

                $user_1 = $this->Broadband_model->getUser($created_by_id);
                $user_1_createdById = $user_1->created_by_id;

                $user_1_type_id = $user_1->create_by;

                $user_2 = $this->Broadband_model->getUser($user_1_createdById);
                $user_2_createdById = $user_2->created_by_id;

                $user_2_type_id = $user_2->create_by;

                $user_type = $this->db->get_where('user_type', ['id' => $user_data['account_type']])->row_array();

                if ($status == 1) {
                    $current_balance = $wallet_balance + $data['profit'];
                    // echo $current_balance;
                    $com_data = [
                        'wallet' => $current_balance,
                    ];

                    if (!empty($com_data)) {
                        $this->db->where(['mobile' => $pay_by]);
                        $this->db->update('users', $com_data);
                    }

                    $input = [
                        'from_mobile' => $pay_by,
                        'mobile' => $data['broadband_number'],
                        'user_type' => $user_type['user_type'],
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Credit',
                        'amount' => $data['profit'],
                        'balance' => $current_balance,
                        'remarks' => 'Broadband Pay Profit'
                    ];

                    if (!empty($input)) {
                        $this->db->insert('wallet_balance_history', $input);
                    }


                    if (isset($create_by) && $created_by_id != 0) {

                        $service = 'broadband';
                        $role_slug_id = 'super_admin';

                        $service_code = $data['service_code'];

                        $admin_commission_rate = $data['admin_commission'];
                        $commission_rate = $data['profit'];


                        if (isset($created_by_id) && $create_by == 'admin') {
                            $commission1_a = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $created_by_id);
                        }
                        if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                            $commission1_b = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $user_1_createdById);
                        }
                        if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                            $commission1_c = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $user_2_createdById);
                        }

                        $commission1_d = $this->Broadband_model->getCommission($service_code, $created_by_id, $create_by, $service, $role_slug_id);

                        if (!is_null($commission1_a)) {
                            $commission1 = $commission1_a;
                        } else if (!is_null($commission1_b)) {
                            $commission1 = $commission1_b;
                        } else if (!is_null($commission1_c)) {
                            $commission1 = $commission1_c;
                        } else {
                            $commission1 = $commission1_d;
                        }

                        $commission_rate_1 = $commission1->fp_amount;

                        $w_bal = $this->db->get_where('users', ['id' => $user_data['created_by_id']])->row_array();
                        $bal = $w_bal['wallet'];

                        $userType_1 = $this->db->get_where('user_type', ['id' => $w_bal['account_type']])->row();

                        if ($userType_1->slug == 'admin') {
                            $commission_rate_1 = $admin_commission_rate - $commission_rate;
                            $new_bal = ($admin_commission_rate - $commission_rate) + $bal;
                        } else {
                            $new_bal = $commission_rate_1 + $bal;
                        }


                        $c_data = [
                            'wallet' => $new_bal,
                        ];


                        if (!empty($c_data)) {
                            $this->db->where(['id' => $user_data['created_by_id']]);
                            $this->db->update('users', $c_data);
                        }

                        $input_1 = [
                            'from_mobile' => $w_bal['mobile'],
                            'mobile' => $data['broadband_number'],
                            'user_type' => $user_data['create_by'],
                            'date' => date('d-m-Y'),
                            'time' => date('H:m:s'),
                            'cr_dr' => 'Credit',
                            'amount' => $commission_rate_1,
                            'balance' => $new_bal,
                            'remarks' => 'Broadband Pay Profit'
                        ];

                        if (!empty($input_1)) {
                            $this->db->insert('wallet_balance_history', $input_1);
                        }

                        if ($user_1_createdById != 0) {

                            $c_by = $w_bal['create_by'];

                            $role_slug_id = 'super_admin';
                            $service = 'broadband';

                            if (isset($created_by_id) && $create_by == 'admin') {
                                $commission2_a = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $created_by_id);
                            }
                            if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                $commission2_b = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $user_1_createdById);
                            }
                            if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                $commission2_c = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $user_2_createdById);
                            }

                            $commission2_d = $this->Broadband_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $role_slug_id);

                            if (!is_null($commission2_a)) {
                                $commission2 = $commission2_a;
                            } else if (!is_null($commission2_b)) {
                                $commission2 = $commission2_b;
                            } else if (!is_null($commission2_c)) {
                                $commission2 = $commission2_c;
                            } else {
                                $commission2 = $commission2_d;
                            }

                            $commission_rate_2 = $commission2->fp_amount;


                            $w_bal_c = $this->db->get_where('users', ['id' => $w_bal['created_by_id']])->row_array();
                            $bal_1 = $w_bal_c['wallet'];


                            $userType_2 = $this->db->get_where('user_type', ['id' => $w_bal_c['account_type']])->row();

                            if ($userType_2->slug == 'admin') {

                                $commission_rate_2 = ($admin_commission_rate - $commission_rate - $commission_rate_1);
                                $new_bal_1 = $commission_rate_2 + $bal_1;
                            } else {
                                $new_bal_1 = $commission_rate_2 + $bal_1;
                            }


                            $c_data_1 = [
                                'wallet' => $new_bal_1,
                            ];


                            if (!empty($c_data_1)) {
                                $this->db->where(['id' => $w_bal['created_by_id']]);
                                $this->db->update('users', $c_data_1);
                            }

                            $input_2 = [
                                'from_mobile' => $w_bal_c['mobile'],
                                'mobile' => $data['broadband_number'],
                                'user_type' => $c_by,
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Credit',
                                'amount' => $commission_rate_2,
                                'balance' => $new_bal_1,
                                'remarks' => 'Broadband Pay Profit'
                            ];

                            if (!empty($input_2)) {
                                $this->db->insert('wallet_balance_history', $input_2);
                            }

                            if ($user_2_createdById != 0) {

                                $c_by_1 = $w_bal_c['create_by'];

                                $role_slug_id = 'super_admin';
                                $service = 'broadband';

                                if (isset($created_by_id) && $create_by == 'admin') {
                                    $commission3_a = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $created_by_id);
                                }
                                if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                    $commission3_b = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $user_1_createdById);
                                }
                                if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                    $commission3_c = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $user_2_createdById);
                                }

                                $commission3_d = $this->Broadband_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $role_slug_id);

                                if (!is_null($commission3_a)) {
                                    $commission3 = $commission3_a;
                                } else if (!is_null($commission3_b)) {
                                    $commission3 = $commission3_b;
                                } else if (!is_null($commission3_c)) {
                                    $commission3 = $commission3_c;
                                } else {
                                    $commission3 = $commission3_d;
                                }

                                $commission_rate_3 = $commission3->fp_amount;


                                $w_bal_1 = $this->db->get_where('users', ['id' => $w_bal_c['created_by_id']])->row_array();
                                $bal_2 = $w_bal_1['wallet'];


                                $userType_3 = $this->db->get_where('user_type', ['id' => $w_bal_1['account_type']])->row();


                                if ($userType_3->slug == 'admin') {

                                    $commission_rate_3 = $admin_commission_rate - $commission_rate - $commission_rate_1 - $commission_rate_2;

                                    $new_bal_2 = ($commission_rate_3) + $bal_2;
                                } else {
                                    $new_bal_2 = $commission_rate_3 + $bal_2;
                                }


                                $c_data_2 = [
                                    'wallet' => $new_bal_2,
                                ];


                                if (!empty($c_data_2)) {
                                    $this->db->where(['id' => $w_bal_c['created_by_id']]);
                                    $this->db->update('users', $c_data_2);
                                }

                                $input_3 = [
                                    'from_mobile' => $w_bal_1['mobile'],
                                    'mobile' => $data['broadband_number'],
                                    'user_type' => $c_by_1,
                                    'date' => date('d-m-Y'),
                                    'time' => date('H:m:s'),
                                    'cr_dr' => 'Credit',
                                    'amount' => $commission_rate_3,
                                    'balance' => $new_bal_2,
                                    'remarks' => 'Broadband Pay Profit'
                                ];

                                // print_r($input_3);

                                if (!empty($input_3)) {
                                    $this->db->insert('wallet_balance_history', $input_3);
                                }
                            }
                        }
                    }

                    $balance = $this->db->get('tbl_utility_balance')->row_array();
                    $api_balance = $balance['balance'];
                    $balance = $api_balance - $data['amount'];
                    $api_current_balance = $balance;

                    $history = [
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'customer_id' => $data['broadband_number'],
                        'customer_name' => $data['customer_name'],
                        'amount' => $data['amount'],
                        'balance' => $api_current_balance,
                        'cr_dr' => 'Debit',
                        'remarks' => 'For Broadband Pay',
                        'user_type' => $user_type['user_type'],
                        'user_mobile' => $data['pay_by'],
                    ];
                    $this->db->insert('tbl_utility_api_history', $history);
                }

                // if ($status == 2 || $status == 3 || $status == 5) {
                //     $new_wallet_balance = $wallet_balance + $data['amount'];

                //     $update_wallet = [
                //         'wallet' => $new_wallet_balance,
                //     ];

                //     if (!empty ($update_wallet)) {
                //         $this->db->where('mobile', $pay_by);
                //         $this->db->update('users', $update_wallet);
                //     }

                //     $wallet_history = [
                //         'from_mobile' => $pay_by,
                //         'mobile' => $data['broadband_number'],
                //         'user_type' => $user_type['user_type'],
                //         'date' => date('d-m-Y'),
                //         'time' => date('H:m:s'),
                //         'cr_dr' => 'Credit',
                //         'amount' => $data['amount'],
                //         'balance' => $new_wallet_balance,
                //         'remarks' => 'Broadband Pay Amount Refund'
                //     ];

                //     if (!empty ($wallet_history)) {
                //         $this->db->insert('wallet_balance_history', $wallet_history);
                //     }
                // }
            }
        }

        echo 'ayesa';
    }
}
