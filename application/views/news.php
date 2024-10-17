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
                        <div class="ibox-title">Update News</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <input type="hidden" value="<?= $news['id']?>" name="id">
                                    <label class="form-control-label">News<b style="color: red;">*</b></label>
                                    <textarea name="news" class="form-control" id="" cols="30" rows="10" required><?=$news['news']?></textarea>
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