<?php
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

                        <?php if (!empty($terms)) { ?>

                            <div class="ibox-title">Update Terms and Conditions URL</div>

                        <?php } else { ?>

                            <div class="ibox-title">Add Terms and Conditions URL</div>

                        <?php } ?>

                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>

                    </div>


                    <div class="ibox-body">

                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="row">

                                <input type="hidden" value="<?= isset($terms['id']) ? $terms['id'] : '' ?>" name="id">

                                <div class="form-group col-md-12">

                                    <label class="form-control-label">URL<b style="color: red;">*</b></label>

                                    <input type="text" name="url" placeholder="Enter Terms and Conditions URL" class="form-control" value="<?= isset($terms['url']) ? $terms['url'] : '' ?>">

                                </div>


                                <!-------------------- Submit Button ------------------------->

                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary btn-lg" name="submitBtn" type="submit">Submit</button>
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