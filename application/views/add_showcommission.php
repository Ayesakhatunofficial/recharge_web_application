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
                        <div class="ibox-title">Add Show Commission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>


                    <div class="ibox-body">

                        <form action="<?= base_url('showcommission/add') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">

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
                                    <select class="form-control select2_demo_1" name="operator" id="operator">
                                        <option value="">First Select Service</option>
                                    </select>
                                </div>


                                <!------------------------   operator logo  --------------->

                                <div class="col-md-6 form-group">
                                    <label for="" class="form-control-label">Logo <b style="color: red;">*</b></label>

                                    <input type="file" class="form-control" name="op_logo">
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
                                    <input type="decimal" class="form-control" name="amount" placeholder="Flat/Percentage Amount" required>
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

    <script>
        function getOperator() {
            var service = document.getElementById("service").value;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('showcommission/getOperator') ?>',
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