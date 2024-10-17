<?php
// echo base_url() . 'operator_image';die;
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
                        <div class="ibox-title">View Operator</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-1" data-toggle="tab" aria-expanded="true"> Mobile Operator </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-2" data-toggle="tab" aria-expanded="false">DTH Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-3" data-toggle="tab" aria-expanded="false">
                                    Electric Bill Pay Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-4" data-toggle="tab" aria-expanded="false">
                                    Post Paid Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-5" data-toggle="tab" aria-expanded="false">
                                    Loan Pay Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-6" data-toggle="tab" aria-expanded="false">
                                    FASTag Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-7" data-toggle="tab" aria-expanded="false">
                                    LPG Gas Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-8" data-toggle="tab" aria-expanded="false">
                                    Insurance Operator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-9" data-toggle="tab" aria-expanded="false">
                                    Broadband Operator</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab-10" data-toggle="tab" aria-expanded="false">
                                    Municiple Operator</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab-11" data-toggle="tab" aria-expanded="false">
                                    Credit Card Operator</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab-12" data-toggle="tab" aria-expanded="false">
                                    Landline Operator</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab-13" data-toggle="tab" aria-expanded="false">
                                    Cable Operator</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab-14" data-toggle="tab" aria-expanded="false">
                                    Subscription Operator</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="table-id">
                            <div class="tab-pane active" id="tab-1" aria-expanded="true">
                                <table class="table table-striped table-bordered table-hover" id="users-type-1" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($operators as $operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>

                                                    <?php if ($operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php echo $operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/index/' . $operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/index/' . $operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-2" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-2" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($dth_operators as $dth_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($dth_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $dth_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $dth_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dth_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/dth_edit/' . $dth_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/dth_delete/' . $dth_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-3" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-3" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($electric_operators as $electric_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($electric_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $electric_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $electric_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $electric_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/electric_edit/' . $electric_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/electric_delete/' . $electric_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-4" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-4" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($postpaid_operators as $postpaid_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($postpaid_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $postpaid_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $postpaid_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $postpaid_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/postpaid_edit/' . $postpaid_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/postpaid_delete/' . $postpaid_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-5" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-5" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($loan_operators as $loan_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($loan_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $loan_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $loan_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $loan_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/loan_edit/' . $loan_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/loan_delete/' . $loan_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-6" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-6" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($fastag_operators as $fastag_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($fastag_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $fastag_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $fastag_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $fastag_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/fastag_edit/' . $fastag_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/fastag_delete/' . $fastag_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-7" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-7" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($lpg_gas_operators as $lpg_gas_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($lpg_gas_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $lpg_gas_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $lpg_gas_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $lpg_gas_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/lpg_gas_edit/' . $lpg_gas_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/lpg_gas_delete/' . $lpg_gas_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-8" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-8" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($insurance_operators as $insurance_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($insurance_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $insurance_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $insurance_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $insurance_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/insurance_edit/' . $insurance_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/insurance_delete/' . $insurance_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-9" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-9" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($broadband_operators as $broadband_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($broadband_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $broadband_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $broadband_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $broadband_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/broadband_edit/' . $broadband_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/broadband_delete/' . $broadband_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-10" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-10" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($municiple_operators as $municiple_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($municiple_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $municiple_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $municiple_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $municiple_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/municiple_edit/' . $municiple_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/municiple_delete/' . $municiple_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-11" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-11" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($creditcard_operators as $creditcard_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($creditcard_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $creditcard_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $creditcard_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $creditcard_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/credit_edit/' . $creditcard_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/credit_delete/' . $creditcard_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-12" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-12" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($landline_operators as $landline_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($landline_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $landline_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $landline_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $landline_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/landline_edit/' . $landline_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/landline_delete/' . $landline_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-13" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-13" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($cable_operators as $cable_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($cable_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $cable_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $cable_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $cable_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/cable_edit/' . $cable_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/cable_delete/' . $cable_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab-14" aria-expanded="false">
                                <table class="table table-striped table-bordered table-hover" id="users-type-14" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Operator Logo</th>
                                            <th>Operator Code</th>
                                            <th>Operator</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($subscription_operators as $subscription_operator) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php if ($subscription_operator['op_logo']) { ?>
                                                        <img src="<?php echo base_url('operator_image/' . $subscription_operator['op_logo']); ?>" width=50 height=50>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $subscription_operator['opcode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $subscription_operator['operator']; ?>
                                                </td>

                                                <td><a href="<?php echo base_url('Editoperator/subscription_edit/' . $subscription_operator['id']); ?>" class="btn btn-primary btn-rounded"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo base_url('Deleteoperator/subscription_delete/' . $subscription_operator['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="alert('Do you Want to Delete?')"><i class="fa fa-times"></i></a></td>
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

    <script type="text/javascript">
        $(function() {
            $('#users-type-1').DataTable({
                pageLength: 5,
            });

            $('#users-type-2').DataTable({
                pageLength: 5,
            });

            $('#users-type-3').DataTable({
                pageLength: 5,
            });
            $('#users-type-4').DataTable({
                pageLength: 5,
            });
            $('#users-type-5').DataTable({
                pageLength: 5,
            });
            $('#users-type-6').DataTable({
                pageLength: 5,
            });
            $('#users-type-7').DataTable({
                pageLength: 5,
            });

            $('#users-type-8').DataTable({
                pageLength: 5,
            });
            $('#users-type-9').DataTable({
                pageLength: 5,
            });
            $('#users-type-10').DataTable({
                pageLength: 5,
            });
            $('#users-type-11').DataTable({
                pageLength: 5,
            });
            $('#users-type-12').DataTable({
                pageLength: 5,
            });
            $('#users-type-13').DataTable({
                pageLength: 5,
            });
            $('#users-type-14').DataTable({
                pageLength: 5,
            });
        })
    </script>