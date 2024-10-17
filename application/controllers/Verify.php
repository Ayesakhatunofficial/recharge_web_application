<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use paytm\paytmchecksum\PaytmChecksum;

class Verify extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
    }

    public function index()
    {
        // die("1324324");

        $data = [];

        date_default_timezone_set('Asia/Kolkata');

        if (isset($_SESSION['user_type'])) {

            /**
             * import checksum generation utility
             * You can get this utility from https://developer.paytm.com/docs/checksum/
             */

            /* initialize an array */
            $paytmParams = array();

            /* body parameters */
            $paytmParams["body"] = array(

                /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
                "mid" => $_SESSION['mid'],

                /* Enter your order id which needs to be check status for */
                "orderId" => $_SESSION['order_id'],
            );

            /**
             * Generate checksum by parameters we have in body
             * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
             */
            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $_SESSION['mkey']);

            /* head parameters */
            $paytmParams["head"] = array(

                /* put generated checksum value here */
                "signature"    => $checksum
            );

            /* prepare JSON string for request */
            $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

            /* for Staging */
            $url = "https://securegw-stage.paytm.in/v3/order/status";

            /* for Production */
            // $url = "https://securegw.paytm.in/v3/order/status";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);

            // echo '<pre>';
            // print_r($response);

            // echo "<pre>"; print_r($data['response']); die;

            $input = [];

            $status = [];

            if (!empty($response)) {
                $data['response'] = json_decode($response, true);

                // echo "<pre>"; print_r($data['response']); die;

                if ($data['response']['body']['resultInfo']['resultStatus'] == 'SUCCESS') {
                    $status['STATUS'] = 1;
                } else if ($data['response']['body']['resultInfo']['resultStatus'] == 'PENDING') {
                    $status['STATUS'] = 0;
                } else if ($data['response']['body']['resultInfo']['resultStatus'] == 'REJECT') {
                    $status['STATUS'] = -1;
                }

                $input = [
                    'txnid' => $data['response']['body']['txnId'],
                    'order_id' => $_SESSION['order_id'],
                    'Fees' => $data['response']['body']['txnAmount'],
                    'txnDate' => $data['response']['body']['txnDate'],
                    'Status' => 1,
                    // 'Status' => $status['STATUS'],
                    'Remarks' => $data['response']['body']['resultInfo']['resultMsg']
                ];

                if (!empty($input)) {
                    $insert = $this->db->insert('online_payment_history', $input);

                    $affectedRows = $this->db->affected_rows();

                    if ($affectedRows) {
                        if ($_SESSION['page'] == 'voter') {
                            redirect(base_url('Voterpay/index'));
                        } else if ($_SESSION['page'] == 'aadhar') {
                            redirect(base_url('Adharpay/index'));
                        } else if ($_SESSION['page'] == 'pan') {
                            redirect(base_url('Panpay/index'));
                        } else if ($_SESSION['page'] == 'panfinder') {
                            redirect(base_url('Panfinderpay/index'));
                        } else if ($_SESSION['page'] == 'ration') {
                            redirect(base_url('Rationpay/index'));
                        } else if ($_SESSION['page'] == 'DL') {
                            redirect(base_url('DLpay/index'));
                        }
                    }                    
                }
            }
        }

        $this->load->view('verify', $data);
    }
}
