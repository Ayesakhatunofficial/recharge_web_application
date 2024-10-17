<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox ibox-warning">
            <div class="ibox-head">
                <div class="ibox-title">KYC Details</div>
            </div>
            <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                <div class="ibox-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Information Type</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>User id</td>
                                <td><?php echo $result['user_id']; ?></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Name</td>
                                <td><?php echo $result['name']; ?></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Mobile No</td>
                                <td><?php echo $result['mobile']; ?></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Firm Name</td>
                                <td><?php echo $result['firm_name']; ?></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Aadhar No</td>
                                <td><?php echo $result['adhar']; ?></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>PAN No</td>
                                <td><?php echo $result['pan']; ?></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Aadhar Front</td>
                                <td>
                                    <a href="<?php echo base_url('uploads/' . $result['adhar_front']); ?>" class="btn btn-warning btn-sm">View</a>
                                    <a href="<?php echo base_url('Download/index/' . $result['id'] . '/f'); ?>" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Aadhar Back</td>
                                <td>
                                    <a href="<?php echo base_url('uploads/' . $result['adhar_back']); ?>" class="btn btn-warning btn-sm">View</a>
                                    <a href="<?php echo base_url('Download/index/' . $result['id'] . '/b'); ?>" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>PAN Card</td>
                                <td>
                                    <a href="<?php echo base_url('uploads/' . $result['pan_image']); ?>" class="btn btn-warning btn-sm">Vew</a>
                                    <a href="<?php echo base_url('Download/index/' . $result['id'] . '/p'); ?>" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Photo</td>
                                <td>
                                    <a href="<?php echo base_url('uploads/' . $result['photo']); ?>" class="btn btn-warning btn-sm">Vew</a>
                                    <a href="<?php echo base_url('Download/index/' . $result['id'] . '/ph'); ?>" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Bank Passbook</td>
                                <td>
                                    <a href="<?php echo base_url('uploads/' . $result['bank_passbook_image']); ?>" class="btn btn-warning btn-sm">Vew</a>
                                    <a href="<?php echo base_url('Download/index/' . $result['id'] . '/pb'); ?>" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <center>
                        <?php
                        if ($result['is_kyc_verified'] == 0) {
                        ?>
                            <a href="<?php echo base_url('Kycapprove/index/' . $result['id']); ?>"><button class="btn btn-danger btn-lg" name="kycapproveBtn">KYC Aproved</button></a>
                    </center>
                <?php    } else { ?>

                    <a href="<?php echo base_url('viewusers'); ?>"><button class="btn btn-success btn-lg" name="kycapproveBtn">KYC Aproved</button></a>
                <?php } ?>

                </center>
                </div>
            </div>
        </div>

    </div>
    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>