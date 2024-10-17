<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Wallet Recharge Manual</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">

                        <form action="" method="post">
                            <div class="row">
                                <!-- <div class="form-group col-md-6">
                                    <label class="form-control-label">Mobile </label>
                                    <input class="form-control" type="number" id="mobile" name="mobile" required>
                                </div> -->
                                <!-- <div class="form-group col-md-6">
                                    <label class="form-control-label">Balance </label>
                                    <input class="form-control" type="number" id="balance" name="balance" readonly>
                                </div> -->
                                <div class="form-group col-md-6">
                                    <div class="upi-box">
                                        <center>
                                            <h5><b>Add Money Pay Via UPI Manual and Send Request </b></h5>
                                            <a class="upi-manual" href="<?php echo $url; ?>"><strong><?php echo $upi['upi']; ?></strong></a>
                                        </center>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Amount </label>
                                        <input class="form-control" type="number" name="amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">UTR No. </label>
                                        <input class="form-control" type="text" name="utr_no" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Narration </label>
                                        <textarea name="narration" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary" name="searchboxbtn">
                                        <a class="btn btn-danger" href="#">Reset</a>
                                    </div>
                                </div>




                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox ibox-warning">
            <div class="ibox-head">
                <div class="ibox-title">Wallet Reacharge History</div>
            </div>
            <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Type</th>
                            <th>Mobile No</th>
                            <th>Amount</th>
                            <th>UTR No</th>
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($datas as $data) { ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $data['user_type'] ?></td>
                                <td><?= $data['mobile']; ?></td>
                                <td><?= $data['amount'] ?></td>
                                <td><?= $data['txn_no'] ?></td>

                                <td><?= (new DateTime($data['create_date']))->format('d-m-Y') ?>
                                    <?= (new DateTime($data['create_time']))->format('H:i:s a') ?></td>
                                <td><?= $data['remarks'] ?></td>

                                <td><?php if ($data['status'] == 1) { ?><button class="btn btn-success btn-sm"><?php echo 'Approved'; ?></button>
                                    <?php }
                                    if ($data['status'] == 0) { ?><button class="btn btn-warning btn-sm"><?php echo 'Pending'; ?></button>
                                    <?php }
                                    if ($data['status'] == -1) { ?><button class="btn btn-danger btn-sm"><?php echo 'Rejected'; ?></button>
                                    <?php } ?></td>
                            </tr>
                        <?php $i++;
                        } ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT-->

<?php include 'includes/footer.php'; ?>