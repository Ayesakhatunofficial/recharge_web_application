<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addupi extends CI_Controller
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
            $data = [];

            if (isset($_SESSION['role'])) {
                $user_type = $_SESSION['role'];
                $condition = [
                    'user_type' => $user_type
                ];
                $data['upi_data'] = $this->db->get_where('tbl_upi', $condition)->row_array();
            }

            if (isset($_SESSION['slug'])) {
                $mobile = $_SESSION['mobile'];
                $user_id = $_SESSION['user_id'];
                $user_type = $_SESSION['slug'];

                $condition = [
                    'user_type' => $user_type,
                    'mobile' => $mobile,
                    'user_id' => $user_id,
                ];
                $data['upi_data'] = $this->db->get_where('tbl_upi', $condition)->row_array();
            }

            // echo "<pre>";
            //         print_r($data['upi']);
            //         die;


            if ($this->input->post() != NULL) {
                $id = $this->input->post('id');

                // echo $id; die;
                $input = [
                    'upi' => $this->input->post('upi'),
                    'min_amount' => $this->input->post('min_amount'),
                    'user_type' => $user_type,
                ];
                if (isset($_SESSION['slug'])) {
                    $input['mobile'] = $mobile;
                    $input['user_id'] = $user_id;
                }

                if (!empty($input) && $id != '') {
                    $this->db->where('id', $id);
                    $update = $this->db->update('tbl_upi', $input);
                    if ($update) {
                        redirect('addupi');
                    } else {
                        die("insert query failed");
                    }
                }
                if (!empty($input) && $id == '') {
                    $insert = $this->db->insert('tbl_upi', $input);
                    if ($insert) {
                        redirect('addupi');
                    } else {
                        die("insert query failed");
                    }
                }
            }

            $this->load->view('addupi', $data);
        } else {
            
            redirect('userlogin');
        }
    }
}
