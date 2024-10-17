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
                        <div class="ibox-title">Add New Voter Card</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Voter card Entry Auto</h4>
                                <hr />
                            </div>

                            <div class="col-md-6">
                                <a href="https://electoralsearch.in/" class="btn btn-success w-100" target="_blank">Click Here For First STEP</a>
                            </div>
                        </div>
                        <br>
                        <form action="<?= base_url('Voterdetails/index'); ?>" id="voterForm" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Upload nvsp File</label>
                                    <input type="file" name="inputfile" id="inputfile" class="form-control">
                                    <div id="output" style="display: none;"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="submit" value="save" class="btn btn-primary" id="savebtn" name="save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>