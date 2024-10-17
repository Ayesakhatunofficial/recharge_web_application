<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php if ($mode == 'Staging') { ?>

        <script type="application/javascript" defer src="https://securegw-stage.paytm.in/merchantpgpui/checkoutjs/merchants/<?= $mid; ?>.js" onload="onScriptLoad();" crossorigin="anonymous"></script>

    <?php } else if ($mode == 'Production') { ?>
        <script type="application/javascript" defer src="https://securegw.paytm.in/merchantpgpui/checkoutjs/merchants/<?= $mid; ?>.js" onload="onScriptLoad();" crossorigin="anonymous"></script>

    <?php } ?>

    <script>
        var order_id = '<?php echo $_SESSION['order_id']; ?>';

        var token = '<?php echo $_SESSION['token']; ?>';

        console.log(order_id);

        console.log(token);

        function onScriptLoad() {
            var config = {
                "root": "",
                "flow": "DEFAULT",
                "data": {
                    "orderId": order_id,
                    "token": token,
                    "tokenType": "TXN_TOKEN",
                    "amount": "<?= $amount; ?>"
                },
                "handler": {
                    "notifyMerchant": function(eventName, data) {
                        console.log("notifyMerchant handler function called");
                        console.log("eventName => ", eventName);
                        console.log("data => ", data);
                    }
                }
            };
            if (window.Paytm && window.Paytm.CheckoutJS) {
                window.Paytm.CheckoutJS.onLoad(function excecuteAfterCompleteLoad() {
                    // initialze configuration using init method
                    window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
                        // after successfully updating configuration, invoke JS Checkout
                        window.Paytm.CheckoutJS.invoke();
                    }).catch(function onError(error) {
                        console.log("error => ", error);
                    });
                });
            }
        }
    </script>
</head>

<body>
    <!-- <h1>Final Payment</h1> -->
</body>

</html>