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
                        <div class="ibox-title">Wallet History</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="POST">
                            <div class="row">
                                <?php
                                if (isset($_SESSION['slug'])) {
                                ?>
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
                                <?php }
                                if (isset($_SESSION['role'])) { ?>
                                    <div class="form-group col-md-2">
                                        <label class="form-control-label">From Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="date" class="form-control" name="from_date">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-control-label">To Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="date" class="form-control" name="to_date">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-control-label">Mobile</label>
                                        <input class="form-control" type="number" name="mobile">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-control-label">User Type</label>
                                        <select name="user_type" id="user_type" class="form-control" onchange="getUser()">
                                            <option value="">Select User Type</option>
                                            <?php foreach ($user_types as $user_type) : ?>
                                                <option value="<?= $user_type['slug']; ?>"><?= $user_type['user_type']; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-control-label">User</label>
                                        <select name="user" id="user" class="form-control">
                                            <option value="">Select User Type First</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <br>
                                        <input type="submit" class="btn btn-primary" value="Search" style="margin-top: 8px; width: 100%;">
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <div class="ibox-title">Show wallet History</div>
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
                                        <th>Mobile</th>
                                        <th>User Type</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Cr/Dr</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($wbalhists)) {
                                        $i = 1;
                                        foreach ($wbalhists as $wbalhist) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?php if (!empty($wbalhist['mobile'])) {
                                                        echo $wbalhist['mobile'];
                                                    } ?></td>
                                                <td><?= $wbalhist['user_type']; ?>
                                                    <br>
                                                    <?= $wbalhist['name']; ?>
                                                    <br>
                                                    <?php if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>
                                                        <?= $wbalhist['from_mobile'] ?>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $wbalhist['date']; ?></td>
                                                <td><?= $wbalhist['time']; ?></td>
                                                <td><?= $wbalhist['cr_dr']; ?></td>
                                                <td><?= $wbalhist['amount']; ?></td>
                                                <td><?= $wbalhist['balance']; ?></td>
                                                <td width="25%"> <span style="color: red;"><?= $wbalhist['remarks']; ?></span> </td>
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
    <script>
        function getUser() {
            var user_type = document.getElementById("user_type").value;
            // alert(user_type);die;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('balancehistory/getUser') ?>',
                data: {
                    user_type: user_type,
                },
                dataType: "json",
                success: function(data) {
                    $("#user").html(data.options);
                }
            });
        }
    </script>

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