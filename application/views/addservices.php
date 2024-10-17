<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<style>
    .image-box i.fa.fa-close {
        width: 20px;
        height: 20px;
        background: #333;
        color: #fff;
        line-height: 20px;
        text-align: center;
        border-radius: 3px;
        position: absolute;
        right: 0px;
    }

    .image-box {
        width: 31%;
        float: left;
        height: 100px;
        border: 1px solid #ddd;
        margin-right: 6px;
        margin-top: 15px;
        position: relative;
    }
</style>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">Add Plans</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="" method="post" class="row" enctype="multipart/form-data">
                                    <!----------------- Service Name ------------------->
                                    <div class="form-group w-100">
                                        <input type="hidden" name="id" value="<?= (isset($result['id'])) ? $result['id'] : "" ?>">
                                        <label>Service Name <b style="color: red;">*</b></label>
                                        <input class="form-control" type="text" name="service_name" placeholder="Service Name" value="<?= (isset($result['service_name'])) ? $result['service_name'] : "" ?>" required>
                                    </div>
                                    <!------------------- Service Image ---------------->
                                    <div class="form-group w-100">
                                        <label class="form-control-label">Service Image</label>
                                        <input type="file" name="serviceimage[]" id="serviceimage" multiple accept="image/*">
                                        <div id="msg"></div>
                                        <?php
                                        if (isset($result)) {
                                            $result = $result['service_name'];
                                            $query = $this->db->query("SELECT * FROM service_image WHERE service_name = '{$result}'")->result_array();

                                            if ($query) {

                                                foreach ($query as $img) :
                                        ?>
                                                    <div class="image-box" id="<?= $img['id']; ?>">
                                                        <img src="<?= base_url('service_image/' . $img['image']); ?>" width='100px' alt=""><a href="javascript:void(0)" onclick="myFunc('<?= $img['id']; ?>')"><i class="fa fa-close"></i></a>
                                                    </div>
                                        <?php
                                                endforeach;
                                            }
                                        } ?>
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
                                            <th>Image</th>
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
                                                    <td>
                                                        <?php
                                                        $query = $this->db->query("SELECT * FROM service_image WHERE service_name = '{$row['service_name']}'")->row_array();

                                                        // print_r($this->db->last_query());

                                                        // echo "<pre>"; print_r($query); die;

                                                        if (empty($query['image'])) {
                                                            echo '<center><strong class="text-danger">Not Image</strong></center>';
                                                        } else {
                                                        ?>
                                                            <img src="<?= base_url('service_image/' . $query['image']); ?>" width="80px" height="50px" alt="">
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $row['service_name']; ?></td>
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
                                                    <td><a href="<?php echo base_url('Addservices/index/' . $row['id']); ?>" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Addservices/index/' . $row['id'] . '/del'); ?>" class="btn btn-danger delBtn btn-circle" id="<?php echo $row['id']; ?>"><i class="fa fa-times"></i></a></td>
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