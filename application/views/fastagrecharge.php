<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="row">

            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">FASTag Recharge</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">
                            <div class="col-md-6" id="search_info">
                                <form action="<?= base_url('fastagrecharge/Recharge') ?>" method="POST">
                                    <div class="form-group">
                                        <label>Vehical Registration Number</label>
                                        <input class="form-control" type="text" placeholder="Enter Vehical Registration Number" id="cust_id" name="cust_id" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Select Bank</label>
                                        <select class="form-control select2_demo_1 " name="service_code" id="operator" required>
                                            <option value="">Select Bank</option>
                                            <?php foreach ($services as $service) { ?>
                                                <option value="<?= $service->opcode ?>"><?= $service->operator ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-addon bg-white">₹</div>
                                            <input class="form-control" type="text" id="amount" name="amount">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <button class="btn btn-primary btn-lg" type="submit" id="recharge_button">Continue to Payment</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6" id="bill_info" style="display: none;">


                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- <div class="col-md-6">
                Banner
            </div> -->
        </div>

        <div class="ibox ibox-warning">
            <div class="ibox-head">
                <div class="ibox-title">FASTag Recharge History</div>
            </div>
            <div class="ibox-body" style="padding-left: 0;padding-right: 0;" id="table-id">
                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" id="viewtd">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>TXID</th>
                            <th>Service Code</th>
                            <th>Fastag Number</th>
                            <th>Amount</th>
                            <?php
                            if (isset($_SESSION['role'])) { ?>
                                <th>Api Profit</th>
                                <th>User</th>
                            <?php  }
                            ?>
                            <th>Profit(₹)</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        if (!empty($bill_data)) {
                            foreach ($bill_data as $data) { ?>

                                <tr>
                                    <td><?= $i ?></td>
                                    <td>
                                        <?php
                                        $op_logo = $this->db->get_where('tbl_fastag_operator', ['opcode' => $data->service_code])->row_array();
                                        ?>
                                        <img src="<?php echo base_url('operator_image/' . $op_logo['op_logo']); ?>" width=50 height=50>
                                    </td>
                                    <td><?= $data->trans_id ?></td>
                                    <td><?= $data->service_code; ?></td>
                                    <td><?= $data->customer_id ?></td>
                                    <td><?= $data->amount ?></td>
                                    <?php
                                    if (isset($_SESSION['role'])) { ?>
                                        <td><?= $data->dp; ?></td>
                                        <td>
                                            <?php
                                            $user = $this->db->get_where('users', ['mobile' => $data->recharge_by])->row_array();
                                            if (!empty($user)) {
                                                echo $user['name'];
                                            } else {
                                                echo "Super Admin";
                                            }
                                            ?>
                                        </td>
                                    <?php  }
                                    ?>
                                    <td>
                                        <?= $data->profit; ?>
                                    </td>
                                    <td><?= (new DateTime($data->created_at))->format('d-m-Y H:i:s a') ?></td>

                                    <td><?php if ($data->trans_status_code == 1) { ?><button class="btn btn-success btn-sm"><?= $data->trans_status ?></button>
                                            <?php }
                                        if ($data->trans_status_code == 0) {
                                            if ($data->status != '') {
                                            ?>
                                                <button class="btn btn-warning btn-sm"><?= $data->trans_status ?></button>
                                            <?php } else if ($data->status == '') { ?>
                                                <button class="btn btn-primary btn-sm"><?php echo 'Accepted'; ?></button>
                                            <?php }
                                        }
                                        if ($data->trans_status_code == 2) { ?><button class="btn btn-danger btn-sm"><?= $data->trans_status ?></button>
                                        <?php }
                                        if ($data->trans_status_code == 3) { ?><button class="btn btn-danger btn-sm"><?= $data->trans_status ?></button>
                                        <?php }
                                        if ($data->trans_status_code == 4) { ?><button class="btn btn-warning btn-sm"><?= $data->trans_status ?></button>
                                        <?php }
                                        if ($data->trans_status_code == 5) { ?><button class="btn btn-info btn-sm"><?= $data->trans_status ?></button>
                                            <?php }
                                        if ($data->trans_status_code == 6) {
                                            if ($data->trans_status != "") { ?>
                                                <button class="btn btn-warning btn-sm"><?= $data->trans_status ?></button>
                                            <?php } else if ($data->trans_status == '') { ?>
                                                <button class="btn btn-warning btn-sm"><?php echo 'In Process' ?></button>
                                        <?php   }
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?php if ($data->trans_status_code == 1) { ?>
                                            <a href="<?= base_url('fastagbill/index/' . $data->id) ?>" class="btn btn-secondary" target="_blank"><i class="fa fa-print"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php $i++;
                            }
                        } ?>
                    </tbody>
                    <tfoot>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= isset($total_amount->total_amount) ? $total_amount->total_amount : ''; ?></td>
                        <?php
                        if (isset($_SESSION['role'])) { ?>
                            <td><?= $total_amount->total_api_profit; ?></td>
                            <td></td>
                        <?php  }
                        ?>
                        <td><?= isset($total_amount->total_profit) ? $total_amount->total_profit : ''; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>


    <script>
        // window.onload = function() {
        //     getCustomerInfo();
        // }

        // function getCustomerInfo() {

        //     var cust_id = document.getElementById("cust_id").value;
        //     var servicecode = document.getElementById("operator").value;
        //     if (cust_id && servicecode) {
        //         document.getElementById("loader").style.display = "block";
        //         document.getElementById("bill_info").style.display = "block";
        //         // alert(servicecode);
        //         $.ajax({
        //             type: 'POST',
        //             url: '<?= base_url('fastagrecharge/getCustomerInfo') ?>',
        //             data: {
        //                 cust_id: cust_id,
        //                 servicecode: servicecode
        //             },
        //             dataType: "json",
        //             success: function(response) {
        //                 // alert(response);
        //                 console.log(response.BILLDUEDATE);
        //                 document.getElementById("customer_id").value = cust_id;
        //                 document.getElementById("service_code").value = servicecode;
        //                 document.getElementById("cust_name").value = response.CUSTNAME;
        //                 document.getElementById("due_date").value = response.BILLDUEDATE;
        //                 document.getElementById("amount").value = response.BILLAMT;

        //                 document.getElementById("loader").style.display = "none";
        //                 document.getElementById("search_button").style.display = "none";

        //             },
        //             error: function(response) {
        //                 console.log("Error:", response);

        //                 document.getElementById("loader").style.display = "none";
        //             }
        //         });
        //     } else {
        //         alert('Please fill the required data');
        //     }

        // }
    </script>