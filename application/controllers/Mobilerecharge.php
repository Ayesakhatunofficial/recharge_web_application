<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobilerecharge extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('Recharge_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {

            if (isset($_SESSION['slug'])) {



                if ($_SESSION['slug'] == 'admin') {
                    $admin_id = $_SESSION['user_id'];

                    $users = $this->Recharge_model->getSubordinateUsers($admin_id);

                    $mobile[] = $_SESSION['mobile'];

                    $merge = array_merge($users, $mobile);

                    if (!is_null($merge) && !empty($merge)) {

                        $datas = $this->Recharge_model->getRechargeDataByMobileNumbers($merge);

                        $total_amount = $this->Recharge_model->totalMobileRechargeAmount($merge);
                    }
                } else {
                    $recharge_by = $_SESSION['mobile'];

                    $datas = $this->Recharge_model->getRechargeList($recharge_by);

                    $total_amount = $this->Recharge_model->totalRechargeAmount($recharge_by);
                }
            }
            if (isset($_SESSION['role'])) {

                $datas = $this->Recharge_model->getData();

                $total_amount = $this->Recharge_model->totalAmount();
            }


            $operators = $this->Recharge_model->getOperator();
            // print_r($operators) ; die;
            $view_data = [
                'datas' => $datas,
                'total_amount' => $total_amount,
                'operators' => $operators,
            ];
            $this->load->view('includes/header');
            $this->load->view('includes/sidebar');
            $this->load->view('mobilerecharge', $view_data);
            $this->load->view('includes/footer');
        } else {

            redirect('userlogin');
        }
    }



    public function Recharge()
    {
        $number = $this->input->post('mob_no');
        $opcode = $this->input->post('operator');
        $amount = $this->input->post('amount');



        if (empty($number) || empty($opcode) || empty($amount)) {

            $this->session->set_flashdata('error', 'Please fill in all the fields.');
            redirect('mobilerecharge');
        }

        if (isset($_SESSION['slug'])) {

            $id = $_SESSION['user_id'];

            $create_by = $_SESSION['created_by'];

            $created_by_id = $_SESSION['created_by_id'];

            $user_type = $_SESSION['user_type'];

            $slug = $_SESSION['slug'];

            $wallet = $this->db->get_where('users', ['id' => $id])->row_array();
            $wallet_balance = $wallet['wallet'];

            $recharge_by = $_SESSION['mobile'];
        }

        if (isset($_SESSION['role'])) {
            $recharge_by = $_SESSION['role'];
            $user_type = $_SESSION['role'];
        }

        $balance = $this->db->get('tbl_balance')->row_array();
        $api_balance = $balance['balance'];

        $user_1 = $this->Recharge_model->getUser($created_by_id);
        $user_1_createdById = $user_1->created_by_id;

        $user_1_type_id = $user_1->create_by;

        $user_2 = $this->Recharge_model->getUser($user_1_createdById);
        $user_2_createdById = $user_2->created_by_id;

        $user_2_type_id  = $user_2->create_by;


        if ($wallet_balance >= $amount && $api_balance >= $amount) {

            $api_url_link = $this->db->get_where('tbl_recharge_api', ['purpose' => 'Transaction API'])->row();
            $url_link = $api_url_link->url;

            $token = 'FwBliKoRxs3r1uybiEx2';
            $userid = 12494;

            $transid = mt_rand(1000000000, 9999999999);

            $check_transid = $this->Recharge_model->checkTransid($transid);
            if (!is_null($check_transid)) {

                $this->session->set_flashdata('error', 'Duplicate Trans ID');
                redirect('mobilerecharge');
            }

            $apiUrl = $url_link . '?userid=' . $userid . '&token=' . $token . '&opcode=' . $opcode . '&number=' . $number . '&amount=' . $amount . '&transid=' . $transid;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {

                echo 'Curl error: ' . curl_error($ch);
            }

            curl_close($ch);
            $response = json_decode($response, true);

            $margin = $response['margin'];

            if (isset($_SESSION['slug'])) {

                if ($margin != '' || $margin != 0) {

                    $profit = $amount * ($margin / 100);

                    ///////////////      COMMISSION   ////////////////////

                    $role_slug_id = 'super_admin';
                    $service = 'mobile';

                    if (isset($created_by_id) && $create_by == 'admin') {

                        $commission_a = $this->Recharge_model->getCommission($opcode, $id, $slug, $service, $created_by_id);
                    }
                    if (isset($user_1_createdById) && $user_1_type_id == 'admin') {

                        $commission_b = $this->Recharge_model->getCommission($opcode, $id, $slug, $service, $user_1_createdById);
                    }
                    if (isset($user_2_createdById) && $user_2_type_id == 'admin') {

                        $commission_c = $this->Recharge_model->getCommission($opcode, $id, $slug, $service, $user_2_createdById);
                    }

                    $commission_d = $this->Recharge_model->getCommission($opcode, $id, $slug, $service, $role_slug_id);

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



                    if ($commission->commission_type == 'percent') {
                        if ($commission->created_by != 'super_admin') {
                            $admin_type = 'admin';

                            $admin_commission  =  $this->Recharge_model->getCommission($opcode, $commission->created_by, $admin_type, $service, $role_slug_id);

                            $admin_commission_rate = $admin_commission->fp_amount;

                            $user_profit = $profit * ($admin_commission_rate / 100);

                            $wallet_profit = $user_profit * ($commission_rate / 100);
                        } else {
                            $wallet_profit = $profit * ($commission_rate / 100);
                        }
                    } else if ($commission->commission_type == 'flat') {
                        $wallet_profit = $commission_rate;
                    }

                    ////////////////          END        ////////////

                    $user_margin = $wallet_profit * 100 / $amount;

                    $admin_percent = $user_profit * 100 / $amount;
                } else {
                    $wallet_profit = 0;
                    $user_margin = 0;
                    $user_profit = 0;
                }
            }

            if (isset($_SESSION['role'])) {
                $profit = $amount * ($margin / 100);
                $wallet_profit = 0;
                $user_margin = 0;
                $user_profit = 0;
            }

            $type = 'Mobile';

            $data = [
                'date' => date('Y-m-d'),
                'trans_id' => $response['transid'],
                'opt_trans_id' => $response['optransid'],
                'ref_id' => $response['referenceid'],
                'message' => $response['message'],
                'number' => $response['number'],
                'amount' => $response['amount'],
                'type' => $type,
                'operator_id' => $opcode,
                'status' => $response['status'],
                'margin' => $user_margin,
                'admin_profit' => $user_profit,
                'admin_percent' => $admin_percent,
                'profit' => $wallet_profit,
                'api_commission' => $response['margin'],
                'api_profit' => $profit,
                'json_data' => json_encode($response),
                'recharge_by' => $recharge_by,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            // print_r($data);

            $result = $this->db->insert('tbl_recharge', $data);

            $status = $response['status'];

            //////////////////////////         status check    //////////////////////////////

            if ($status == 'PENDING') {

                $status_api_url = $this->db->get_where('tbl_recharge_api', ['purpose' => 'Transaction Status API'])->row();
                $status_url = $status_api_url->url;

                $apiUrl = $status_url . '?userid=' . $userid . '&token=' . $token . '&transid=' . $transid;


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $res = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }
                curl_close($ch);
                $res = json_decode($res, true);


                $data_1 = [
                    'status' => $res['status'],
                    'message' => $res['message'],
                    'opt_trans_id' => $res['optransid'],
                    'json_status_data' => json_encode($res),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                // print_r($data_1);

                $this->db->where('trans_id', $transid);
                $this->db->update('tbl_recharge', $data_1);
                $status = $res['status'];
            }

            ////////////////////      END       //////////////////////

            ///////////////    api balance deduct history  /////////////////////

            if ($status == 'SUCCESS') {

                if (isset($_SESSION['role'])) {

                    $user_mobile = '';
                    $user_type = $recharge_by;
                } else if (isset($_SESSION['slug'])) {

                    $user_mobile = $recharge_by;
                }

                $balance_1 = $this->db->get('tbl_balance')->row_array();
                $api_balance = $balance_1['balance'];

                $balance = $api_balance - $amount;

                $api_current_balance = $balance + $profit;

                $history = [
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'number' => $number,
                    'amount' => $amount,
                    'balance' => $api_current_balance,
                    'cr_dr' => 'Debit',
                    'remarks' => 'For Mobile Recharge',
                    'user_type' => $user_type,
                    'user_mobile' => $user_mobile,
                ];

                $this->db->insert('tbl_recharge_api_history', $history);
            }

            //////////////////////////       end  /////////////////////////////

            if (isset($_SESSION['slug'])) {

                ////////////////////          amount deduct for recharge start with history         ///////////////

                if ($status == 'SUCCESS' || $status == 'PENDING') {

                    $updated_wallet_balance = $wallet_balance - $amount;

                    $update_data = [
                        'wallet' => $updated_wallet_balance,
                    ];

                    if (!empty($update_data)) {
                        $this->db->where(['id' => $id]);
                        $this->db->update('users', $update_data);
                    }

                    $input_data = [
                        'from_mobile' => $_SESSION['mobile'],
                        'mobile' => $number,
                        'user_type' => $_SESSION['user_type'],
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Debit',
                        'amount' => $amount,
                        'balance' => $updated_wallet_balance,
                        'remarks' => 'For Mobile Recharge'
                    ];

                    // echo '<pre>';
                    // print_r($input_data);

                    if (!empty($input_data)) {
                        $this->db->insert('wallet_balance_history', $input_data);
                    }
                }
            }

            ///////////////             end of code amount deduct             //////////////////////



            if (isset($_SESSION['slug']) && $margin) {

                if ($status == 'SUCCESS') {

                    ///////////////////////         PROFIT ADD AND BALANCE UPDATE    //////////////////////

                    $current_balance = $updated_wallet_balance + $wallet_profit;
                    // echo $current_balance;
                    $com_data = [
                        'wallet' => $current_balance,
                    ];

                    if (!empty($com_data)) {
                        $this->db->where(['id' => $_SESSION['user_id']]);
                        $this->db->update('users', $com_data);
                    }


                    $input = [
                        'from_mobile' => $_SESSION['mobile'],
                        'mobile' => $number,
                        'user_type' => $_SESSION['user_type'],
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Credit',
                        'amount' => $wallet_profit,
                        'balance' => $current_balance,
                        'remarks' => 'Mobile Recharge Profit'
                    ];


                    if (!empty($input)) {
                        $this->db->insert('wallet_balance_history', $input);
                    }

                    /////////////////////         END BALANCE UPDATE    ///////////////////

                    if (isset($created_by_id) && $created_by_id != 0) {
                        $role_slug_id = 'super_admin';
                        $service = 'mobile';

                        if (isset($created_by_id) && $create_by == 'admin') {
                            $commission1_a = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $created_by_id);
                        }
                        if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                            $commission1_b = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $user_1_createdById);
                        }
                        if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                            $commission1_c = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $user_2_createdById);
                        }

                        $commission1_d = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $role_slug_id);

                        if (!is_null($commission1_a)) {
                            $commission1 = $commission1_a;
                        } else if (!is_null($commission1_b)) {
                            $commission1 = $commission1_b;
                        } else if (!is_null($commission1_c)) {
                            $commission1 =  $commission1_c;
                        } else {
                            $commission1 = $commission1_d;
                        }

                        $commission_rate_1 = $commission1->fp_amount;

                        if ($commission1->commission_type == 'percent') {

                            $w_profit = $user_profit * ($commission_rate_1 / 100);
                        } else if ($commission1->commission_type == 'flat') {

                            $w_profit = $commission_rate_1;
                        }

                        $w_bal = $this->db->get_where('users', ['id' => $created_by_id])->row_array();
                        $bal = $w_bal['wallet'];

                        $userType_1 = $this->db->get_where('user_type', ['id' => $w_bal['account_type']])->row();

                        if ($userType_1->slug == 'admin') {
                            $w_profit = $user_profit - $wallet_profit;
                            $new_bal = ($user_profit - $wallet_profit) + $bal;
                        } else {
                            $new_bal = $w_profit + $bal;
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
                            'mobile' => $number,
                            'user_type' => $create_by,
                            'date' => date('d-m-Y'),
                            'time' => date('H:m:s'),
                            'cr_dr' => 'Credit',
                            'amount' => $w_profit,
                            'balance' => $new_bal,
                            'remarks' => 'Mobile Recharge Profit'
                        ];

                        // print_r($input_1);

                        if (!empty($input_1)) {
                            $this->db->insert('wallet_balance_history', $input_1);
                        }


                        if ($user_1_createdById != 0) {
                            $c_by = $w_bal['create_by'];

                            $role_slug_id = 'super_admin';
                            $service = 'mobile';

                            if (isset($created_by_id) && $create_by == 'admin') {
                                $commission2_a = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $created_by_id);
                            }
                            if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                $commission2_b = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $user_1_createdById);
                            }
                            if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                $commission2_c = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $user_2_createdById);
                            }

                            $commission2_d = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $role_slug_id);

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

                            if ($commission2->commission_type == 'percent') {

                                $w_profit_1 = $user_profit * ($commission_rate_2 / 100);
                            } else if ($commission2->commission_type == 'flat') {

                                $w_profit_1 = $commission_rate_2;
                            }

                            $w_bal_c = $this->db->get_where('users', ['id' => $w_bal['created_by_id']])->row_array();
                            $bal_1 = $w_bal_c['wallet'];

                            $userType_2 = $this->db->get_where('user_type', ['id' => $w_bal_c['account_type']])->row();

                            if ($userType_2->slug == 'admin') {
                                $w_profit_1 = $user_profit - $wallet_profit - $w_profit;
                                $new_bal_1 = ($w_profit_1) + $bal_1;
                            } else {
                                $new_bal_1 = $w_profit_1 + $bal_1;
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
                                'mobile' => $number,
                                'user_type' => $c_by,
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Credit',
                                'amount' => $w_profit_1,
                                'balance' => $new_bal_1,
                                'remarks' => 'Mobile Recharge Profit'
                            ];


                            if (!empty($input_2)) {
                                $this->db->insert('wallet_balance_history', $input_2);
                            }

                            if ($user_2_createdById != 0) {
                                $c_by_1 = $w_bal_c['create_by'];

                                $role_slug_id = 'super_admin';
                                $service = 'mobile';

                                if (isset($created_by_id) && $create_by == 'admin') {
                                    $commission3_a = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $created_by_id);
                                }
                                if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                    $commission3_b = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $user_1_createdById);
                                }
                                if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                    $commission3_c = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $user_2_createdById);
                                }

                                $commission3_d = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $role_slug_id);

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

                                if ($commission3->commission_type == 'percent') {

                                    $w_profit_2 = $user_profit * ($commission_rate_3 / 100);
                                } else if ($commission3->commission_type == 'flat') {

                                    $w_profit_2 = $commission_rate_3;
                                }

                                $w_bal_1 = $this->db->get_where('users', ['id' => $w_bal_c['created_by_id']])->row_array();
                                $bal_2 = $w_bal_1['wallet'];

                                $userType_3 = $this->db->get_where('user_type', ['id' => $w_bal_1['account_type']])->row();

                                if ($userType_3->slug == 'admin') {
                                    $w_profit_2 = $user_profit - $wallet_profit - $w_profit - $w_profit_1;
                                    $new_bal_2 = ($w_profit_2) + $bal_2;
                                } else {
                                    $new_bal_2 = $w_profit_2 + $bal_2;
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
                                    'mobile' => $number,
                                    'user_type' => $c_by_1,
                                    'date' => date('d-m-Y'),
                                    'time' => date('H:m:s'),
                                    'cr_dr' => 'Credit',
                                    'amount' => $w_profit_2,
                                    'balance' => $new_bal_2,
                                    'remarks' => 'Mobile Recharge Profit'
                                ];

                                if (!empty($input_3)) {
                                    $this->db->insert('wallet_balance_history', $input_3);
                                }
                            }
                        }
                    }
                }
            }

            if ($status == 'SUCCESS') {
                $this->session->set_flashdata('success', 'Recharge successful.');
                redirect('mobilerecharge');
            } else {
                $this->session->set_flashdata('error', 'An error occurred during recharge.');
                redirect('mobilerecharge');
            }
        } else {
            $this->session->set_flashdata('error', 'Insufficient Balance , Please <a href=" walletrecharge "> Recharge Your Wallet </a>');
            redirect('mobilerecharge');
        }
    }

    public function Status()
    {
        $status_api_url = $this->db->get_where('tbl_recharge_api', ['purpose' => 'Transaction Status API'])->row();
        $status_url = $status_api_url->url;
        $token = 'FwBliKoRxs3r1uybiEx2';
        $userid = 12494;

        $pending_data = $this->db->where('status', 'PENDING')
            ->or_where('status', '')
            ->get('tbl_recharge')
            ->result();

        foreach ($pending_data as $data) {
            $transid = $data->trans_id;
            // echo $transid; 
            $apiUrl = $status_url . '?userid=' . $userid . '&token=' . $token . '&transid=' . $transid;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $res = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }
            curl_close($ch);
            // print_r($res);
            $res = json_decode($res, true);

            $data_1 = [
                'status' => $res['status'],
                'message' => $res['message'],
                'opt_trans_id' => $res['optransid'],
                'json_status_data' => json_encode($res),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // print_r($data_1);

            $this->db->where('trans_id', $transid);
            $this->db->update('tbl_recharge', $data_1);

            $status = $res['status'];

            $wallet_data = $this->db->get_where('users', ['mobile' => $data->recharge_by])->row_array();
            $wallet_balance = $wallet_data['wallet'];

            $user_type_id = $wallet_data['account_type'];
            $user_type_data = $this->db->get_where('user_type', ['id' => $user_type_id])->row_array();

            $created_by_id = $wallet_data['created_by_id'];
            $create_by = $wallet_data['create_by'];

            $user_1 = $this->Recharge_model->getUser($created_by_id);
            $user_1_createdById = $user_1->created_by_id;

            $user_1_type_id = $user_1->create_by;

            $user_2 = $this->Recharge_model->getUser($user_1_createdById);
            $user_2_createdById = $user_2->created_by_id;

            $user_2_type_id  = $user_2->create_by;

            $user_type = $user_type_data['user_type'];
            $refund_balance = $data->amount;


            // if ($status == 'FAIL') {

            //     $current_balance = $wallet_balance + $refund_balance;

            //     $input = [
            //         'wallet' => $current_balance,
            //     ];

            //     if (!empty($input)) {
            //         $this->db->where('mobile', $data->recharge_by);
            //         $this->db->update('users', $input);
            //     }


            //     if ($data->type == 'Mobile') {
            //         $remarks = 'Refund For Mobile Recharge';
            //     } else if ($data->type == 'DTH') {
            //         $remarks = 'Refund For DTH Recharge';
            //     }

            //     $input_data = [
            //         'from_mobile' => $data->recharge_by,
            //         'mobile' => $data->number,
            //         'user_type' => $user_type,
            //         'date' => date('d-m-Y'),
            //         'time' => date('H:m:s'),
            //         'cr_dr' => 'Credit',
            //         'amount' => $refund_balance,
            //         'balance' => $current_balance,
            //         'remarks' => $remarks,
            //     ];

            //     if (!empty($input_data)) {
            //         $this->db->insert('wallet_balance_history', $input_data);
            //     }
            // }

            if ($status == 'SUCCESS') {

                $balance = $this->db->get('tbl_balance')->row_array();
                $api_balance = $balance['balance'];

                $balance = $api_balance - $refund_balance;
                $api_current_balance = $balance + $data->api_profit;

                if ($data->type == 'Mobile') {
                    $remarks = 'For Mobile Recharge';
                } else if ($data->type == 'DTH') {
                    $remarks = 'For DTH Recharge';
                }

                $history = [
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'number' => $data->number,
                    'amount' => $refund_balance,
                    'balance' => $api_current_balance,
                    'cr_dr' => 'Debit',
                    'remarks' => $remarks,
                    'user_type' => $user_type,
                    'user_mobile' => $data->recharge_by,
                ];

                $this->db->insert('tbl_recharge_api_history', $history);
            }


            if ($status == 'SUCCESS') {


                $current_balance = $wallet_balance + $data->profit;
                // echo $current_balance;


                $com_data = [
                    'wallet' => $current_balance,
                ];

                if (!empty($com_data)) {
                    $this->db->where(['mobile' => $data->recharge_by]);
                    $this->db->update('users', $com_data);
                }


                if ($data->type == 'Mobile') {
                    $remarks = 'Mobile Recharge Profit';
                } else if ($data->type == 'DTH') {
                    $remarks = 'DTH Recharge Profit';
                }

                $input = [
                    'from_mobile' => $data->recharge_by,
                    'mobile' => $data->number,
                    'user_type' => $user_type,
                    'date' => date('d-m-Y'),
                    'time' => date('H:m:s'),
                    'cr_dr' => 'Credit',
                    'amount' => $data->profit,
                    'balance' => $current_balance,
                    'remarks' => $remarks
                ];


                if (!empty($input)) {
                    $this->db->insert('wallet_balance_history', $input);
                }

                if (isset($created_by_id) && $created_by_id != 0) {
                    $role_slug_id = 'super_admin';

                    if ($data->type == 'Mobile') {
                        $service = 'mobile';
                    } else if ($data->type == 'DTH') {
                        $service = 'dth';
                    }

                    $opcode = $data->operator_id;

                    $user_profit = $data->admin_profit;

                    $wallet_profit = $data->profit;

                    if (isset($created_by_id) && $create_by == 'admin') {

                        $commission1_a = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $created_by_id);
                    }
                    if (isset($user_1_createdById) && $user_1_type_id == 'admin') {

                        $commission1_b = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $user_1_createdById);
                    }
                    if (isset($user_2_createdById) && $user_2_type_id == 'admin') {

                        $commission1_c = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $user_2_createdById);
                    }

                    $commission1_d = $this->Recharge_model->getCommission($opcode, $created_by_id, $create_by, $service, $role_slug_id);

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

                    if ($commission1->commission_type == 'percent') {

                        $w_profit = $user_profit * ($commission_rate_1 / 100);
                    } else if ($commission1->commission_type == 'flat') {

                        $w_profit = $commission_rate_1;
                    }

                    $w_bal = $this->db->get_where('users', ['id' => $created_by_id])->row_array();
                    $bal = $w_bal['wallet'];

                    $userType_1 = $this->db->get_where('user_type', ['id' => $w_bal['account_type']])->row();

                    if ($userType_1->slug == 'admin') {

                        $w_profit = $user_profit - $wallet_profit;

                        $new_bal = ($user_profit - $wallet_profit) + $bal;
                    } else {
                        $new_bal = $w_profit + $bal;
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
                        'mobile' => $data->number,
                        'user_type' => $create_by,
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Credit',
                        'amount' => $w_profit,
                        'balance' => $new_bal,
                        'remarks' => $remarks
                    ];

                    // print_r($input_1);

                    if (!empty($input_1)) {
                        $this->db->insert('wallet_balance_history', $input_1);
                    }


                    if ($user_1_createdById != 0) {

                        $c_by = $w_bal['create_by'];

                        $role_slug_id = 'super_admin';

                        if ($data->type == 'Mobile') {
                            $service = 'mobile';
                        } else if ($data->type == 'DTH') {
                            $service = 'dth';
                        }

                        if (isset($created_by_id) && $create_by == 'admin') {

                            $commission2_a = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $created_by_id);
                        }
                        if (isset($user_1_createdById) && $user_1_type_id == 'admin') {

                            $commission2_b = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $user_1_createdById);
                        }
                        if (isset($user_2_createdById) && $user_2_type_id == 'admin') {

                            $commission2_c = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $user_2_createdById);
                        }

                        $commission2_d = $this->Recharge_model->getCommission($opcode, $user_1_createdById, $c_by, $service, $role_slug_id);

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

                        if ($commission2->commission_type == 'percent') {

                            $w_profit_1 = $user_profit * ($commission_rate_2 / 100);
                        } else if ($commission2->commission_type == 'flat') {

                            $w_profit_1 = $commission_rate_2;
                        }

                        $w_bal_c = $this->db->get_where('users', ['id' => $w_bal['created_by_id']])->row_array();
                        $bal_1 = $w_bal_c['wallet'];

                        $userType_2 = $this->db->get_where('user_type', ['id' => $w_bal_c['account_type']])->row();

                        if ($userType_2->slug == 'admin') {

                            $w_profit_1 = $user_profit - $wallet_profit - $w_profit;

                            $new_bal_1 = ($w_profit_1) + $bal_1;
                        } else {
                            $new_bal_1 = $w_profit_1 + $bal_1;
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
                            'mobile' => $data->number,
                            'user_type' => $c_by,
                            'date' => date('d-m-Y'),
                            'time' => date('H:m:s'),
                            'cr_dr' => 'Credit',
                            'amount' => $w_profit_1,
                            'balance' => $new_bal_1,
                            'remarks' => $remarks
                        ];


                        if (!empty($input_2)) {
                            $this->db->insert('wallet_balance_history', $input_2);
                        }

                        if ($user_2_createdById != 0) {
                            $c_by_1 = $w_bal_c['create_by'];

                            $role_slug_id = 'super_admin';

                            if ($data->type == 'Mobile') {
                                $service = 'mobile';
                            } else if ($data->type == 'DTH') {
                                $service = 'dth';
                            }

                            if (isset($created_by_id) && $create_by == 'admin') {

                                $commission3_a = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $created_by_id);
                            }
                            if (isset($user_1_createdById) && $user_1_type_id == 'admin') {

                                $commission3_b = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $user_1_createdById);
                            }
                            if (isset($user_2_createdById) && $user_2_type_id == 'admin') {

                                $commission3_c = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $user_2_createdById);
                            }

                            $commission3_d = $this->Recharge_model->getCommission($opcode, $user_2_createdById, $c_by_1, $service, $role_slug_id);

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

                            if ($commission3->commission_type == 'percent') {

                                $w_profit_2 = $user_profit * ($commission_rate_3 / 100);
                            } else if ($commission3->commission_type == 'flat') {

                                $w_profit_2 = $commission_rate_3;
                            }

                            $w_bal_1 = $this->db->get_where('users', ['id' => $w_bal_c['created_by_id']])->row_array();
                            $bal_2 = $w_bal_1['wallet'];

                            $userType_3 = $this->db->get_where('user_type', ['id' => $w_bal_1['account_type']])->row();

                            if ($userType_3->slug == 'admin') {

                                $w_profit_2 = $user_profit - $wallet_profit - $w_profit - $w_profit_1;

                                $new_bal_2 = ($w_profit_2) + $bal_2;
                            } else {

                                $new_bal_2 = $w_profit_2 + $bal_2;
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
                                'mobile' => $data->number,
                                'user_type' => $c_by_1,
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Credit',
                                'amount' => $w_profit_2,
                                'balance' => $new_bal_2,
                                'remarks' => $remarks
                            ];

                            if (!empty($input_3)) {
                                $this->db->insert('wallet_balance_history', $input_3);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getPlans()
    {
        # API URL
        $url = "https://wpr.oynxdigital.com/api-fetch-plans.php";

        # Define the data
        $accountID = "aid_24011811555664";            // Account ID
        $secret_key = "sk_7e281beab47164ca9f8e117b38e2b10533fce67e20402";           // Secret Key
        $operator = $this->input->post('opcode');             // Operator Code
        $operator_circle = $this->input->post('circle');
        // $operator = 'vodafoneidea' ;           // Operator Code
        // $operator_circle = 'kolkata';     // Circle Code



        # Put the data into an array
        $data = [
            "accountID" => $accountID,
            "secret_key" => $secret_key,
            "operator" => $operator,
            "operator_circle" => $operator_circle
        ];

        # Initialiaze the curl
        $ch = curl_init($url);

        # Setup request to send json via POST.
        $payload = json_encode(["plan_fetch" => $data]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);

        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        # Send request.
        $result = curl_exec($ch);

        curl_close($ch);

        // echo $result;

        $operator = $this->input->post('operator');

        $op_logos = $this->db->get_where('tbl_operator', ['opcode' => $operator])->row_array();

        $logo = base_url() . 'operator_image/' . $op_logos['op_logo'];

        $api_response = json_decode($result, true);



        echo json_encode(['api_response' => $api_response, 'logo' => $logo]);
    }

    public function getData()
    {
        $ch = curl_init();
        $url = 'https://wpr.oynxdigital.com/recharge-plan.php?operator=vodafoneidea&operator_circle=kolkata';
        // $url = 'https://jsonplaceholder.typicode.com/todos/1';


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        echo $response;
    }



    public function user()
    {
        if ($_SESSION['slug'] == 'admin') {
            $admin_id = $_SESSION['user_id'];

            $users = $this->Recharge_model->getSubordinateUsers($admin_id);

            $result = $this->Recharge_model->getRechargeDataByMobileNumbers($users);
        }
    }
}
