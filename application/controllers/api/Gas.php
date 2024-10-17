<?php

class Gas extends CI_Controller
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

        $this->load->model('Gas_model');
    }

    public function getCustomerInfo()
    {

        $this->form_validation->set_rules('service_code', 'Service Code', 'required');

        $this->form_validation->set_rules('customer_number', 'Customer Number', 'required');

        if ($this->form_validation->run() == FALSE) {

            $error_messages = strip_tags(validation_errors());
            $error_messages = str_replace(["<br>", "\n"], '', $error_messages);

            $response = [
                'is_success' => false,
                'message' => $error_messages,
            ];

            echo json_encode($response);
        } else {

            $ch = curl_init();

            $mobileNo = 8777846136;

            $apiKey = 'boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ';

            $serviceCode = $this->input->post('service_code');

            $custNo = $this->input->post('customer_number');

            $data = $this->Gas_model->getData();

            $pincode = $data->pincode;

            $latitude = $data->latitude;

            $longitude = $data->longitude;
            //  echo $pincode; die;

            $url_data = $this->db->get('tbl_utility_api')->row();

            $url_link = $url_data->url;


            $apiUrl = $url_link . 'MobileNo=' . $mobileNo . '&APIKey=' . $apiKey . '&REQTYPE=BILLINFO&SERCODE=' . $serviceCode . '&CUSTNO=' . $custNo . '&REFMOBILENO=' . $mobileNo . '&AMT=0&STV=0&FIELD1=0&FIELD2=0&FIELD3=0&FIELD4=0&FIELD5=0&PCODE=' . $pincode . '&LAT=' . $latitude . '&LONG=' . $longitude . '&RESPTYPE=JSON';


            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }

            curl_close($ch);

            $response = json_decode($response, true);

            if (!empty($response)) {
                $respond = [
                    'status' => true,
                    'message' => 'Success',
                    'data' => $response
                ];
                echo json_encode($respond);
            } else {
                $respond = [
                    'status' => false,
                    'message' => 'Invalid or Empty response Received'
                ];
                echo json_encode($respond);
            }
        }
    }

    public function booking()
    {

        $this->form_validation->set_rules('service_code', 'Service Code', 'required');

        $this->form_validation->set_rules('customer_number', 'Customer Number', 'required');

        $this->form_validation->set_rules('amount', 'Amount', 'required');

        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $error_messages = strip_tags(validation_errors());
            $error_messages = str_replace(["<br>", "\n"], '', $error_messages);

            $response = [
                'is_success' => false,
                'message' => $error_messages,
            ];

            echo json_encode($response);
        } else {

            $cust_no = $this->input->post('customer_number');

            $service_code = $this->input->post('service_code');

            $amount = $this->input->post('amount');

            $cust_name = $this->input->post('customer_name');

            $user = authuser();

            $id = $user['id'];

            $create_by = $user['create_by'];

            $created_by_id = $user['created_by_id'];

            $user_type_data = $this->db->get_where('user_type', ['id' => $user['account_type']])->row_array();

            $user_type = $user_type_data['user_type'];

            $slug = $user_type_data['slug'];


            $wallet = $this->db->get_where('users', ['id' => $id])->row_array();
            $wallet_balance = $wallet['wallet'];

            $pay_by = $user['mobile'];

            $balance = $this->db->get('tbl_balance')->row_array();
            $api_balance = $balance['balance'];

            $user_1 = $this->Billpay_model->getUser($created_by_id);
            $user_1_createdById = $user_1->created_by_id;

            $user_1_type_id = $user_1->create_by;

            $user_2 = $this->Billpay_model->getUser($user_1_createdById);
            $user_2_createdById = $user_2->created_by_id;

            $user_2_type_id  = $user_2->create_by;


            if ($wallet_balance >= $amount && $api_balance >= $amount) {

                $data = $this->Gas_model->getData();

                $pincode = $data->pincode;

                $latitude = $data->latitude;

                $longitude = $data->longitude;

                $mobileNo = 8777846136;

                $apiKey = 'boPpbGBPpxLiim5Qi9dnqy2onioy3ZaOckZ';

                $ref_no = mt_rand(1000000000, 9999999999);

                $payment_url = $this->Gas_model->getApi();
                $api_url = $payment_url->url;


                $apiUrl = $api_url . 'MobileNo=' . $mobileNo . '&APIKey=' . $apiKey . '&REQTYPE=BILLPAY&REFNO=' . $ref_no . '&SERCODE=' . $service_code . '&CUSTNO=' . $cust_no . '&REFMOBILENO=' . $mobileNo . '&AMT=' . $amount . '&STV=0&FIELD1=8777846136&PCODE=' . $pincode . '&LAT=' . $latitude . '&LONG=' . $longitude . '&RESPTYPE=JSON';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }

                curl_close($ch);

                $response = json_decode($response, true);

                $service  = 'lpg_gas';
                $role_slug_id  = 'super_admin';

                if (isset($created_by_id) && $create_by == 'admin') {
                    $commission_a  = $this->Gas_model->getCommission($service_code, $id, $slug, $service, $created_by_id);
                }
                if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                    $commission_b  =  $this->Gas_model->getCommission($service_code, $id, $slug, $service, $user_1_createdById);
                }
                if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                    $commission_c = $this->Gas_model->getCommission($service_code, $id, $slug, $service, $user_2_createdById);
                }

                $commission_d = $this->Gas_model->getCommission($service_code, $id, $slug, $service, $role_slug_id);

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

                    $admin_commission  =  $this->Gas_model->getCommission($service_code, $commission->created_by, $admin_type, $service, $role_slug_id);

                    $admin_commission_rate = $admin_commission->fp_amount;
                }

                $data = [
                    'date' => date('Y-m-d'),
                    'customer_number' => $cust_no,
                    'customer_name' => $cust_name,
                    'service_code' => $service_code,
                    'status_msg' => $response['STATUSMSG'],
                    'amount' => $amount,
                    // 'due_date' => $due_date,
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

                $result = $this->db->insert('lpg_gas_payment', $data);

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
                    $this->db->update('lpg_gas_payment', $data_1);

                    $status = $res['TRNSTATUS'];
                }


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
                        'mobile' => $cust_no,
                        'user_type' => $user_type,
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Debit',
                        'amount' => $amount,
                        'balance' => $updated_wallet_balance,
                        'remarks' => 'For LPG Gas Pay'
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
                        'mobile' => $cust_no,
                        'user_type' => $user_type,
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Credit',
                        'amount' => $commission_rate,
                        'balance' => $new_wallet_balance,
                        'remarks' => 'LPG Gas Pay Profit'
                    ];

                    if (!empty($input)) {
                        $this->db->insert('wallet_balance_history', $input);
                    }

                    if (isset($create_by) && $created_by_id != 0) {
                        $service  = 'lpg_gas';
                        $role_slug_id  = 'super_admin';

                        if (isset($created_by_id) && $create_by == 'admin') {
                            $commission1_a  = $this->Gas_model->getCommission($service_code, $created_by_id, $create_by, $service, $created_by_id);
                        }
                        if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                            $commission1_b  =  $this->Gas_model->getCommission($service_code, $created_by_id, $create_by, $service, $user_1_createdById);
                        }
                        if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                            $commission1_c = $this->Gas_model->getCommission($service_code, $created_by_id, $create_by, $service, $user_2_createdById);
                        }

                        $commission1_d = $this->Gas_model->getCommission($service_code, $created_by_id, $create_by, $service, $role_slug_id);

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
                            'mobile' => $cust_no,
                            'user_type' => $create_by,
                            'date' => date('d-m-Y'),
                            'time' => date('H:m:s'),
                            'cr_dr' => 'Credit',
                            'amount' => $commission_rate_1,
                            'balance' => $new_bal,
                            'remarks' => 'LPG Gas Pay Profit'
                        ];

                        if (!empty($input_1)) {
                            $this->db->insert('wallet_balance_history', $input_1);
                        }

                        if ($user_1_createdById != 0) {

                            $c_by = $w_bal['create_by'];

                            $role_slug_id = 'super_admin';
                            $service = 'lpg_gas';

                            if (isset($created_by_id) && $create_by == 'admin') {
                                $commission2_a = $this->Gas_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $created_by_id);
                            }
                            if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                $commission2_b = $this->Gas_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $user_1_createdById);
                            }
                            if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                $commission2_c = $this->Gas_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $user_2_createdById);
                            }

                            $commission2_d = $this->Gas_model->getCommission($service_code, $user_1_createdById, $c_by, $service, $role_slug_id);

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
                                'mobile' => $cust_no,
                                'user_type' => $c_by,
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Credit',
                                'amount' => $commission_rate_2,
                                'balance' => $new_bal_1,
                                'remarks' => 'LPG Gas Pay Profit'
                            ];

                            if (!empty($input_2)) {
                                $this->db->insert('wallet_balance_history', $input_2);
                            }

                            if ($user_2_createdById != 0) {

                                $c_by_1 = $w_bal_c['create_by'];

                                $role_slug_id = 'super_admin';
                                $service = 'lpg_gas';

                                if (isset($created_by_id) && $create_by == 'admin') {
                                    $commission3_a = $this->Gas_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $created_by_id);
                                }
                                if (isset($user_1_createdById) && $user_1_type_id == 'admin') {
                                    $commission3_b = $this->Gas_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $user_1_createdById);
                                }
                                if (isset($user_2_createdById) && $user_2_type_id == 'admin') {
                                    $commission3_c = $this->Gas_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $user_2_createdById);
                                }

                                $commission3_d = $this->Gas_model->getCommission($service_code, $user_2_createdById, $c_by_1, $service, $role_slug_id);

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
                                    'mobile' => $cust_no,
                                    'user_type' => $c_by_1,
                                    'date' => date('d-m-Y'),
                                    'time' => date('H:m:s'),
                                    'cr_dr' => 'Credit',
                                    'amount' => $commission_rate_3,
                                    'balance' => $new_bal_2,
                                    'remarks' => 'LPG Gas Pay Profit'
                                ];

                                if (!empty($input_3)) {
                                    $this->db->insert('wallet_balance_history', $input_3);
                                }
                            }
                        }
                    }
                }

                if ($status == 1) {
                    $utility_balance = $this->db->get('tbl_utility_balance')->row_array();
                    $api_balance = $utility_balance['balance'];
                    $api_current_balance = $api_balance - $amount;


                    $user_mobile = $pay_by;

                    $history = [
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'customer_id' => $cust_no,
                        'customer_name' => $cust_name,
                        'amount' => $amount,
                        'balance' => $api_current_balance,
                        'cr_dr' => 'Debit',
                        'remarks' => 'For LPG Gas Pay',
                        'user_type' => $user_type,
                        'user_mobile' => $user_mobile,
                    ];


                    $this->db->insert('tbl_utility_api_history', $history);
                }

                if ($status == 1) {
                    $respond = [
                        'status' => true,
                        'message' => 'Payment Successfull',
                        'data' => $response,
                        'status_check_data' => $res
                    ];

                    echo json_encode($respond);
                } else if ($status == 0) {
                    $respond = [
                        'status' => true,
                        'message' => 'Request Accepted',
                        'data' => $response,
                        'status_check_data' => $res
                    ];

                    echo json_encode($respond);
                } else {
                    $respond = [
                        'status' => false,
                        'message' => 'Payment Fail',
                        'data' => $response,
                        'status_check_data' => $res
                    ];

                    echo json_encode($respond);
                }
            } else {
                $respond = [
                    'status' => false,
                    'message' => 'Insufficient Balance, Please Recharge Your Wallet',
                    'wallet_balance' => $wallet['wallet'],
                    'api_balance' => $api_balance
                ];

                echo json_encode($respond);
            }
        }
    }


    public function history()
    {
        $user  =  authuser();

        $pay_by = $user['mobile'];

        $bill_data = $this->Gas_model->getLPGData($pay_by);

        $total_amount = $this->Gas_model->totalBillAmount($pay_by);

        if (!is_null($bill_data)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $bill_data,
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

        $gas_bill = $this->db->query(" SELECT 
                                            tbl_lpg_operator.op_logo, 
                                            tbl_lpg_operator.operator,
                                            users.name,
                                            user_type.user_type,
                                            lpg_gas_payment.*
                                        FROM 
                                            lpg_gas_payment
                                        JOIN 
                                            tbl_lpg_operator
                                        ON 
                                            tbl_lpg_operator.opcode = lpg_gas_payment.service_code
                                        JOIN 
                                            users
                                        ON 
                                            lpg_gas_payment.pay_by =  users.mobile 
                                        JOIN 
                                            user_type
                                        ON 
                                            users.account_type = user_type.id           
                                        WHERE 
                                            lpg_gas_payment.id = $id")->row_array();


        function AmountInWords(float $amount)
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
                    $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                    $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
           ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
           ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
                } else $string[] = null;
            }
            $implode_to_Rupees = implode('', array_reverse($string));
            $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
             " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
            return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        }

        $amount = $gas_bill['amount'];
        $words = AmountInWords($amount);

        $words = str_replace(array("\r", "\n"), '', $words);

        if (!is_null($gas_bill)) {
            $respond = [
                'status' => true,
                'message' => 'Success',
                'data' => $gas_bill,
                'amount_in_words' => $words,
                'logo_url' => base_url() . 'operator_image/'
            ];

            echo json_encode($respond);
        }
    }
}
