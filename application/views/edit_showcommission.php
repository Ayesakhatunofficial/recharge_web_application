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
                        <div class="ibox-title">Edit Show Commission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>


                    <div class="ibox-body">

                        <form action="<?= base_url('showcommission/edit/' . $commission['id']) ?>" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <!------------------------ Service --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Service <b style="color: red;">*</b></label>

                                    <?php
                                    if ($commission['service'] == 'mobile') {
                                        $service = 'Mobile Recharge';
                                    } else if ($commission['service'] == 'dth') {
                                        $service = "DTH Recharge";
                                    } else if ($commission['service'] == 'electric') {
                                        $service = 'Electric Bill';
                                    } else if ($commission['service'] == 'loan') {
                                        $service = 'Loan Payment';
                                    } else if ($commission['service'] == 'postpaid') {
                                        $service = 'PostPaid Bill';
                                    } else if ($commission['service'] == 'fastag') {
                                        $service = 'FASTag Recharge';
                                    } else if ($commission['service'] == 'lpg_gas') {
                                        $service = 'LPG Gas';
                                    } else if ($commission['service'] == 'insurance') {
                                        $service = 'Insurance';
                                    } else if ($commission['service'] == 'broadband') {
                                        $service = 'Broadband';
                                    } else if ($commission['service'] == 'municiple') {
                                        $service = 'Municiple Service';
                                    } else if ($commission['service'] == 'credit') {
                                        $service = 'Credit Card';
                                    } else if ($commission['service'] == 'landline') {
                                        $service = 'Landline';
                                    } else if ($commission['service'] == 'cable') {
                                        $service = 'Cable';
                                    } else if ($commission['service'] == 'subscription') {
                                        $service = 'Subscriptions';
                                    } else if ($commission['service'] == 'bus_booking') {
                                        $service = 'Bus Booking';
                                    } else {
                                        $service = $commission['service'];
                                    }
                                    ?>
                                    <input type="text" class="form-control" value="<?= $service; ?>" name="service_name" readonly>

                                </div>

                                <!------------------------ Mobile Operator --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label"> Operator <b style="color: red;">*</b> </label>
                                    <input type="text" class="form-control" readonly name="operator" value="<?= isset($operators['operator']) ? $operators['operator'] : $commission['operator_code']; ?>">
                                </div>


                                <!------------------------   operator logo  --------------->

                                <div class="col-md-6 form-group">
                                    <label for="" class="form-control-label">Logo </label>

                                    <input type="file" class="form-control" name="op_logo">
                                </div>



                                <!------------------------ commission type --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Commission Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="commission_type" required>
                                        <option value="">Select Type</option>
                                        <option value="flat" <?php if ($commission['type'] == 'flat') {
                                                                    echo "selected";
                                                                } ?>>Flat</option>
                                        <option value="percent" <?php if ($commission['type'] == 'percent') {
                                                                    echo "selected";
                                                                } ?>>Percentage</option>
                                    </select>
                                </div>

                                <!----------------- Flat/percentage amount -------------------------------->

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Commission Rate <b style="color: red;">*</b></label>
                                    <input type="decimal" class="form-control" name="amount" placeholder="Flat/Percentage Amount" required value="<?= $commission['amount'] ?>">
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