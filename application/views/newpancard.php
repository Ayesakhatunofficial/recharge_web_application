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
                        <div class="ibox-title">Add New PAN Card</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">if you are (+18/-18)</label>
                                    <select class="form-control" name="age_type" id="age">
                                        <option value="18-">18- Minor</option>
                                        <option value="18+">18+ Adult</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">PAN No <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="pan_no" maxlength="10" name="pan_no" required>
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
                                    <label class="form-control-label">Date of Birth<b style="color: red;">*</b></label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="dob">
                                        <!-- <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div> -->
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Gender <b style="color: red;">*</b></label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">-- Select Gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Photo </label> (<span style="color: crimson; font-size: 13px;"><b style="color: red;">*</b> Upload Image Only and Image must be in jpeg, png, gif format</span>)
                                    <input type="file" class="form-control" name="photo" accept="image/png, image/gif, image/jpeg">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Signature Photo </label> (<span style="color: crimson; font-size: 13px;"><b style="color: red;">*</b> Upload Image Only and Image must be in jpeg, png, gif format</span>)
                                    <input type="file" class="form-control" name="sign_photo" accept="image/png, image/gif, image/jpeg">
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