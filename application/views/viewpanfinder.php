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
                        <div class="ibox-title">List Pan Number Finder Request</div>
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
                                    <label class="form-control-label">Aadhar Number</label>
                                    <input class="form-control" type="text" id="adhar_no" maxlength="14" name="adhar_no" onblur="adharNo()" placeholder="12XX-XXXX-XX78">
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
                        <div class="ibox-title">Show PAN Finder Request</div>
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
                                        <th>User Type</th>
                                        <th>Aadhar Number</th>
                                        <th>Full Name</th>
                                        <th>Father Name</th>
                                        <th>Aadhar Front Photo</th>
                                        <th>Aadhar Back Photo</th>
                                        <th>Create Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($panfinders as $panfinder) { ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-info my-2" data-toggle="modal" data-target="#viewModal<?= $panfinder['id']; ?>">View</a>

                                                <?php if ($panfinder['status'] == 0) { ?>
                                                    <a href="#" class="btn btn-danger my-2" data-toggle="modal" data-target="#rejectModal<?= $panfinder['id']; ?>">Reject</a>

                                                    <a href="#" class="btn btn-success my-2" data-toggle="modal" data-target="#basicModal<?= $panfinder['id']; ?>">Approved</a>
                                                <?php } ?>
                                                <a href="<?= base_url('Deletepan/index/' . $panfinder['id']); ?>" class="btn btn-danger my-2">Delete</a>
                                            </td>
                                            <td><textarea readonly><?= $panfinder['remarks']; ?></textarea></td>
                                            <td>
                                                <?php if ($panfinder['status'] == 1) { ?>
                                                    <div class="alert-success text-center">Approved</div>
                                                <?php } else if ($panfinder['status'] == 0) { ?>
                                                    <div class="alert-info text-center">Pending</div>
                                                <?php } else if ($panfinder['status'] == -1) { ?>
                                                    <div class="alert-danger text-center">Rejected</div>
                                                <?php } ?>
                                                <?php if ($panfinder['is_pay_print'] == 0 && $panfinder['status'] == 1) {  ?>
                                                    <?php
                                                    $fees = $this->db->get_where('payment_fees', ['id_type' => 'PAN FINDER '])->row_array();
                                                    ?>
                                                    <a href="<?= base_url('Paytm/index/' . $panfinder['adhar_no'].'/'.$fees['fees'].'/panfinder-pay'); ?>" class="btn btn-success my-3">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($panfinder['is_pay_print'] == 1) { ?>
                                                    <label class="alert-success text-center w-100">Paid</label>
                                                <?php } else { ?>
                                                    <label class="alert-danger text-center w-100">Unpaid</label>
                                                <?php } ?>
                                            </td>
                                            <td> Abhijit Mondal </td>
                                            <td>Retailer</td>
                                            <td><?= $panfinder['adhar_no']; ?></td>
                                            <td><?= $panfinder['full_name']; ?></td>
                                            <td><?= $panfinder['father_name']; ?></td>
                                            <td>
                                                <img src="<?= base_url(); ?>/pan_uploads/<?= $panfinder['adhar_front_photo']; ?>" alt="" width="100px" height="auto">
                                            </td>
                                            <td>
                                                <img src="<?= base_url(); ?>/pan_uploads/<?= $panfinder['adhar_back_photo']; ?>" alt="" width="100px" height="auto">
                                            </td>
                                            <td><?= $panfinder['create_date']; ?></td>
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

    <?php foreach ($panfinders as $panfinder) :  ?>
        <!--------------------- View PAN modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="viewModal<?= $panfinder['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">PAN Details </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $view = $this->db->get_where('panfinder', ['id' => $panfinder['id']])->row_array();
                        ?>
                        <table class="table" id="table" border="0">
                            <tr>
                                <td>User Name: Abhijit Mondal </td>
                                <td>User Type: Retailer</td>
                            </tr>
                            <tr>
                                <td>Aadhar Number: <?= $view['adhar_no']; ?></td>
                                <td>Full Name: <?= $view['full_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Father Name: <?= $view['father_name']; ?></td>
                                <td>Create Date: <?= $view['create_date']; ?></td>
                            </tr>
                            <tr>
                                <td>Aadhar Front Photo: <img src="<?= base_url(); ?>/pan_uploads/<?= $view['adhar_front_photo']; ?>" alt="" width="100px" height="auto"> </td>
                                <td>Aadhar Back Photo: <img src="<?= base_url(); ?>/pan_uploads/<?= $view['adhar_back_photo']; ?>" alt="" width="100px" height="auto"></td>
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
                                <td>Payment Status:
                                    <?php
                                    if ($view['is_pay_print'] == 1) {
                                        echo '<label class="alert-success text-center w-100">Paid</label>';
                                    } else if ($view['is_pay_print'] == 0) {
                                        echo '<label class="alert-danger text-center w-100">Unpaid</label>';
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

    <?php foreach ($panfinders as $panfinder) :  ?>
        <!--------------------- Approved PAN modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="basicModal<?= $panfinder['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('Approvepan/index/' . $panfinder['id']); ?>" method="post" enctype="multipart/form-data">
                            <div class="col-md-12 form-group">
                                <textarea name="remarks" class="form-control"></textarea>
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

    <?php foreach ($panfinders as $panfinder) :  ?>
        <!--------------------- Reject PAN modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="rejectModal<?= $panfinder['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('Rejectpan/index/' . $panfinder['id']); ?>" method="post">
                            <div class="col-md-12 form-group">
                                <textarea name="remarks" class="form-control"></textarea>
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