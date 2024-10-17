<!DOCTYPE html>
<html lang="en">

<head>
    <title>Desun | Payments</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/css/adminx.css" media="screen" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <!-- <link rel="icon" href="<? //php echo webdata('web_fav'); 
                                ?>" type="image/*" /> -->
    <!--script src="../assets/dist/js/historry.js"></script-->
    <script src="<?php echo base_url(); ?>assets/dist/js/sweetalert.min.js"></script>
    <style>
        .navbar-brand-image {
            width: 3.875rem;
            height: 1.875rem;
        }

        .brand-logo {
            background-image: url('../images/brand.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position:
                center;
            height: 40px;
            width: 120px
        }

        .small-logo {
            /* height: 60px; */
            width: 150px;
        }

        .adminx-container .navbar {
            font-size: .875rem;
            /* background-color: #000; */
            height: 3.5rem;
            padding: 0;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            background-image: linear-gradient(90deg, #085bac, #11c4cb);
        }

        .adminx-sidebar {
            /* background: #fff; */
            position: fixed;
            width: 260px;
            top: 3.5rem;
            bottom: 0;
            left: 0;
            z-index: 1040;
            -webkit-box-shadow: 1px 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 1px 1px 1px 0 rgba(0, 0, 0, .1);
            background-image: linear-gradient(180deg, #095fae, #11c4cb);
        }

        .sidebar-nav-link {
            padding: .5rem 1.5rem;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            color: #ffffff;
        }

        .sidebar-nav-link.active {
            color: #ffffff;
        }

        .sidebar-sub-nav {
            list-style-type: none;
            margin: 0;
            padding: .5rem 0;
            font-size: .875rem;
            background-image: linear-gradient(180deg, #095fae, #11c4cb);
        }

        a:hover {
            color: white;
        }

        .card {
            border-radius: 5px;
        }

        .sp-background {
            background: #f9fcff;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

        }

        .card-nblue {
            background: #011f3f;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #0e98be;
        }

        .bg-mix {
            background: linear-gradient(#0857ab, #11c9cc);
        }

        .table-hover tbody tr:hover {
            background-color: #011f3f;
            color: white;
        }
    </style>

</head>

<body class="sp-background">
    <? //php print_r($paramList['orderId']); die; 
    ?>
    <div class="p-3">
        <div class="container">
            <div class="row  d-flex justify-content-center" style="-webkit-box-shadow: 0px 0px 18px -6px rgba(113,255,105,1); -moz-box-shadow: 0px 0px 18px -6px rgba(113,255,105,1); box-shadow: 0px 0px 18px -6px rgba(113,255,105,1);">
                <div class="col-md-12 card p-4">
                    <div class="row">
                        <a class="btn btn-primary btn-sm" href="<?= base_url('dashboard') ?>">Back</a>

                        <div class="col-md-12 text-center">

                            <div class="col-md-12 text-center mt-1">
                                <div class="text-center">
                                    <!-- <img src="<? //php echo base_url(); 
                                                    ?>assets/img/gpay.png" alt="gpay" height="20px">
                                    <img src="<? //php echo base_url(); 
                                                ?>assets/img/paytm.png" alt="gpay" height="20px">
                                    <img src="<? //php echo base_url(); 
                                                ?>assets/img/phonepe.png" alt="gpay" height="20px">
                                    <img src="<? //php echo base_url(); 
                                                ?>assets/img/bhim_logo.png" alt="gpay" height="20px">
                                    <img src="<? //php echo base_url(); 
                                                ?>assets/img/amazonpay.png" alt="gpay" height="20px"> -->
                                </div>
                                <div class="mt-2 d-flex justify-content-center" id="qrcode" style="max-width:100%">
                                    <img src="<?php echo base_url(); ?>assets/img/Payment-Failed.gif" alt="" width="100">
                                </div>
                                <br>
                                <div class="text-dark"><h3 style="color: red;">Payment Failed !!! <br> Try Again </h3></div>
                            </div>
                            <br>
                            <div class="col-md-12 text-center mt-0">
                                <img src="<?php echo base_url() ?>assets/img/rectangle.png" alt="" style="width: 90%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/vendor.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/adminx.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/custom-new.js?<?= time() ?>"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/qrcode.min.js"></script>






</body>

</html>