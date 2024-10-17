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
                        <div class="ibox-title">New Driving License</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">DL Number <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="dl_no" maxlength="20" name="dl_no" placeholder="WB25 20220002736" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Full Name <b style="color: red;">*</b></label>
                                    <input class="form-control" type="text" name="name" id='name' placeholder="Name" required>
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
                                    <label class="form-control-label">DTO Office</label>
                                    <input class="form-control " type="text" id = "dto_office" name="dto_office">
                                </div>
                                <div class="form-group col-md-4" >
                                    <label class="form-control-label">State <b style="color: red;">*</b></label>
                                    <select name="state" class="form-control" id="state">
                                        <option value="">-- Select State --</option>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?= $state['state']; ?>"><?= $state['state']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">District</label>
                                    <input class="form-control " id="district" type="text" name="district">
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