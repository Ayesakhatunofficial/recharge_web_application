<html>

<head>
    <title>Gateway Check Out Page</title>
</head>

<body>
    <center>
        <h1>Please do not refresh this page...</h1>
    </center>
    <form method="post" action="<?= base_url('walletupi') ?>" name="f1">
        <table border="1">
            <tbody>
                <?php
                foreach ($paramList as $name => $value) {
                    echo '<input type="hidden" style="width: 80%; margin-top: 10px;" name="' . $name . '" value="' . $value . '"><br>';
                }
                ?>
                <input type="hidden" style="width: 80%; margin-top: 10px;" name="checksum" value="<?php echo $checkSum ?>">
            </tbody>
        </table>
        <script type="text/javascript">
            document.f1.submit();
        </script>
    </form>

</body>

</html>



