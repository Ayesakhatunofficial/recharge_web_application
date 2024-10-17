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
                        <div class="ibox-title">View Banner</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="text-right mb-2">
                            <a href="<?=base_url('banner')?>"><button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Banner</button></a>
                        </div>
                        <div class="row">
                            <div class="col-md-12 w-100">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Banner Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($banners as $data) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo base_url('uploads/' . $data['banner']); ?>" width=100 height=70>
                                                </td>

                                                <td><a href="<?php echo base_url('Banner/edit/' . $data['id']); ?>" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Banner/delete/' . $data['id']); ?>" class="btn btn-danger delBtn btn-circle" onclick="alert('Do You Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
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
    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>