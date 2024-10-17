<style>
    .firstpage {
        height: 500px;
        background-size: contain;
        background-repeat: no-repeat;
        margin-right: 30px;
        width: 320px;
        float: none;
        position: relative;
        font-size: 15px;
        margin-bottom: 20px;
    }

    .secondpage {

        height: 500px;
        background-size: contain;
        background-repeat: no-repeat;
        margin-right: 30px;
        width: 320px;
        float: none;
        position: relative;
    }

    @font-face {
        font-family: mangal;
        src: url(font/MANGAL.TTF);
    }

    main.bg {
        font-family: 'arial', mangal;
        font-weight: 600;
    }



    .secondpage {
        font-size: 9px;
        font-weight: 600;
        box-sizing: border-box;
        padding: 14px;
    }

    .gender span.label,
    .dob span.label {
        width: 116px;
        display: inline-block;
    }

    .imagecontainer {
        position: absolute;
        top: 129px;
        left: 76px;
    }

    img.picture {
        width: 170px;
        height: 208px;
    }

    .barcode {
        width: 155px;
        height: 23px;
        position: absolute;
        top: 92px;
        left: 13px;
    }

    .epicnumber {
        position: absolute;
        top: 93px;
        left: 196px;
    }

    .settable {
        position: absolute;
        top: 365px;
        left: 25px;
    }

    .tablecss {
        font-family: arial;
        font-size: 14px;
        font-weight: bold;
    }

    .r_name {
        position: absolute;
        top: 331px;
        left: 25px;
    }

    .actual_name {
        position: absolute;
        left: 25px;
        top: 363px;
    }

    .father_name {
        position: absolute;
        left: 25px;
        top: 395px;
    }

    .father_name_actual {
        position: absolute;
        left: 25px;
        top: 427px;
    }

    .gender span.value {
        text-transform: capitalize;
    }

    .secondpage .gender {
        margin-bottom: 4px;
    }

    .secondpage .dob {
        position: relative;
        margin-bottom: 4px;
    }

    .secondpage .dob span.value {
        top: -5px;
        position: relative;
    }

    .address_regional {
        margin-bottom: 5px;
    }

    .address {
        margin-bottom: 60px;
    }

    .nirvachan .date {
        width: 100px;
        float: left;
    }

    .nirvachan .nirvachanofficer {
        float: right;
        width: 160px;
        text-align: right;
        position: relative;
    }

    img.officersign {
        position: absolute;
        top: -50px;
        left: 20px;
    }

    .nirvachan:before,
    .nirvachan:after {
        display: block;
        content: '';
        clear: both;
    }

    .nirvachan {
        margin-bottom: 10px;
    }

    .assemballysankhya .regional {
        margin-bottom: 4px;
    }

    .assemballysankhya {
        margin-bottom: 10px;
    }

    .bhagsankhya .regional {
        margin-bottom: 4px;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact;
        }
    }

    @page {
        size: auto;
        margin: 0mm;
    }

    @media print {
        a[href]:after {
            content: none !important;
        }
    }

    @media print {

        .header,
        .hide {
            visibility: hidden
        }

        form.bootom-form {
            display: none;
        }
    }
</style>

<body onload="window.print();">
    <main class="bg">
        <div class="row">
            <div class="firstpage" style='background-image: url(<?= base_url(); ?>votercard/voter2/hindi.jpg);'>
                <svg id="barcode" class="barcode"></svg>
                <div class="epicnumber"><?= $voter['epic_no']; ?></div>
                <div class="imagecontainer">
                    <img src='<?= base_url(); ?>votercard/profile_image/<?= $voter['profile_photo']; ?>' class="picture" />
                </div>
                <div class="settable">
                    <table class="tablecss" style="font-weight: bold; font-size: 12px;">
                        <tbody>
                            <tr>
                                <td style="padding-bottom: 15px;">नाम</td>
                                <td style="padding-bottom: 15px;">: <?= $voter['full_name_local_language']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 15px;">NAME</td>
                                <td style="padding-bottom: 15px;">: <?= $voter['name']; ?> </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 15px;">पिता का नाम</td>
                                <td style="padding-bottom: 15px;">: <?= $voter['f_h_name_local_language']; ?> </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 15px;">Father NAME</td>
                                <td style="padding-bottom: 15px;">: <?= $voter['f_h_name']; ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- kannada start -->
                <!-- kannada end -->
                <!-- tamil start -->
                <!-- tamil end -->
                <!-- marathi start -->
                <!-- marathi end -->
                <!-- language punjabi start -->
                <!-- language punjabi end -->
                <!-- gujrati start -->
                <!-- gujrati end -->
            </div>

            <div class="secondpage" style='background-image: url(<?= base_url(); ?>votercard/voter2/hindiback.jpg);''>
                        <div class="gender">
                            <span class="label">लिंग/Sex</span>
                            <span class="value">: पुरुष / <?= $voter['gender']; ?></span>
                        </div>
                        <div class="dob">
                            <span class="label">जन्म तिथि / आयु
                                <br />
                                Date Of Birth/Age
                            </span>
                            <span class="value">: <?= $voter['dob']; ?></span>
                        </div>
                        <div class="address_regional">
                            <span class="label">पता : </span>
                            <span class="value"><?= $voter['address_local_language']; ?></span>
                        </div>
                        <div class="address">
                            <span class="label">Address : </span>
                            <span class="value"><?= $voter['address']; ?></span>
                        </div>
                        <div class="nirvachan">
                            <div class="date">
                                <span class="label">Date:</span>
                                <span class="value"><?php
                                                    date_default_timezone_set('Asia/Kolkata');
                                                    $date = date('d-m-y');
                                                    echo $date;
                                                    ?></span>
                            </div>

                            <div class="nirvachanofficer">
                                <img class="officersign" src="<?= base_url(); ?>votercard/votersign.png" />
                                <span class="label">निर्वाचक रजिस्ट्रीकरण अधिकारी
                                    <br />
                                    Electoral Registration Officer
                                </span>
                                <span class="value"></span>
                            </div>
                        </div>
                        <div class="assemballysankhya">
                            <div class="regional">
                                <span class="label">विधानसभा निर्वाचन क्षेत्र संख्या और नाम : </span>
                                <span class="value">
                                    <br />
                                    <?= $voter['assembly_local']; ?>
                                </span>
                            </div>

                            <div class="actual">
                                Assembly Constituency No. &amp; Name :
                        <span class="value">
                            <br />
                            <?= $voter['assembly']; ?>
                        </span>
                            </div>
                        </div>
                        <div class="bhagsankhya">
                            <div class="regional">
                                <span class="label">भाग संख्या और नाम  : </span>
                                <span class="value"><?= $voter['part_no']; ?>- <?= $voter['part_name_local']; ?>   </span>
                            </div>

                            <div class="actual">
                                Part No. &amp; Name :
                        <span class="value"><?= $voter['part_no']; ?>- <?= $voter['part_name']; ?></span>
                            </div>
                        </div>
                        <table class="secondpage" style="font-size: 12px; left: -25px; top: 427px;"></table>
                    </div>

                </div>

    </main>
</body>


<script src="<?php echo base_url(); ?>assets/barjs/JsBarcode.all.min.js"></script>

<script>
    var data = "<?php echo $voter['epic_no']; ?>";
    console.log(data);
    window.onload = function() {
        JsBarcode("#barcode", data, {
            format: "CODE128",
            displayValue: false,
            width: 6,
            height: 70,
            text: data,
            fontOptions: "bold",
            textMargin: 1,
            textcolor : "red"
        });
        
        window.print();
    }
</script>