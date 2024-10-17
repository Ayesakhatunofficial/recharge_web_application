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

            <div class="col-md-6">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">DTH Reacharge</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="<?= base_url('dthrecharge_new/Recharge') ?>" method="POST">
                            <div class="form-group">
                                <label>DTH Number</label>
                                <input class="form-control" type="number" placeholder="XXXXXXXXXX" id="dth_no" name="dth_no">
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
                                <label class="form-control-label">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-addon bg-white">₹</div>
                                    <input class="form-control" type="text" placeholder="100" id="operator" name="amount">
                                    <div class="input-group-addon bg-white"><a href="#"> View Plans</a></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-lg" type="submit" id="recharge_button" onclick="disableBtn()">Continue to Recharge</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-6">
                Banner
            </div> -->
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
                            <th>DTH No</th>
                            <th>Amount</th>
                            <?php if (isset($_SESSION['role'])) { ?>
                                <th>API Commission(%)</th>
                                <th>API Profit(₹)</th>
                                <th>User</th>
                            <?php } ?>
                            <th>Commission(%)</th>
                            <th>Profit(₹)</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        if (!empty($datas)) {
                            foreach ($datas as $data) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?php
                                        $op_logo = $this->db->get_where('tbl_dth_operator', ['operator' => $data->operator])->row_array();
                                        ?>
                                        <img src="<?php echo base_url('operator_image/' . $op_logo['op_logo']); ?>" width=50 height=50>
                                    </td>
                                    <?php if (isset($_SESSION['slug'])) { ?>
                                        <td><?= $data->operator; ?></td>
                                    <?php } ?>
                                    <td><?= $data->ref_id ?></td>
                                    <td><?= $data->number ?></td>
                                    <td><?= $data->amount ?></td>
                                    <?php if (isset($_SESSION['role'])) { ?>
                                        <td><?= $data->api_commission; ?></td>
                                        <td><?= $data->api_profit; ?></td>
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
                                    <td><?= $data->margin ?></td>
                                    <td><?= $data->profit; ?></td>
                                    <td><?= (new DateTime($data->created_at))->format('d-m-Y H:i:s a') ?></td>

                                    <td><?php if ($data->status == 'SUCCESS') { ?><button class="btn btn-success btn-sm"><?= $data->status ?></button>
                                        <?php }
                                        if ($data->status == 'PENDING') { ?><button class="btn btn-warning btn-sm"><?= $data->status ?></button>
                                        <?php }
                                        if ($data->status == 'FAIL') { ?><button class="btn btn-danger btn-sm"><?= $data->status ?></button>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($data->status == 'SUCCESS') { ?>
                                            <a href="<?= base_url('dthbill/index/' . $data->id) ?>" class="btn btn-secondary" target="_blank"><i class="fa fa-print"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php $i++;
                            }
                        } ?>
                    </tbody>
                    <tfoot>
                        <?php if (!empty($total_amount) || $total_amount != "") {
                            // print_r($total_amount); 
                        ?>

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
                                    <td></td>
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




    <!-- <script>
        window.onload = function() {
            getOperator();
        }

        function getOperator() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('dthrecharge/getOperator') ?>',
                dataType: "json",
                success: function(response) {
                    var operatorSelect = $("#operator");
                    var lastSixElements = response.slice(-6);

                    lastSixElements.forEach(function(item) {
                        var option = '<option value="' + item.OpCode + '">' + item.Operator + '</option>';
                        operatorSelect.append(option);
                    });
                },
                error: function(response) {
                    console.log("Error:", response);
                }
            });
        }
    </script> -->