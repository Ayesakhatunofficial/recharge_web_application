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
                        <div class="ibox-title">Search Ration Card</div>
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
                                    <label class="form-control-label">Ration Card</label>
                                    <input class="form-control" type="text" id="adhar_no" maxlength="14" name="adhar_no" placeholder="12XX-XXXX-XX78"><i id="adhar_no_msg" style="display: none; color: red;font-size:13px"></i>
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
                        <div class="ibox-title">Show Ration Details</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                        <div class="tab-content">
                            <table class="table table-striped table-bordered table-hover" id="viewadharcard" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ration Type</th>
                                        <th>Ration Number</th>
                                        <th>Date</th>
                                        <th>Photo</th>
                                        <th>Signature</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($rations as $ration) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $ration['ration_type']; ?></td>
                                            <td><?= $ration['ration_no']; ?></td>
                                            <td><?= $ration['create_date']; ?></td>
                                            <td>
                                                <img src="<?= base_url('rationcard/' . $ration['family_photo']); ?>" width="100px" height="auto" alt="">
                                            </td>
                                            <td>
                                                <img src="<?= base_url('rationcard/' . $ration['sign_photo']); ?>" width="100px" height="auto" alt="">
                                            </td>
                                            <?php
                                            $fees = $this->db->get_where('payment_fees', ['id_type' => 'RATION'])->row_array();
                                            ?>
                                            <td>
                                                <a href="#" class="btn btn-info my-2" data-toggle="modal" data-target="#viewModal<?= $ration['id']; ?>">View</a>

                                                <?php if ($ration['status'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printration/index/' . $ration['id']); ?>" class="btn btn-primary btn-sm">Print</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/' . $ration['ration_no'] . '/' . $fees['fees'] . '/ration-print'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <a href="<?php echo base_url('Deleterationcard/index/' . $ration['id']) ?>" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($rations as $ration) :  ?>
        <!--------------------- View ration_details modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="viewModal<?= $ration['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
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
                        $view = $this->db->get_where('ration_details', ['id' => $ration['id']])->row_array();
                        ?>
                        <table class="table" id="table" border="0">
                            <tr>
                                <td>Name: <?= $view['full_name']; ?> </td>
                                <td>Ration Card No: <?= $view['ration_no']; ?> </td>
                            </tr>
                            <tr>
                                <td>Father Name: <?= $view['father_name']; ?></td>
                                <td>Block: <?= $view['block']; ?></td>
                            </tr>
                            <tr>
                                <td>Panchayat: <?= $view['panchayat']; ?> </td>
                                <td>Village: <?= $view['village']; ?> </td>
                            </tr>
                            <tr>
                                <td>State: <?= $view['state']; ?></td>
                                <td>District: <?= $view['district']; ?></td>
                            </tr>
                            <tr>
                                <td>Photo: <img src="<?= base_url(); ?>/rationcard/<?= $view['family_photo']; ?>" alt="" width="100px" height="auto"> </td>
                                <td>Signature: <img src="<?= base_url(); ?>/rationcard/<?= $view['sign_photo']; ?>" alt="" width="100px" height="auto"></td>
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

    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>

    <script type="text/javascript">
        $(function() {
            $('#viewadharcard').DataTable({
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
        })
    </script>