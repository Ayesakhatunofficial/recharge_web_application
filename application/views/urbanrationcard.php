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
                        <div class="ibox-title">Add New Ration Card</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Ration Type</label>
                                    <input class="form-control" type="text" id="ration_type" value="Urban" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Ration Number <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="ration_no" name="ration_no" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Full Name <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="full_name" name="full_name" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Father Name <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="father_name" name="father_name" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Block <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="block" name="block" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Panchayat <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="panchayat" name="panchayat" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Village <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="village" name="village" required>
                                </div>
                                
                                <div class="form-group col-md-4" >
                                    <label class="form-control-label">State <b style="color: red;">*</b></label>
                                    <select name="state" class="form-control" id="state" required>
                                        <option value="">-- Select State --</option>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?= $state['state']; ?>"><?= $state['state']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-control-label">District <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" id="district" name="district" required>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Family Ration Card Photo <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="family_photo" accept="image/png, image/gif, image/jpeg">
                                    <span style="color: crimson; font-size: 13px;"><b style="color: red;">***</b> Upload Image Only and Image must be in jpeg, png, gif format</span>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Signature Photo <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="sign_photo" accept="image/png, image/gif, image/jpeg">
                                    <span style="color: crimson; font-size: 13px;"><b style="color: red;">***</b> Upload Image Only and Image must be in jpeg, png, gif format</span>
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