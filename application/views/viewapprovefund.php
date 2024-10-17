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
                        <div class="ibox-title">List Fund Approved</div>
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
                        <div class="ibox-title">Show Fund Approved || Total Amount - ₹
                            <?php 
                            if(!empty($total_amount)){
                                echo $total_amount['amount'];
                            } else{
                                echo '0.00';
                            }
                            ?>
                        </div>
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
                                        <!-- <th>Action</th> -->
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <!-- <th>User Name</th> -->
                                        <th>User Type</th>
                                        <th>Mobile</th>
                                        <th>Amount</th>
                                        <th>Transaction No</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($listfundrequests)) {
                                        $i = 1;
                                        foreach ($listfundrequests as $listfundrequest) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                
                                                <td><?= $listfundrequest['remarks']; ?></td>
                                                <td>
                                                    <?php if ($listfundrequest['status'] == 1) { ?>
                                                        <div class="alert-success text-center">Approved</div>
                                                    <?php } else if ($listfundrequest['status'] == 0) { ?>
                                                        <div class="alert-info text-center">Pending</div>
                                                    <?php } else if ($listfundrequest['status'] == -1) { ?>
                                                        <div class="alert-danger text-center">Rejected</div>
                                                    <?php } ?>
                                                </td>
                                                <!-- <td><? //= $listfundrequest['username']; 
                                                            ?></td> -->
                                                <td><?= $listfundrequest['user_type']; ?></td>
                                                <td><?= $listfundrequest['mobile']; ?></td>
                                                <td><?= $listfundrequest['amount']; ?></td>
                                                <td><?= $listfundrequest['txn_no']; ?></td>
                                                <td><?= $listfundrequest['create_date']; ?><br><?= $listfundrequest['create_time']; ?></td>
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