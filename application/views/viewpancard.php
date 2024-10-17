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
                        <div class="ibox-title">Search Pan</div>
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
                                    <label class="form-control-label">PAN No</label>
                                    <input class="form-control" type="text" id="pan_no" maxlength="10" name="pan_no">
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
                        <div class="ibox-title">Show PAN Details</div>
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
                                        <th>PAN Number</th>
                                        <th>Name</th>
                                        <th>Father Name</th>
                                        <th>DOB</th>
                                        <th>Create Date</th>
                                        <th>NSDL Print</th>
                                        <th>UTI Print</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($pans as $pan) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $pan['pan_no']; ?></td>
                                            <td><?= $pan['full_name']; ?></td>
                                            <td><?= $pan['father_name']; ?></td>
                                            <td><?= $pan['dob']; ?></td>
                                            <td><?= $pan['create_date']; ?></td>
                                            <?php
                                                $fees = $this->db->get_where('payment_fees', ['id_type' => 'PAN Card'])->row_array();
                                            ?>
                                            <td>
                                                <?php if ($pan['is_pay_nsdl_print'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printpannsdl/index/' . $pan['id']); ?>" class="btn btn-primary btn-sm">Print-1</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$pan['pan_no'].'/'.$fees['fees'].'/pan-nsdl'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($pan['is_pay_uti_print'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printpanuti/index/' . $pan['id']); ?>" class="btn btn-primary btn-sm">Print-2</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$pan['pan_no'].'/'.$fees['fees'].'/pan-uti'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                            <!-- <?php if(isset($actions)){
                                                 foreach($actions as $action) : ?>
                                            <a href="<?php echo base_url($action['action_url'].'/index/' . $pan['id']); ?>" class="btn btn-<?= $action['btn_color']; ?>"><?= $action['action_name']; ?></a>
                                            <?php endforeach; } else { ?> -->
                                                <a href="<?php echo base_url('Deletepancard/index/' . $pan['id']) ?>" class="btn btn-danger">Delete</a>
                                                <!-- <?php } ?> -->
                                                <a href="#" class="btn btn-info my-2" data-toggle="modal" data-target="#viewModal<?= $pan['id']; ?>">View</a>
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

    <?php foreach ($pans as $pan) :  ?>
        <!--------------------- View Pan Card details modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="viewModal<?= $pan['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
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
                        $view = $this->db->get_where('pan_details', ['id' => $pan['id']])->row_array();
                        ?>
                        <table class="table" id="table" border="0">
                            <tr>
                                <td>Name: <?= $view['full_name']; ?> </td>
                                <td>PAN No: <?= $view['pan_no']; ?> </td>
                            </tr>
                            <tr>
                                <td>Father Name: <?= $view['father_name']; ?> </td>
                                <td>Date Of Birth <?= $view['dob']; ?></td>
                            </tr>
                            <tr>
                                <td>Gender: <?= $view['gender']; ?></td>
                            </tr>
                            <tr>
                                <td>Photo: <img src="<?= base_url(); ?>/pan_uploads/<?= $view['photo']; ?>" alt="" width="100px" height="auto"> </td>
                                <td>Signature: <br><br><img src="<?= base_url(); ?>/pan_uploads/<?= $view['sign_photo']; ?>" alt="" width="100px" height="auto"></td>
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