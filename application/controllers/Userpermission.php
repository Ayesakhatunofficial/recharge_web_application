<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Userpermission extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index()
    {
        $input = [];

        $data = [];

        if ($this->input->post() != NULL) {
            // echo "<pre>"; print_r($_POST); die;

            $input = [
                'user_type' => $this->input->post('user_type'),
                'parent_menu' => json_encode($this->input->post('menu')),
                'menu_action' => json_encode($this->input->post('action'))
            ];

            // echo "<pre>"; print_r($input); die('input');

            $data['prm'] = $this->db->get_where('menu_permission', ['user_type' => $input['user_type']])->row_array();

            if (!empty($input)) {
                if (empty($data['prm'])) {

                    $insert = $this->db->insert('menu_permission', $input);

                    $error = $this->db->error();

                    if ($error['code'] == 0) {
                        redirect('userpermission', 'refresh');
                    }
                } else {

                    $this->db->where(['user_type' => $this->input->post('user_type')]);
                    $this->db->update('menu_permission', $input);

                    $affectedRow = $this->db->affected_rows();

                    if($affectedRow){
                        redirect('userpermission', 'refresh');
                    }
                }
            }
        }

        $data['user_types'] = $this->db->get('user_type')->result_array();

        $data['menus'] = $this->db->query("SELECT * FROM `menu`")->result_array();

        $this->load->view('userpermission', $data);
    }

    public function userType()
    {
        $prm = $this->db->get_where('menu_permission', ['user_type' => $_POST['ut']])->row_array();

        $pm = json_decode($prm['parent_menu'], true);

        $menu = implode(',', $pm);

        $ma = json_decode($prm['menu_action'], true);

        $action = implode(',', $ma);

        echo json_encode([
            'resp' => 'success',
            'userType' => $prm['user_type'],
            'menu' => $pm,
            'action' => $ma
        ]);
    }
}
