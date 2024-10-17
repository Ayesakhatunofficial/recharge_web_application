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
                        <div class="ibox-title">Pan Number Finder</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Aadhar No <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="adhar_no" maxlength="14" name="adhar_no" onblur="adharNo()"  placeholder="12XX-XXXX-XX78" required><i id="adhar_no_msg" style="display: none;color: red;font-size:13px"></i>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Full Name <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="full_name" name="full_name" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Father Name <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="father_name" name="father_name" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Aadhar Front Photo </label> (<span style="color: crimson; font-size: 13px;"><b style="color: red;">*</b> Upload Image Only and Image must be in jpeg, png, gif format</span>)
                                    <input type="file" class="form-control" name="adhar_front_photo" accept="image/png, image/gif, image/jpeg">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Aadhar Back Photo </label> (<span style="color: crimson; font-size: 13px;"><b style="color: red;">*</b> Upload Image Only and Image must be in jpeg, png, gif format</span>)
                                    <input type="file" class="form-control" name="adhar_back_photo" accept="image/png, image/gif, image/jpeg">
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

    <?php include 'includes/footer.php'; ?>

    
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

