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
                        <div class="ibox-title">Payment Gateway</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post">
                            <div class="row">
                                <!----------------- service Type ------------------->
                                <div class="form-group col-md-6 w-100">
                                    <input type="hidden" name="id" value="<?= (isset($result['id'])) ? $result['id'] : "" ?>">
                                    <label class="form-control-label">Payment Gateway</label>
                                    <input type="text" class="form-control" name="service" value="<?= (isset($result['service_name'])) ? $result['service_name'] : ""; ?>">
                                </div>

                                <!------------------- LIVE / STAGEING -------------------------->

                                <div class="form-group col-md-6 w-100">
                                    <label class="form-control-label">LIVE / TESTING</label>
                                    <select name="live_test" id="live_test" class="form-control">
                                        <option value="TESTING">TESTING</option>
                                        <option value="LIVE">LIVE</option>
                                    </select>
                                </div>

                                <!-----------------  secret key  ------------------->
                                <div class="form-group col-md-6 w-100">
                                    <label class="form-control-label">Secret Key (MID)</label>
                                    <input type="text" class="form-control" name="secret_key" placeholder="Secret Key" value="<?= (isset($result['secret_key'])) ? $result['secret_key'] : ""; ?>">
                                </div>

                                <!----------------- authentication key  ------------------->
                                <div class="form-group col-md-6 w-100">
                                    <label class="form-control-label">Authentication Key (M KEY)</label>
                                    <input type="text" class="form-control" name="authentication_key" placeholder="Authentication Key" value="<?= (isset($result['secret_key'])) ? $result['authentication_key'] : ""; ?>">
                                </div>

                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary btn-lg" type="submit" name="submitBtn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>

                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">API Details</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1-1" aria-expanded="true">
                                <table class="table table-striped table-bordered table-hover" id="api-settings" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service</th>
                                            <th>LIVE / TESTING</th>
                                            <th>Secret Key</th>
                                            <th>Authentication Key</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($api_settings as $api) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $api['service']; ?></td>
                                                <td><?= $api['live_test']; ?></td>
                                                <td><?= $api['secret_key']; ?></td>
                                                <td><?= $api['authentication_key']; ?></td>
                                                <td><?= $api['create_date']; ?></td>
                                                <td>
                                                    <?php if ($api['status'] == 1) { ?>
                                                        <a href="<?= base_url('Apisettingsstatus/index/' . $api['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $api['status']; ?>">Active</button></a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('Apisettingsstatus/index/' . $api['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $api['status']; ?>">Inactive</button></a>
                                                    <?php } ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Apisettings/index/' . $api['id']); ?>" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Apisettings/index/' . $api['id'] . '/del'); ?>" class="btn btn-danger delBtn btn-circle"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>