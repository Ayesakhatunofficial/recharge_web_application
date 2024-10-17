<?php

class Mobilerecharge extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        validJWT();

        $this->load->helper(array('form', 'url',));

        $this->load->library('form_validation');

        $this->load->model('Recharge_model');
    }


    public function  index()
    {
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');

        $this->form_validation->set_rules('operator', 'Operator', 'required');

        $this->form_validation->set_rules('amount', 'Amount', 'required');

        if ($this->form_validation->run() == FALSE) {
            $error_messages = strip_tags(validation_errors());
            $error_messages = str_replace(["<br>", "\n"], '', $error_messages);

            $response = [
                'is_success' => false,
                'message' => $error_messages,
            ];

            echo json_encode($response);
        } else {

            $number = $this->input->post('mobile_number');
            $opcode = $this->input->post('operator');
            $amount = $this->input->post('amount');

            $user = authuser();

            $id = $user['id'];

            $create_by = $user['create_by'];

            $created_by_id = $user['created_by_id'];

            $user_type_data = $this->db->get_where('user_type', ['id' => $user['account_type']])->row_array();

            $user_type = $user_type_data['user_type'];

            $slug = $user_type_data['slug'];


            $wallet = $this->db->get_where('users', ['id' => $id])->row_array();
            $wallet_balance = $wallet['wallet'];

            $recharge_by = $user['mobile'];

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

                    $response = [
                        'status' => false,
                        'message' => 'Duplicate trans id'
                    ];
                    echo json_encode($response);
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

                if ($margin != '' || $margin != 0) {

                    $profit = $amount * ($margin / 100);
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

                            $user_profit = $wallet_profit;
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

                    $user_mobile = $recharge_by;

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
                        'from_mobile' => $user_mobile,
                        'mobile' => $number,
                        'user_type' => $user_type,
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

                ///////////////             end of code amount deduct             //////////////////////


                if ($margin) {

                    if ($status == 'SUCCESS') {

                        ///////////////////////         PROFIT ADD AND BALANCE UPDATE    //////////////////////

                        $current_balance = $updated_wallet_balance + $wallet_profit;
                        // echo $current_balance;
                        $com_data = [
                            'wallet' => $current_balance,
                        ];

                        if (!empty($com_data)) {
                            $this->db->where(['id' => $id]);
                            $this->db->update('users', $com_data);
                        }


                        $input = [
                            'from_mobile' => $user_mobile,
                            'mobile' => $number,
                            'user_type' => $user_type,
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
                    $respond = [
                        'is_success' => true,
                        'message' => 'Recharge Successfully Done.',
                        'data' => $response,
                        'status_check_data' => $res,
                    ];
                    echo json_encode($respond);
                } else if ($status == 'PENDING') {
                    $respond = [
                        'is_success' => false,
                        'message' => 'Something went wrong! , Recharge Pending',
                        'data' => $response,
                        'status_check_data' => $res,
                    ];

                    echo json_encode($respond);
                } else {
                    $respond = [
                        'is_success' => false,
                        'message' => 'Recharge Fail',
                        'data' => $response,
                        'status_check_data' => $res,
                    ];

                    echo json_encode($respond);
                }
            } else {
                $respond = [
                    'is_success' => false,
                    'message' => 'Insufficient Balance, Please Recharge Your Wallet',
                    'wallet_balance' => $wallet['wallet'],
                    'api_balance' => $api_balance
                ];

                echo json_encode($respond);
            }
        }
    }


    public function getPlans()
    {
        $this->form_validation->set_rules('circle', 'Circle', 'required');

        $this->form_validation->set_rules('operator_code', 'Operator Code', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = [
                'is_success' => false,
                'message' => 'Validation error',
                'error' => $this->form_validation->error_array()
            ];

            echo json_encode($response);
        } else {

            $operator = $this->input->post('operator_code');

            if ($operator == 10) {
                $opcode = 'airtel';
            } else if ($operator == 11 || $operator == 12) {
                $opcode = 'bsnl';
            } else if ($operator == 21 || $operator == 13) {
                $opcode = 'mtnl';
            } else if ($operator == 14) {
                $opcode = 'jio';
            } else if ($operator == 15) {
                $opcode = 'vodafoneidea';
            }
            # API URL
            $url = "https://wpr.oynxdigital.com/api-fetch-plans.php";

            # Define the data
            $accountID = "aid_24011811555664";            // Account ID
            $secret_key = "sk_7e281beab47164ca9f8e117b38e2b10533fce67e20402";           // Secret Key
            $operator = $opcode;             // Operator Code
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

            $operator = $this->input->post('operator_code');

            $op_logos = $this->db->get_where('tbl_operator', ['opcode' => $operator])->row_array();

            $logo = base_url() . 'operator_image/' . $op_logos['op_logo'];

            $api_response = json_decode($result, true);

            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $api_response,
                'logo' => $logo
            ];

            echo json_encode($respond);
        }
    }

    public function history()
    {
        $user = authuser();

        $recharge_by = $user['mobile'];

        $datas = $this->Recharge_model->getRechargeList($recharge_by);

        $total_amount = $this->Recharge_model->totalRechargeAmount($recharge_by);

        if (!is_null($datas)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $datas,
                'total_profit' => $total_amount->total_profit,
                'total_amount' => $total_amount->total_amount,
                'logo_url' => 'https://recharge.desuntechnologies.com/operator_image/'
            ];

            echo json_encode($respond);
        } else {

            $respond = [
                'status' => false,
                'message' => 'Something went wrong'
            ];

            echo json_encode($respond);
        }
    }

    public function bill()
    {
        $id = $this->input->get('id');
        if (!empty($id) || $id != '') {

            $mobile_bill = $this->db->query("SELECT 
                                            tbl_operator.op_logo, 
                                            tbl_operator.operator,
                                            users.name,
                                            user_type.user_type,
                                            tbl_recharge.*
                                        FROM 
                                            tbl_recharge
                                        JOIN 
                                            tbl_operator
                                        ON 
                                            tbl_operator.opcode = tbl_recharge.operator_id
                                        JOIN 
                                            users
                                        ON 
                                            tbl_recharge.recharge_by =  users.mobile 
                                        JOIN 
                                            user_type
                                        ON 
                                            users.account_type = user_type.id           
                                        WHERE 
                                            tbl_recharge.id = $id")->row_array();

            if (!is_null($mobile_bill) || !empty($mobile_bill)) {

                $amount = $mobile_bill['amount'];
                $words = $this->AmountInWords($amount);

                $words = str_replace('/\s+/', ' ', $words);
                $words =  preg_replace('/\s+/', ' ', $words);
                $words = trim($words);

                // echo $words; die;


                $respond = [
                    'status' => true,
                    'message' => 'Success',
                    'data' => $mobile_bill,
                    'amount_in_words' => $words,
                    'logo_url' => base_url() . 'operator_image/'
                ];

                echo json_encode($respond);
            } else {
                $respond = [
                    'status' => false,
                    'message' => 'Something went wrong or Id does not exist'
                ];

                echo json_encode($respond);
            }
        } else {
            $respond = [
                'status' => false,
                'message' => 'Id does not exist'
            ];

            echo json_encode($respond);
        }
    }

    public function AmountInWords(float $amount)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' And ' : null;
                $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
            } else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        $get_paise = ($amount_after_decimal > 0) ? " And " . ($change_words[$amount_after_decimal / 10] . " " . $change_words[$amount_after_decimal % 10]) . ' Paise ' : '';
        return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }
}
