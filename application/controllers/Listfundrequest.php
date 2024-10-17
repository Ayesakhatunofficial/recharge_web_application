<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Listfundrequest extends CI_Controller
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
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user, 'status' => 0])->result_array();
                // print_r($data['listfundrequests']); die;
            }

            $user_id = $_SESSION['user_id'];
            // echo $user_id; die;

            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'admin')) {
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user_id, 'status' => 0])->result_array();
                // print_r($data['listfundrequests']); die;
            }

            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'super_distributor')) {
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user_id, 'status' => 0])->result_array();
                // print_r($data['listfundrequests']); die;
            }

            if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'distributor')) {
                $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['user_create' => $user_id, 'status' => 0])->result_array();
                // print_r($data['listfundrequests']); die;
            }

            // echo "<pre>"; print_r($data['dl_nos']); die;

            if ($this->input->post() != NULL) {
                $from_date = date("d-m-Y", strtotime($this->input->post('from_date')));

                $to_date = date("d-m-Y", strtotime($this->input->post('to_date')));

                $input = [
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'mobile' => $this->input->post('mobile')
                ];

                // echo "<pre>"; print_r($input); die;

                if (!empty($input['mobile'])) {
                    $data['listfundrequests'] = $this->db->order_by('id', 'desc')->get_where('listfundrequest', ['mobile' => $input['mobile']])->result_array();
                } else {
                    $data['listfundrequests'] = $this->db->order_by('id', 'desc')->query("SELECT * FROM listfundrequest WHERE create_date BETWEEN '{$input['from_date']}' AND '{$input['to_date']}'")->result_array();
                }
            }

            $this->load->view('listfundrequest', $data);
        } else {

            redirect('userlogin');
        }
    }
}
