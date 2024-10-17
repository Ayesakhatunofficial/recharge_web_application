<?php
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>B2B Portal | Dashboard</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->



</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">


                <?php if ($_SESSION['slug'] == 'admin' && isset($_SESSION['slug'])) { ?>

                    <a class="link" href="<?php echo base_url('dashboard'); ?>">

                        <span class="brand">
                            <?php
                            $admin_id = $_SESSION['user_id'];
                            $site_name = $this->db->get('profile_info')->row_array();
                            $site = $this->db->get_where('users', ['id' => $admin_id])->row_array();
                            if (isset($site['title']) && $site['title'] != NuLL) {
                                echo $site['title'];
                            } else {
                                echo $site_name['site_title'];
                            }
                            ?>
                        </span>


                        <span class="brand-mini">
                            <?php if (isset($site['title']) && $site['title'] != NuLL) {
                                echo $site['name'];
                            } else {
                                echo 'RD';
                            } ?>
                        </span>


                    </a>


                    <?php } else {
                    if ($_SESSION['slug']) {

                        $created_by_id = $_SESSION['created_by_id'];
                        $create_by = $_SESSION['created_by']; //d

                        $user_1 = $this->db->get_where('users', ['id' => $created_by_id])->row(); //d
                        $user_1_createdById = $user_1->created_by_id;
                        $user_1_type = $user_1->create_by; //sd

                        $user_2 = $this->db->get_where('users', ['id' => $user_1_createdById])->row(); //sd
                        $user_2_createdById = $user_2->created_by_id;
                        $user_2_type = $user_2->create_by; //a

                        $user_3 = $this->db->get_where('users', ['id' => $user_2_createdById])->row(); //a

                        if ($create_by == 'admin' && isset($user_1->title)) {
                            $f_title = $user_1->title;
                            $f_name = $user_1->name;
                        } elseif ($user_1_type == 'admin' && isset($user_2->title)) {
                            $f_title = $user_2->title;
                            $f_name = $user_2->name;
                        } elseif ($user_2_type == 'admin' && isset($user_3->title)) {
                            $f_title = $user_3->title;
                            $f_name = $user_3->name;
                        } else {
                            $site_name = $this->db->get('profile_info')->row_array();
                            $f_title = $site_name['site_title'];
                            $f_name = 'RD';
                        }
                    ?>
                        <a class="link" href="<?= base_url('dashboard'); ?>">
                            <span class="brand">
                                <?= $f_title; ?>
                            </span>
                            <span class="brand-mini">
                                <?= $f_name; ?>
                            </span>
                        </a>
                    <?php } else { ?>
                        <a class="link" href="<?php echo base_url('dashboard'); ?>">
                            <span class="brand">
                                <?php
                                $site_name = $this->db->get('profile_info')->row_array();
                                echo $site_name['site_title'];
                                ?>
                            </span>
                            <span class="brand-mini">RD</span>
                        </a>
                <?php }
                } ?>
            </div>
            <!-- Responsive Menu bar-->
            <div class="menu-btn">
              <i class="fas fa-bars"></i>
            </div>
            <!-- Responsive Menu bar-->
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                     <!-- <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>-->
                    <?php

                    if (!empty($_SESSION['slug'])) {

                        $ut = $this->db->get_where('user_type', ['slug' => $_SESSION['slug']])->row_array();

                        // echo "<pre>"; print_r($ut); die;
                    }
                    ?>
                    <?php if (isset($_SESSION['role'])) { ?>
                        <li class="mobile-hide">
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
                        <li class="mobile-hide">
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
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">


                    <li class="dropdown dropdown-inbox">
                        <a href="https://web.whatsapp.com/send?phone=918777846136" style="font-size: 22px;color: #2ecc71;" class="nav-link"><i class="fa fa-whatsapp"></i></a>
                    </li>


                    <li class="dropdown dropdown-inbox">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i>
                            <span class="badge badge-primary envelope-badge">
                                <?php
                                if (isset($_SESSION['role'])) {
                                    $user = $_SESSION['role'];
                                    $datas = $this->db->query("SELECT COUNT(id) as total_id from listfundrequest where user_create = '$user' and status = 0 ")->row_array();
                                    echo $datas['total_id'];
                                }
                                if (isset($_SESSION['slug'])) {
                                    $user_id = $_SESSION['user_id'];
                                    // echo $user_id; die;
                                    $data = $this->db->query("SELECT COUNT(id) as total_id from listfundrequest where user_create = $user_id and status = 0 ")->row_array();
                                    echo $data['total_id'];
                                }
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                            <li class="dropdown-menu-header">
                                <div>
                                    <span><strong>
                                            <?php
                                            if (isset($_SESSION['role'])) {
                                                echo $datas['total_id'];
                                            }
                                            if (isset($_SESSION['slug'])) {
                                                echo $data['total_id'];
                                            }

                                            ?>
                                            New
                                        </strong> Request</span>
                                    <a class="pull-right" href="listfundrequest">View all</a>
                                </div>
                            </li>
                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                                <div>
                                    <?php
                                    if (isset($_SESSION['role'])) {
                                        $user = $_SESSION['role'];
                                        $fund_requests = $this->db->query("SELECT * FROM listfundrequest WHERE user_create = '$user' and status = 0  LIMIT 5")->result_array();
                                    } else if (isset($_SESSION['slug'])) {
                                        $user_id = $_SESSION['user_id'];
                                        $fund_requests = $this->db->query("SELECT * FROM listfundrequest WHERE user_create = $user_id and status = 0 LIMIT 5 ")->result_array();
                                    }
                                    foreach ($fund_requests as $fundrequest) {

                                    ?>
                                        <a class="list-group-item" href="listfundrequest">
                                            <div class="media">
                                                <div class="media-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/users/u1.jpg" />
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-strong">
                                                        <?php
                                                        $name_id = $fundrequest['username'];
                                                        $name = $this->db->get_where('users', ['id' => $name_id])->row_array();
                                                        echo $name['name'];
                                                        ?>
                                                    </div><small class="text-muted float-right">
                                                        <?php echo $fundrequest['create_date']; ?>
                                                    </small>
                                                    <div class="font-13" style="color:black;">
                                                        <?php echo $fundrequest['mobile'] . " (<strong style='
                                                     color: #003cff;'>₹" . $fundrequest['amount'] . "</strong>) "; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <?php
                    if (isset($_SESSION['role'])) {

                        $notifications = $this->db->order_by('id', 'desc')->limit(5)->get('notifications')->result_array();
                    } else {

                        if ($_SESSION['slug']) {

                            $created_by_id = $_SESSION['created_by_id'];
                            $create_by = $_SESSION['created_by']; //d

                            $user_1 = $this->db->get_where('users', ['id' => $created_by_id])->row(); //d
                            $user_1_createdById = $user_1->created_by_id;
                            $user_1_type = $user_1->create_by; //sd

                            $user_2 = $this->db->get_where('users', ['id' => $user_1_createdById])->row(); //sd
                            $user_2_createdById = $user_2->created_by_id;
                            $user_2_type = $user_2->create_by; //a

                            if ($create_by == 'admin') {

                                $notifications = $this->db->order_by('id', 'desc')->get_where('notifications', ['created_by' => $created_by_id], 5)->result_array();
                            } elseif ($user_1_type == 'admin') {

                                $notifications = $this->db->order_by('id', 'desc')->get_where('notifications', ['created_by' => $user_1_createdById], 5)->result_array();
                            } elseif ($user_2_type == 'admin') {

                                $notifications = $this->db->order_by('id', 'desc')->get_where('notifications', ['created_by' => $user_2_createdById], 5)->result_array();
                            } else {
                                $notifications = $this->db->order_by('id', 'desc')->get_where('notifications', ['created_by' => 'super_admin'], 5)->result_array();
                            }
                        }
                    }

                    ?>


                    <li class="dropdown dropdown-notification">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o rel"><span class="notify-signal"></span></i></a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                            <li class="dropdown-menu-header">
                                <div>
                                    <span><strong>5 New</strong> Notifications</span>
                                    <!-- <a class="pull-right" href="javascript:;">view all</a> -->
                                </div>
                            </li>
                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                                <div>

                                    <?php
                                    foreach ($notifications as $notification) {
                                    ?>
                                        <a class="list-group-item">
                                            <div class="media">
                                                <div class="media-img">
                                                    <span class="badge badge-warning badge-big"><i class="fa fa-bell-o"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-13"><?= $notification['notification'] ?></div><small class="text-muted"><?= date('d-m-Y H:i:s A', strtotime($notification['created_at'])) ?></small>
                                                </div>
                                            </div>
                                        </a>

                                    <?php } ?>

                                </div>
                            </li>
                        </ul>
                    </li>



                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" />
                            <span>
                                <?= (isset($_SESSION['user_type']) ? $_SESSION['first_name'] : (isset($_SESSION['role']) ? 'Super Admin' : '')); ?>
                                <br> <small>
                                    <?= (isset($_SESSION['user_type']) ? $_SESSION['user_type'] . " (" . $_SESSION['mobile'] . ")" : ''); ?>
                                </small>
                            </span>
                            <i class="fa fa-angle-down m-l-5"></i>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?= base_url('profile'); ?>"><i class="fa fa-user"></i>My
                                Profile</a>
                            <!-- <a class="dropdown-item" href="javascript:;"><i class="fa fa-support"></i>Support</a> -->
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="<?= base_url('Logout/index/'); ?>"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>


                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->