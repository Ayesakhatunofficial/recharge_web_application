<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
        $this->load->model('Dashboard_model');
    }

    public function index()
    {

        if ($_SESSION['role'] || $_SESSION['slug']) {

            // echo "<pre>"; print_r($_SESSION); die;
            // die("here");

            // if($_SESSION['role'] == 'super_admin'){
            //     $this->load->view('dashboard');
            // } else {
            //     redirect('Login', 'refresh');
            // }
            // echo BASEPATH; die;
            date_default_timezone_set('Asia/Kolkata');
            $today = date('Y-m-d');
            $onemonthago = date('Y-m-d', strtotime('-30 days'));
            // ECHO $onemonthago; 

            if (isset($_SESSION['slug'])) {
                $mob = $_SESSION['mobile'];
                // echo $mob; die;

                $data['today_com'] = $this->Dashboard_model->getTodayCommission($today, $mob);
                $data['user_today_profit'] = $this->Dashboard_model->getTodayUserProfit($mob);

                $data['onemonth_com'] = $this->Dashboard_model->getOnemonthCommission($today, $onemonthago, $mob);
                $data['user_month_profit'] = $this->Dashboard_model->getMonthUserProfit($mob);

                $data['total_com'] = $this->Dashboard_model->getTotalCommission($mob);
                $data['user_total_profit'] = $this->Dashboard_model->getTotalUserProfit($mob);


                $data['today_utility'] = $this->Dashboard_model->getTodayUtilityData($mob, $today);
                // $data['today_utility_profit'] = $this->Dashboard_model->todayUtilityProfit($mob);

                //   print_r($data['today_utility']);die;

                $data['onemonth_utility'] = $this->Dashboard_model->getOnemonthUtilityData($mob, $today, $onemonthago);
                $data['total_utility'] = $this->Dashboard_model->getTotalUtilityData($mob);
            }

            if (isset($_SESSION['role'])) {
                $data['today_com'] = $this->Dashboard_model->getTodayCom($today);
                $data['today_profit'] = $this->Dashboard_model->getTodayProfit();

                $data['onemonth_com'] = $this->Dashboard_model->getOnemonthCom($today, $onemonthago);
                $data['onemonth_profit'] = $this->Dashboard_model->geOnemonthProfit();

                $data['total_com'] = $this->Dashboard_model->getTotalCom();
                $data['total_profit'] = $this->Dashboard_model->getTotalProfit();

                $data['today_utility'] = $this->Dashboard_model->getTodayUtility($today);
                $data['onemonth_utility'] = $this->Dashboard_model->getOnemonthUtility($today, $onemonthago);
                $data['total_utility'] = $this->Dashboard_model->getTotalUtility();
            }


            //   print_r($data['total_com']);die;

            $this->load->view('dashboard', $data);
        } else {

            redirect('userlogin');
        }
    }
}
