<?php

// print_r($result) ;die;
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">Edit User</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>

                    <?php
                    if (isset($_SESSION['user_type']) ||  isset($_SESSION['role'])) {
                        $active = "d-none";
                    } else {
                        $active = "";
                    }
                    ?>
                    <div class="ibox-body">
                        <form action="<?= base_url('editusers/') . $userdata['id'] ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" name="id" value="<?= $userdata['id']; ?>">

                                <!----------------- Account Type ------------------->

                                <?php
                                //  print_r($userdata) ;die;
                                if (isset($_SESSION['slug']) && $_SESSION['slug'] == 'admin') {
                                    $account_types = $this->db->query("SELECT * FROM `user_type` WHERE slug != 'admin'")->result_array();
                                    // print_r($account_types);die;
                                } else  if (isset($_SESSION['slug']) && $_SESSION['slug'] == 'super_distributor') {
                                    $account_types = $this->db->query("SELECT * FROM `user_type` WHERE slug BETWEEN 'distributor' AND 'reatiler'")->result_array();
                                } else if (isset($_SESSION['slug']) && $_SESSION['slug'] == 'distributor') {
                                    $account_types = $this->db->query("SELECT * FROM `user_type` WHERE slug = 'reatiler'")->result_array();
                                } else {
                                    $account_types = $this->db->get('user_type')->result_array();
                                }
                                ?>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Account Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='account_type' required>
                                        <?php foreach ($account_types as $account_type) : ?>
                                            <option value="<?= $account_type['id']; ?>" <?= ($userdata['account_type'] == $account_type['id']) ? ' selected' : ''; ?>>
                                                <?= $account_type['user_type']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>



                                <!----------------- Name -------------------------------->

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Name <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="name" value="<?= $userdata['name'] ?>" placeholder="Name" required>
                                </div>

                                <!------------------ Father Name --------------------------->

                                <div class="col-md-6 form-group <?= $active; ?>">
                                    <label class="form-control-label">Father Name <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="father_name" placeholder="Father Name">
                                </div>

                                <!---------------------- D O B --------------------------->

                                <div class="col-md-6 form-group <?= $active; ?>">
                                    <label class="form-control-label">Date of Birth <b style="color: red;">*</b></label>

                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="dob">
                                        <!-- <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div> -->
                                    </div>
                                </div>

                                <!--------------- Firm Name --------------------------->

                                <div class="col-md-6 form-group <?= $active; ?>">
                                    <label class="form-control-label">Firm Name <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="firm_name" placeholder="Firm Name">
                                </div>

                                <!------------------ Email ID ---------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Email ID <b style="color: red;">*</b></label>
                                    <input type="email" class="form-control" value="<?= $userdata['email'] ?>" name="email" placeholder="example@gmail.com" required>
                                </div>

                                <!-------------------- Mobile Number ---------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Mobile Number <b style="color: red;">*</b></label>
                                    <input type="number" class="form-control" value="<?= $userdata['mobile'] ?>" name="mobile" placeholder="98XXXXXX12" required>
                                </div>

                                <!------------------- PAN Number ------------------------>

                                <div class="col-md-6 form-group ">
                                    <label class="form-control-label">PAN Number <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="pan" placeholder="AAAAA1234A" value="<?= $userdata['pan'] ?>">
                                </div>

                                <!---------------------- AADHAAR NUMBER ------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Aadhaar Number <b style="color: red;">*</b></label>
                                    <input type="number" class="form-control" name="adhar" placeholder="1234XXXX5678" value="<?= $userdata['adhar'] ?>">
                                </div>

                                <!------------------- Gender ------------------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Gender <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='gender'>
                                        <option>Select gender</option>
                                        <option value="male" <?php if ($userdata['gender'] == 'male') echo 'selected'; ?>>Male</option>
                                        <option value="female" <?php if ($userdata['gender'] == 'female') echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>

                                <!---------------------------- State ------------------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">State <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="state" required>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?= $state['id']; ?>" <?= ($userdata['state'] == $state['id']) ? ' selected' : ''; ?>><?= $state['state']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!---------------------- Plan Name --------------------------->

                                <div class="col-md-6 form-group <?= $active; ?>">
                                    <label class="form-control-label">Plan Name <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="plan">
                                        <?php foreach ($plans as $plan) : ?>
                                            <option value="<?= $plan['id']; ?>"><?= $plan['plan_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!--------------------- GST Number -------------------------->

                                <div class="col-md-6 form-group <?= $active; ?>">
                                    <label class="form-control-label">GST Number</label>
                                    <input type="text" class="form-control" name="gst" placeholder="22AAAAA0000A1Z5">
                                </div>
                            </div>
                            <div class="row <?= $active; ?>">
                                <!----------------- BANK Name ------------------------------>
                                <div style="width: 100%;display: block;padding-left: 15px;font-size: 18px;"><strong>Bank Details </strong></div>
                                <br>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Bank Name <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="bank_name" placeholder="Bank Name">
                                </div>

                                <!----------------- IFSC ----------------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">IFSC <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="ifsc" placeholder="AAAAXXXX123">
                                </div>

                                <!------------------------- Bank Acc Holder --------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Bank Account Holder <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="bank_acc_holder" placeholder="Bank Account Holder">
                                </div>

                                <!------------------------ Branch Name ------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Branch Name <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="branch_name" placeholder="Branch Name">
                                </div>

                            </div>
                            <div class="row">
                                <!----------------- BANK Name ------------------------------>
                                <div class="<?= $active; ?>" style="width: 100%;display: block;padding-left: 15px;font-size: 18px;"><strong>Address </strong></div>
                                <br>



                                <!----------------------------- City --------------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">City </label>
                                    <input type="text" class="form-control" name="city" placeholder="City" value="<?= $userdata['city'] ?>">
                                </div>

                                <!----------------------- Address --------------------------------->

                                <div class="col-md-6 form-group ">
                                    <label class="form-control-label">Address <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="address" placeholder="Address" value="<?= $userdata['address'] ?>">
                                </div>

                                <!-------------------------- PIN Code ------------------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">PIN Code <b style="color: red;">*</b></label>
                                    <input type="text" maxlength="6" class="form-control" value="<?= $userdata['pin'] ?>" name="pin" placeholder="7XXXX1">
                                </div>

                                <!-------------------------- Password  ------------------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password"  >
                                </div>

                                <!------------------- Status ------------------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Status </label>
                                    <select class="form-control select2_demo_1" name='status'>
                                        <option value="1" <?php if ($userdata['status'] == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0" <?php if ($userdata['status'] == 0) echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>

                                <?php if (isset($_SESSION['role'])) {
                                    $role = $_SESSION['role'];
                                    // echo $role; die;
                                ?>
                                    <div class="col-md-6 form-group">
                                        <label for="" class="form-control-label">Assigned By</label>
                                        <select class="form-control select2_demo_1" name='create_by'>
                                            <option value="">Select Role</option>
                                            <option value="<?= $role ?>">Super Admin</option>
                                        </select>
                                    </div>
                                <?php } ?>



                            </div>
                            <div class="row <?= $active; ?>">

                                <div style="width: 100%;display: block;padding-left: 15px;font-size: 18px;"><strong>Upload Documents </strong></div>
                                <br>
                                <!--------------------- Adhar Upload ------------------------------>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Upload Aadhaar Card Front Side <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="adhar_front">
                                    <span><?= (isset($upload_error)) ? $upload_error : ""; ?></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Upload Aadhaar Card Back Side <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="adhar_back">
                                    <span><?= (isset($upload_error)) ? $upload_error : ""; ?></span>
                                </div>

                                <!-------------------------- PAN Card -------------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Upload PAN Card <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="pan_image">
                                </div>

                                <!----------------------- Photo --------------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Upload Photo <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="photo" accept="image/png, image/gif, image/jpeg">
                                    <span style="color: crimson; font-size: 13px;"><b style="color: red;">***</b> Upload Image Only and Image must be in jpeg, png, gif format</span>
                                </div>

                                <!----------------------- Bank Passbook ---------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Upload Bank Passbook <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="bank_passbook_image">
                                </div>




                            </div>
                            <!-------------------- Submit Button ------------------------->
                            <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-lg" name="submitBtn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END PAGE CONTENT-->

<?php include 'includes/footer.php'; ?>