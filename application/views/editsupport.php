<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Support Ticket | Edit Your Query</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                          
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">User Mobile </label>
                                    <input class="form-control" type="text" id="mobile" name="mobile" value="<?=isset($support['user_mobile']) ? $support['user_mobile'] : '' ?>" required readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">User Name</label>
                                    <input class="form-control" type="text" id="balance" value="<?=isset($support['user_name']) ? $support['user_name'] : '' ?>" name="user_name" required readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">User Type</label>
                                    <input class="form-control" type="text" name="user_type" value="<?=isset($support['user_type']) ? $support['user_type'] : '' ?>" required readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Select Problem Type</label>
                                    <select name="problem_type" id="" class="form-control">
                                        <option value="">--Select--</option>
                                        <?php  foreach($services as $service){ ?>
                                        <option value="<?=$service['id']?>" <?php if ($service['id'] == $support['problem_type']) echo 'selected' ?>><?=$service['service_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Write Your Query Here</label>
                                    <textarea name="query" class="form-control" ><?= $support['query']?></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Image</label>
                                    <input type="file" class="form-control" name="problem_photo" value="<?=$support['image']?>">
                                    <div><?= $support['image'] ?></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="submit" value="Submit" class="btn btn-primary" name="searchboxbtn">
                                    <!-- <a class="btn btn-danger" href="#">Reset</a> -->
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