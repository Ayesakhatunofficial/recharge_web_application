<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Walletrecharge extends CI_Controller
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
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $user_t = $_SESSION['user_type'];
                $user_mobile = $_SESSION['mobile'];
                $created_by = $_SESSION['created_by'];
                $created_by_id = $_SESSION['created_by_id'];
                // echo $created_by;
                // echo $created_by_id;
                // die;
            }

            if ($created_by == 'super_admin') {
                $created_by_id = $created_by;
            }

            $data['datas'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['username' => $user_id])->result_array();

            if ($this->input->post() != NULL) {
                if (empty($this->input->post('utr_no') && $this->input->post('amount'))) {
                    $this->session->set_flashdata('error', 'Amount Or UTR field is required');
                    redirect('walletrecharge');
                }
                date_default_timezone_set('Asia/Kolkata');
                $date = date('d-m-Y');
                $time = date('H:m:s');
                $input = [
                    'mobile' => $user_mobile,
                    'username' => $user_id,
                    'user_type' => $user_t,
                    'amount' => $this->input->post('amount'),
                    'txn_no' => $this->input->post('utr_no'),
                    'create_date' => $date,
                    'create_time' => $time,
                    'status' => 0,
                    'remarks' => $this->input->post('narration'),
                    'user_create' => $created_by_id,
                ];

                if (!empty($input)) {
                    $insert = $this->db->insert('listfundrequest', $input);
                    $error = $this->db->error();

                    if ($insert) {
                        $this->session->set_flashdata('success', 'Request send successfully');
                        redirect('walletrecharge');
                    }
                }
            }
            
            $this->load->view('walletrecharge', $data);
        } else {

            redirect('userlogin');
        }
    }

    public function success($orderid)
    {

        $data['orderid'] = $orderid;
        // print_r($data['orderid']); die;
        $this->load->view('success', $data);
    }

    public function fail()
    {
        $this->load->view('fail');
    }
}
