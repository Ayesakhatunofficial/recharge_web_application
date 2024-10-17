<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">View Terms and Conditions URL</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <?php if (empty($terms)) { ?>
                        <div>
                            <a href="<?= base_url('terms') ?>" class="btn btn-primary mt-2 ml-2"><i class="fa fa-plus"></i> Add </a>
                        </div>

                    <?php } ?>

                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-12 w-100">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>URL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($terms)) {
                                            $i = 1;
                                            foreach ($terms as $data) :
                                        ?>
                                                <tr>
                                                    
                                                    <td><?php echo $i; ?></td>

                                                    <td>
                                                        <?php echo $data['url']; ?>
                                                    </td>

                                                    <td>
                                                        <a href="<?php echo base_url('terms/index/' . $data['id']); ?>" class="btn btn-primary btn-circle mb-2"><i class="fa fa-edit"></i></a> &nbsp;

                                                        <a href="<?php echo base_url('terms/delete/' . $data['id']); ?>" class="btn btn-danger delBtn btn-circle" onclick=" return confirm('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                        <?php
                                                $i++;
                                            endforeach;
                                        }
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
    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>