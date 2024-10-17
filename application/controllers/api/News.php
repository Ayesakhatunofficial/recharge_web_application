<?php
class News extends CI_Controller
{
    protected $response = ["is_success" => false, "message" => null, "data" => null, "errors" => null];

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();

        validJWT();

        $this->load->helper(array('form', 'url',));

        $this->load->library('form_validation');
    }

    public function index()
    {

        $user = authuser();


        $created_by_id = $user['created_by_id'];
        $create_by = $user['created_by']; //d

        $user_1 = $this->db->get_where('users', ['id' => $created_by_id])->row(); //d
        $user_1_createdById = $user_1->created_by_id;
        $user_1_type = $user_1->create_by; //sd

        $user_2 = $this->db->get_where('users', ['id' => $user_1_createdById])->row(); //sd
        $user_2_createdById = $user_2->created_by_id;
        $user_2_type = $user_2->create_by; //a

        if ($create_by == 'admin') {

            $news = $this->db->order_by('id', 'desc')->get_where('tb_news', ['created_by' => $created_by_id])->row_array();
        } elseif ($user_1_type == 'admin') {

            $news = $this->db->order_by('id', 'desc')->get_where('tb_news', ['created_by' => $user_1_createdById])->row_array();
        } elseif ($user_2_type == 'admin') {

            $news  = $this->db->order_by('id', 'desc')->get_where('tb_news', ['created_by' => $user_2_createdById])->result_array();
        } else {
            $news = $this->db->order_by('id', 'desc')->get_where('tb_news', ['created_by' => 'super_admin'])->row_array();
        }

        // $notifications  = $this->db->get('notifications')->result_array();

        if (!is_null($news)) {

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => $news
            ];

            echo json_encode($response);
        }
    }
}
