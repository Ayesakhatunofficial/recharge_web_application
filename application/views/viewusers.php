<?php
// echo 'ayesa'; die;
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox ibox-warning">
            <div class="ibox-head">
                <div class="ibox-title">View Users</div>
            </div>
            <?php if (isset($_SESSION['role'])) { ?>
                <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-1" data-toggle="tab" aria-expanded="true"> Admin <?php echo '(' . $a_total['total_a'] . ')'; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-2" data-toggle="tab" aria-expanded="false"> Super Distributer
                                <?php
                                if ($sd_total['total_sd'] != '') {
                                    echo '(' . $sd_total['total_sd'] . ')';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-3" data-toggle="tab" aria-expanded="false"> Distributor
                                <?php
                                if ($d_total['total_d'] != '') {
                                    echo '(' . $d_total['total_d'] . ')';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-4" data-toggle="tab" aria-expanded="false"> Retailer <?php echo '(' . $r_total['total_r'] . ')'; ?></a>
                        </li>
                    </ul>


                    <div class="tab-content" id="table-id">
                        <div class="tab-pane active" id="tab-1" aria-expanded="true">
                            <table class="table table-striped table-bordered table-hover" id="users-type-1" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Create By</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admins as $admin) : ?>
                                        <tr>
                                            <td><?php echo $admin['id']; ?></td>
                                            <td><strong><?php echo $admin['name']; ?></strong></td>
                                            <td><?php echo $admin['address']; ?></td>
                                            <td><?php echo $admin['mobile']; ?></td>
                                            <td><?php echo $admin['wallet']; ?></td>
                                            <td>
                                                <?= 'Super Admin'; ?>
                                            </td>
                                            <td>
                                                <?php if ($admin['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $admin['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $admin['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $admin['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $admin['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($super_distributer['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $super_distributer['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $super_distributer['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?> 
                                            </td> -->


                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $admin['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $admin['id']) ?>" class="btn btn-danger btn-rounded ml-1" onclick="alert('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                                <a href="https://wa.me/91<?php echo $admin['mobile']; ?>" target="_blank" style="font-size: 22px;color: #ffffff;padding: 3px 10px;" class="btn btn-success btn-rounded ml-1"><i class="fa fa-whatsapp"></i></a>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="tab-2" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-2" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Create By</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($super_distributers as $super_distributer) : ?>
                                        <tr>
                                            <td><?php echo $super_distributer['id']; ?></td>
                                            <td><strong><?php echo $super_distributer['name']; ?></strong></td>
                                            <td><?php echo $super_distributer['address']; ?></td>
                                            <td><?php echo $super_distributer['mobile']; ?></td>
                                            <td><?php echo $super_distributer['wallet']; ?></td>
                                            <td>
                                                <?php
                                                if ($super_distributer['created_by_id'] != 0 || $super_distributer['created_by_id'] != NULL) {
                                                    $create_by = $this->db->get_where('users', ['id' => $super_distributer['created_by_id']])->row_array();

                                                    echo $create_by['name'];
                                                } else {
                                                    echo 'Super Admin';
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($super_distributer['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $super_distributer['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $super_distributer['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $super_distributer['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $super_distributer['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($distributer['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $super_distributer['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $super_distributer['id']) ?>" class="btn btn-danger btn-rounded ml-1" onclick="alert('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                                <a href="https://wa.me/91<?php echo $super_distributer['mobile']; ?>" target="_blank" style="font-size: 22px;color: #ffffff;padding: 3px 10px;" class="btn btn-success btn-rounded ml-1"><i class="fa fa-whatsapp"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="tab-3" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-3" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Create By</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($distributers as $distributer) : ?>
                                        <tr>
                                            <td><?php echo $distributer['id']; ?></td>
                                            <td><strong><?php echo $distributer['name']; ?></strong></td>
                                            <td><?php echo $distributer['address']; ?></td>
                                            <td><?php echo $distributer['mobile']; ?></td>
                                            <td><?php echo $distributer['wallet']; ?></td>
                                            <td>
                                                <?php
                                                if ($distributer['created_by_id'] != 0 || $distributer['created_by_id'] != NULL) {
                                                    $create_by_1 = $this->db->get_where('users', ['id' => $distributer['created_by_id']])->row_array();

                                                    echo $create_by_1['name'];
                                                } else {
                                                    echo 'Super Admin';
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($distributer['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $distributer['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $distributer['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $distributer['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $distributer['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($distributer['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $distributer['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $distributer['id']) ?>" class="btn btn-danger btn-rounded ml-1" onclick="alert('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                                <a href="https://wa.me/91<?php echo $distributer['mobile']; ?>" target="_blank" style="font-size: 22px;color: #ffffff;padding: 3px 10px;" class="btn btn-success btn-rounded ml-1"><i class="fa fa-whatsapp"></i></a> 
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="tab-4" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-4" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th width="30%">Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Create By</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reatilers as $reatiler) : ?>
                                        <tr>
                                            <td><?php echo $reatiler['id']; ?></td>
                                            <td><strong><?php echo $reatiler['name']; ?></strong></td>
                                            <td><?php echo $reatiler['address']; ?></td>
                                            <td><?php echo $reatiler['mobile']; ?></td>
                                            <td><?php echo $reatiler['wallet']; ?></td>
                                            <td>
                                                <?php
                                                if ($reatiler['created_by_id'] != 0 || $reatiler['created_by_id'] != NULL) {
                                                    $create_by_2 = $this->db->get_where('users', ['id' => $reatiler['created_by_id']])->row_array();

                                                    echo $create_by_2['name'];
                                                } else {
                                                    echo 'Super Admin';
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($reatiler['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($reatiler['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $reatiler['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $reatiler['id']) ?>" class="btn btn-danger btn-rounded ml-1" onclick="alert('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                                <a href="https://wa.me/91<?php echo $reatiler['mobile']; ?>" target="_blank" style="font-size: 22px;color: #ffffff;padding: 3px 10px;" class="btn btn-success btn-rounded ml-1"><i class="fa fa-whatsapp"></i></a> 
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            <?php } else if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'admin')) { ?>
                <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-2" data-toggle="tab" aria-expanded="true"> Super
                                Distributer <?php echo '(' . $sd_total_a['total_sd_a'] . ')'; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-3" data-toggle="tab" aria-expanded="false">
                                Distributer <?php echo '(' . $d_total_a['total_d_a'] . ')'; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-4" data-toggle="tab" aria-expanded="false">
                                Reatiler <?php echo '(' . $r_total_a['total_r_a'] . ')'; ?></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="table-id">
                        <div class="tab-pane active" id="tab-2" aria-expanded="true">
                            <table class="table table-striped table-bordered table-hover" id="users-type-2" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($super_distributers_a as $super_distributer) : ?>
                                        <tr>
                                            <td><?php echo $super_distributer['id']; ?></td>
                                            <td><strong><?php echo $super_distributer['name']; ?></strong></td>
                                            <td><?php echo $super_distributer['address']; ?></td>
                                            <td><?php echo $super_distributer['mobile']; ?></td>
                                            <td><?php echo $super_distributer['wallet']; ?></td>
                                            <td>
                                                <?php if ($super_distributer['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $super_distributer['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $super_distributer['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $super_distributer['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $super_distributer['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($super_distributer['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $super_distributer['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $super_distributer['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->

                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $super_distributer['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $super_distributer['id']) ?>" class="btn btn-danger btn-rounded ml-1" onclick="alert('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                            </td>


                                            <!-- <td>
                                            <a href="<?php echo base_url('Editusers/index/' . $super_distributer['id']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="<?php echo base_url('Deleteusers/index/' . $super_distributer['id']) ?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                        </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="tab-3" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-3" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($distributers_a as $distributer) : ?>
                                        <tr>
                                            <td><?php echo $distributer['id']; ?></td>
                                            <td><strong><?php echo $distributer['name']; ?></strong></td>
                                            <td><?php echo $distributer['address']; ?></td>
                                            <td><?php echo $distributer['mobile']; ?></td>
                                            <td><?php echo $distributer['wallet']; ?></td>
                                            <td>
                                                <?php if ($distributer['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $distributer['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $distributer['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $distributer['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $distributer['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($distributer['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $distributer['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $distributer['id']) ?>" class="btn btn-danger btn-rounded ml-1"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="tab-4" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-4" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reatilers_a as $reatiler) : ?>
                                        <tr>
                                            <td><?php echo $reatiler['id']; ?></td>
                                            <td><strong><?php echo $reatiler['name']; ?></strong></td>
                                            <td><?php echo $reatiler['address']; ?></td>
                                            <td><?php echo $reatiler['mobile']; ?></td>
                                            <td><?php echo $reatiler['wallet']; ?></td>
                                            <td>
                                                <?php if ($reatiler['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($reatiler['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $reatiler['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $reatiler['id']) ?>" class="btn btn-danger btn-rounded ml-1"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            <?php } else if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'super_distributor')) { ?>
                <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-3" data-toggle="tab" aria-expanded="false">
                                Distributer <?php echo '(' . $d_total_sd['total_d_sd'] . ')'; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-4" data-toggle="tab" aria-expanded="false">
                                Reatiler <?php echo '(' . $r_total_sd['total_r_sd'] . ')'; ?></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="table-id">
                        <div class="tab-pane active" id="tab-3" aria-expanded="false">
                            <table class=" table table-striped table-bordered table-hover" id="users-type-3" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($distributer_sd as $distributer) : ?>
                                        <tr>
                                            <td><?php echo $distributer['id']; ?></td>
                                            <td><strong><?php echo $distributer['name']; ?></strong></td>
                                            <td><?php echo $distributer['address']; ?></td>
                                            <td><?php echo $distributer['mobile']; ?></td>
                                            <td><?php echo $distributer['wallet']; ?></td>
                                            <td>
                                                <?php if ($distributer['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $distributer['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $distributer['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $distributer['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $distributer['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($distributer['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $distributer['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $distributer['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $distributer['id']) ?>" class="btn btn-danger btn-rounded ml-1"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="tab-4" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-4" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reatiler_sd as $reatiler) : ?>
                                        <tr>
                                            <td><?php echo $reatiler['id']; ?></td>
                                            <td><strong><?php echo $reatiler['name']; ?></strong></td>
                                            <td><?php echo $reatiler['address']; ?></td>
                                            <td><?php echo $reatiler['mobile']; ?></td>
                                            <td><?php echo $reatiler['wallet']; ?></td>
                                            <td>
                                                <?php if ($reatiler['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($reatiler['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $reatiler['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $reatiler['id']) ?>" class="btn btn-danger btn-rounded ml-1"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            <?php } else if (isset($_SESSION['slug']) && ($_SESSION['slug'] == 'distributor')) { ?>
                <div class="ibox-body" style="padding-left: 0;padding-right: 0;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-4" data-toggle="tab" aria-expanded="false">
                                Reatiler <?php echo '(' . $r_total_d['total_r_d'] . ')'; ?></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="table-id">
                        <div class="tab-pane active" id="tab-4" aria-expanded="false">
                            <table class="table table-striped table-bordered table-hover" id="users-type-4" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <!-- <th>KYC Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reatiler_d as $reatiler) : ?>
                                        <tr>
                                            <td><?php echo $reatiler['id']; ?></td>
                                            <td><strong><?php echo $reatiler['name']; ?></strong></td>
                                            <td><?php echo $reatiler['address']; ?></td>
                                            <td><?php echo $reatiler['mobile']; ?></td>
                                            <td><?php echo $reatiler['wallet']; ?></td>
                                            <td>
                                                <?php if ($reatiler['status'] == 1) { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-success btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Active</button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('Status/index/' . $reatiler['id']); ?>"><button class='btn btn-danger btn-rounded' id='statusBtn' data-status="<?php echo $reatiler['status']; ?>">Inactive</button></a>
                                                <?php } ?>

                                            </td>
                                            <!-- <td>
                                                <? //php if ($reatiler['is_kyc_verified'] == 1) { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-success btn-sm">Verified</a>
                                                <? //php  } else { 
                                                ?>
                                                    <a href="<? //php echo base_url('Verifykyc/index/' . $reatiler['id']); 
                                                                ?>" class="btn btn-danger btn-sm">Not Verified</a>
                                                <? //php } 
                                                ?>
                                            </td> -->
                                            <td>
                                                <a href="<?php echo base_url('Editusers/index/' . $reatiler['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo base_url('Deleteusers/index/' . $reatiler['id']) ?>" class="btn btn-danger btn-rounded ml-1"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript">
        $(function() {
            $('#users-type-1').DataTable({
                pageLength: 10,
            });

            $('#users-type-2').DataTable({
                pageLength: 10,
            });

            $('#users-type-3').DataTable({
                pageLength: 10,
            });

            $('#users-type-4').DataTable({
                pageLength: 10,
            });
        });
    </script>