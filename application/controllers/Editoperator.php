<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Editoperator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
    }

    public function index($id)
    {
        $data['operator'] = $this->db->get_where('tbl_operator', ['id' => $id])->row_array();

        //  echo "<pre>"; print_r($data['operator']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }

            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }

        $this->load->view('editoperator', $data);
    }

    public function dth_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_dth_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_dth_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }

        $this->load->view('editoperator', $data);
    }

    public function electric_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_services', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_services', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }

        $this->load->view('editoperator', $data);
    }

    public function postpaid_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_postpaid_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_postpaid_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function loan_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_loan_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_loan_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function fastag_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_fastag_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_fastag_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function lpg_gas_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_lpg_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_lpg_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function insurance_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_insurance_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_insurance_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function broadband_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_broadband_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_broadband_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function municiple_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_municiple_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_municiple_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function credit_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_creditcard_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_creditcard_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function landline_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_landline_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_landline_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function cable_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_cable_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_cable_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }

    public function subscription_edit($id)
    {
        $data['operator'] = $this->db->get_where('tbl_subscription_operator', ['id' => $id])->row_array();

        // echo "<pre>"; print_r($data['commission']); die;

        $input = [];

        if ($this->input->post() != NULL) {
            $ext = pathinfo($_FILES["op_logo"]['name'], PATHINFO_EXTENSION);
            // echo $ext; 
            $new_name = uniqid('op_logo-' . date('d-m-Y') . '-') . '.' . $ext;
            // echo $new_name; die;
            $config = [
                'upload_path' => FCPATH . 'operator_image',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'file_name' => $new_name
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('op_logo')) {
                $data['op_logo'] = $this->upload->data();
            } else {
                $data['upload_error'] = $this->upload->display_errors();
                //    print_r($data['upload_error']); die;
                $this->load->view('editoperator', $data);
            }

            if ($data['op_logo']['file_name'] != '') {
                unlink(FCPATH . 'operator_image/' . $data['operator']['op_logo']);
            }
            $input = [
                'opcode' => $this->input->post('op_code'),
                'operator' => $this->input->post('op_name'),
                'op_logo' => ($_FILES["op_logo"]['name'] == "") ? $data['operator']['op_logo'] : $data['op_logo']['file_name'],
            ];

            // echo "<pre>";
            // print_r($input);
            // die('Here input');

            if (!empty($input)) {
                $this->db->where(['id' => $id]);
                $this->db->update('tbl_subscription_operator', $input);

                $error = $this->db->error();

                // echo "<pre>"; print_r($error) ; die;

                if ($error['code'] != 0) {
                    die("Operator update query failed");
                } else {
                    redirect('viewoperator', 'refresh');
                }
            }
        }
        $this->load->view('editoperator', $data);
    }
}
