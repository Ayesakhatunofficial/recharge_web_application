<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Balancehistory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Recharge_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {
            $query_usertype = $this->db->get('user_type');
            $data['user_types'] = $query_usertype->result_array();

            $this->db->select('wallet_balance_history.*, users.name')
                ->from('wallet_balance_history')
                ->join('users', 'wallet_balance_history.from_mobile = users.mobile')
                ->order_by('wallet_balance_history.id', 'desc');
            $data['wbalhists'] = $this->db->get()->result_array();


            if (isset($_SESSION['slug']) && $_SESSION['slug'] == 'admin') {
                $admin_id = $_SESSION['user_id'];

                $users = $this->Recharge_model->getSubordinateUsers($admin_id);

                // $data['wbalhists'] = $this->db->where_in('from_mobile', $users)->get('wallet_balance_history')->result_array();

                $this->db->select('wallet_balance_history.*, users.name')
                    ->from('wallet_balance_history')
                    ->join('users', 'wallet_balance_history.from_mobile = users.mobile')
                    ->where_in('wallet_balance_history.from_mobile', $users)
                    ->order_by('wallet_balance_history.id', 'desc');
                $data['wbalhists'] = $this->db->get()->result_array();

                // $data['wbalhists'] = $this->db->order_by('id', 'desc')->get_where('wallet_balance_history', ['from_mobile' => $_SESSION['mobile']])->result_array();
            }


            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'reatiler' || $_SESSION['slug'] == 'super_distributor' || $_SESSION['slug'] == 'distributor')) {

                // $data['wbalhists'] = $this->db->order_by('id', 'desc')
                //     ->get_where('wallet_balance_history', ['from_mobile' => $_SESSION['mobile']])
                //     ->result_array();

                $this->db->select('wallet_balance_history.*, users.name')
                    ->from('wallet_balance_history')
                    ->join('users', 'wallet_balance_history.from_mobile = users.mobile')
                    ->where('wallet_balance_history.from_mobile', $_SESSION['mobile'])
                    ->order_by('wallet_balance_history.id', 'desc');
                $data['wbalhists'] = $this->db->get()->result_array();
            }

            if ($this->input->post() != NULL) {
                if (isset($_SESSION['slug'])) {
                    $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

                    $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

                    $input = [
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'mobile' => $this->input->post('mobile')
                    ];

                    // echo "<pre>"; print_r($input); die;

                    if (!empty($input['mobile'])) {

                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->get_where('wallet_balance_history', ['mobile' => $input['mobile']])->result_array();
                    } else {

                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM wallet_balance_history WHERE date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
                    }
                }
                if (isset($_SESSION['role'])) {

                    $from_date = $this->input->post('from_date');
                    $to_date = $this->input->post('to_date');
                    $mobile = $this->input->post('mobile');
                    $user_type = $this->input->post('user_type');
                    $user = $this->input->post('user');

                    if (!empty($from_date && $to_date) && empty($mobile && $user_type && $user)) {
                        $input = [
                            'from_date' => date("d-m-Y", strtotime($from_date)),
                            'to_date' => date("d-m-Y", strtotime($to_date)),
                        ];
                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM wallet_balance_history WHERE date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
                    }
                    if (!empty($mobile) && empty($from_date && $to_date && $user_type && $user)) {

                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->get_where('wallet_balance_history', ['mobile' => $mobile])->result_array();
                    }

                    if (!empty($user_type && $user) && empty($mobile && $to_date && $from_date)) {

                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->get_where('wallet_balance_history', ['from_mobile' => $user])->result_array();
                    }
                    if (!empty($from_date && $to_date && $mobile) && empty($user_type && $user)) {
                        $input = [
                            'from_date' => date("d-m-Y", strtotime($from_date)),
                            'to_date' => date("d-m-Y", strtotime($to_date)),
                        ];
                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM wallet_balance_history WHERE date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND mobile = $mobile ")->result_array();
                    }

                    if (!empty($from_date && $to_date && $user_type && $user) && empty($mobile)) {
                        $input = [
                            'from_date' => date("d-m-Y", strtotime($from_date)),
                            'to_date' => date("d-m-Y", strtotime($to_date)),
                        ];
                        $data['wbalhists'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM wallet_balance_history WHERE date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND from_mobile = $user ")->result_array();
                    }
                }
            }

            $this->load->view('balancehistory', $data);
        } else {

            redirect('userlogin');
        }
    }

    public function getUser()
    {
        $user_type = $this->input->post('user_type');

        // Get the user_type_id
        $users_id = $this->db->get_where('user_type', ['slug' => $user_type])->row_array();
        $user_type_id = $users_id['id'];

        // Get users based on the conditions
        $this->db->where('account_type', $user_type_id);
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);

        $users = $this->db->get('users')->result_array();

        $opt = "<option value=''>Select User</option>";
        foreach ($users as $user) {
            $opt .= "<option value='" . $user['mobile'] . "'>" . $user['name'] . " - " . $user['mobile'] . "</option>";
        }

        // Return the options as JSON
        echo json_encode(['options' => $opt]);
    }
}
