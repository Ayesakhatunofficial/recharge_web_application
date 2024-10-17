<?php

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
                        <div class="ibox-title">Add UPI</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <!----------------- User Type ------------------->
                                <input type="hidden" name="id" value="<?= !empty($upi_data['id']) ? $upi_data['id'] : '' ?>">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">UPI </label>
                                    <input type="text" class="form-control" name="upi" placeholder="Enter UPI" value="<?= !empty($upi_data['upi']) ? $upi_data['upi'] : '' ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Min. Amount </label>
                                    <input type="decimal" class="form-control" name="min_amount" placeholder="Enter Minimum Amount" value="<?= !empty($upi_data['min_amount']) ? $upi_data['min_amount'] : '' ?>">
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