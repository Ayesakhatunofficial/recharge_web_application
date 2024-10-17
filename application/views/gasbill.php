<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <style>
        body {
            background-color: #ccc;
            font-family: 'Ubuntu', sans-serif;
        }

        table {
            background-color: #fff;
        }

        .title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 0;
            text-align: center;
        }

        .subtitle {
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 2px;
            margin-top: 0;
            text-align: center;
        }

        .subtitle.tleft {
            text-align: left;
        }

        h4 {
            margin-bottom: 1px;
            margin-top: 8px;
            text-align: center;
            font-size: 20px;
        }

        .small_latter {
            font-size: 12px;
            line-height: 13px;
        }

        .item_head th {
            border-bottom: 1px dashed #636363;
            font-size: 12px;
            line-height: 16px;
        }

        .item_head .pro tr {
            border-bottom: 1px solid #636363;
        }

        td.right {
            text-align: right;
        }

        .item_head.pro td {
            font-size: 11px;
            border-bottom: 1px dashed #636363;
            font-weight: 600;
        }

        .total_wrap td {
            /* border-bottom: 1px dashed #636363; */
            font-size: 11px;
            line-height: 9px;
            font-weight: 600;
        }

        .small_latter.tot {
            line-height: 13px;
        }

        .item_head.adj {
            border-left: 1px solid #636363;
            width: 100%;
            font-size: 13px;
        }

        .tb {
            border: 1px solid #636363;
            border-collapse: collapse;
        }

        .part2 tr {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-bottom: 1px solid #636363;
            border-collapse: collapse;
            border-image: none;
            border-top: 1px solid #636363;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }

        .light {
            text-align: left;
            font-weight: 100;
            color: gray;
            font-size: 11px;
        }

        .part2 td {
            border-left: 1px solid #636363;
            border-right: 1px solid #636363;
        }

        .tb2 {
            border-bottom: 1px solid #636363;
            font-size: 13px;
        }

        p {
            font-size: 12px;
            margin: 0;
            text-align: center;
        }
    </style>
</head>

<body onload="window.print();">
    <table width="850" style="padding: 0px;">
        <tr>
            <td style="text-align: center;">
                <img src="<?php echo base_url('operator_image/' . $operator['op_logo']); ?>" width=80 height=55>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Receipt</h4>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="small_latter">
                    <tr>
                        <td>Receipt No : <strong><?= $gas_bill['id']; ?></strong></td>

                        <td style="text-align: right">Customer ID : <strong><?= $gas_bill['customer_number']; ?></strong></td>
                    </tr>
                    <!-- <tr>
					
				</tr> -->
                    <tr>
                        <td>Customer Name : <strong><?= $gas_bill['customer_name']; ?></strong></td>
                        <td style="text-align: right">TXID : <strong><?= $gas_bill['trans_id']; ?></td>
                    </tr>
                    <!-- <tr>
					
				</tr> -->

                    <tr>
                        <td><?= $user['user_type'] ?> Number : <strong><?= 'XXXXXX'. substr(($gas_bill['pay_by']), -4); ?></strong></td>
                        <td style="text-align: right">Billing Date : <strong><?= date('d-m-Y', strtotime($gas_bill['date'])); ?></strong></td>

                    </tr>
                    <tr>
                        <td><?= $user['user_type'] ?> Name : <strong><?= $account['name'] ?></strong></td>
                    </tr>
                    <tr>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="item_head pro">
                    <tr>
                        <th style="text-align: left;">Item Name</th>
                        <th>Q</th>
                        <th>Price</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><?= $operator['operator']; ?>
                        </td>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: center;"><?= round($gas_bill['amount'], 2); ?><br></td>
                        <td style="text-align: right;"><?= round($gas_bill['amount'], 2); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="total_wrap">
                    <tr>
                        <td width="50%" style="text-align: left;">Total</td>
                        <td width="50%" style="text-align: right;"><?= round($gas_bill['amount'], 2); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--<tr>
		<td>			
			<table width="100%" class="part2" style="border-collapse: collapse;">	
				<tr>
					<td width="36%"></td>
					<td width="26%">SGST 2.5%</td>
					<td width="26%">CGST 2.5%</td>
				</tr>
				<tr>
					<td width="36%">Taxable Amount of 5%</td>
					<td width="26%">371.43</td>
					<td width="26%">371.43</td>

				</tr>
				<tr>
					<td width="36%">Tax Amount of 5%</td>
					<td width="26%">9.29</td>
					<td width="26%">9.29</td>
				</tr>
								<tr>
    				<td width="36%">Total</td>
    				<td width="26%">9.29</td>
    				<td width="26%">9.29</td>
				</tr>
				<tr>
					<td></td>
					<td>Total Tax Amount</td>
					<td>18.57</td>
				</tr>
				<tr>
					<td></td>
					<td>Total Taxable Amount</td>
					<td>371.43</td>
				</tr>
			</table>
		</td>
	</tr>--->

        <tr>
            <td>
                <table width="100%" class="tb2">
                    <tr>
                        <td><strong>Amount Paid</strong></td>
                        <td class="right"><strong><?= round($gas_bill['amount'], 2); ?></strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="small_latter tot">
                    <tr>
                        <td>Inwords: <?php echo $words . ' Only'; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="border-top: 1px dashed #ccc;">
                    <tr>
                        <td>
                            <p>This is a system generated invoice hence may not require signature | Print generated on <?= date('d-m-Y H:i:s a') ?></p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="border-top: 1px dashed #ccc;">
                    <tr>
                        <td>
                            <center><small class="footline" style="text-align: center;">THANK YOU. PLEASE VISIT AGAIN.</small></center>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>