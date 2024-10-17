<style>
    .thead {
        display: block;
        background: #eaecff;
    }

    .tbody {
        display: block;
        width: 100%;
        overflow: auto;
        max-height: 400px;
    }
</style>

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

            <div class="col-md-5">
                <div class="ibox ibox-primary">

                    <div class="ibox-head ">

                        <div class="ibox-title">Mobile Reacharge</div>

                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>

                    </div>


                    <div class="ibox-body">

                        <form action="<?= base_url('mobilerecharge/Recharge') ?>" method="POST">

                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="form-control" type="number" placeholder="XXXXXXXXXX" id="mob_no" name="mob_no">
                            </div>


                            <div class="form-group">
                                <label class="form-control-label">Select Your Operator</label>
                                <select class="form-control select2_demo_1 " name="operator" id="operator">
                                    <option value="">Select Operator</option>
                                    <?php foreach ($operators as $operator) { ?>
                                        <option value="<?= $operator['opcode']; ?>"><?= $operator['operator']; ?></option>
                                    <?php }  ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Select Your Circle</label>
                                <select class="form-control select2_demo_1 " name="circle" id="circle">
                                    <option value="">Select Circle</option>
                                    <option value="west-bengal">West Bengal</option>
                                    <option value="kolkata">Kolkata</option>
                                    <option value="andra-pradesh-telangana">Andhra Pradesh & Telengana</option>
                                    <option value="assam">Assam</option>
                                    <option value="bihar-jharkhand">Bihar & Jharkhand</option>
                                    <option value="chennai">Chennai / Madras</option>
                                    <option value="delhi-ncr">Delhi & NCR </option>
                                    <option value="gujarat">Gujarat</option>
                                    <option value="haryana">Haryana</option>
                                    <option value="himachal-pradesh">Himachal Pradesh</option>
                                    <option value="jammu-kashmir">Jammu & Kashmir</option>
                                    <option value="karnataka">Karnataka</option>
                                    <option value="kerala">Kerala</option>
                                    <option value="madhya-pradesh-chhattisgarh">Madhya Pradesh & Chattisgarh</option>
                                    <option value="maharashtra-goa">Maharashtra & Goa</option>
                                    <option value="mumbai">Mumbai / Bombay</option>
                                    <option value="north-east">North East</option>
                                    <option value="odisha">Orissa</option>
                                    <option value="punjab">Punjab</option>
                                    <option value="rajasthan">Rajasthan</option>
                                    <option value="tamilnadu">Tamilnadu</option>
                                    <option value="uttar-pradesh-east">UP EAST</option>
                                    <option value="upwest-uttarakhand">UP WEST & Uttarakhand</option>
                                    <option value="west-bengal">Sikkim</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label class="form-control-label">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-addon bg-white">₹</div>
                                    <input class="form-control" type="text" placeholder="100" id="amount" name="amount">
                                    <div class="input-group-addon bg-white "><a data-toggle="modal" data-target="#largeModal" onclick="getPlans()"> View Plans</a></div>
                                </div>
                            </div>



                            <div class="form-group">
                                <button class="btn btn-primary btn-lg" type="submit" id="recharge_button">Continue to Recharge</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <img src="<?php echo base_url(); ?>assets/img/slider/recharge.jpg" width="100%" />
            </div>
        </div>

        <div class="ibox ibox-warning">
            <div class="ibox-head">
                <div class="ibox-title">Reacharge History</div>
            </div>


            <div class="ibox-body" style="padding-left: 0;padding-right: 0;" id="table-id">
                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" id="viewtd">
                    <thead>
                        <tr>
                            <th>#</th>

                            <th>Logo</th>

                            <?php if (isset($_SESSION['slug'])) { ?>
                                <th>Operator</th>
                            <?php } ?>

                            <th>TXID</th>

                            <th>Mobile</th>

                            <th>Amount</th>

                            <?php if (isset($_SESSION['role'])) { ?>

                                <th>API(%)</th>

                                <th>API(₹)</th>

                            <?php }
                            if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>

                                <th>User</th>

                            <?php } ?>

                            <th>Percent(%)</th>

                            <th>Profit(₹)</th>

                            <th>Date</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php $i = 1;

                        if (!empty($datas)) {

                            // echo '<pre>';
                            // print_r($datas);
                            // die;
                            foreach ($datas as $data) { ?>

                                <tr>
                                    <td><?= $i ?></td>

                                    <td>
                                        <?php
                                        $op_logo = $this->db->get_where('tbl_operator', ['operator' => $data->operator])->row_array();
                                        ?>
                                        <img src="<?php echo base_url('operator_image/' . $op_logo['op_logo']); ?>" width=40 height=40>
                                    </td>

                                    <?php if (isset($_SESSION['slug'])) { ?>
                                        <td><?= $data->operator; ?></td>
                                    <?php } ?>

                                    <td><?= $data->ref_id; ?></td>

                                    <td><?= $data->number; ?></td>

                                    <td><?= $data->amount; ?></td>

                                    <?php if (isset($_SESSION['role'])) { ?>

                                        <td><?= $data->api_commission; ?></td>

                                        <td><?= $data->api_profit; ?></td>

                                    <?php }
                                    if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>

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

                                    <?php } ?>

                                    <td><?= ($data->status != 'FAIL') ? $data->margin : '0.000'; ?></td>

                                    <td><?= ($data->status != 'FAIL') ? $data->profit : '0.000'; ?></td>

                                    <td><?= (new DateTime($data->created_at))->format('d-m-Y H:i:s a'); ?></td>


                                    <td>
                                        <?php if ($data->status == 'SUCCESS') { ?><button class="btn btn-success btn-sm"><?= $data->status ?></button>

                                        <?php } else if ($data->status == 'PENDING') { ?><button class="btn btn-warning btn-sm"><?= $data->status ?></button>

                                        <?php } else if ($data->status == 'FAIL') { ?><button class="btn btn-danger btn-sm"><?= $data->status ?></button>

                                        <?php } else {
                                            echo $data->status;
                                        } ?>
                                    </td>

                                    <td>
                                        <?php if ($data->status == 'SUCCESS') { ?>

                                            <a href="<?= base_url('mobilebill/index/' . $data->id) ?>" class="btn btn-secondary" target="_blank"><i class="fa fa-print"></i></a>

                                        <?php } ?>
                                    </td>

                                </tr>

                        <?php $i++;
                            }
                        } ?>

                    </tbody>

                    <tfoot>
                        <?php if (!empty($total_amount) || $total_amount != "") { ?>

                            <tr>
                                <td></td>

                                <td></td>

                                <?php if (isset($_SESSION['slug'])) { ?>
                                    <td></td>
                                <?php } ?>

                                <td></td>

                                <td></td>

                                <td>
                                    <?php
                                    if (!empty($total_amount->total_amount || $total_amount->total_amount != "")) {
                                        echo $total_amount->total_amount;
                                    } else {
                                        echo " ";
                                    }
                                    ?>
                                </td>

                                <?php if (isset($_SESSION['role'])) { ?>
                                    <td>
                                        <?php
                                        if (!empty($total_amount->t_commission && $total_amount->t_com) || ($total_amount->t_commission != " " && $total_amount->t_com != 0)) {
                                            echo round($total_amount->t_commission / $total_amount->t_com, 3);
                                        } else {
                                            echo " 0 ";
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        if (!empty($total_amount->t_api_profit) || $total_amount->t_api_profit != " ") {
                                            echo $total_amount->t_api_profit;
                                        }
                                        ?>
                                    </td>

                                <?php }
                                if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>

                                    <td>
                                    </td>

                                <?php } ?>

                                <td>
                                    <?php
                                    if ($total_amount->total_margin != " " && $total_amount->t_margin != 0) {
                                        echo round($total_amount->total_margin / $total_amount->t_margin, 3);
                                    }
                                    ?>
                                </td>

                                <td><?= $total_amount->total_profit; ?></td>

                                <td></td>

                                <td></td>

                                <td></td>

                            </tr>

                        <?php } ?>

                    </tfoot>

                </table>
            </div>
        </div>

    </div>


    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">View Plans</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;padding-bottom: 0;">

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-11-1" aria-expanded="true">

                            <table class="table table-striped visitors-table" id="plan_table">

                                <thead class="thead">

                                    <tr>

                                        <th width="9%">Operator</th>

                                        <th width="66%">Details</th>

                                        <th width="10%" style="text-align: center;">Validity</th>

                                        <th width="15%" style="text-align: right;">Pack</th>

                                    </tr>

                                </thead>

                                <tbody class="tbody">

                                    <tr>

                                    </tr>

                                </tbody>

                            </table>

                        </div>
                        <div class="tab-pane" id="tab-11-2" aria-expanded="false">

                        </div>
                        <div class="tab-pane" id="tab-11-3" aria-expanded="false">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        function getPlans() {
            var circle = document.getElementById("circle").value;
            var operator = document.getElementById("operator").value;
            if (operator == 10) {
                opcode = 'airtel';
            } else if (operator == 11 || operator == 12) {
                opcode = 'bsnl';
            } else if (operator == 21 || operator == 13) {
                opcode = 'mtnl';
            } else if (operator == 14) {
                opcode = 'jio';
            } else if (operator == 15) {
                opcode = 'vodafoneidea';
            }
            // alert(opcode);
            $.ajax({
                type: 'POST',
                url: '<?= base_url('mobilerecharge/getPlans') ?>',
                data: {
                    circle: circle,
                    opcode: opcode,
                    operator: operator
                },
                dataType: "json",
                success: function(response) {
                    var plans = response.api_response.data || [];
                    var logo = response.logo || '';

                    // Clear existing rows in the table
                    $('#plan_table .tbody').empty();

                    // Iterate through the plans and update the table
                    plans.forEach(function(plan) {
                        var row = '<tr>' +
                            '<td width="11%"><img class="m-r-10" style="width: 40px;" src="' + logo + '"></td>' +
                            '<td width="66%">' + plan.details + '</td>' +
                            '<td width="10%" style="text-align: center;">' + plan.validity + '</td>' +
                            '<td width="15%" style="text-align: right;"><button onclick="getPrice(' + plan.price + ')" class="btn btn-danger" style="display: block;width:100%;background-color: #e40000;border-color: #e40000;" data-dismiss="modal"><strong>' + plan.price + '</strong></button></td>' +
                            '</tr>';
                        $('#plan_table .tbody').append(row);
                    });

                },
                error: function(response) {
                    console.log("Error:", response);
                }
            });
        }

        function getPrice(price) {
            document.getElementById("amount").value = price;

        };
    </script>