<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Balancededuct extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {
            $input = [];
            if (isset($_SESSION['slug'])) {
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $user_t = $_SESSION['user_type'];
                    $user_mobile = $_SESSION['mobile'];
                    // echo $user_id;
                    //         die;
                }

                $balance_1 = $this->db->get_where('users', ['id' => $user_id])->row_array();
                //  print_r($balance_1); die;

                $wallet_balance = $balance_1['wallet'];
                // echo $wallet_balance; die;

                if ($this->input->post() != NULL) {
                    if ($this->input->post('mobile') != $user_mobile) {
                        $balance = $this->input->post('balance');
                        // echo $balance; die;
                        if ($balance > 0 && $balance >= $this->input->post('amount')) {
                            $wallet = $this->input->post('balance') - $this->input->post('amount');
                            // echo $wallet;
                            $input = [
                                'wallet' => $wallet,
                                'narration' => $this->input->post('narration'),
                            ];

                            // print_r($input);

                            $wallet_balance += $this->input->post('amount');
                            $data = [
                                'wallet' => $wallet_balance,
                            ];

                            // print_r($data);
                        }
                        // exit;

                        if (!empty($input)) {
                            // print_r($input);
                            $this->db->where(['mobile' => $this->input->post('mobile')]);
                            $this->db->update('users', $input);

                            $error = $this->db->error();

                            if ($error['code'] == 0) {
                                date_default_timezone_set('Asia/Kolkata');

                                $user = $this->db->get_where('users', ['mobile' => $this->input->post('mobile')])->row_array();

                                $account_type = $user['account_type'];

                                $user_type = $this->db->get_where('user_type', ['id' => $account_type])->row_array();

                                $date = date('d-m-Y');

                                $time = date('H:m:s');

                                $input_bh = [
                                    'mobile' => $this->input->post('mobile'),
                                    'from_mobile' => $user_mobile,
                                    'user_type' => $user_t,
                                    'date' => $date,
                                    'time' => $time,
                                    'cr_dr' => 'Debit',
                                    'amount' => $this->input->post('amount'),
                                    'balance' => $wallet,
                                    'remarks' => $this->input->post('narration'),
                                ];

                                // print_r($input_bh); die; 

                                if (!empty($input_bh)) {
                                    $insert = $this->db->insert('wallet_balance_history', $input_bh);

                                    // $error = $this->db->error();

                                    // if ($error['code'] == 0) {
                                    //     redirect('balancehistory', 'refresh');
                                    // }
                                }
                            }
                        }

                        if (!empty($data)) {
                            $this->db->where(['id' => $user_id]);
                            $this->db->update('users', $data);

                            $error = $this->db->error();

                            if ($error['code'] == 0) {
                                date_default_timezone_set('Asia/Kolkata');

                                // print_r($user_type);
                                // die;

                                $date = date('d-m-Y');

                                $time = date('H:m:s');

                                $input_bdh = [
                                    'from_mobile' => $this->input->post('mobile'),
                                    'mobile' => $user_mobile,
                                    'user_type' => $user_type['user_type'],
                                    'date' => $date,
                                    'time' => $time,
                                    'cr_dr' => 'Credit',
                                    'amount' => $this->input->post('amount'),
                                    'balance' => $wallet_balance,
                                    'remarks' =>  $this->input->post('narration'),
                                ];
                                //   print_r($input_bh);die;

                                if (!empty($input_bdh)) {
                                    // print_r($input_bh);
                                    // die;
                                    $insert = $this->db->insert('wallet_balance_history', $input_bdh);

                                    $error = $this->db->error();

                                    if ($error['code'] == 0) {
                                        redirect('balancehistory', 'refresh');
                                    }
                                }
                            }
                        }
                    } else {
                        $this->session->set_flashdata('error', 'User Cannot Deduct Balance From Same Account.');
                        redirect('balancededuct');
                    }
                }
            }
            if (isset($_SESSION['role'])) {
                if ($this->input->post() != NULL) {
                    $wallet = $this->input->post('balance') - $this->input->post('amount');
                    $input = [
                        'wallet' => $wallet,
                        'narration' => $this->input->post('narration'),
                    ];

                    if (!empty($input)) {

                        $this->db->where(['mobile' => $this->input->post('mobile')]);
                        $this->db->update('users', $input);


                        $error = $this->db->error();

                        if ($error['code'] == 0) {
                            date_default_timezone_set('Asia/Kolkata');



                            // print_r($user_type);
                            // die;

                            $date = date('d-m-Y');

                            $time = date('H:m:s');

                            $input_bh = [
                                'from_mobile' => $this->input->post('mobile'),
                                'user_type' => $_SESSION['role'],
                                'date' => $date,
                                'time' => $time,
                                'cr_dr' => 'Debit',
                                'amount' => $this->input->post('amount'),
                                'balance' => $wallet,
                                'remarks' =>  $this->input->post('narration'),
                            ];
                            //  print_r($input_bh);die;

                            if (!empty($input_bh)) {
                                // print_r($input_bh);
                                // die;
                                $insert = $this->db->insert('wallet_balance_history', $input_bh);

                                $error = $this->db->error();

                                if ($error['code'] == 0) {
                                    redirect('balancehistory', 'refresh');
                                }
                            }
                        }
                    }
                }
            }

            $this->load->view('balancededuct');
        } else {

            redirect('userlogin');
        }
    }
}
