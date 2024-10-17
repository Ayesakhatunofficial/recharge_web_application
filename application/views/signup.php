<?php $site_name = $this->db->get('profile_info')->row_array(); ?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <meta property="og:image" itemprop="image" content="<?= base_url(); ?>assets/share.jpeg" />
    <title><?= $site_name['site_title']; ?> | Login</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url(); ?>assets/css/pages/auth-light.css" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content ">
        <form id="reg-form" action="" method="post">
            <center><a style="color: #439500;font-weight: bold;font-size: 38px;font-size: 31px;" class="loglink" href="<?= base_url(); ?>"><I><span style="color: #0b76ff;">RECHARGE</span> DESUN</I></a></center>
            <hr>
            <h2 class="login-title">Sign Up</h2>
            <input type="hidden" value="<?= isset($user_code) ? $user_code : '' ?>" name='user_code'>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-user"></i></div>
                    <input class="form-control" type="text" name="name" placeholder="Full Name" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-mobile"></i></div>
                    <input class="form-control" type="number" name="mobile" placeholder="Mobile" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <select class="form-control" name='gender'>
                        <option>-- Gender --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <?php $states = $this->db->get('state')->result_array(); ?>
                <div class="form-group col-md-6">
                    <div class="input-group-icon right">
                        <select class="form-control select2_demo_1" name='state' required>
                            <option>-- State --</option>
                            <?php foreach ($states as $state) : ?>
                                <option value="<?= $state['id']; ?>"><?= $state['state']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control" name="city" placeholder="City">
                </div>

                <div class="col-md-6 form-group">
                    <input type="text" maxlength="6" class="form-control" name="pin" placeholder="Pincode">
                </div>
            </div>

            <div class="form-group ">
                <input type="text" class="form-control" name="address" placeholder="Address">
            </div>

            <!------------------- PAN Number ------------------------>

            <div class="form-group">
                <input type="text" class="form-control" name="pan" placeholder="Pan Card Number">
            </div>

            <!---------------------- AADHAAR NUMBER ------------------>

            <div class="form-group">
                <input type="number" class="form-control" name="adhar" placeholder="Adhaar Card Number">
            </div>

            <!-------------------------- Password  ------------------------------>

            <div class="form-group">
                <input type="text" class="form-control" name="password" placeholder="Password" required>
            </div>


            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Signup</button>
            </div>
            <div class="text-center">If you are a member?
                <a class="color-blue" href="<?= base_url('userlogin'); ?>">Login here</a>
            </div>
        </form>
    </div>
    <br>
    <center><strong>A Unit of <a style="color: #439500;" target="_blank" href="https://www.desuntechnology.in/">Desun Technology Pvt Ltd</a></strong></center>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/js/app.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    mobile: {
                        required: true,
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
</body>

</html>