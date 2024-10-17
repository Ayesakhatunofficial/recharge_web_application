<?php
//echo base_url();die;
include 'includes/header.php';

include 'includes/sidebar.php';
?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if (isset($_SESSION['slug'])) {
                                if ($user_today_profit['amount'] != NULL || $today_com['today_margin'] != NULL) {
                                    echo $user_today_profit['amount'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            if (isset($_SESSION['role'])) {
                                if ($today_com['t_profit'] != NULL || $today_com['t_profit'] != '') {
                                    echo $today_com['t_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }  ?>
                        </h2>
                        <div class="m-b-5">Today Mobile & DTH Recharge </div><i class="fa fa-money widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>
                                <?php
                                if (isset($_SESSION['slug'])) {
                                    if ($today_com['today_amount'] != NULL || $today_com['today_amount'] != '') {
                                        echo $today_com['today_amount'];
                                    } else {
                                        echo '0.00';
                                    }
                                }

                                if (isset($_SESSION['role'])) {
                                    if ($today_com['today_amount'] != NULL || $today_com['today_amount'] != '') {
                                        $profit = ($today_com['t_profit'] - $today_profit['amount']);
                                        $percentage = round($profit * 100 / $today_com['today_amount'], 2);
                                        echo $today_com['today_amount'] . "  ( " . $profit . "  -  " . $percentage . "%  )";
                                    } else {
                                        echo '0.00';
                                    }
                                }

                                ?>
                            </small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-info color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if (isset($_SESSION['slug'])) {
                                if ($user_month_profit['onemonth_amount'] != NULL || $onemonth_com['onemonth_margin'] != NULL) {
                                    echo $user_month_profit['onemonth_amount'];
                                } else {
                                    echo '0.00';
                                }
                            }

                            if (isset($_SESSION['role'])) {
                                if ($onemonth_com['onemonth_profit'] != NULL || $onemonth_com['onemonth_profit'] != '') {
                                    echo $onemonth_com['onemonth_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            ?>
                        </h2>
                        <div class="m-b-5">Monthly Mobile & DTH Recharge</div><i class="fa fa-money widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>
                                <?php
                                if (isset($_SESSION['slug'])) {
                                    if ($onemonth_com['onemonth_amount'] != NULL || $onemonth_com['onemonth_amount'] != '') {
                                        echo $onemonth_com['onemonth_amount'];
                                    } else {
                                        echo '0.00';
                                    }
                                }

                                if (isset($_SESSION['role'])) {
                                    if ($onemonth_com['onemonth_amount'] != NULL || $onemonth_com['onemonth_amount'] != '') {
                                        $one_profit = ($onemonth_com['onemonth_profit'] - $onemonth_profit['onemonth_amount']);
                                        // echo $one_profit;die;
                                        $one_percentage = round($one_profit * 100 / $onemonth_com['onemonth_amount'], 3);
                                        echo $onemonth_com['onemonth_amount'] . "  ( " . $one_profit . "  -  " . $one_percentage . "%  )";
                                    } else {
                                        echo '0.00';
                                    }
                                }

                                ?>
                            </small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if (isset($_SESSION['slug'])) {
                                if ($user_total_profit['t_amount'] != '' || $total_com['total_margin'] != NULL) {
                                    echo  $user_total_profit['t_amount'];
                                } else {
                                    echo '0.00';
                                }
                            }

                            if (isset($_SESSION['role'])) {
                                if ($total_com['total_profit'] != NULL || $total_com['total_profit'] != '') {
                                    echo $total_com['total_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            ?>
                        </h2>
                        <div class="m-b-5">Total Mobile & DTH Recharge</div><i class="fa fa-money widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>
                                <?php
                                if (isset($_SESSION['slug'])) {
                                    if ($total_com['total_amount'] != NULL || $total_com['total_amount'] != '') {
                                        echo $total_com['total_amount'];
                                    } else {
                                        echo '0.00';
                                    }
                                }

                                if (isset($_SESSION['role'])) {
                                    $to_profit = ($total_com['total_profit'] - $total_profit['t_amount']);
                                    // echo $one_profit;die;
                                    $to_percentage = round($to_profit * 100 / $onemonth_com['onemonth_amount'], 3);

                                    if ($total_com['total_amount'] != NULL || $total_com['total_amount'] != '') {
                                        echo $total_com['total_amount'] . "  ( " . $to_profit . "  -  " . $to_percentage . "%  )";
                                    } else {
                                        echo '0.00';
                                    }
                                }

                                ?>
                            </small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-warning color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if ($total_com['total_recharge'] != NULL || $total_com['total_recharge'] != '') {
                                echo $total_com['total_recharge'];
                            } else {
                                echo '0';
                            }
                            ?>
                        </h2>
                        <div class="m-b-5">No of Recharge</div><i class="fa fa-mobile widget-stat-icon"></i>
                        <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="page-heading">
            <h1 class="page-title mgt10">Utility Bill Payments</h1>
        </div>-->

        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-purple color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if (isset($_SESSION['slug'])) {
                                if ($today_utility['today_profit'] != NULL || $today_utility['today_profit'] != NULL) {
                                    echo $today_utility['today_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            if (isset($_SESSION['role'])) {
                                if ($today_utility['today_api_profit'] != NULL || $today_utility['today_api_profit'] != '') {
                                    echo $today_utility['today_api_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }

                            ?>
                        </h2>
                        <div class="m-b-5">Today Utility Recharge</div><i class="fa fa-money widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>
                                <?php
                                if ($today_utility['today_amount'] != NULL || $today_utility['today_amount'] != '') {
                                    echo $today_utility['today_amount'];
                                } else {
                                    echo '0.00';
                                }
                                ?>
                            </small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-ebony color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if (isset($_SESSION['slug'])) {
                                if ($onemonth_utility['onemonth_profit'] != NULL || $onemonth_utility['onemonth_profit'] != NULL) {
                                    echo $onemonth_utility['onemonth_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            if (isset($_SESSION['role'])) {
                                if ($onemonth_utility['onemonth_api_profit'] != NULL || $onemonth_utility['onemonth_api_profit'] != '') {
                                    echo $onemonth_utility['onemonth_api_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            ?>
                        </h2>
                        <div class="m-b-5">This Months Utility Recharge</div><i class="fa fa-money widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>
                                <?php
                                if ($onemonth_utility['onemonth_amount'] != NULL || $onemonth_utility['onemonth_amount'] != '') {
                                    echo $onemonth_utility['onemonth_amount'];
                                } else {
                                    echo '0.00';
                                }
                                ?>
                            </small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-teal color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if (isset($_SESSION['slug'])) {
                                if ($total_utility['total_profit'] != NULL || $total_utility['total_profit'] != NULL) {
                                    echo $total_utility['total_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            if (isset($_SESSION['role'])) {
                                if ($total_utility['total_api_profit'] != NULL || $total_utility['total_api_profit'] != '') {
                                    echo $total_utility['total_api_profit'];
                                } else {
                                    echo '0.00';
                                }
                            }
                            ?>
                        </h2>
                        <div class="m-b-5">Total Utility Recharge</div><i class="fa fa-money widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>
                                <?php
                                if ($total_utility['total_amount'] != NULL || $total_utility['total_amount'] != '') {
                                    echo $total_utility['total_amount'];
                                } else {
                                    echo '0.00';
                                }
                                ?>
                            </small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="ibox bg-yellow color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php
                            if ($total_utility['total_pay'] != NULL || $total_utility['total_pay'] != '') {
                                echo $total_utility['total_pay'];
                            } else {
                                echo '0.00';
                            }
                            ?>
                        </h2>
                        <div class="m-b-5">No of Recharge</div><i class="fa fa-mobile widget-stat-icon"></i>
                        <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <?php $banner_img = $this->db->get('tb_banner')->row_array(); ?>

                        <img src="<?php echo base_url('uploads/' . $banner_img['banner']); ?>" width="100%" />
                        <div>
                            <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="bar_chart" style="height: 260px; display: none; width: 796px;" width="995" height="325" class="chartjs-render-monitor"></canvas>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <?php if (isset($_SESSION['role'])) {
                    $wallet = $this->db->query("SELECT SUM(wallet) as total_wallet from users where status = 1 and is_deleted = 0")->row_array();
                ?>
                    <div class="ibox bg-primary color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">
                                <?php echo $wallet['total_wallet']; ?>
                            </h2>
                            <div class="m-b-5">Total Wallet Amount</div><i class="fa fa-inr widget-stat-icon"></i>
                            <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                        </div>
                    </div>

                    <?php
                    $admin = $this->db->query("SELECT COUNT(id) as total_admin from users where account_type = 6 and status = 1 and is_deleted = 0")->row_array();
                    ?>

                    <div class="ibox bg-danger color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">
                                <?php echo $admin['total_admin']; ?>
                            </h2>
                            <div class="m-b-5">Total Admin</div><i class="fa fa-user widget-stat-icon"></i>
                            <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                        </div>
                    </div>

                <?php }
                if ($_SESSION['slug'] == 'admin' || isset($_SESSION['role'])) {
                    if (isset($_SESSION['role'])) {
                        $sd = $this->db->query("SELECT COUNT(id) as total_sd from users where account_type = 1 and status = 1 and is_deleted = 0")->row_array();
                    } else if ($_SESSION['slug'] == 'admin') {
                        $u_id = $_SESSION['user_id'];
                        $sd = $this->db->query("SELECT COUNT(id) as total_sd from users where account_type = 1 and status = 1 and is_deleted = 0 and created_by_id = $u_id ")->row_array();
                    }
                ?>

                    <div class="ibox bg-teal color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">
                                <?php echo $sd['total_sd']; ?>
                            </h2>
                            <div class="m-b-5">Total Super Distributor</div><i class="fa fa-user widget-stat-icon"></i>
                            <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                        </div>
                    </div>

                <?php }
                if ($_SESSION['slug'] == 'admin' || $_SESSION['slug'] == 'super_distributor' || isset($_SESSION['role'])) {
                    if (isset($_SESSION['role'])) {
                        $dis = $this->db->query("SELECT COUNT(id) as total_dis from users where account_type = 2 and status = 1 and is_deleted = 0")->row_array();
                    } else if ($_SESSION['slug'] == 'admin' || $_SESSION['slug'] == 'super_distributor') {
                        $as_id = $_SESSION['user_id'];
                        $dis = $this->db->query("SELECT COUNT(id) as total_dis from users where account_type = 2 and status = 1 and is_deleted = 0 and created_by_id = $as_id ")->row_array();
                    }
                ?>

                    <div class="ibox bg-warning color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">
                                <?php echo $dis['total_dis']; ?>
                            </h2>
                            <div class="m-b-5">Total Distributor</div><i class="fa fa-user widget-stat-icon"></i>
                            <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                        </div>
                    </div>

                <?php }
                if ($_SESSION['slug'] == 'admin' || $_SESSION['slug'] == 'super_distributor' || $_SESSION['slug'] == 'distributor' || isset($_SESSION['role'])) {
                    if (isset($_SESSION['role'])) {
                        $retailer = $this->db->query("SELECT COUNT(id) as total_r from users where account_type = 3 and status = 1 and is_deleted = 0")->row_array();
                    } else if ($_SESSION['slug'] == 'admin' || $_SESSION['slug'] == 'super_distributor' || $_SESSION['slug'] == 'distributor') {
                        $asd_id = $_SESSION['user_id'];
                        $retailer = $this->db->query("SELECT COUNT(id) as total_r from users where account_type = 3 and status = 1 and is_deleted = 0 and created_by_id = $asd_id")->row_array();
                    }
                ?>

                    <div class="ibox bg-ebony color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">
                                <?php echo $retailer['total_r']; ?>
                            </h2>
                            <div class="m-b-5">Total Retailer</div><i class="fa fa-user widget-stat-icon"></i>
                            <!-- <div><i class="fa fa-level-up m-r-5"></i><small>122.00</small></div> -->
                        </div>
                    </div>
                <?php } ?>

                <div class="ibox">
                    <div class="ibox-body">

                        <div class="row align-items-center">
                            <div class="col-md-12">
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6264418459963919"
     crossorigin="anonymous"></script>
<!-- 3X3 Ads -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6264418459963919"
     data-ad-slot="1422922913"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
                            </div>
                            <!--<div class="col-md-12">f</div>-->
                        </div>
                    </div>
                </div>







                <!-- <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Statistics</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                    </div>
                                </div>
                                <canvas id="doughnut_chart" style="height: 160px; display: block; width: 167px;" width="208" height="200" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="m-b-20 text-success"><i class="fa fa-circle-o m-r-10"></i>JIO 10</div>
                                <div class="m-b-20 text-info"><i class="fa fa-circle-o m-r-10"></i>AIRTEL 7</div>
                                <div class="m-b-20 text-warning"><i class="fa fa-circle-o m-r-10"></i>BSNL 4</div>
                            </div>
                        </div>
                        <ul class="list-group list-group-divider list-group-full">
                            <li class="list-group-item">JIO
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 64%</span>
                            </li>
                            <li class="list-group-item">AIRTEL
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 58%</span>
                            </li>
                            <li class="list-group-item">BSNL
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 12%</span>
                            </li>
                            <li class="list-group-item">VI
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 4%</span>
                            </li>
                            <li class="list-group-item">MTNL
                                <span class="float-right text-danger"><i class="fa fa-caret-down"></i> 0%</span>
                            </li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
        <style>
            .visitors-table tbody tr td:last-child {
                display: flex;
                align-items: center;
            }

            .visitors-table .progress {
                flex: 1;
            }

            .visitors-table .progress-parcent {
                text-align: right;
                margin-left: 10px;
            }
        </style>

    </div>
    <!-- END PAGE CONTENT-->
    <?php include 'includes/footer.php'; ?>