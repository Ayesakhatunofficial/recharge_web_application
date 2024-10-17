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
                        <div class="ibox-title">API Utility Balance Report</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="POST">
                            <div class="row">
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
                                    <label class="form-control-label">Customer Id</label>
                                    <input class="form-control" type="number" name="cust_id">
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
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <div class="ibox-title">Show API Utility Balance History</div>
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
                                        <th>Date / Time</th>
                                        <th>Customer Name</th>
                                        <th>Customer Id</th>
                                        <th>User Type</th>
                                        <th>User Name</th>
                                        <th>Cr/Dr</th>
                                        <th>Cr Amount</th>
                                        <th>Dr Amount</th>
                                        <th>Balance</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($apibalhists)) {
                                        $i = 1;
                                        foreach ($apibalhists as $apibalhist) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $apibalhist['date']; ?> <br> <?= $apibalhist['time']; ?></td>
                                                <td><?= $apibalhist['customer_name']?></td>
                                                <td><?= $apibalhist['customer_id']; ?></td>
                                                <td><?= $apibalhist['user_type']; ?></td>
                                                <td>
                                                    <?php
                                                    $users = $this->db->get_where('users', ['mobile' => $apibalhist['user_mobile']])->row_array();
                                                    echo $users['name'];
                                                    ?> <br>
                                                    <?= $apibalhist['user_mobile']; ?>
                                                </td>
                                                <td><?= $apibalhist['cr_dr']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($apibalhist['cr_dr'] == 'Credit') {
                                                        echo $apibalhist['amount'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($apibalhist['cr_dr'] == 'Debit') {
                                                        echo $apibalhist['amount'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $apibalhist['balance']; ?></td>
                                                <td width="25%"> <span style="color: red;"><?= $apibalhist['remarks']; ?></span> </td>
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
                url: '<?= base_url('apiutilityreport/getUser') ?>',
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