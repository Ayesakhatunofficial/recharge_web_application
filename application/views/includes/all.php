<style>

</style>
<div class="content-wrapper css-off">
    <ul class="mobile-show">
        <?php if (isset($_SESSION['role'])) { ?>
            <li>
                <span class="badge badge-primary m-r-5 m-b-5" id="total_balance">
                    R : ₹
                    <?php
                    //$ci = &get_instance();
                    $this->load->database();
                    $query = $this->db->query('SELECT balance FROM tbl_balance');
                    $result = $query->row_array();
                    echo isset($result['balance']) ? $result['balance'] : 0; ?>
                </span>

                <span class="badge badge-warning m-b-5">U : ₹
                    <?php
                    //$ci = &get_instance();
                    $this->load->database();
                    $query = $this->db->query('SELECT balance FROM tbl_utility_balance');
                    $result = $query->row_array();
                    echo isset($result['balance']) ? $result['balance'] : 0; ?>
                </span>
            </li>
        <?php } else { ?>
            <li>
                <a href="<?= base_url('walletrecharge') ?>">
                    <span class="badge badge-primary m-r-5 m-b-5">
                        <i class="fas fa-wallet"></i>
                        Balance: ₹
                        <?php
                        //$ci = &get_instance();
                        $this->load->database();
                        $user_id = $_SESSION['user_id'];
                        // echo $user_id; die;
                        $query_1 = $this->db->query("SELECT wallet FROM users where id = $user_id");
                        $result = $query_1->row_array();
                        // print_r($result); die;
                        echo isset($result['wallet']) ? $result['wallet'] : 0; ?>


                    </span>
                </a>
            </li>
        <?php } ?>
    </ul>

    <?php
    if (isset($_SESSION['role'])) {
        $user_type = $_SESSION['role'];
        $upi = $this->db->get_where('tbl_upi', ['user_type' => $user_type])->row_array();
    }
    if (isset($_SESSION['slug'])) {
        $user_type = $_SESSION['created_by'];
        $user_id = $_SESSION['created_by_id'];
        $mobile = $_SESSION['mobile'];
        if ($user_type == 'super_admin') {
            $condition = ['user_type' => $user_type];
        } else {
            $condition = [
                'user_type' => $user_type,
                'user_id' => $user_id,
            ];
        }
        // print_r($condition); 

        $upi = $this->db->get_where('tbl_upi', $condition)->row_array();
        // print_r($upi); die;
        $url = 'upi://pay?pa=' . $upi['upi'] . '&pn=RechargeDesun&cu=INR&am=' . $upi['min_amount'];
    }
    ?>

    <div class="news">
        <!-- <h3> <span id="indmarquee">
                <marquee class="news-text">Online Auto Wallet Recharge Working Fine, Recharge Your Wallet Online Welcome to DTPL Recharge, AIRTEL JIO & All Operator Working Fine With Highest Average Margin(3% to 7%), MOBILE DTH RECHARGE & ELECTRICITY BILL PAYMENT Working Fine </marquee>
            </span>
        </h3> -->

        <?php
        if (isset($_SESSION['role'])) {
            $news_data = $this->db->get_where('tb_news', ['created_by' => $_SESSION['role']])->row_array();
        } else if ($_SESSION['slug'] == 'admin') {
            $news_data = $this->db->get_where('tb_news', ['created_by' => $_SESSION['user_id']])->row_array();
            if (empty($news_data)) {
                $news_data = $this->db->get_where('tb_news', ['created_by' => 'super_admin'])->row_array();
            }
        } else {
            if ($create_by == 'admin') {
                $news_data = $this->db->get_where('tb_news', ['created_by' => $created_by_id])->row_array();
            } else if ($user_1_type == 'admin') {
                $news_data = $this->db->get_where('tb_news', ['created_by' => $user_1_createdById])->row_array();
            } else if ($user_2_type == 'admin') {
                $news_data = $this->db->get_where('tb_news', ['created_by' => $user_2_createdById])->row_array();
            } else {
                $news_data = $this->db->get_where('tb_news', ['created_by' => 'super_admin'])->row_array();
            }
        }
        ?>

        <h3> <span id="indmarquee">
                <marquee class="news-text"><?= $news_data['news'] ?></marquee>
            </span>
        </h3>

        <!-- <a class="upi" href="<? //php echo $url; 
                                    ?>">Add Money Pay Via UPI : <strong><? //php echo $upi['upi']; 
                                                                        ?></strong></a> -->
        <a class="upi" data-toggle="modal" style="color: #fff; font-weight: 600;" data-target="#paymentupi">Auto-Wallet Recharge Online</strong></a>
    </div>
    <!--<a href="phonepe://pay?pa=9933865105@ybl&pn=Flipkar&cu=INR&am=1699" style="background: #333; padding: 10px; text-decoration: none;color: white;font-size: larger;border-radius: 7px;">Phone Pay</a>-->
    <div class="recharge-options">
        <div class="recharge-items">
            <ul>
                <li name="mobilerecharge">
                    <a href="<?= base_url('mobilerecharge') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/mobile-phone.png" alt="Recharge" class="icon-inactive">
                        <span> Recharge</span>
                    </a>
                </li>
                <li name="dthrecharge">
                    <a href="<?= base_url('dthrecharge') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/television.png" alt="Recharge" class="icon-inactive">
                        <span> DTH</span>
                    </a>
                </li>
                <li name="electricbill">
                    <a href="<?= base_url('electricbill') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/light-bulb.png" alt="Recharge" class="icon-inactive">
                        <span> Electricity</span>
                    </a>
                </li>
                <li name="postpaidbill">
                    <a href="<?= base_url('postpaidbill') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/sim-card.png" alt="Recharge" class="icon-inactive">
                        <span>Post Paid</span>
                    </a>
                </li>
                <li name="landline">

                    <a href="<?= base_url('landline') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/landlinee.png" alt="Recharge" class="icon-inactive">
                        <span> Landline</span>
                    </a>
                </li>

                <li name="broadband">
                    <a href="<?= base_url('broadband') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/internet.png" alt="Recharge" class="icon-inactive">
                        <span> Broadband</span>
                    </a>
                </li>
                <li name="gas">
                    <a href="<?= base_url('gas') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/gas-tank.png" alt="Recharge" class="icon-inactive">
                        <span> Cylinder</span>
                    </a>
                </li>
                <li name="cable">
                    <a href="<?= base_url('cable') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/cable.png" alt="Recharge" class="icon-inactive">
                        <span> Cable</span>
                    </a>

                </li>
                <li name="insurance">
                    <a href="<?= base_url('insurance') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/insurance.png" alt="Recharge" class="icon-inactive">
                        <span> Insurance</span>
                    </a>
                </li>
                <li name="fastagrecharge">
                    <a href="<?= base_url('fastagrecharge') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/toll.png" alt="Recharge" class="icon-inactive">
                        <span> FASTag</span>
                    </a>
                </li>

                <li name="loanpay">
                    <a href="<?= base_url('loanpay') ?>">
                        <img src="<?php echo base_url(); ?>assets/img/service/loan.png" alt="Recharge" class="icon-inactive">
                        <span> Loan</span>
                    </a>
                </li>
                <li name="arge">
                    <a href="#!" class="d-more-serv">
                        <img src="<?php echo base_url(); ?>assets/img/service/menu.png" alt="Recharge" class="icon-inactive">
                        <span> More+</span>
                    </a>

                    <div class="d-more-service" style="display: none;">
                        <div class="d-inner">
                            <div class="d-service-col">
                                <a href="<?= base_url('creditcard') ?>">
                                    <img src="<?php echo base_url(); ?>assets/img/service/credit-card.png" alt="Recharge" class="icon-inactive">
                                    <span> Credit Card</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="pipegas">
                                    <img src="<?php echo base_url(); ?>assets/img/service/stove.png" alt="Recharge" class="icon-inactive">
                                    <span> Piped Gas</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="water">
                                    <img src="<?php echo base_url(); ?>assets/img/service/water-tap.png" alt="Recharge" class="icon-inactive">
                                    <span> Water</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="education">
                                    <img src="<?php echo base_url(); ?>assets/img/service/education.png" alt="Recharge" class="icon-inactive">
                                    <span> Education Fees</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="housing">
                                    <img src="<?php echo base_url(); ?>assets/img/service/housing.png" alt="Recharge" class="icon-inactive">
                                    <span> Housing Society</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="hospital">
                                    <img src="<?php echo base_url(); ?>assets/img/service/hospital.png" alt="Recharge" class="icon-inactive">
                                    <span> Hospital</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="<?= base_url('municiple') ?>">
                                    <img src="<?php echo base_url(); ?>assets/img/service/muncipal.png" alt="Recharge" class="icon-inactive">
                                    <span> Municipal Services</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="challan">
                                    <img src="<?php echo base_url(); ?>assets/img/service/challan.png" alt="Recharge" class="icon-inactive">
                                    <span> Challan</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="metro">
                                    <img src="<?php echo base_url(); ?>assets/img/service/metro.png" alt="Recharge" class="icon-inactive">
                                    <span> Metro</span>
                                </a>
                            </div>
                            <div class="d-service-col">
                                <a href="<?= base_url('subscription') ?>">
                                    <img src="<?php echo base_url(); ?>assets/img/service/subscription.jpg" alt="Recharge" class="icon-inactive">
                                    <span> Subscriptions</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </li>
            </ul>
        </div>
    </div>



</div>