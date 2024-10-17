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
                        <div class="ibox-title">Offers</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="hidden" name="id" value="<?= (isset($result['id'])) ? $result['id'] : ""; ?>">
                                    <label class="form-control-label">Service Category <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='service_category' required>
                                        <option value="source">--Select Service--</option>
                                        <?php foreach ($services as $service) : ($result['service_category'] == $service['slug']) ? $selected = 'selected' : $selected = ''; ?>
                                            <option value="<?= $service['slug']; ?>" <?= $selected; ?>><?= $service['service_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Offer Title" value="<?= isset($result['title']) ? $result['title'] : ""; ?>">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Start Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="start_date" value="<?= isset($result['start_date']) ? $result['start_date'] : ""; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">End Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="end_date" value="<?= isset($result['end_date']) ? $result['end_date'] : ""; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Offer</label>
                                    <select class="form-control select2_demo_1" name="offer">
                                        <option value="flat" <?= ((isset($result['offer'])) && ($result['offer'] == 'flat')) ? "selected" : ""; ?>>Flat</option>
                                        <option value="percent" <?= ((isset($result['offer'])) && ($result['offer'] == 'percent')) ? "selected" : ""; ?>>Percentage</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Amount </label>
                                    <input type="number" class="form-control" name="amount" placeholder="Flat/Percentage Amount" value="<?= isset($result['amount']) ? $result['amount'] : ""; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Offer Image</label>
                                    <input type="file" name="offer_image" class="form-control">
                                    <?php if (isset($result['offer_image'])) { ?>
                                        <img src="<?= base_url('offer_image/' . $result['offer_image']); ?>" alt="offer-image" width="100px" height="100px">
                                    <?php
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="submit" value="submit" class="btn btn-danger" name="offerBtn">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <div class="ibox-title">Show Offers</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1-1" aria-expanded="true">
                                <table class="table table-striped table-bordered table-hover" id="bus_booking-1" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Service Category</th>
                                            <th>Offer Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Amount</th>
                                            <th>Offer</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($offers as $offer) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><img src="<?= base_url('offer_image/' . $offer['offer_image']); ?>" width="100px" height="100px" alt="offer-image"></td>
                                                <td>
                                                    <?php
                                                        foreach($services as $service)
                                                        {
                                                            if($offer['service_category'] == $service['slug'])
                                                            {
                                                                echo $service['service_name'];
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $offer['title']; ?></td>
                                                <td style="color: green;"><strong><?= $offer['start_date']; ?></strong></td>
                                                <td style="color: red;"><strong><?= $offer['end_date']; ?></strong></td>
                                                <td><?= $offer['amount']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($offer['offer'] == 'flat') {
                                                        echo "Flat";
                                                    } else {
                                                        echo "Percentage";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($offer['status'] == 1) { ?>
                                                        <a href="<?= base_url('Offersstatus/index/' . $offer['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $offer['status']; ?>">Active</button></a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('Offersstatus/index/' . $offer['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $offer['status']; ?>">Inactive</button></a>
                                                    <?php } ?>
                                                </td>
                                                <td><a href="<?php echo base_url('Offers/index/' . $offer['id']); ?>" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoffers/index/' . $offer['id']); ?>" class="btn btn-danger delBtn btn-circle"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ------------------- Book Seats modal -------------------
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Large Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Modal Body</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div> -->




    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>