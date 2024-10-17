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
                        <div class="ibox-title">Voter Card</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-control-label">Upload Profile Photo</label>
                                    <input type="file" name="profile_photo" class="form-control" accept="image/png, image/gif, image/jpeg" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Language <b style="color: red;">*</b></label>
                                    <select name="language" class="form-control" id="language">
                                        <option value="">-- Select Language --</option>
                                        <?php foreach ($languages as $language) : ?>
                                            <option value="<?= $language['language_code']; ?>"><?= $language['language']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Epic No <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="epic_no" name="epic_no" value="<?= $result['epic_no']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Name <b style="color: red;">*</b> </label>
                                    <input class="form-control" type="text" id="name" name="name" value="<?= $result['name']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Full Name To Local Language </label>
                                    <input class="form-control " type="text" id="name_local" name="full_name_local_language" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                <label class="form-control-label">Select Father/Husband</label>
                                    <select name="f_h_type" class="form-control">
                                        <option>Select</option>
                                        <option value="Father">Father</option>
                                        <option value="Husband">Husband</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="form-control-label">Father/Husband Name</label>
                                    <input type="text" class="form-control" id="f_h_name" name="f_h_name" value="<?= $result['father_name']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Father/Husband Name To Local Language </label>
                                    <input class="form-control " type="text" id="f_h_name_local" name="f_h_name_local_language" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Gender <b style="color: red;">*</b></label>
                                    <select name="gender" class="form-control" id="gender" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Date of Birth<b style="color: red;">*</b></label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="dob" required>
                                        <!-- <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div> -->
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Assembly Constituency Number and Name </label>
                                    <input class="form-control " id="assembly" type="text" name="assembly" value="<?= $result['ac_no'] . ' - ' . $result['ac_name']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Assembly Constituency Number and Name </label>
                                    <input class="form-control " id="assembly_local" type="text" name="assembly_local" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="form-control-label">Part Number</label>
                                    <input class="form-control " id="part_no" type="text" name="part_no" value="<?= $result['part_no']; ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-control-label">Part Name </label>
                                    <input class="form-control " id="part_name" type="text" name="part_name" value="<?= $result['part_name']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Part Name Local Language </label>
                                    <input class="form-control " id="part_name_local" type="text" name="part_name_local" readonly>
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
                                    <input type="submit" value="Submit" class="btn btn-primary" name="submitbtn">
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