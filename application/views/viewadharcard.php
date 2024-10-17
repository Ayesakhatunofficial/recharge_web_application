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
                        <div class="ibox-title">Search Aadhar</div>
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
                                    <label class="form-control-label">Aadhar No</label>
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
                        <div class="ibox-title">Show Aadhar Details</div>
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
                                        <th>Name</th>
                                        <th>Aadhar Number</th>
                                        <th>Address</th>
                                        <th>Language</th>
                                        <th>Date</th>
                                        <th>Print-1</th>
                                        <th>Print-2</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($adhars as $adhar) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $adhar['full_name']; ?></td>
                                            <td><?= $adhar['adhar_no']; ?>
                                            
                                            <a href="#" class="btn btn-info my-2" data-toggle="modal" data-target="#viewModal<?= $adhar['id']; ?>">View</a></td>
                                            <td><?= $adhar['address']; ?></td>
                                            <td>
                                                <?php
                                                foreach($languages as $language){
                                                    if($adhar['language'] == $language['language_code']){
                                                        echo $language['language'];
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?= $adhar['create_date']; ?></td>
                                            <?php
                                                $fees = $this->db->get_where('payment_fees', ['id_type' => 'Aadhar Card'])->row_array();
                                            ?>
                                            <td>
                                                <?php if ($adhar['is_pay_print1'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printadhar/index/' . $adhar['id']); ?>" target="_blank" class="btn btn-primary btn-sm">Print-1</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$adhar['adhar_no'].'/'.$fees['fees'].'/aadhar-print1'); ?>"  class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($adhar['is_pay_print2'] == 1) { ?>
                                                    <a href="<?php echo base_url('Printadharpvc/index/' . $adhar['id']); ?>" target="_blank" class="btn btn-primary btn-sm">Print-2</a>
                                                <?php  } else { ?>
                                                    <a href="<?= base_url('Paytm/index/'.$adhar['adhar_no'].'/'.$fees['fees'].'/aadhar-print2'); ?>" class="btn btn-success btn-sm">Pay Now</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                            <!-- <?php if(isset($actions)){
                                            foreach($actions as $action) : ?>
                                            <a href="<?php echo base_url($action['action_url'].'/index/' . $adhar['id']); ?>" class="btn btn-<?= $action['btn_color']; ?>"><?= $action['action_name']; ?></a> <br><br>
                                            <?php endforeach; } else { ?> -->

                                                <a href="<?php echo base_url('Editadharcard/index/' . $adhar['id']); ?>" class="btn btn-warning">Edit</a>
                                                <a href="<?php echo base_url('Deleteadharcard/index/' . $adhar['id']) ?>" class="btn btn-danger">Delete</a>
                                                <!-- <?php } ?> -->
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

    <?php foreach ($adhars as $adhar) :  ?>
        <!--------------------- View Pan Card details modal --------------------->
        <!-- basic modal -->
        <div class="modal fade" id="viewModal<?= $adhar['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Aadhar Details </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $view = $this->db->get_where('aadhar_details', ['id' => $adhar['id']])->row_array();
                        ?>
                        <table class="table" id="table" border="0">
                            <tr>
                                <td>Name: <?= $view['full_name']; ?> </td>
                                <td>Aadhar No: <?= $view['adhar_no']; ?> </td>
                            </tr>
                            <tr>
                                <td>Date Of Birth <?= $view['dob']; ?></td>
                            </tr>
                            <tr>
                                <td>Gender: <?= $view['gender']; ?></td>
                            </tr>
                            <tr>
                                <td>Photo: <img src="<?= base_url(); ?>/adhar_uploads/<?= $view['photo']; ?>" alt="" width="100px" height="auto"> </td>
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