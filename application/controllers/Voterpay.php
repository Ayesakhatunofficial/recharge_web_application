<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Voterpay extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        date_default_timezone_set('Asia/Kolkata');

        if (isset($_SESSION['user_type'])) {

            $user_type = $this->db->get_where('user_type', ['slug' => $_SESSION['slug']])->row_array();

            $uri = [];

            if ($_SESSION['order_id'] != NULL) {
                $online_voter_pay = $this->db->get_where('online_payment_history', ['order_id' => $_SESSION['order_id'], 'status' => 1])->row_array();

                if (empty($online_voter_pay)) {
                    $online_voter_pay['Fees'] = 0;
                    $online_voter_pay['Remarks'] = "-";
                }

                $deduct_wallet_balance = $user_type['wallet_money'] - $online_voter_pay['Fees'];

                if ($deduct_wallet_balance > 0) {

                    $this->db->where(['slug' => $_SESSION['slug']]);
                    $this->db->update('user_type', ['wallet_money' => $deduct_wallet_balance]);

                    $error = $this->db->error();

                    if ($error['code'] == 0) {

                        if ($_SESSION['action'] == 'print') {
                            if ($deduct_wallet_balance != $user_type['wallet_money']) {
                                $this->db->where(['epic_no' => $_SESSION['AID']]);
                                $this->db->update('voter_details', ['is_pay_print' => 1]);
                            }

                            $this->db->insert('wallet_balance_history', [
                                'mobile' => $user_type['mobile'],
                                'user_type' => $user_type['user_type'],
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Debit',
                                'amount' => $online_voter_pay['Fees'],
                                'balance' => $deduct_wallet_balance,
                                'remarks' => $online_voter_pay['Remarks']
                            ]);

                            $error_print = $this->db->error();

                            if ($error_print['code'] == 0) {

                                unset($_SESSION['AID']);
                                unset($_SESSION['page']);
                                unset($_SESSION['action']);
                                unset($_SESSION['order_id']);
                                unset($_SESSION['mid']);
                                unset($_SESSION['mkey']);
                                unset($_SESSION['token']);

                                redirect('viewvotercard', 'refresh');
                            }
                        }

                        if ($_SESSION['action'] == 'print1') {

                            if ($deduct_wallet_balance != $user_type['wallet_money']) {
                                $this->db->where(['epic_no' => $_SESSION['AID']]);
                                $this->db->update('voter_details', ['is_pay_print1' => 1]);
                            }

                            $this->db->insert('wallet_balance_history', [
                                'mobile' => $user_type['mobile'],
                                'user_type' => $user_type['user_type'],
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Debit',
                                'amount' => $online_voter_pay['Fees'],
                                'balance' => $deduct_wallet_balance,
                                'remarks' => $online_voter_pay['Remarks']
                            ]);

                            $error_print1 = $this->db->error();

                            if ($error_print1['code'] == 0) {

                                unset($_SESSION['AID']);
                                unset($_SESSION['page']);
                                unset($_SESSION['action']);
                                unset($_SESSION['order_id']);
                                unset($_SESSION['mid']);
                                unset($_SESSION['mkey']);
                                unset($_SESSION['token']);

                                redirect('viewvotercard', 'refresh');
                            }
                        }

                        if ($_SESSION['action'] == 'print2') {

                            if ($deduct_wallet_balance != $user_type['wallet_money']) {
                                $this->db->where(['epic_no' => $_SESSION['AID']]);
                                $this->db->update('voter_details', ['is_pay_print2' => 1]);
                            }

                            $this->db->insert('wallet_balance_history', [
                                'mobile' => $user_type['mobile'],
                                'user_type' => $user_type['user_type'],
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Debit',
                                'amount' => $online_voter_pay['Fees'],
                                'balance' => $deduct_wallet_balance,
                                'remarks' => $online_voter_pay['Remarks']
                            ]);

                            $error_print2 = $this->db->error();

                            if ($error_print2['code'] == 0) {

                                unset($_SESSION['AID']);
                                unset($_SESSION['page']);
                                unset($_SESSION['action']);
                                unset($_SESSION['order_id']);
                                unset($_SESSION['mid']);
                                unset($_SESSION['mkey']);
                                unset($_SESSION['token']);

                                redirect('viewvotercard', 'refresh');
                            }
                        }

                        if ($_SESSION['action'] == 'eprint') {

                            if ($deduct_wallet_balance != $user_type['wallet_money']) {
                                $this->db->where(['epic_no' => $_SESSION['AID']]);
                                $this->db->update('voter_details', ['is_pay_e_print' => 1]);
                            }

                            $this->db->insert('wallet_balance_history', [
                                'mobile' => $user_type['mobile'],
                                'user_type' => $user_type['user_type'],
                                'date' => date('d-m-Y'),
                                'time' => date('H:m:s'),
                                'cr_dr' => 'Debit',
                                'amount' => $online_voter_pay['Fees'],
                                'balance' => $deduct_wallet_balance,
                                'remarks' => $online_voter_pay['Remarks']
                            ]);

                            $error_eprint = $this->db->error();

                            if ($error_eprint['code'] == 0) {

                                unset($_SESSION['AID']);
                                unset($_SESSION['page']);
                                unset($_SESSION['action']);
                                unset($_SESSION['order_id']);
                                unset($_SESSION['mid']);
                                unset($_SESSION['mkey']);
                                unset($_SESSION['token']);

                                redirect('viewvotercard', 'refresh');
                            }
                        }
                    } else {
                        die;
                    }
                } else {
                    die("You have insufficient balance, please recharge");
                }
            }
        }
    }
}
