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
                        <div class="ibox-title">DTH Recharge Report</div>
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
                                    <label class="form-control-label">Operator</label>
                                    <select class="form-control select2_demo_1 " name="operator" id="operator">
                                        <option value="">Select Operator</option>
                                        <?php foreach ($operators as $operator) { ?>
                                            <option value="<?= $operator['opcode']; ?>"><?= $operator['operator']; ?></option>
                                        <?php }  ?>
                                    </select>
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
                        <div class="ibox-title">Show DTH Recharge Report</div>
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
                                        <th>Logo</th>
                                        <th>Operator</th>
                                        <th>TXID</th>
                                        <th>DTH No</th>
                                        <th>Amount</th>
                                        <th>Commission(%)</th>
                                        <th>Profit(₹)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recharge_reports)) {
                                        $i = 1;
                                        foreach ($recharge_reports as $data) { ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?php
                                                    $op_logo = $this->db->get_where('tbl_dth_operator', ['operator' => $data->operator])->row_array();
                                                    ?>
                                                    <img src="<?php echo base_url('operator_image/' . $op_logo['op_logo']); ?>" width=50 height=50>
                                                </td>
                                                <td><?= $data->operator; ?></td>
                                                <td><?= $data->ref_id ?></td>
                                                <td><?= $data->number ?></td>
                                                <td><?= $data->amount ?></td>
                                                <td><?= $data->margin ?></td>
                                                <td>

                                                    <?php
                                                    $profit = $data->amount * $data->margin / 100;
                                                    echo $profit;
                                                    $profit += $profit;
                                                    ?>
                                                </td>
                                                <td><?= (new DateTime($data->created_at))->format('d-m-Y H:i:s a') ?></td>

                                                <td><?php if ($data->status == 'SUCCESS') { ?><button class="btn btn-success btn-sm"><?= $data->status ?></button>
                                                    <?php } else if ($data->status == 'PENDING') { ?><button class="btn btn-warning btn-sm"><?= $data->status ?></button>
                                                    <?php } else if ($data->status == 'FAIL') { ?><button class="btn btn-danger btn-sm"><?= $data->status ?></button>
                                                    <?php } else {
                                                        echo $data->status;
                                                    } ?></td>
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