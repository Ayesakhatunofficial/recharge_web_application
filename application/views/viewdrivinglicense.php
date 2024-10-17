<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Search Driving License</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="form-control-label">From Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="from_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label">To Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="to_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label">Driving License No</label>
                                    <input class="form-control" type="text" id="dl_no" name="dl_no">
                                </div>
                                <div class="col-md-3 form-group">
                                    <br>
                                    <input type="submit" class="btn btn-primary" value="Search" style="margin-top: 8px; width: 100%;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <div class="ibox-title">Show Driving License</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover" id="viewdl" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Action</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>User Name</th>
                                        <th>User Mobile</th>
                                        <th>User Type</th>
                                        <th>DL Number</th>
                                        <th>Create Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($dl_nos as $dl_no) { ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?php if ($dl_no['status'] == 0) { ?>
                                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal<?= $dl_no['id']; ?>">Reject</a>

                                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#basicModal<?= $dl_no['id']; ?>">Approved</a>
                                                <?php } ?>
                                                <?php if ($dl_no['status'] == 1) { ?>
                                                    <a href="<?= base_url('DL_uploads/' . $dl_no['pdf_file']); ?>" class="btn btn-success text-center">PDF</a>
                                                <?php } ?>
                                                <a href="<?= base_url('Deletedl/index/' . $dl_no['id']); ?>" class="btn btn-danger my-2">Delete</a>
                                            </td>
                                            <td><textarea readonly><?= $dl_no['remarks']; ?></textarea></td>
                                            <?php
                                            $fees = $this->db->get_where('payment_fees', ['id_type' => 'Driving License'])->row_array();
                                            ?>
                                            <td>
                                                <?php if ($dl_no['status'] == 1) { ?>
                                                    <div class="alert-success text-center">Approved</div>
                                                <?php } else if ($dl_no['status'] == 0) { ?>
                                                    <div class="alert-info text-center">Pending</div>
                                                <?php } else if ($dl_no['status'] == -1) { ?>
                                                    <div class="alert-danger text-center">Rejected</div>
                                                <?php } ?>
                                                <?php if ($dl_no['is_pay_print'] == 0 && $dl_no['status'] == 1) {  ?>
                                                    <a href="<?= base_url('Paytm/index/' . $dl_no['dl_no'] . '/' . $fees['fees'] . '/DL-pay'); ?>" class="btn btn-success my-3">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($dl_no['is_pay_print'] == 1) { ?>
                                                    <label class="alert-success text-center w-100">Paid</label>
                                                <?php } else { ?>
                                                    <label class="alert-danger text-center w-100">Unpaid</label>
                                                <?php } ?>
                                            </td>
                                            <td>Anil Rao</td>
                                            <td>9876543210</td>
                                            <td>Retailer</td>
                                            <td>
                                                <?= $dl_no['dl_no']; ?>
                                                <a href="#" class="btn btn-info my-2" data-toggle="modal" data-target="#viewModal<?= $dl_no['id']; ?>">View</a>
                                            </td>
                                            <td><?= $dl_no['create_date']; ?></td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($dl_nos as $dl_no) :  ?>
        <!--------------------- View Driving lincence details modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="viewModal<?= $dl_no['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Driving License Details </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $view = $this->db->get_where('dl_details', ['id' => $dl_no['id']])->row_array();
                        ?>
                        <table class="table" id="table" border="0">
                            <tr>
                                <td>Name: <?= $view['name']; ?> </td>
                                <td>DL No: <?= $view['dl_no']; ?> </td>
                            </tr>
                            <tr>
                                <td>Date Of Birth <?= $view['dob']; ?></td>
                                <td>DTO Office: <?= $view['dto_office']; ?></td>
                            </tr>
                            <tr>
                                <td>State: <?= $view['state']; ?></td>
                                <td>District: <?= $view['district']; ?></td>
                            </tr>
                            <tr>
                                <td>Application Status:
                                    <?php
                                    if ($view['status'] == 0) {
                                        echo '<div class="alert-info text-center">Pending</div>';
                                    } else if ($view['status'] == 1) {
                                        echo '<div class="alert-success text-center">Approved</div>';
                                    } else if ($view['status'] == -1) {
                                        echo '<div class="alert-danger text-center">Rejected</div>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <?php foreach ($dl_nos as $dl_no) :  ?>
        <!--------------------- Approved DL modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="basicModal<?= $dl_no['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Upload PDF</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('Approvedl/index/' . $dl_no['id']); ?>" method="post" enctype="multipart/form-data">
                            <div class="col-md-12 form-group">
                                <input type="file" class="form-control" name="pdf_file">
                                <span style="color: crimson; font-size: 13px;"><b style="color: red;">**</b> Upload PDF Only </span>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-lg" name="submitBtn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <?php foreach ($dl_nos as $dl_no) :  ?>
        <!--------------------- Reject DL modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="rejectModal<?= $dl_no['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('Rejectdl/index/' . $dl_no['id']); ?>" method="post">
                            <div class="col-md-12 form-group">
                                <textarea name="remarks" class="form-control" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-lg" name="submitBtn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>

    <script type="text/javascript">
        $(function() {
            $('#viewdl').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
        });
    </script>