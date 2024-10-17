<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Viewapprovefund extends CI_Controller
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

            if ($this->uri->segment(3) != NULL) {
                $id = $this->uri->segment(3);

                $data['actions'] = $this->db->get_where('menu_action', ['menu_id' => $id])->result_array();
            }
            if (isset($_SESSION['role'])) {
                $user = $_SESSION['role'];
                // ECHO $user; die;
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user, 'status' => 1])->result_array();

                $this->db->select_sum('amount');
                $this->db->where('status', 1);
                $this->db->where('user_create', $user);
                $data['total_amount'] = $this->db->get('listfundrequest')->row_array();

                // print_r($data['total_amount']);
                // die;
            }

            $user_id = $_SESSION['user_id'];
            // echo $user_id; die;

            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'admin')) {
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user_id, 'status' => 1])->result_array();
                // print_r($data['listfundrequests']); die;

                $this->db->select_sum('amount');
                $this->db->where('status', 1);
                $this->db->where('user_create', $user_id);
                $data['total_amount'] = $this->db->get('listfundrequest')->row_array();
            }

            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'super_distributor')) {
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user_id, 'status' => 1])->result_array();
                // print_r($data['listfundrequests']); die;

                $this->db->select_sum('amount');
                $this->db->where('status', 1);
                $this->db->where('user_create', $user_id);
                $data['total_amount'] = $this->db->get('listfundrequest')->row_array();
            }

            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'distributor')) {
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user_id, 'status' => 1])->result_array();
                // print_r($data['listfundrequests']); die;

                $this->db->select_sum('amount');
                $this->db->where('status', 1);
                $this->db->where('user_create', $user_id);
                $data['total_amount'] = $this->db->get('listfundrequest')->row_array();
            }

            // echo "<pre>"; print_r($data['dl_nos']); die;

            if ($this->input->post() != NULL) {
                // $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

                // $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $mobile = $this->input->post('mobile');

                // $input = [
                //     'from_date' => $from_date,
                //     'to_date' => $to_date,
                //     'mobile' => $this->input->post('mobile')
                // ];

                // echo "<pre>";
                // print_r($input);
                // die;

                if (!empty($mobile) && empty($from_date) && empty($to_date)) {
                    if (isset($_SESSION['role'])) {
                        $cond = [
                            'mobile' => $mobile,
                            'status' => 1
                        ];
                        $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', $cond)->result_array();
                        // print_r($data['listfundrequests']);
                        // die;
                        $this->db->select_sum('amount');
                        $this->db->where('status', 1);
                        $this->db->where('mobile', $mobile);
                        $this->db->where('user_create', $user);
                        $data['total_amount'] = $this->db->get('listfundrequest')->row_array();
                    } elseif (isset($_SESSION['slug'])) {
                        $user_id = $_SESSION['user_id'];
                        $cond = [
                            'mobile' => $mobile,
                            'status' => 1,
                            'user_create' => $user_id
                        ];
                        $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', $cond)->result_array();

                        $this->db->select_sum('amount');
                        $this->db->where('status', 1);
                        $this->db->where('mobile', $mobile);
                        $this->db->where('user_create', $user_id);
                        $data['total_amount'] = $this->db->get('listfundrequest')->row_array();
                    }
                } else if (!empty($from_date && $to_date) && empty($mobile)) {
                    $input = [
                        'from_date' => date("d-m-Y", strtotime($from_date)),
                        'to_date' => date("d-m-Y", strtotime($to_date)),
                    ];

                    if (isset($_SESSION['role'])) {
                        $user = $_SESSION['role'];

                        $data['listfundrequests'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND status = 1 and user_create = '$user'")->result_array();

                        $data['total_amount'] = $this->db->query("SELECT SUM(amount) as amount FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND status = 1 and user_create = '$user'")->row_array();
                    }

                    if (isset($_SESSION['slug'])) {

                        $user_id = $_SESSION['user_id'];
                        $data['listfundrequests'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND status = 1 AND user_create = $user_id")->result_array();

                        $data['total_amount'] = $this->db->query("SELECT SUM(amount) as amount FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND status = 1 AND user_create = $user_id")->row_array();
                    }
                } else {
                    $input = [
                        'from_date' => date("d-m-Y", strtotime($from_date)),
                        'to_date' => date("d-m-Y", strtotime($to_date)),
                    ];
                    if (isset($_SESSION['role'])) {
                        $user = $_SESSION['role'];

                        $data['listfundrequests'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND status = 1 AND mobile = $mobile and user_create = '$user'")->result_array();

                        $data['total_amount'] = $this->db->query("SELECT SUM(amount) as amount FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND mobile = $mobile AND status = 1 and user_create = '$user'")->row_array();
                    }

                    if (isset($_SESSION['slug'])) {
                        $user_id = $_SESSION['user_id'];

                        $data['listfundrequests'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND status = 1 AND user_create = $user_id AND mobile = $mobile")->result_array();

                        $data['total_amount'] = $this->db->query("SELECT SUM(amount) as amount FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}' AND mobile = $mobile AND status = 1 AND user_create = $user_id")->row_array();
                    }
                }
            }

            $this->load->view('viewapprovefund', $data);
        } else {

            redirect('userlogin');
        }
    }
}
