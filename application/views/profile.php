<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <h1 class="page-title">Profile</h1>
    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">


                    <div class="ibox-body text-center">


                        <?php if (isset($_SESSION['role'])) { ?>

                            <div class="m-t-20">

                                <img class="img-circle" src="<?= base_url('profile_image/' . $super_admin['profile_image']); ?>" />

                            </div>

                            <h5 class="font-strong m-b-10 m-t-10"><?= $super_admin['first_name'] . " " . $super_admin['last_name']; ?></h5>


                            <div class="m-b-20 text-muted"><?= isset($super_admin['role']) ? "Super Admin" : " "; ?></div>


                        <?php }


                        if (isset($_SESSION['slug'])) { ?>

                            <div class="m-t-20">

                                <img class="img-circle" src="<?= base_url('uploads/' . $user['photo']); ?>" />

                            </div>

                            <h5 class="font-strong m-b-10 m-t-10"><?= $user['name']; ?></h5>

                            <div class="m-b-20 text-muted"><?= $_SESSION['user_type']; ?></div>

                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">

                <div class="ibox">

                    <div class="ibox-body">

                        <ul class="nav nav-tabs tabs-line">

                            <li class="nav-item">

                                <a class="nav-link active" href="#tab-2" data-toggle="tab"><i class="ti-settings"></i> Settings</a>

                            </li>

                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab-2">

                                <form action="" method="post" enctype="multipart/form-data">

                                    <?php if (isset($_SESSION['role'])) { ?>

                                        <div class="row">

                                            <div class="col-sm-12 form-group">

                                                <label>Site Title</label>

                                                <input type="hidden" name="id" value="<?= isset($super_admin['id']) ? $super_admin['id'] : ""; ?>">

                                                <input class="form-control" type="text" name="site_title" placeholder="Site Title" value="<?= isset($super_admin['site_title']) ? $super_admin['site_title'] : ""; ?>">

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>First Name</label>

                                                <input class="form-control" type="text" name="first_name" placeholder="First Name" required value="<?= isset($super_admin['first_name']) ? $super_admin['first_name'] : ""; ?>">

                                            </div>

                                            <div class="col-sm-6 form-group">

                                                <label>Last Name</label>

                                                <input class="form-control" type="text" name="last_name" placeholder="Last Name" value="<?= isset($super_admin['last_name']) ? $super_admin['last_name'] : ""; ?>">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label>Email</label>

                                            <input class="form-control" type="text" name="email" placeholder="Email address" required value="<?= isset($super_admin['email']) ? $super_admin['email'] : ""; ?>">

                                        </div>


                                        <div class="form-group">

                                            <label>Password</label>

                                            <input class="form-control" type="password" name="password" placeholder="Password" value="<?= isset($super_admin['password']) ? $super_admin['password'] : ""; ?>">

                                        </div>


                                        <div class="form-group">

                                            <label>Upload Profile Image</label>

                                            <input class="form-control" type="file" name="profile_image" value="<?= $super_admin['profile_image']; ?>">

                                            <span><?= (isset($upload_error)) ? $upload_error : ""; ?></span>
                                        </div>

                                    <?php }
                                    if (isset($_SESSION['slug'])) {
                                    ?>
                                        <div class="row">

                                            <div class="col-sm-6 form-group">

                                                <label>User Type</label>

                                                <input type="hidden" name="id" value="<?= $user['id']; ?>">

                                                <input class="form-control" type="text" name="user_type" value="<?= $_SESSION['user_type'] ?>" readonly>

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>Name</label>

                                                <input class="form-control" type="text" name="name" placeholder="First Name" required value="<?= $user['name'] ?>">

                                            </div>

                                            <div class="col-sm-6 form-group">

                                                <label>Mobile No.</label>

                                                <input class="form-control" type="text" name="mobile" value="<?= $user['mobile'] ?>" readonly>

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>Email</label>

                                                <input class="form-control" type="email" name="email" value="<?= $user['email'] ?>">

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>Address</label>

                                                <input class="form-control" type="text" name="address" value="<?= $user['address'] ?>">

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>City</label>

                                                <input class="form-control" type="text" name="city" value="<?= $user['city'] ?>">

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>Pincode</label>

                                                <input class="form-control" type="text" name="pincode" value="<?= $user['pin'] ?>">

                                            </div>


                                            <div class="col-sm-6 form-group">

                                                <label>Password</label>

                                                <input class="form-control" type="password" name="password" value="<?= $user['password'] ?>">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label>Logo Image</label>

                                            <input class="form-control" type="file" name="profile_image" value="<?= $user['photo']; ?>">

                                            <span><?= (isset($upload_error)) ? $upload_error : ""; ?></span>

                                        </div>

                                    <?php }
                                    if (isset($_SESSION['slug']) && $_SESSION['slug'] == 'admin') { ?>

                                        <!-- <div class="form-group">
                                            <label for="">Logo</label>

                                            <input type="file" class="form-control" name="logo" value="">

                                            <div><? //= $user['logo'] 
                                                    ?></div>
                                        </div> -->

                                        <div class="form-group">
                                            
                                            <label for="">Referral Code</label>

                                            <input type="text" class="form-control" name="custom_code" value="<?= $user['custom_code'] ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Title</label>

                                            <input type="text" class="form-control" name="title" value="<?= $user['title'] ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Url</label>

                                            <input type="text" class="form-control" name="url" value="<?= $user['url'] ?>">
                                        </div>

                                    <?php } ?>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>