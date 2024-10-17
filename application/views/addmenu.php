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
                        <div class="ibox-title">Add Menu</div>
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
                                        <input class="form-control" type="text" name="menu_name">
                                    </div>
                                    <!-------------------- url name ------------------------->
                                    <!-- <div class="form-group w-100">
                                        <label> Menu Url </label>
                                        <input class="form-control" type="text" name="url">
                                    </div> -->
                                    <!------------------------ is_parent ----------------------->
                                    <div class="form-group w-100">
                                        <label> Is Parent </label>
                                        <select class="form-control select2_demo_1" id="is_parent" name="is_parent">
                                            <option value="Y">Yes</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                    <!-------------------------- Parent Menu --------------->
                                    <!-- <div class="form-group w-100">
                                        <label class="form-control-label">Parent Menu</label>
                                        <select class="form-control select2_demo_1" name="parent_menu" id="parent_menu">
                                            <?php foreach ($parent_menus as $parent_menu) :
                                            ?>   
                                                <option value="-">Select Menu</option>    
                                                <option value="<?= $parent_menu['id']; ?>"><?= $parent_menu['menu_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> -->
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
                                            <th>Url</th>
                                            <th>Is Parent</th>
                                            <th>Parent Menu</th>
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
                                                    <td><?php echo $row['menu_name']; ?></td>
                                                    <td><?php echo $row['url']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['is_parent'] == 'Y') {
                                                            echo  '<button class="btn btn-success btn-rounded">Yes</button>';
                                                        } else if ($row['is_parent'] == 'N'){
                                                            echo  '<button class="btn btn-danger btn-rounded">No</button>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['parent_menu']; ?></td>
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