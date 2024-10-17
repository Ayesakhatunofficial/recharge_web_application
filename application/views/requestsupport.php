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
                        <div class="ibox-title">Support Ticket Request</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">From Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="from_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">To Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="to_date">
                                    </div>
                                </div>

                                <div class="col-md-4 form-group">
                                    <br>
                                    <input type="submit" class="btn btn-primary" value="Search" style="margin-top: 8px; width: 100%;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <div class="ibox-title">Show Support Ticket Request</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body" style="padding-left: 0;padding-right: 0;" id="table-id">
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover" id="viewdl" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Support ID</th>
                                        <th>Date</th>
                                        <th>User Name</th>
                                        <th>User Type</th>
                                        <th>Mobile</th>
                                        <th>Problem Type</th>
                                        <th>Query</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($supports)) {
                                        $i = 1;
                                        foreach ($supports as $support) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?=$support['support_id']?></td>
                                                <td><?= $support['date']; ?></td>
                                                <td><?= $support['user_name'] ?></td>
                                                <td><?= $support['user_type']; ?></td>
                                                <td><?= $support['user_mobile']; ?></td>
                                                <td><?= $support['service_name']; ?></td>
                                                <td><?= $support['query']; ?></td>
                                                <td>
                                                    <img src="<?= base_url('uploads/' . $support['image']) ?>" alt="" width=80 height=50>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($support['status'] == 'pending') { ?>
                                                        <button class="btn btn-warning btn-sm"><?php echo 'PENDING'; ?></button>
                                                    <?php
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($support['status'] == 'pending') { ?>
                                                        <a href="#" class="btn btn-success btn-sm mb-2"  data-toggle="modal" data-target="#basicModal<?= $support['id'];?>"> Solved</a>
                                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal<?= $support['id']; ?>">Reject</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                    <?php $i++;
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

    <?php
    if (!empty($supports)) {
        foreach ($supports as $support) :
    ?>
            <!--------------------- Approved PAN modal --------------------->
            <!-- basic modal -->
            <div class="modal fade" id="basicModal<?= $support['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('supportticket/approved/' . $support['id']); ?>" method="post" enctype="multipart/form-data">
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

    <?php endforeach;
    } ?>

    <?php if (!empty($supports)) {
        foreach ($supports as $support) :  ?>
            <!--------------------- Reject PAN modal --------------------->
            <!-- basic modal -->
            <div class="modal fade" id="rejectModal<?= $support['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('supportticket/reject/' . $support['id']); ?>" method="post">
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
    <?php endforeach;
    } ?>


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