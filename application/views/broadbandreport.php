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
                        <div class="ibox-title">Broadband Payment Report</div>
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
                                    <select class="form-control select2_demo_1 " name="operator">
                                        <option value="">Select Operator</option>
                                        <?php foreach ($operators as $operator) { ?>
                                            <option value="<?= $operator->opcode; ?>"><?= $operator->operator; ?></option>
                                        <?php } ?>
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
                        <div class="ibox-title">Show Broadband Payment Report</div>
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
                                        <th>TXID</th>
                                        <th>Service Code</th>
                                        <th>Broadband Number</th>
                                        <th>Amount</th>
                                        <?php
                                        if (isset($_SESSION['role'])) { ?>
                                            <th>Api Profit</th>
                                            <th>User</th>
                                        <?php  }
                                        ?>
                                        <th>Profit(₹)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($broadband_reports)) {
                                        $i = 1;
                                        foreach ($broadband_reports as $data) { ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td>
                                                    <?php
                                                    $op_logo = $this->db->get_where('tbl_broadband_operator', ['opcode' => $data->service_code])->row_array();
                                                    ?>
                                                    <img src="<?php echo base_url('operator_image/' . $op_logo['op_logo']); ?>" width=50 height=50>
                                                </td>
                                                <td><?= $data->trans_id ?></td>
                                                <td><?= $data->service_code; ?></td>
                                                <td><?= $data->broadband_number ?></td>
                                                <td><?= $data->amount ?></td>
                                                <?php
                                                if (isset($_SESSION['role'])) { ?>
                                                    <td><?= $data->dr; ?></td>
                                                    <td>
                                                        <?php
                                                        $user = $this->db->get_where('users', ['mobile' => $data->pay_by])->row_array();
                                                        if (!empty($user)) {
                                                            echo $user['name'];
                                                        } else {
                                                            echo "Super Admin";
                                                        }
                                                        ?>
                                                    </td>
                                                <?php  }
                                                ?>

                                                <td>
                                                    <?php
                                                    echo $data->profit;
                                                    ?>
                                                </td>
                                                <td><?= (new DateTime($data->created_at))->format('d-m-Y H:i:s a') ?></td>

                                                <td><?php if ($data->trans_status_code == 1) { ?><button class="btn btn-success btn-sm"><?= $data->trans_status ?></button>
                                                    <?php }
                                                    if ($data->trans_status_code == 0) { ?><button class="btn btn-warning btn-sm"><?= $data->trans_status ?></button>
                                                    <?php }
                                                    if ($data->trans_status_code == 2) { ?><button class="btn btn-danger btn-sm"><?= $data->trans_status ?></button>
                                                    <?php }
                                                    if ($data->trans_status_code == 3) { ?><button class="btn btn-danger btn-sm"><?= $data->trans_status ?></button>
                                                    <?php }
                                                    if ($data->trans_status_code == 4) { ?><button class="btn btn-warning btn-sm"><?= $data->trans_status ?></button>
                                                    <?php }
                                                    if ($data->trans_status_code == 5) { ?><button class="btn btn-info btn-sm"><?= $data->trans_status ?></button>
                                                    <?php }
                                                    if ($data->trans_status_code == 6) { ?><button class="btn btn-warning btn-sm"><?= $data->trans_status ?></button>
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
    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>

    <script type="text/javascript">
        $(function() {
            $('#viewdl').DataTable({
                pageLength: 10,
            });
        });
    </script>