<?php

defined('BASEPATH') or exit('No direct script access allowed');

// session_start();

class Userlogin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');

        $this->load->library('session');
    }

    public function index()
    {
        $data = [];

        if ($this->input->post() != NULL) {
            $data = [
                'mobile' => $this->input->post('mobile'),
                'password' => md5($this->input->post('password'))
            ];
        }

        // echo "<pre>"; print_r($data); die;

        if ($data != NULL) {

            $sql = $this->db->get_where('users', ['mobile' => $data['mobile'], 'password' => $data['password'], 'status' => 1, 'is_deleted' => 0])->row_array();

            if (!empty($sql)) {
                // print_r($sql);die;
                $query = $this->db->get_where('user_type', ['id' => $sql['account_type']]);

                $result = $query->row_array();
                // print_r($result);die;

                $error = $this->db->error();

                if ($error['code'] == 0) {
                    $_SESSION['user_id'] = $sql['id'];
                    $_SESSION['first_name'] = $sql['name'];
                    $_SESSION['mobile'] = $sql['mobile'];
                    $_SESSION['email'] = $sql['email'];
                    $_SESSION['user_type'] = $result['user_type'];
                    $_SESSION['slug'] = $result['slug'];
                    $_SESSION['created_by_id'] = $sql['created_by_id'];
                    $_SESSION['created_by'] = $sql['create_by'];
                    $_SESSION['wallet'] = $sql['wallet'];
                    $_SESSION['user_code'] = $sql['user_id'];

                    $act = $this->db->get_where('menu_permission', ['user_type' => $_SESSION['slug']])->row_array();

                    // echo "<pre>"; print_r($act); die("userlogin");

                    $pm = json_decode($act['parent_menu'], true);

                    $ac = json_decode($act['menu_action'], true);

                    //  echo "<pre>"; print_r($pm); print_r($ac);
                    //   die;

                    $menu_action = implode(',', $ac);

                    $parent_menu = implode(',', $pm);

                    $parent_m = $this->db->query("SELECT * FROM menu WHERE id IN($parent_menu)")->result_array();

                    $action_m = $this->db->query("SELECT * FROM menu_action WHERE id IN($menu_action)")->result_array();

                    //  echo "<pre>"; print_r($action_m); 
                    //  die;

                    $parent = array_column($parent_m, 'menu_name');

                    $action = array_column($action_m, 'action_name');

                    // echo "<pre>";
                    // print_r($action);
                    // print_r($parent);
                    // die;

                    $_SESSION['parent'] = $parent_menu;

                    $_SESSION['action'] = $menu_action;

                    // echo "<pre>";
                    // print_r($_SESSION);
                    // die;

                    $this->load->helper('url');

                    if (isset($_SESSION['user_type'])) {
                        redirect('dashboard', 'refresh');
                    } else {

                        redirect('userlogin', 'refresh');
                    }
                }
            } else {
                redirect('userlogin');
            }
        }

        $this->load->view('userlogin');
    }
}
