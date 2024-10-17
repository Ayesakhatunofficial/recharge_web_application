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
                        <div class="ibox-title">View Commission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-md-12 w-100" id="table-id">
                                <table class="table  table-bordered " id="viewcom">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Type</th>
                                            <th>User Name / Mobile</th>
                                            <th>Service</th>
                                            <th>Operator</th>
                                            <th>Commission Type</th>
                                            <th>Commision Rate</th>
                                            <!-- <th>Range Amount</th> -->
                                            <!-- <th>TDS/GST</th>
                                            <th>Chain Type</th> -->
                                            <!-- <th>Transaction Type</th> -->
                                            <!-- <th>For Any Specific users</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($commissions as $commission) :
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php
                                                    $usertype = $this->db->get_where('user_type', ['slug' => $commission['user_type']])->row_array();
                                                    echo $usertype['user_type'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $user = $this->db->get_where('users', ['id' => $commission['user_id']])->row_array();
                                                    echo $user['name'] . '<br>' . $user['mobile'];
                                                    ?>
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
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'dth') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_dth_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'electric') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_services', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'postpaid') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_postpaid_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'loan') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_loan_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'fastag') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_fastag_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'lpg_gas') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_lpg_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'insurance') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_insurance_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'broadband') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_broadband_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'municiple') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_municiple_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'credit') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_creditcard_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'landline') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_landline_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'cable') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_cable_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'subscription') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo "All Operator";
                                                        } else {
                                                            $mob_operator = $this->db->get_where('tbl_subscription_operator', ['opcode' => $commission['mob_operator']])->row_array();
                                                            echo $mob_operator['operator'];
                                                        }
                                                    } else if ($commission['service'] == 'bus_booking') {
                                                        if ($commission['mob_operator'] == 'all') {
                                                            echo 'All Operator';
                                                        }
                                                    } else {
                                                        echo $commission['mob_operator'];
                                                    }




                                                    // . " - " . $commission['fp_amount'] : $commission['fp_amount'];
                                                    ?>
                                                </td>

                                                <td><?php
                                                    if ($commission['commission_type'] == 'flat') {
                                                        echo "Flat";
                                                    } else if ($commission['commission_type'] == 'percent') {
                                                        echo "Percentage";
                                                    }
                                                    ?></td>

                                                <td><?= $commission['fp_amount']; ?></td>

                                                <!-- <td><?php
                                                            // echo $commission['from_amount'] .' - ' . $commission['to_amount'];; 
                                                            ?></td> -->
                                                <!-- <td><? //php echo $commission['tds_gst']; 
                                                            ?></td> -->
                                                <!-- <td>
                                                    <?php
                                                    // if ($commission['chain_type'] == 'abc') {
                                                    //     echo 'ABC';
                                                    // } else {
                                                    //     echo 'XYZ';
                                                    // }
                                                    ?>
                                                </td> -->
                                                <!-- <td>
                                                    <?php
                                                    // if ($commission['transaction_type'] == 'cr') {
                                                    //     echo 'Credit';
                                                    // } else {
                                                    //     echo 'Debit';
                                                    // }
                                                    ?>
                                                </td> -->
                                                <!-- <td><? //= $commission['specific_user']; 
                                                            ?></td> -->

                                                <td><a href="<?php echo base_url('Editcommission/index/' . $commission['id']); ?>" class="btn btn-primary btn-rounded mb-1"><i class="fa fa-edit"></i></a> &nbsp;
                                                    <a href="<?php echo base_url('Deletecommission/index/' . $commission['id']); ?>" class="btn btn-danger delBtn btn-rounded" onclick="return confirm('Do You Want to Delete?')"><i class="fa fa-times"></i></a>
                                                </td>
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