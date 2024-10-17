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
                        <div class="ibox-title">Show Commission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>

                    <?php if ($_SESSION['slug'] == 'admin' || $_SESSION['role']) { ?>

                        <div>

                            <a href="<?= base_url('showcommission/add') ?>" class="btn btn-primary mt-3 ml-5">Add <i class="fa fa-plus"></i></a>

                        </div>

                    <?php } ?>

                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-12 w-100" id="table-id">
                                <table class="table  table-bordered " id="viewcom">
                                    <thead>
                                        <tr>
                                            <th>#</th>

                                            <th>Logo</th>

                                            <th>Service</th>

                                            <th>Operator</th>

                                            <th>Commission Type</th>

                                            <th>Commision Rate</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                        if (!empty($commissions)) {
                                            $i = 1;
                                            foreach ($commissions as $commission) :
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td>

                                                        <img src="<?php echo base_url('operator_image/' . $commission['op_logo']); ?>" width=50 height=50>

                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($commission['service'] == 'mobile') {
                                                            echo "Mobile Recharge";
                                                        } else if ($commission['service'] == 'dth') {
                                                            echo "DTH Recharge";
                                                        } else if ($commission['service'] == 'electric') {
                                                            echo "Electric Bill";
                                                        } else if ($commission['service'] == 'postpaid') {
                                                            echo 'Post Paid Bill';
                                                        } else if ($commission['service'] == 'loan') {
                                                            echo 'Loan Payment';
                                                        } else if ($commission['service'] == 'fastag') {
                                                            echo 'FASTag Recharge';
                                                        } else if ($commission['service'] == 'lpg_gas') {
                                                            echo 'LPG Gas';
                                                        } else if ($commission['service'] == 'insurance') {
                                                            echo 'Insurance';
                                                        } else if ($commission['service'] == 'broadband') {
                                                            echo 'Broadband';
                                                        } else if ($commission['service'] == 'municiple') {
                                                            echo 'Municiple Service';
                                                        } else if ($commission['service'] == 'credit') {
                                                            echo 'Credit Card';
                                                        } else if ($commission['service'] == 'landline') {
                                                            echo 'Landline';
                                                        } else if ($commission['service'] == 'cable') {
                                                            echo 'Cable';
                                                        } else if ($commission['service'] == 'subscription') {
                                                            echo 'Subscription';
                                                        } else if ($commission['service'] == 'bus_booking') {
                                                            echo 'Bus Booking';
                                                        } else {
                                                            echo $commission['service'];
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($commission['service'] == 'mobile') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'dth') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_dth_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'electric') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_services', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'postpaid') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_postpaid_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'loan') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_loan_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'fastag') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_fastag_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'lpg_gas') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_lpg_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'insurance') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_insurance_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'broadband') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_broadband_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'municiple') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_municiple_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'credit') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_creditcard_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'landline') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_landline_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'cable') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_cable_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'subscription') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo "All Operator";
                                                            } else {
                                                                $operator_code = $this->db->get_where('tbl_subscription_operator', ['opcode' => $commission['operator_code']])->row_array();
                                                                echo $operator_code['operator'];
                                                            }
                                                        } else if ($commission['service'] == 'bus_booking') {
                                                            if ($commission['operator_code'] == 'all') {
                                                                echo 'All Operator';
                                                            }
                                                        } else {
                                                            echo $commission['operator_code'];
                                                        }


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($commission['type'] == 'flat') {
                                                            echo "Flat";
                                                        } else if ($commission['type'] == 'percent') {
                                                            echo "Percentage";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><?= $commission['amount'] ?></td>

                                                    <td>
                                                        <a href="<?php echo base_url('showcommission/edit/' . $commission['id']); ?>" class="btn btn-primary btn-rounded mb-1"><i class="fa fa-edit"></i></a> &nbsp;

                                                        <a href="<?php echo base_url('showcommission/delete/' . $commission['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="return confirm('Do You Want to Delete?')"><i class="fa fa-times"></i></a>

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

    <script type="text/javascript">
        $(function() {
            $('#viewcom').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
        });
    </script>