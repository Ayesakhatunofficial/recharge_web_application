<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use paytm\paytmchecksum\PaytmChecksum;

class Paytm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        // $data = [];

        date_default_timezone_set('Asia/Kolkata');

        if (isset($_SESSION['user_type'])) {

            $paytmParams = array();

            if($this->uri->segment(5) != NULL)
            {
                $abc = $this->uri->segment(5);

                $xyz = explode('-', $abc);

                $_SESSION['page'] = $xyz[0];
                $_SESSION['action'] = $xyz[1];

            }

            if ($this->uri->segment(3) != NULL) {
                $aid = $this->uri->segment(3);

                $_SESSION['AID'] = $aid;

                $order_id = uniqid($aid . '_');

                $_SESSION['order_id'] = $order_id;
            }

            $URI = [];

            $mode = "Staging";   #-------------------- Staging ----------------------#

            // $mode = "Production";   #------------------- Production ----------------------#

            if ($mode == 'Staging') {

                /* for Staging */

                $api = $this->db->get_where('api_settings', ['live_test' => 'TESTING'])->row_array();

            } else if ($mode == 'Production') {

                /* for Production */

                $api = $this->db->get_where('api_settings', ['live_test' => 'LIVE'])->row_array();

                // echo "<pre>"; print_r($api); die;
            }

            $mid = $api['secret_key'];
            $mkey = $api['authentication_key'];

            $_SESSION['mid'] = $api['secret_key'];
            $_SESSION['mkey'] = $api['authentication_key'];

            // $amount = $URI['fees'];

            // echo $data['amount']; die;

            if ($this->uri->segment(4) != NULL) {
                $AMOUNT = $this->uri->segment(4);

                $URI['fees'] = $AMOUNT;
            }
            // echo $URI['fees']; die;

            // $URI['fees'] = '1.00';

            $paytmParams["body"] = array(
                "requestType"   => "Payment",
                "mid"           => $api['secret_key'],
                "websiteName"   => "Demo",
                "orderId"       => $_SESSION['order_id'],
                "callbackUrl"   => base_url('verify'),
                "txnAmount"     => array(
                    "value"     => $URI['fees'],
                    "currency"  => "INR",
                ),
                "userInfo"      => array(
                    "custId"    => $_SESSION['user_type'],
                ),
            );

            // $data['mid'] = $mid;

            // $data['mkey'] = $mkey;

            // echo "<pre>"; print_r($paytmParams["body"]); die;

            // echo "<pre>"; print_r($api); die;

            /*
            * Generate checksum by parameters we have in body
            * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
            */
            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $api['authentication_key']);

            $paytmParams["head"] = array(
                "signature"    => $checksum
            );

            $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

            $url = "";

            if ($mode == 'Staging') {
                /* for Staging */
                $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid={$api['secret_key']}&orderId={$_SESSION['order_id']}";
            } else if ($mode == 'Production') {
                /* for Production */
                $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid={$api['secret_key']}&orderId={$_SESSION['order_id']}";
            }

            // echo $url; die;

            //  echo "<pre>"; print_r($paytmParams["body"]); die;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $response = curl_exec($ch);
            // var_dump($order_id);
            // echo '<pre>';
            // print_r($response); die;

            $dat = json_decode($response, true);

            // echo "<pre>"; print_r($dat);  
            // echo $dat['body']['txnToken']; die;

            if ($dat['body']['resultInfo']['resultMsg'] == 'Success') {
                $_SESSION['token'] = $dat['body']['txnToken'];

                // redirect('paytm');
            } else {
                die("Here");
            }

            // header('location: paytm.php');

            // print_r($dat);
            // echo $_SESSION['token'];
            // die;

            // echo "<pre>";

            // print_r($_GET);

            // print_r($paytmParams["body"]);

            // print_r($response);

            // echo $_SESSION['token'];

            // die;


            // die;
            $this->load->view('paytm', [
                'amount' => $URI['fees'],
                'mid' => $mid,
                'mkey' => $mkey,
                'mode' => $mode
            ]);
        }
    }
}
