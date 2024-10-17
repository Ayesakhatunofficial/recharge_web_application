<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Approvelistfundrequest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index($id)
    {
        $input = [];

        $input = [
            'remarks' => $this->input->post("remarks"),
            'status'  => 1
        ];

        // echo $id; die;
        $result = $this->db->get_where('listfundrequest', ['id' => $id])->row_array();
        // print_r($result); die;
        $request_amount = $result['amount'];

        $mobile = $result['mobile'];
        $balance = $this->db->get_where('users', ['mobile' => $mobile])->row_array();
        $old_balance = $balance['wallet'];

        if (isset($_SESSION['slug'])) {

            $user_id = $_SESSION['user_id'];
            $wallet_1 = $this->db->get_where('users', ['id' => $user_id])->row_array();
            $wallet_balance_1 = $wallet_1['wallet'];

            if ($wallet_balance_1 >= $request_amount) {
                $current_wa = $wallet_balance_1 - $request_amount;
            } else {
                redirect('listfundrequest', 'refresh');
            }

            $data = [
                'wallet' => $current_wa,
            ];

            date_default_timezone_set('Asia/Kolkata');

            $input_data = [
                'mobile' => $result['mobile'],
                'user_type' => $result['user_type'],
                'from_mobile' => $_SESSION['mobile'],
                'date' => date('d-m-Y'),
                'time' => date('H:m:s'),
                'cr_dr' => 'Debit',
                'amount' => $request_amount,
                'balance' => $current_wa,
                'remarks' => $this->input->post("remarks"),
                // 'created_by' => 
            ];

            if (!empty($input_data)) {
                $this->db->insert('wallet_balance_history', $input_data);
            }


            $new_balance = $old_balance + $request_amount;

            $data_1 = [
                'wallet' => $new_balance,
            ];
            
            // print_r($input);
            // print_r($data); 
            // print_r($data_1); die;

            if (!empty($data)) {
                $this->db->where(['id' => $user_id]);
                $this->db->update('users', $data);

                $error = $this->db->error();
                if ($error['code'] == 0) {
                    if (!empty($data_1)) {
                        $this->db->where(['mobile' => $mobile]);
                        $this->db->update('users', $data_1);
                    }

                    $input_1 = [
                        'mobile' => $_SESSION['mobile'],
                        'user_type' => $_SESSION['user_type'],
                        'from_mobile' => $result['mobile'],
                        'date' => date('d-m-Y'),
                        'time' => date('H:m:s'),
                        'cr_dr' => 'Credit',
                        'amount' => $request_amount,
                        'balance' => $new_balance,
                        'remarks' => $this->input->post("remarks")
                    ];

                    if (!empty($input_1)) {
                        $this->db->insert('wallet_balance_history', $input_1);
                    }
                }
            }
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] == 'super_admin') {
            $new_amount = $request_amount + $old_balance;
            $data = [
                'wallet' => $new_amount,
            ];

            if (!empty($data)) {
                $this->db->where(['mobile' => $mobile]);
                $this->db->update('users', $data);
            }

            $input_2 = [
                'from_mobile' => $result['mobile'],
                'user_type' => $result['user_type'],
                'date' => date('d-m-Y'),
                'time' => date('H:m:s'),
                'cr_dr' => 'Credit',
                'amount' => $request_amount,
                'balance' => $new_amount,
                'remarks' => $this->input->post("remarks")
            ];

            if (!empty($input_2)) {
                $this->db->insert('wallet_balance_history', $input_2);
            }
        }



        if (!empty($input)) {
            $this->db->where(['id' => $id]);
            $this->db->update('listfundrequest', $input);

            $error = $this->db->error();

            if ($error['code'] == 0) {
                $this->session->set_flashdata('success', 'Recharge Approved.');
                redirect('balancehistory', 'refresh');
            }
        }
    }
}
