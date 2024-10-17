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
                        <div class="ibox-title">Add User Type</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="" method="post" class="row">
                                    <!----------------- User Type ------------------->
                                    <div class="form-group w-100">
                                        <input type="hidden" name="id" value="<?= (isset($result['id'])) ? $result['id'] : "" ?>">
                                        <label>User Type <b style="color: red;">*</b></label>
                                        <input class="form-control" type="text" name="user_type" placeholder="XXXXXXXXXX" value="<?= (isset($result['user_type'])) ? $result['user_type'] : "" ?>" required>
                                    </div>
                                    <!-------------------------- Status --------------->
                                    <div class="form-group w-100">
                                        <label class="form-control-label">Status</label>
                                        <select class="form-control select2_demo_1" name="status">

                                            <?php
                                            // if (isset($result['status'])) {
                                            //     $selcted = 'selected';
                                            // } else {
                                            //     $selcted = '';
                                            // }
                                            ?>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-lg" type="submit" name="submitBtn">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($rows)) :

                                            $i = 1;

                                            foreach ($rows as $row) :

                                        ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['user_type']; ?></td>
                                                    <td><?php echo $row['create_date']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['status'] == 1) {
                                                            echo  '<button class="btn btn-success btn-rounded">Active</button>';
                                                        } else {
                                                            echo  '<button class="btn btn-danger btn-rounded">Inactive</button>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><a href="<?php echo base_url('Adduserstype/index/' . $row['id']); ?>" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Adduserstype/index/' . $row['id'] . '/del'); ?>" class="btn btn-danger delBtn btn-circle"><i class="fa fa-times"></i></a></td>
                                                </tr>
                                        <?php
                                                $i++;
                                            endforeach;
                                        endif;
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