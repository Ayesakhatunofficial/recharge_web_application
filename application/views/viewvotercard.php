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
                        <div class="ibox-title">Voter List</div>
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
                                    <label class="form-control-label">Voter No</label>
                                    <input class="form-control" type="text" id="epic_no" maxlength="10" name="epic_no">
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
                        <div class="ibox-title">Show Voter Details</div>
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
                                        <th>Voter ID Number</th>
                                        <th>Name</th>
                                        <th>Language</th>
                                        <th>Print</th>
                                        <th>Print-1</th>
                                        <th>Print-2</th>
                                        <th>E-Voter</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($voters as $voter) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?= $voter['epic_no']; ?>
                                               
                                            </td>
                                            <td><?= $voter['name']; ?></td>
                                            <td>
                                                <?php
                                                foreach ($languages as $language) {
                                                    if ($voter['language'] == $language['language_code']) {
                                                        echo $language['language'];
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php
                                                $fees = $this->db->get_where('payment_fees', ['id_type' => 'Voter Card'])->row_array();
                                            ?>
                                            <td>
                                                <?php if ($voter['is_pay_print'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printvoter/index/' . $voter['id']); ?>" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$voter['epic_no'].'/'.$fees['fees'].'/voter-print'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($voter['is_pay_print1'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printvoter1/index/' . $voter['id']); ?>" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$voter['epic_no'].'/'.$fees['fees'].'/voter-print1'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($voter['is_pay_print2'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printvoter2/index/' . $voter['id']); ?>" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$voter['epic_no'].'/'.$fees['fees'].'/voter-print2'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($voter['is_pay_e_print'] == 1) { ?>
                                                    <a href="<?php echo base_url('PrintEvoter/index/' . $voter['id']); ?>" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$voter['epic_no'].'/'.$fees['fees'].'/voter-eprint'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('Deletevotercard/index/' . $voter['id']) ?>" class="btn btn-danger">Delete</a>
                                                <a href="#" class="btn btn-info my-2" data-toggle="modal" data-target="#viewModal<?= $voter['id']; ?>">View</a>
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


    <?php foreach ($voters as $voter) :  ?>
        <!--------------------- View Voter Card details modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="viewModal<?= $voter['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Voter Details </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $view = $this->db->get_where('voter_details', ['id' => $voter['id']])->row_array();
                        ?>
                        <table class="table" id="table" border="0">
                            <tr>
                                <td>Name: <?= $view['name']; ?> </td>
                                <td>Epic No: <?= $view['epic_no']; ?> </td>
                            </tr>
                            <tr>
                                <td>Date Of Birth <?= $view['dob']; ?></td>
                                <td>Assembly: <?= $view['assembly']; ?></td>
                            </tr>
                            <tr>
                                <td>Part No: <?= $view['part_no']; ?></td>
                                <td>Part Name: <?= $view['part_name']; ?></td>
                                <td>Address: <?= $view['address']; ?></td>
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