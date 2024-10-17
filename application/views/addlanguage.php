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
                        <div class="ibox-title">Add Language</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="" method="post" class="row">
                                    <!----------------- Language ------------------->
                                    <div class="form-group w-100">
                                        <input type="hidden" name="id" value="<?= (isset($result['id'])) ? $result['id'] : "" ?>">
                                        <label>Language <b style="color: red;">*</b></label>
                                        <input class="form-control" type="text" name="language" placeholder="Language" value="<?= (isset($result['language'])) ? $result['language'] : "" ?>" required>
                                    </div>
                                    <!-------------------- Language - Code -------------------->
                                    <div class="form-group w-100">
                                        <label>Language Code <b style="color: red;">*</b></label>
                                        <input class="form-control" type="text" name="language_code" placeholder="example: English => en" value="<?= (isset($result['language_code'])) ? $result['language_code'] : "" ?>" required>
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
                                            <th>Language</th>
                                            <th>Language Code</th>
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
                                                    <td><?php echo $row['language']; ?></td>
                                                    <td><?php echo $row['language_code']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['status'] == 1) {
                                                            echo  '<button class="btn btn-success btn-rounded">Active</button>';
                                                        } else {
                                                            echo  '<button class="btn btn-danger btn-rounded">Inactive</button>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><a href="<?php echo base_url('Addlanguage/index/' . $row['id']); ?>" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Addlanguage/index/' . $row['id'] . '/del'); ?>" class="btn btn-danger delBtn btn-circle"><i class="fa fa-times"></i></a></td>
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