<?php
// print_r($operator); die;
// foreach($mob_operators as $mob_operator){
//     echo $mob_operator['opcode'] . '<br>'; 
// }die;
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
                        <div class="ibox-title">Edit Operator</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" id="editoperator" enctype="multipart/form-data">
                            <div class="row">

                                <!----------------- User Type ------------------->

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Operator Code <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="op_code" placeholder="Enter Operator Code" required value="<?= $operator['opcode']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Operator <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="op_name" placeholder="Enter Operator Name" required value="<?= $operator['operator']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Operator Logo <b style="color: red;">*</b></label><br>
                                    <?php echo $operator['op_logo']; ?>
                                    <input type="file" class="form-control" name="op_logo" value="">
                                    <span><?= (isset($upload_error)) ? $upload_error : ""; ?></span>
                                </div>


                                <!-------------------- Submit Button ------------------------->

                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary btn-lg" name="submitBtn" type="submit">Update</button>
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