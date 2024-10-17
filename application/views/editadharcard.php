<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Add New Adhar Card</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="hidden" name="id" value="<?= $adhar['id']; ?>">
                                    <label class="form-control-label">Aadhar No <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="adhar_no" maxlength="14" name="adhar_no" onblur="adharNo()" value="<?= $adhar['adhar_no']; ?>"><i id="adhar_no_msg" style="display: none;color: red;font-size:13px"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Photo </label> (<span style="color: crimson; font-size: 13px;"><b style="color: red;">*</b> Upload Image Only and Image must be in jpeg, png, gif format</span>)
                                    <input type="file" class="form-control" name="photo" accept="image/png, image/gif, image/jpeg">
                                    <img src="<?php echo base_url(); ?>adhar_uploads/<?= $adhar['photo']; ?>" width="100px" height="auto" >
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Date of Birth<b style="color: red;">*</b></label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="dob" value="<?= $adhar['dob']; ?>">
                                        <!-- <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div> -->
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Language <b style="color: red;">*</b></label>
                                    <select name="language" class="form-control" id="language">
                                        <?php foreach($languages as $language) : ($language['language_code'] == $adhar['language']) ? $selected = "selected" : $selected = ""; ?>
                                        <option <?= $selected; ?> value="<?= $language['language_code']; ?>"><?= $language['language']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                               
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Name <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" name="full_name" id='full_name' placeholder="Name"  value="<?= $adhar['full_name']; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Name To Local Language <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id = "name_local" name="full_name_local_language" value="<?= $adhar['full_name_local_language']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Gender <b style="color: red;">*</b></label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="Male" <?= ($adhar['gender'] == 'Male') ? $adhar['gender'] : "" ;?>>Male</option>
                                        <option value="Female" <?= ($adhar['gender'] == 'Female') ? $adhar['gender'] : "" ;?>>Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Gender To Local Language <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="gender_local" name="gender_local_language" value="<?= $adhar['gender_local_language']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Address With FatherName/Husband Name <b style="color: red;">*</b></label>
                                    <textarea name="address" class="form-control" id="address"><?= $adhar['address']; ?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Address To Local Language <b style="color: red;">*</b></label>
                                    <textarea name="address_local_language" class="form-control" id="address_local" readonly><?= $adhar['address_local_language']; ?></textarea>
                                </div>
                                
                                <div class="col-md-12 form-group">
                                    <input type="submit" value="Submit" class="btn btn-primary" name="searchboxbtn">
                                    <a class="btn btn-danger" href="#">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END PAGE CONTENT-->


    <script>
        function adharNo() 
        {
            var adhar_no = document.getElementById('adhar_no').value;

            if(adhar_no.length != 14)
            {
                document.getElementById('adhar_no_msg').style.display = "block";

                document.getElementById('adhar_no_msg').setHTML('Please Enter Valid 12 Digit Aadhaar Number');
            }

            
        }
    </script>

    <?php include 'includes/footer.php'; ?>