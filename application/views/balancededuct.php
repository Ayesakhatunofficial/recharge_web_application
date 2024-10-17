<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Deduct Balance</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Mobile </label>
                                    <input class="form-control" type="number" id="mobile" name="mobile" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Balance </label>
                                    <input class="form-control" type="number" id="balance" name="balance" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Amount </label>
                                    <input class="form-control" type="decimal" name="amount" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">Narration </label>
                                    <textarea name="narration" class="form-control"></textarea>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="submit" value="Submit" class="btn btn-primary" name="searchboxbtn">
                                    <a class="btn btn-danger" href="#">Reset</a>
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

    <script>
        $(document).ready(function() {
            var url = "<?= base_url('Getmobdata/index'); ?>";
            console.log(url);
            $('#mobile').on('blur', function() {

                var mob = $(this).val();

                var mob_obj = {
                    'mob': mob
                };

                // console.log(mob_obj);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: mob_obj,
                    success: (data) => {
                        var output = JSON.parse(data);
                        if (output.responce == 'success') {
                            $('#balance').val(output.bal);
                        }
                    }
                });
            });
        });
    </script>