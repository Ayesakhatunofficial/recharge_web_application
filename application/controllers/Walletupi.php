<?php
defined('BASEPATH') or exit('No direct script accessed allowed');

class Walletupi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Walletupi_model');
    }

    public function index()
    {
        if ($this->input->post()) {
            // echo '<pre>';
            // print_r($this->input->post());
            // // die;

            $token = $this->input->post('token');
            $orderId = $this->input->post('orderId');
            $txnAmount = $this->input->post('txnAmount');
            $txnNote = $this->input->post('txnNote');
            $cust_Mobile = $this->input->post('cust_Mobile');
            $cust_Email = $this->input->post('cust_Email');
            $callback_url = $this->input->post('callback_url');
            $checksum = $this->input->post('checksum');
            $upiuid = $this->input->post('upiuid');

            if (isset($token) && !empty($token) && !empty($orderId) && !empty($txnNote) && !empty($txnAmount) && !empty($cust_Mobile) && !empty($cust_Email) && !empty($checksum) && !empty($upiuid) && $txnAmount >= 100) {
                // echo 'ayesa' ; die;
                $result = $this->Walletupi_model->getPartnerData($token);

                if ($result->token == $token) {
                    $paramList = array();
                    $paramList["upiuid"] = $upiuid;
                    $paramList["token"] = $token;
                    $paramList["orderId"] = $orderId;
                    $paramList["txnAmount"] = $txnAmount;
                    $paramList["txnNote"] = $txnNote;
                    $paramList["cust_Mobile"] = $cust_Mobile;
                    $paramList["cust_Email"] = $cust_Email;
                    $paramList["callback_url"] = $callback_url;

                    $verifySignature = $this->verifySignature($paramList, $result->secret, $checksum);

                    if ($verifySignature == 1) {
                        $paytmBusinessData = json_decode($result->paytm_buisness, true);
                        $upi_id = $paytmBusinessData['upi_id'];
                        $upi_name = $paytmBusinessData['upi_name'];

                        if (isset($upi_id) && !empty($upi_id) && isset($upi_name) && !empty($upi_name) && $upiuid == $upi_id) {
                            session_start();
                            session_regenerate_id();

                            $txn_ref_id = $this->GenRandomString() . time();

                            $_SESSION['muid'] = $result->id;
                            $_SESSION['auth_token'] = $result->token;
                            $_SESSION['txn_ref_id'] = $txn_ref_id;
                            $_SESSION['upi_id'] = $upi_id;
                            $_SESSION['client_orderid'] = $orderId;
                            $_SESSION['txnAmount'] = $txnAmount;
                            $_SESSION["txnNote"] = $txnNote;
                            $_SESSION['cust_Mobile'] = $cust_Mobile;
                            $_SESSION['cust_Email'] = $cust_Email;

                            $qrdata =  "<script>
                                    setTimeout(function(){ 
                                    document.getElementById(\"qrcode\").innerHTML = '';
                                    GenerateQR('" . $upi_id . "', '" . $upi_name . "', '" . $txnAmount . "', '" . $txn_ref_id . "', '" . $txnNote . "'); 
                                    var upilink = document.getElementById(\"qrcode\").title;
                               
                                    document.getElementById(\"upilink\").href = upilink;
                                    }, 1500);
                                    </script>";

                            // $html = '<form id="formSubmit" action="' . $callback_url . '" method="post" style="display:none;">
                            //         <input type="hidden" id="status" name="status">
                            //         <input type="hidden" id="message" name="message">
                            //         <input type="hidden" name="cust_Mobile" value="' . $cust_Mobile . '">
                            //         <input type="hidden" name="cust_Email" value="' . $cust_Email . '">
                            //         <input type="hidden" id="hash" name="hash">
                            //         <input type="hidden" id="checksum" name="checksum">
                            //         </form>
                            //         <script>
                            //         function TxnStatus(){
                            //         $.ajax({ 
                            //             url: "' . base_url('walletupi/paytmTxnStatus') . '",
                            //             type: "POST", 
                            //             success: function(result) {
                            //             var obj = JSON.parse(result);

                            //             if(obj.status=="SUCCESS"){

                            //             document.getElementById("qrcode").innerHTML = "<img src=\'' . base_url() . 'assets/img/success.gif\' width=\'150\'>";	
                            //             document.getElementById("status").value = obj.status;
                            //             document.getElementById("message").value = obj.message;
                            //             document.getElementById("hash").value = obj.hash;
                            //             document.getElementById("checksum").value = obj.checksum;

                            //             setTimeout(function(){ 
                            //             document.getElementById("formSubmit").submit();
                            //             }, 2000);

                            //             }  


                            //             }
                            //     });
                            //  } 
                            //  setInterval(function(){ 
                            //     TxnStatus();
                            //     }, 10000);
                            //  </script>';

                            // echo $html;
                        } else {
                            $html = '<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
                            <form id="formSubmit" action="' . $callback_url . '" method="post" style="display:none;">
                            <input type="hidden" name="status" value="FAILED" >
                            <input type="hidden" name="message" value="upi id is invalid or not updated" >
                            <input type="hidden" name="cust_Mobile" value="' . $cust_Mobile . '">
                            <input type="hidden" name="cust_Email" value="' . $cust_Email . '">
                            <input type="hidden" name="hash" value="false">
                            <input type="hidden" name="checksum" value="false">
                            </form>
                            <script type="text/javascript">
                            setTimeout(function(){ 
                            document.getElementById("formSubmit").submit();
                            }, 1500);
                            </script>
                            ';

                            echo $html;
                            exit();
                        }
                    } else {
                        $html = '<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
                        <form id="formSubmit" action="' . $callback_url . '" method="post" style="display:none;">
                        <input type="hidden" name="status" value="FAILED" >
                        <input type="hidden" name="message" value="Checksum Mismatch" >
                        <input type="hidden" name="cust_Mobile" value="' . $cust_Mobile . '">
                        <input type="hidden" name="cust_Email" value="' . $cust_Email . '">
                        <input type="hidden" name="hash" value="false">
                        <input type="hidden" name="checksum" value="false">
                        </form>
                        <script type="text/javascript">
                        setTimeout(function(){ 
                        document.getElementById("formSubmit").submit();
                        }, 1000);
                        </script>
                        ';

                        echo $html;
                        exit();
                    }
                } else {
                    $html = '<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
                    <form id="formSubmit" action="' . $callback_url . '" method="post" style="display:none;">
                    <input type="hidden" name="status" value="FAILED" >
                    <input type="hidden" name="message" value="Unauthorized Access or Token Is Invalid" >
                    <input type="hidden" name="cust_Mobile" value="' . $cust_Mobile . '">
                    <input type="hidden" name="cust_Email" value="' . $cust_Email . '">
                    <input type="hidden" name="hash" value="false">
                    <input type="hidden" name="checksum" value="false">
                    </form>
                    <script type="text/javascript">
                    setTimeout(function(){ 
                    document.getElementById("formSubmit").submit();
                    }, 1000);
                    </script>
                    ';

                    echo $html;
                    exit();
                }
            }



            // print_r($paytmBusinessData);
            // die;
        }
        $this->load->view('qrcode', ['qrdata' => $qrdata, 'paramList' => $paramList, 'result' => $result]);
    }

    public function  Recharge()
    {
        // print_r($this->input->post()); die;
        $token = '3c8948-c2a1a9-d17fd9-ab656e-679495'; // Your Token, (Url:http://example.com/Settings).
        $secret = 'UHKNaEfKhS'; // Your Secret Key, (Url:http://example.com/Settings).
        $RECHPAY_ENVIRONMENT = 'PROD'; // PROD, TEST
        $checkSum = "";
        $upiuid = "paytmqr2810050501011c7hdlw291fz@paytm";
        $paramList = array();
        $orderId = "DTPL" . time();
        $txnAmount = $this->input->post('txnAmount');
        $txnNote = $this->input->post('txnNote');
        $cust_Mobile = $this->input->post('cust_Mobile');
        $cust_Email = $this->input->post('cust_Email');
        $gateway_type = $this->input->post('gateway_type');
        $callback_url = base_url('walletupi/Callback');

        $paramList["upiuid"] = $upiuid;
        $paramList["token"] = $token;
        $paramList["orderId"] = $orderId;
        $paramList["txnAmount"] = $txnAmount;
        $paramList["txnNote"] = $txnNote;
        $paramList["cust_Mobile"] = $cust_Mobile;
        $paramList["cust_Email"] = $cust_Email;
        $paramList["callback_url"] = $callback_url;

        if ($txnAmount >= 100) {
            $checkSum = $this->generateSignature($paramList, $secret);

            $this->load->view('walletupi', ['paramList' => $paramList, 'checkSum' => $checkSum]);
        } else {
            $this->session->set_flashdata('error', 'Amount Should Be Grater Than or equal 100');
            redirect('dashboard');
        }
    }

    public function paytmTxnStatus()
    {
        session_start();
        session_regenerate_id();

        // echo $wallet_balance;
        // die;

        if ($this->input->method() == 'post') {
            $arr = array("status" => 'PENDING', "message" => 'Payment Processing');
            if (
                isset($_SESSION['txn_ref_id']) &&
                !empty($_SESSION['upi_id']) &&
                !empty($_SESSION['client_orderid']) &&
                !empty($_SESSION['cust_Mobile']) &&
                !empty($_SESSION['cust_Email']) &&
                !empty($_SESSION['muid']) &&
                !empty($_SESSION['auth_token'])
            ) {

                $txn_ref_id = $_SESSION['txn_ref_id'];
                $upi_id = $_SESSION['upi_id'];
                $client_orderid = $_SESSION['client_orderid'];
                $cust_Mobile = $_SESSION['cust_Mobile'];
                $cust_Email = $_SESSION['cust_Email'];
                $txnNote = $_SESSION['txnNote'];
                $muid = $_SESSION['muid'];
                $auth_token = $_SESSION['auth_token'];

                $userdata = $this->Walletupi_model->getUserdata($auth_token, $muid);

                $res = $this->Walletupi_model->getIfsc($txn_ref_id);

                if ($userdata->id > 0 && ($res == '' || $res == NULL)) {

                    $query = $this->Walletupi_model->getQuery($client_orderid);

                    if ($query == '' || $query == NULL) {
                        $paytmBusinessData = json_decode($userdata->paytm_buisness, true);

                        $JsonData = json_encode(array("MID" => $paytmBusinessData['mid'], "ORDERID" => $txn_ref_id));



                        $url = "https://securegw.paytm.in/order/status?JsonData=$JsonData";

                        $ch = curl_init($url);

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);

                        curl_close($ch);

                        $res = json_decode($response, true);

                        if ($res['STATUS'] == "TXN_SUCCESS" && $res['MID'] == $paytmBusinessData['mid'] && $res['ORDERID'] == $txn_ref_id) {
                            $credited_at = date("Y-m-d H:i:s");
                            $bene_account_no = $paytmBusinessData['upi_id'];
                            $bene_account_ifsc = $txn_ref_id;
                            $rmtr_full_name = $cust_Email;
                            $rmtr_account_no = $cust_Mobile . " - " . $client_orderid;
                            $rmtr_account_ifsc = $res['RESPMSG'];
                            $rmtr_to_bene_note = $txnNote;
                            $txn_id = time();
                            $amount = $res['TXNAMOUNT'];
                            $charges_gst = 0;
                            $settled_amount = $res['TXNAMOUNT'];;
                            $txn_time = $res['TXNDATE'];
                            $created_at = $res['TXNDATE'];
                            $payment_type = $res['PAYMENTMODE'];
                            $bank_ref_num = $res['BANKTXNID'];

                            $data = [
                                'credited_at' => $credited_at,
                                'cust_mobile' => $cust_Mobile,
                                'bene_account_no' => $bene_account_no,
                                'bene_account_ifsc' => $bene_account_ifsc,
                                'rmtr_full_name' => $rmtr_full_name,
                                'rmtr_account_no' => $rmtr_account_no,
                                'rmtr_account_ifsc' => $rmtr_account_ifsc,
                                'rmtr_to_bene_note' => $rmtr_to_bene_note,
                                'txn_id' => $txn_id,
                                'amount' => $amount,
                                'charges_gst' => $charges_gst,
                                'settled_amount' => $settled_amount,
                                'txn_time'  => $txn_time,
                                'created_at' => $created_at,
                                'payment_type' => $payment_type,
                                'bank_ref_num' => $bank_ref_num,
                                'client_orderid' =>  $client_orderid,
                                'results' => $response,
                                'user_id' => $userdata->id,
                                'user_type' => $_SESSION['user_type'],
                                'user_name' => $_SESSION['first_name'],
                            ];
                            $insert = $this->db->insert('tb_virtualtxn', $data);

                            if ($insert) {
                                $json_string = json_encode(array(
                                    "txnStatus" => 'TXN_SUCCESS',
                                    "resultInfo" => $res['RESPMSG'],
                                    "orderId" => $client_orderid,
                                    "txnAmount" => $amount,
                                    "txnId" => $txn_id,
                                    "bankTxnId" => $res['TXNID'],
                                    "paymentMode" => $payment_type,
                                    "txnDate" => $credited_at,
                                    "utr" => $bank_ref_num,
                                    "sender_vpa" => $cust_Mobile,
                                    "sender_note" => $txnNote,
                                    "payee_vpa" => $upi_id,
                                ));

                                // print_r($json_string);

                                $hash = $this->hash_encrypt($json_string, $userdata->secret);
                                // echo $hash;
                                $RechPayChecksum = $this->generateSignature($json_string, $userdata->secret);
                                // echo $RechPayChecksum;
                                $arr = array("status" => 'SUCCESS', "message" => 'Transactions Successfully', "hash" => $hash, "checksum" => $RechPayChecksum, "orderId" => $client_orderid);
                                //session_destroy();

                                if (isset($_SESSION['slug'])) {
                                    $id = $_SESSION['user_id'];
                                    $wallet = $this->db->get_where('users', ['id' => $id])->row_array();
                                    $wallet_balance = $wallet['wallet'];
                                    $update_amount = $wallet_balance + $amount;
                                    $input = [
                                        'wallet' => $update_amount,
                                    ];
                                    if (!empty($input)) {
                                        $this->db->where(['id' => $id]);
                                        $this->db->update('users', $input);
                                    }
                                    //   $this->db->update('users', $input);
                                    $history = [
                                        'from_mobile' => $_SESSION['mobile'],
                                        'mobile' => $bank_ref_num,
                                        'user_type' => $_SESSION['user_type'],
                                        'date' => date('Y-m-d'),
                                        'time' => date('H:i:s'),
                                        'cr_dr' => 'Credit',
                                        'amount' => $amount,
                                        'balance' => $update_amount,
                                        'remarks' => 'UPI Auto Wallet Recharge',
                                        'type' => 'UPI'
                                    ];

                                    $this->db->insert('wallet_balance_history', $history);
                                }
                                unset($_SESSION['muid']);
                                unset($_SESSION['auth_token']);
                                unset($_SESSION['txn_ref_id']);
                                unset($_SESSION['upi_id']);
                                unset($_SESSION['client_orderid']);
                                unset($_SESSION['txnAmount']);
                            }
                        }
                    } else {
                        $arr = array("status" => 'FAILED', "message" => 'Duplicate Order Id');
                    }
                } else {
                    $arr = array("status" => 'FAILED', "message" => 'Duplicate Request');
                }
            }
        } else {
            $arr = array("status" => 'FAILED', "message" => 'Unauthorized Request');
        }
        echo json_encode($arr);
    }


    public function Callback()
    {
        $verifySignature = '';
        $array = array();
        $paramList = array();

        $secret = 'UHKNaEfKhS';
        $status = $this->input->post('status'); // Its Payment Status Only, Not Txn Status.
        $message = $this->input->post('message'); // Txn Message.
        $cust_Mobile = $this->input->post('cust_Mobile'); // Txn Message.
        $cust_Email = $this->input->post('cust_Email'); // Txn Message.
        $hash = $this->input->post('hash'); // Encrypted Hash / Generated Only SUCCESS Status.
        $checksum = $this->input->post('checksum');  // Checksum verifySignature / Generated Only SUCCESS Status.

        // Payment Status.
        if ($status == "SUCCESS") {

            $paramList = $this->hash_decrypt($hash, $secret);
            // print_r($paramList); die;
            $verifySignature = $this->verifySignature($paramList, $secret, $checksum);

            // Checksum verify.
            if ($verifySignature) {
                // print_r($paramlist); die;
                $array = json_decode($paramList);

                // Payment Response
                echo "<pre>";
                echo "Payment Status: $status<br>";
                echo "Payment Message: $message<br>";
                echo "Customer Mobile: $cust_Mobile<br>";
                echo "Customer Email: $cust_Email<br>";
                echo "Payment hash: $hash<br>";
                echo "Payment Checksum: $checksum<hr>";
                foreach ($array as $key => $value) {
                    echo "<b>$key:</b> <b style='color:green'>$value</b><hr>";
                }
                echo '<h2><b style="color:green">Checksum Verified!</b></h2>';
            } else {

                // Payment Response
                echo "<pre>";
                echo "Payment Status: $status<br>";
                echo "Payment Message: $message<br>";
                echo '<h2><b style="color:red">Checksum Invalid!</b></h2>';
            }
        }
    }

    public function generateSignature($params, $key)
    {
        if (!is_array($params) && !is_string($params)) {
            throw new Exception("string or array expected, " . gettype($params) . " given");
        }
        if (is_array($params)) {
            $params = self::getStringByParams($params);
            // echo $params; die;	
        }
        return self::generateSignatureByString($params, $key);
    }

    static private function getStringByParams($params)
    {
        ksort($params);
        $params = array_map(function ($value) {
            return ($value !== null && strtolower($value) !== "null") ? $value : "";
        }, $params);
        return implode("|", $params);
    }

    static private function generateSignatureByString($params, $key)
    {
        $salt = self::generateRandomString(4);
        // echo $salt; die;
        return self::calculateChecksum($params, $key, $salt);
    }

    static private function generateRandomString($length)
    {
        $random = "";
        srand((float) microtime() * 1000000);

        $data = "9876543210ZYXWVUTSRQPONMLKJIHGFEDCBAabcdefghijklmnopqrstuvwxyz!@#$&_";

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;
    }

    static private function calculateChecksum($params, $key, $salt)
    {
        try {
            $hashString = self::calculateHash($params, $salt);
            $encryptedChecksum = self::encrypt($hashString, $key);
            // print_r($encryptedChecksum);
            return $encryptedChecksum;
        } catch (Exception $e) {
            // Handle exceptions, if any
            // echo "Error calculating checksum: " . $e->getMessage(); die;
            return ['error' => $e->getMessage()];
        }

        // echo $hashString;
        // // echo self::encrypt($hashString, $key); 
        // die;
        // return self::encrypt($hashString, $key);
    }

    static private function calculateHash($params, $salt)
    {
        $finalString = $params . "|" . $salt;
        $hash = hash("sha256", $finalString);
        return $hash . $salt;
    }

    private static $iv = "@@@@&&&&####$$$$";

    static public function encrypt($input, $key)
    {
        $key = html_entity_decode($key);

        if (function_exists('openssl_encrypt')) {
            $data = openssl_encrypt($input, "AES-128-CBC", $key, 0, self::$iv);
        } else {
            $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
            $input = self::pkcs5Pad($input, $size);
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
            mcrypt_generic_init($td, $key, self::$iv);
            $data = mcrypt_generic($td, $input);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            $data = base64_encode($data);
        }
        return $data;
    }

    static private function pkcs5Pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function hash_decrypt($msg_encrypted_bundle, $password)
    {
        $password = sha1($password);

        $components = explode(':', $msg_encrypted_bundle);
        $iv            = $components[0];
        $salt          = hash('sha256', $password . $components[1]);
        $encrypted_msg = $components[2];

        $decrypted_msg = openssl_decrypt(
            $encrypted_msg,
            'aes-256-cbc',
            $salt,
            null,
            $iv
        );

        if ($decrypted_msg === false)
            return false;

        $msg = substr($decrypted_msg, 41);
        return $decrypted_msg;
    }

    static public function verifySignature($params, $key, $checksum)
    {
        // echo $checksum; die;
        if (!is_array($params) && !is_string($params)) {
            throw new Exception("string or array expected, " . gettype($params) . " given");
        }
        if (isset($params['CHECKSUMHASH'])) {
            unset($params['CHECKSUMHASH']);
        }
        if (is_array($params)) {
            $params = self::getStringByParams($params);
            // echo $params; die;
        }
        return self::verifySignatureByString($params, $key, $checksum);
    }

    static private function verifySignatureByString($params, $key, $checksum)
    {
        $RechPay_hash = self::decrypt($checksum, $key);
        $salt = substr($RechPay_hash, -4);
        return $RechPay_hash == self::calculateHash($params, $salt) ? true : false;
    }

    static public function decrypt($encrypted, $key)
    {
        $key = html_entity_decode($key);

        if (function_exists('openssl_decrypt')) {
            $data = openssl_decrypt($encrypted, "AES-128-CBC", $key, 0, self::$iv);
        } else {
            $encrypted = base64_decode($encrypted);
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
            mcrypt_generic_init($td, $key, self::$iv);
            $data = mdecrypt_generic($td, $encrypted);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            $data = self::pkcs5Unpad($data);
            $data = rtrim($data);
        }
        return $data;
    }

    static private function pkcs5Unpad($text)
    {
        $pad = ord($text[strlen($text) - 1]);
        if ($pad > strlen($text))
            return false;
        return substr($text, 0, -1 * $pad);
    }

    public function GenRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function hash_encrypt($data, $password)
    {
        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($password);

        $salt = sha1(mt_rand());
        $saltWithPassword = hash('sha256', $password . $salt);

        $encrypted = openssl_encrypt(
            "$data",
            'aes-256-cbc',
            "$saltWithPassword",
            null,
            $iv
        );
        $msg_encrypted_bundle = "$iv:$salt:$encrypted";
        return $msg_encrypted_bundle;
    }
}
