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
                        <div class="ibox-title">Add Commission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post">
                            <div class="row">

                                <!----------------- User Type ------------------->

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">User Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='user_type' id="user_type" required onchange="getUser()">
                                        <option value="">Select User Type</option>
                                        <?php foreach ($user_types as $user_type) : ?>
                                            <option value="<?= $user_type['slug']; ?>"><?= $user_type['user_type']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">User </label>
                                    <select class="form-control select2_demo_1" name='user' id="user">
                                        <option value="">First Select User Type</option>
                                    </select>
                                </div>

                                <!---------------------- Plan --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">Plan <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="plan" required>
                                        <? //php foreach ($plans as $plan) : 
                                        ?>
                                            <option value="<?= $plan['slug']; ?>"><?= $plan['plan_name']; ?></option>
                                        <? //php endforeach; 
                                        ?>
                                    </select>
                                </div> -->

                                <!------------------------ Service --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Service <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="service_name" id="service" onchange="getOperator()" required>
                                        <option value="">Select Services</option>
                                        <option value="mobile">Mobile Recharge</option>
                                        <option value="dth">DTH Recharge</option>
                                        <option value="electric">Electric Bill</option>
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
                                        <option value="bus_booking">Bus Booking</option>
                                    </select>
                                </div>

                                <!------------------------ Mobile Operator --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label"> Operator <b style="color: red;">*</b> </label>
                                    <select class="form-control select2_demo_1" name="mob_operator" id="operator">
                                       <option value="">First Select Service</option>
                                    </select>
                                </div>

                                

                                <!------------------------ commission type --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Commission Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="commission_type" required>
                                        <option value="">Select Type</option>
                                        <option value="flat">Flat</option>
                                        <option value="percent">Percentage</option>
                                    </select>
                                </div>

                                <!----------------- Flat/percentage amount -------------------------------->

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Commission Rate <b style="color: red;">*</b></label>
                                    <input type="decimal" class="form-control" name="fp_amount" placeholder="Flat/Percentage Amount" required>
                                </div>

                                <!------------------ From Amount --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">From Amount <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="from_amount" placeholder="From Amount" required>
                                </div> -->

                                <!------------------ To Amount --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">To Amount <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="to_amount" placeholder="To Amount" required>
                                </div> -->

                                <!------------------ TDS / GST --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">TDS / GST (%) </label>
                                    <input type="text" class="form-control" name="tds_gst" placeholder="TDS/GST (%)">
                                </div> -->

                                <!------------------------ Chain Type --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">Chain Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="chain_type" required>
                                        <option value="abc">ABC</option>
                                        <option value="xyz">XYZ</option>
                                    </select>
                                </div> -->

                                <!------------------------ Transaction Type --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">Transaction Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="transaction_type" required>
                                        <option value="cr">Credit</option>
                                        <option value="dr">Debit</option>
                                    </select>
                                </div> -->

                                <!--------------- For any specific user --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">For Any Specific User </label>
                                    <input type="text" class="form-control" name="specific_user" placeholder="For Any Specific User">
                                </div> -->

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

    <script>
        function getUser() {
            var user_type = document.getElementById("user_type").value;
            // alert(user_type);die;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('addcommission/getUser') ?>',
                data: {
                    user_type: user_type,
                },
                dataType: "json",
                success: function(data) {
                    $("#user").html(data.options);
                }
            });
        }

        function getOperator(){
            var service = document.getElementById("service").value;
            $.ajax({
               type: 'POST',
               url: '<?= base_url('addcommission/getOperator')?>',
               data: {
                service: service,
               },
               dataType: "json",
               success: function(data) {
                $("#operator").html(data.options);
               } 
            });
        }
    </script>