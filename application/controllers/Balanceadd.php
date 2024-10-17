<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Balanceadd extends CI_Controller
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

            $input_bh = [];

            if (isset($_SESSION['slug'])) {
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $user_t = $_SESSION['user_type'];
                    $user_mobile = $_SESSION['mobile'];
                    // echo $user_id;
                    //         die;
                }

                $balance = $this->db->get_where('users', ['id' => $user_id])->row_array();

                // print_r($balance);die;

                $wallet_balance = $balance['wallet'];

                if ($this->input->post() != NULL) {
                    if ($this->input->post('mobile') != $user_mobile) {
                        if ($this->input->post('amount') <= $wallet_balance) {
                            $wallet_balance -= $this->input->post('amount');
                            $data = [
                                'wallet' => $wallet_balance,
                            ];
                            $wallet = $this->input->post('balance') + $this->input->post('amount');

                            $input = [
                                'wallet' => $wallet,
                                'narration' => $this->input->post('narration'),
                            ];
                        }

                        $user = $this->db->get_where('users', ['mobile' => $this->input->post('mobile')])->row_array();

                        $account_type = $user['account_type'];

                        $user_type = $this->db->get_where('user_type', ['id' => $account_type])->row_array();

                        if (!empty($data)) {
                            // print_r($data);die;
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
                                    'mobile' => $this->input->post('mobile'),
                                    'from_mobile' => $user_mobile,
                                    'user_type' => $user_type['user_type'],
                                    'date' => $date,
                                    'time' => $time,
                                    'cr_dr' => 'Debit',
                                    'amount' => $this->input->post('amount'),
                                    'balance' => $wallet_balance,
                                    'remarks' =>  $this->input->post('narration'),
                                ];
                                //  print_r($input_bh);die;

                                if (!empty($input_bdh)) {
                                    // print_r($input_bh);
                                    // die;
                                    $insert = $this->db->insert('wallet_balance_history', $input_bdh);
                                }
                            }
                        }

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
                                    'mobile' => $user_mobile,
                                    'user_type' => $user_t,
                                    'date' => $date,
                                    'time' => $time,
                                    'cr_dr' => 'Credit',
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
                    } else {
                        $this->session->set_flashdata('error', 'User Cannot Add Balance From Same Account.');
                        redirect('balanceadd');
                    }
                }
            }

            if (isset($_SESSION['role'])) {
                if ($this->input->post() != NULL) {
                    $wallet = $this->input->post('balance') + $this->input->post('amount');
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
                                'cr_dr' => 'Credit',
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


            // echo $wallet_balance; die;


            $this->load->view('balanceadd');
        } else {

            redirect('userlogin');
        }
    }
}
