<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Supportticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        $data = [];
        if (isset($_SESSION['slug'])) {
            $user_data = [
                'user_type' => $_SESSION['user_type'],
                'user_mobile' => $_SESSION['mobile'],
                'user_name' => $_SESSION['first_name']
            ];
            $data['user_data'] = $user_data;

            $data['services'] = $this->db->get('services')->result_array();

            if ($this->input->post()) {

                $input = $this->input->post();

                // print_r($_FILES['problem_photo']);
                // die;

                $digits = 4;
                $support_id =  str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

                if (isset($_FILES['problem_photo'])) {
                    $ext = pathinfo($_FILES["problem_photo"]['name'], PATHINFO_EXTENSION);
                    $new_name = uniqid('support-' . date('d-m-Y') . '-') . '.' . $ext;
                    // echo $new_name;
                    // die;

                    $config = [
                        'upload_path' => './uploads',
                        'allowed_types' => 'jpeg|jpg|png',
                        'file_name' => $new_name
                    ];

                    $this->upload->initialize($config);

                    $this->load->library('upload', $config);

                    if (!($this->upload->do_upload('problem_photo'))) {

                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $data['problem_photo'] = $this->upload->data();
                    }
                }

                $input_data = [
                    'support_id' => $support_id,
                    'date' => date('Y-m-d'),
                    'user_name' => $input['user_name'],
                    'user_mobile' => $input['mobile'],
                    'user_type' => $input['user_type'],
                    'image' => $data['problem_photo']['file_name'],
                    'problem_type' => $input['problem_type'],
                    'query' => $input['query'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $_SESSION['user_id']
                ];
                // print_r($input_data);
                // die;

                $result =  $this->db->insert('support_tickets', $input_data);

                if ($result) {
                    redirect('Supportticket/viewsupport', 'refresh');
                } else {
                    die("insert query failed");
                }
            }
        }


        $this->load->view('supportticket', $data);
        // print_r($data); die;
    }

    public function viewsupport()
    {
        $id = $_SESSION['user_id'];
        $data['supports'] = $this->db->query("SELECT services.id, services.service_name, support_tickets.* FROM support_tickets JOIN services ON services.id = support_tickets.problem_type WHERE support_tickets.created_by = $id ORDER BY support_tickets.id DESC")->result_array();


        if ($this->input->post() != NULL) {

            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');

            $data['supports'] = $this->db->query("SELECT services.id, services.service_name, support_tickets.* 
                                     FROM support_tickets 
                                     JOIN services ON services.id = support_tickets.problem_type 
                                     WHERE support_tickets.created_by = $id 
                                     AND support_tickets.date BETWEEN '$from_date' AND '$to_date' 
                                     ORDER BY support_tickets.id DESC")->result_array();
        }

        $this->load->view('viewsupport', $data);
    }

    public function requestsupport()
    {
        $data['supports'] = $this->db->query("SELECT services.id, services.service_name, support_tickets.* FROM support_tickets JOIN services ON services.id = support_tickets.problem_type WHERE support_tickets.status = 'pending' ORDER BY support_tickets.id DESC")->result_array();

        if ($this->input->post() != NULL) {

            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');

            $data['supports'] = $this->db->query("SELECT services.id, services.service_name, support_tickets.* 
            FROM support_tickets 
            JOIN services ON services.id = support_tickets.problem_type 
            WHERE support_tickets.status = 'pending' 
            AND support_tickets.date BETWEEN '$from_date' AND '$to_date' 
            ORDER BY support_tickets.id DESC")->result_array();
        }
        $this->load->view('requestsupport', $data);
    }

    public function approvedsupport()
    {
        $data['supports'] = $this->db->query("SELECT services.id, services.service_name, support_tickets.* FROM support_tickets JOIN services ON services.id = support_tickets.problem_type WHERE support_tickets.status = 'success' ORDER BY support_tickets.id DESC")->result_array();

        if ($this->input->post() != NULL) {

            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');

            $data['supports'] = $this->db->query("SELECT services.id, services.service_name, support_tickets.* 
            FROM support_tickets 
            JOIN services ON services.id = support_tickets.problem_type 
            WHERE support_tickets.status = 'success' 
            AND support_tickets.date BETWEEN '$from_date' AND '$to_date' 
            ORDER BY support_tickets.id DESC")->result_array();
        }
        $this->load->view('approvedsupport', $data);
    }

    public function approved($id)
    {
        $data = [
            'remarks' => $this->input->post('remarks'),
            'status' => 'success',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $_SESSION['user_id']
        ];

        $this->db->where('id', $id);
        $result = $this->db->update('support_tickets', $data);
        if ($result) {
            redirect('supportticket/approvedsupport');
        }
    }

    public function reject($id)
    {
        $data = [
            'remarks' => $this->input->post('remarks'),
            'status' => 'rejected',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $_SESSION['user_id']
        ];

        $this->db->where('id', $id);
        $result = $this->db->update('support_tickets', $data);
        if ($result) {
            redirect('supportticket/requestsupport');
        }
    }


    public function editsupport($id)
    {
        $data['services'] = $this->db->get('services')->result_array();
        $data['support'] = $this->db->get_where('support_tickets', ['id' => $id])->row_array();

        if ($this->input->post()) {
            $input = $this->input->post();

            if (isset($_FILES['problem_photo'])) {
                $ext = pathinfo($_FILES["problem_photo"]['name'], PATHINFO_EXTENSION);
                $new_name = uniqid('support-' . date('d-m-Y') . '-') . '.' . $ext;
                // echo $new_name;
                // die;

                $config = [
                    'upload_path' => './uploads',
                    'allowed_types' => 'jpeg|jpg|png',
                    'file_name' => $new_name
                ];

                $this->upload->initialize($config);

                $this->load->library('upload', $config);

                if (!($this->upload->do_upload('problem_photo'))) {

                    $data['upload_error'] = $this->upload->display_errors();
                } else {
                    $data['problem_photo'] = $this->upload->data();
                }

                if ($data['problem_photo']['file_name'] != '') {
                    // print_r($data['banner_data']['banner']); die;
                    unlink(FCPATH . 'uploads/' . $data['support']['image']);
                }
            }

            $input_data = [
                'image' => ($_FILES["problem_photo"]['name'] == "") ? $data['support']['image'] : $data['problem_photo']['file_name'],
                'problem_type' => $input['problem_type'],
                'query' => $input['query'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['user_id']
            ];

            $this->db->where('id', $id);
            $result = $this->db->update('support_tickets', $input_data);

            if ($result) {
                redirect('supportticket/viewsupport');
            } else {
                echo 'Update query failed';
            }
        }
        $this->load->view('editsupport', $data);
    }
}
