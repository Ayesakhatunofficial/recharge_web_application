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
                        <div class="ibox-title">Add Operator</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <!----------------- User Type ------------------->
                                <div class="form-group col-md-6">
                                    <label class="form-control-label"> Service <b style="color: red;">*</b></label>
                                    <select class="form-control " name="service" id="" required>
                                        <option value="">Select Service</option>
                                        <option value="mobile">Mobile Recharge</option>
                                        <option value="dth">DTH Recharge</option>
                                        <option value="electric_bill">Electric Bill Payment</option>
                                        <option value="postpaid">Post Paid Bill</option>
                                        <option value="fastag">FASTag Recharge</option>
                                        <option value="loan">Loan Payment</option>
                                        <option value="lpg_gas">LPG Gas</option>
                                        <option value="insurance">Insurance</option>
                                        <option value="broadband">Broadband</option>
                                        <option value="municiple">Municiple Service</option>
                                        <option value="credit">Credit Card</option>
                                        <option value="landline">Landline</option>
                                        <option value="cable">Cable</option>
                                        <option value="subscription">Subscriptions</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Operator/Service Code <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="op_code" placeholder="Enter Operator/Service Code" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Operator <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="op_name" placeholder="Enter Operator Name" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Operator Logo <b style="color: red;">*</b></label>
                                    <input type="file" class="form-control" name="op_logo">
                                    <span><?= (isset($upload_error)) ? $upload_error : ""; ?></span>
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