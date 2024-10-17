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
                        <div class="ibox-title">Menu Action</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="" method="post" class="row">
                                    <!----------------- Menu Name ------------------->
                                    <div class="form-group w-100">
                                        <label> Menu Name </label>
                                        <select class="form-control select2_demo_1" id="menu" name="menu">
                                        <option>--Select Menu--</option>
                                        <?php foreach($menus as $menu): ?>
                                            
                                            <option value="<?= $menu['id']; ?>"> <?= $menu['menu_name']; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                        
                                    </div>
                                    <!-------------------- url name ------------------------->
                                    <div class="form-group w-100">
                                        <label> Action Name </label>
                                        <input type="text" class="form-control" id="action_name" name="action_name">
                                    </div>
                                    <!------------------------ is_parent ----------------------->
                                    <div class="form-group w-100">
                                        <label> Action Url </label>
                                        <input class="form-control" type="text" name="action_url" id="action_url">
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
                                            <th>Menu</th>
                                            <th>Action Name</th>
                                            <th>Action Url</th>
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
                                                    <td><?php echo $row['menu_id']; ?></td>
                                                    <td><?php echo $row['action_name']; ?></td>
                                                    <td><?php echo $row['action_url']; ?></td>
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