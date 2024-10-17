<?php

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<style>
    #table tr td {
        border-top: 0px solid #fff !important;
    }
</style>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Upi Payment Report</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label class="form-control-label">From Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="from_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="form-control-label">To Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="to_date">
                                    </div>
                                </div>

                                <div class="col-md-2 form-group">
                                    <br>
                                    <input type="submit" class="btn btn-primary" value="Search" style="margin-top: 8px; width: 100%;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <?php
                        $total_amount = 0;
                        if (!empty($upi_reports)) {

                            foreach ($upi_reports as $amount) {
                                $total_amount += $amount['amount'];
                            }
                        }
                        ?>
                        <div class="ibox-title">Show Upi Payment Report || Total : ₹ <?= $total_amount; ?></div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body" style="padding-left: 0;padding-right: 0;" id="table-id">
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover" id="viewdl" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>TXN ID</th>
                                        <th>UTR No</th>
                                        <!-- <th>Type</th> -->
                                        <th>Customers</th>
                                        <th>Amount(₹)</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($upi_reports)) {

                                        foreach ($upi_reports as $data) { ?>
                                            <tr>
                                                <td><?= (new DateTime($data['credited_at']))->format('d-m-Y H:i:s a') ?></td>
                                                <td><?= $data['txn_id'] ?> <br> <?= $data['client_orderid'] ?></td>
                                                <td><?= $data['bank_ref_num'] ?></td>

                                                <!-- <td><? //= $data['bene_account_no']
                                                            ?> <br> Received - <? //=$data['payment_type']
                                                                                ?></td> -->
                                                <td><?= $data['cust_mobile'] ?> <br> <?= $data['rmtr_full_name'] ?><br> <?= $data['user_name'] ?><br><?= $data['user_type'] ?> </td>
                                                <td><?= $data['amount'] ?></td>
                                                <td><?= $data['rmtr_to_bene_note'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($data['rmtr_account_ifsc'] == 'Txn Success') {
                                                        echo "<b class='text-success'>COMPLETED</b>";
                                                    } else {
                                                        echo "<b class='text-danger'>WARNING</b>";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>

    <script type="text/javascript">
        $(function() {
            $('#viewdl').DataTable({
                pageLength: 10,
                order: {
                    column: 0,
                    order: 'desc'
                }

            });
        });
    </script>