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
                        <div class="ibox-title">List Fund Request</div>
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
                                    <label class="form-control-label">Mobile</label>
                                    <input class="form-control" type="number" id="mobile" name="mobile">
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
                        <div class="ibox-title">Show Fund Request</div>
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
                                        <th>Action</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>User Type</th>
                                        <th>Amount</th>
                                        <th>Transaction No</th>
                                        <th>Date</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($listfundrequests)) {
                                        $i = 1;
                                        foreach ($listfundrequests as $listfundrequest) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td>
                                                    <?php if ($listfundrequest['status'] == 0) { ?>

                                                        <!--- Dynamic Action data --->
                                                        <!-- <?php foreach ($actions as $action) : ?>
                                                        <a href="<?php echo base_url($action['action_url'] . '/index/' . $super_distributer['id']); ?>" class="btn btn-<?= $action['btn_color']; ?>"><i class="<?= $action['icon'] ?>"></i></a>
                                                        <?php endforeach; ?> -->

                                                        <a href="#" class="btn btn-success my-2" data-toggle="modal" data-target="#basicModal<?= $listfundrequest['id']; ?>">Approved</a>

                                                        <a href="#" class="btn btn-danger my-2" data-toggle="modal" data-target="#rejectModal<?= $listfundrequest['id']; ?>">Reject</a>


                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $user = $listfundrequest['username'];
                                                    $name = $this->db->get_where('users', ['id' => $user])->row_array();
                                                    echo $name['name'];
                                                    ?>
                                                </td>
                                                <td><?= $listfundrequest['mobile']; ?></td>
                                                <td><?= $listfundrequest['user_type']; ?></td>
                                                <td><?= $listfundrequest['amount']; ?></td>
                                                <td><?= $listfundrequest['txn_no']; ?></td>
                                                <td><?= $listfundrequest['create_date']; ?><br><?= $listfundrequest['create_time']; ?></td>
                                                <td><textarea readonly><?= $listfundrequest['remarks']; ?></textarea></td>
                                                <td>
                                                    <?php if ($listfundrequest['status'] == 1) { ?>
                                                        <div class="alert-success text-center">Approved</div>
                                                    <?php } else if ($listfundrequest['status'] == 0) { ?>
                                                        <div class="alert-info text-center">Pending</div>
                                                    <?php } else if ($listfundrequest['status'] == -1) { ?>
                                                        <div class="alert-danger text-center">Rejected</div>
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
    if (!empty($listfundrequests)) {
        foreach ($listfundrequests as $listfundrequest) :
    ?>
            <!--------------------- Approved PAN modal --------------------->
            <!-- basic modal -->
            <div class="modal fade" id="basicModal<?= $listfundrequest['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('Approvelistfundrequest/index/' . $listfundrequest['id']); ?>" method="post" enctype="multipart/form-data">
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

    <?php if (!empty($listfundrequests)) {
        foreach ($listfundrequests as $listfundrequest) :  ?>
            <!--------------------- Reject PAN modal --------------------->
            <!-- basic modal -->
            <div class="modal fade" id="rejectModal<?= $listfundrequest['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Remarks <b style="color: red;">*</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('Rejectlistfundrequest/index/' . $listfundrequest['id']); ?>" method="post">
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