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
                                    <label class="form-control-label">Aadhar No <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="adhar_no" maxlength="14" name="adhar_no" onblur="adharNo()"  placeholder="12XX-XXXX-XX78" required><i id="adhar_no_msg" style="display: none;color: red;font-size:13px"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Photo </label> (<span style="color: crimson; font-size: 13px;"><b style="color: red;">*</b> Upload Image Only and Image must be in jpeg, png, gif format</span>)
                                    <input type="file" class="form-control" name="photo" accept="image/png, image/gif, image/jpeg">

                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Date of Birth<b style="color: red;">*</b></label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="dob">
                                        <!-- <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div> -->
                                    </div>
                                </div>

                                <div class="form-group col-md-6" >
                                    <label class="form-control-label">Language <b style="color: red;">*</b></label>
                                    <select name="language" class="form-control" id="language">
                                        <option value="">-- Select Language --</option>
                                        <?php foreach ($languages as $language) : ?>
                                            <option value="<?= $language['language_code']; ?>"><?= $language['language']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Name <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" name="full_name" id='full_name' placeholder="Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Name To Local Language </label>
                                    <input class="form-control " type="text" id = "name_local" name="full_name_local_language" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Gender <b style="color: red;">*</b></label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">-- Select Gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Gender To Local Language </label>
                                    <input class="form-control " id="gender_local" type="text" name="gender_local_language" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Address With FatherName/Husband Name <b style="color: red;">*</b></label>
                                    <textarea name="address" class="form-control" id="address" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Address To Local Language </label>
                                    <textarea name="address_local_language" id="address_local" class="form-control " readonly></textarea>
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
       
        function adharNo() {
            var adhar_no = document.getElementById('adhar_no').value;

            // console.log(adhar_no);

            if (adhar_no.length != 14) {
                document.getElementById('adhar_no_msg').style.display = "block";

                document.getElementById('adhar_no_msg').setHTML('Please Enter Valid 12 Digit Aadhaar Number');
            }
        }
    </script>



    <?php include 'includes/footer.php'; ?>