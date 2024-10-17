<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewusers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($_SESSION['role'] || $_SESSION['slug']) {
            
            $data = [];
            if ($this->uri->segment(3) != NULL) {
                $id = $this->uri->segment(3);

                $data['actions'] = $this->db->get_where('menu_action', ['menu_id' => $id])->result_array();
            }


            ///////////////////////////// SUPER ADMIN ////////////////////////////////////


            $data['super_distributers'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 1, 'is_deleted' => 0])->result_array();

            $data['sd_total'] = $this->db->query("SELECT COUNT(id) as total_sd FROM users WHERE account_type = 1 AND is_deleted = 0")->row_array();

            $data['distributers'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 2, 'is_deleted' => 0])->result_array();

            $data['d_total'] = $this->db->query("SELECT COUNT(id) as total_d FROM users WHERE account_type = 2 AND is_deleted = 0")->row_array();


            $data['reatilers'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 3, 'is_deleted' => 0])->result_array();

            $data['r_total'] = $this->db->query("SELECT COUNT(id) as total_r FROM users WHERE account_type = 3 AND is_deleted = 0")->row_array();
            // echo '<pre>';
            // print_r($data['reatilers']);
            // die;

            $data['admins'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 6, 'is_deleted' => 0])->result_array();

            $data['a_total'] = $this->db->query("SELECT COUNT(id) as total_a FROM users WHERE account_type = 6 AND is_deleted = 0")->row_array();
            // print_r($data['a_total']); die;



            if (isset($_SESSION['slug'])) {
                $user_id = $_SESSION['user_id'];

                /////////////////////////////   ADMIN   /////////////////////////////////////

                if ($_SESSION['slug'] == 'admin') {

                    $data['super_distributers_a'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 1, 'is_deleted' => 0, 'create_by' => 'admin', 'created_by_id' => $_SESSION['user_id']])->result_array();



                    $data['sd_total_a'] = $this->db->query("SELECT COUNT(id) as total_sd_a FROM users WHERE account_type = 1 AND is_deleted = 0 AND create_by = 'admin' AND created_by_id = $user_id")->row_array();



                    $data['distributers_a'] = $this->User_model->getSubordinateDistributors($user_id);

                    $count = 0;

                    foreach ($data['distributers_a'] as $dis) {
                        $count++;
                    }

                    $data['d_total_a'] = [
                        'total_d_a' => $count
                    ];

                    $data['reatilers_a'] = $this->User_model->getSubordinateRetailers($user_id);

                    $count_r = 0;

                    foreach ($data['reatilers_a'] as $reatiler) {
                        $count_r++;
                    }

                    $data['r_total_a'] = [
                        'total_r_a' => $count_r
                    ];
                }



                /////////////////////////////// SUPER DISTRIBUTOR  ////////////////////////////

                $data['distributer_sd'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 2, 'is_deleted' => 0, 'create_by' => 'super_distributor', 'created_by_id' => $_SESSION['user_id']])->result_array();

                $data['d_total_sd'] = $this->db->query("SELECT COUNT(id) as total_d_sd FROM users WHERE account_type = 2 AND is_deleted = 0 AND create_by = 'super_distributor' AND created_by_id = $user_id")->row_array();

                $data['reatiler_sd'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 3, 'is_deleted' => 0, 'create_by' => 'super_distributor', 'created_by_id' => $_SESSION['user_id']])->result_array();

                $data['r_total_sd'] = $this->db->query("SELECT COUNT(id) as total_r_sd FROM users WHERE account_type = 3 AND is_deleted = 0 AND create_by = 'super_distributor' AND created_by_id = $user_id")->row_array();



                /////////////////////////////////       DISTRIBUTOR       ////////////////////////////////

                $data['reatiler_d'] = $this->db->order_by('wallet', 'desc')->get_where('users', ['account_type' => 3, 'is_deleted' => 0, 'create_by' => 'distributor', 'created_by_id' => $_SESSION['user_id']])->result_array();

                $data['r_total_d'] = $this->db->query("SELECT COUNT(id) as total_r_d FROM users WHERE account_type = 3 AND is_deleted = 0 AND create_by = 'distributor' AND created_by_id = $user_id")->row_array();
            }

            // $data['name'] = 'ayesa';
            $this->load->view('viewusers', $data);
        } else {
            redirect('userlogin');
        }
    }
}
