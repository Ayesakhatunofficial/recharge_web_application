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
                        <div class="ibox-title">Edit Commission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" id="editcommissionForm">
                            <div class="row">
                                <!----------------- User Type ------------------->

                                <div class="form-group col-md-6">
                                    <input type="hidden" name="id" value="<?= $commission['id']; ?>">
                                    <label class="form-control-label">User Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='user_type'>
                                        <?php
                                        foreach ($user_types as $user_type) : ($user_type['slug'] == $commission['user_type']) ? $selected = "selected" : $selected = "";
                                        ?>
                                            <option value="<?= $user_type['slug']; ?>" <?= $selected; ?>><?= $user_type['user_type']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">User </label>
                                    <?php $user = $this->db->get_where('users', ['id' => $commission['user_id']])->row_array(); ?>
                                    <input type="text" class="form-control" readonly value="<?= $user['name']; ?>" name="user">
                                </div>

                                <!---------------------- Plan --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">Plan <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="plan">
                                        <?php
                                        // foreach ($plans as $plan) : ($plan['id'] == $commission['plan']) ? $selected = "selected" : $selected = "";
                                        ?>
                                            <option value="<? //= $plan['id']; 
                                                            ?>" <?= $selected; ?>><?= $plan['plan_name']; ?></option>
                                        <? //php endforeach; 
                                        ?>
                                    </select>
                                </div> -->

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
                                    }else if ($commission['service'] == 'cable') {
                                        $service = 'Cable';
                                    }else if ($commission['service'] == 'subscription') {
                                        $service = 'Subscriptions';
                                    }else if ($commission['service'] == 'bus_booking') {
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
                                    <input type="text" class="form-control" readonly name="mob_operator" value="<?= isset($operators['operator']) ? $operators['operator'] : $commission['mob_operator']; ?>">
                                </div>

                                <!------------------------ commission type --------------------------->

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Commission Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="commission_type" required>
                                        <option value="">Select Type</option>
                                        <option value="flat" <?php if ($commission['commission_type'] == 'flat') {
                                                                    echo "selected";
                                                                } ?>>Flat</option>
                                        <option value="percent" <?php if ($commission['commission_type'] == 'percent') {
                                                                    echo "selected";
                                                                } ?>>Percentage</option>
                                    </select>
                                </div>

                                <!----------------- Flat/percentage amount -------------------------------->

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Commission Rate <b style="color: red;">*</b></label>
                                    <input type="decimal" class="form-control" name="fp_amount" placeholder="Percentage Amount" value="<?= $commission['fp_amount']; ?>">
                                </div>

                                <!------------------ From Amount --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">From Amount <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="from_amount" placeholder="From Amount" value="<?= $commission['from_amount']; ?>">
                                </div> -->

                                <!------------------ To Amount --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">To Amount <b style="color: red;">*</b></label>
                                    <input type="text" class="form-control" name="to_amount" placeholder="To Amount" value="<?= $commission['to_amount']; ?>">
                                </div> -->

                                <!------------------ TDS / GST --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">TDS / GST (%) </label>
                                    <input type="text" class="form-control" name="tds_gst" placeholder="TDS/GST (%)" value="<?= $commission['tds_gst']; ?>">
                                </div> -->

                                <!------------------------ Chain Type --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">Chain Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="chain_type" required>
                                        <option value="abc" <?= ($commission['chain_type'] == 'abc') ? "selected" : ""; ?>>ABC</option>
                                        <option value="xyz" <?= ($commission['chain_type'] == 'xyz') ? "selected" : ""; ?>>XYZ</option>
                                    </select>
                                </div> -->

                                <!------------------------ Transaction Type --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">Transaction Type <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name="transaction_type" required>
                                        <option value="cr" <?= ($commission['transaction_type'] == 'cr') ? "selected" : ""; ?>>Credit</option>
                                        <option value="dr" <?= ($commission['transaction_type'] == 'dr') ? "selected" : ""; ?>>Debit</option>
                                    </select>
                                </div> -->

                                <!--------------- For any specific user --------------------------->

                                <!-- <div class="col-md-6 form-group">
                                    <label class="form-control-label">For Any Specific User </label>
                                    <input type="text" class="form-control" name="specific_user" placeholder="For Any Specific User" value="<?= $commission['specific_user']; ?>">
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