<style>
    @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900);

    .body {
        margin: 0;
        font-family: Rubik, sans-serif;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6a7a8c;
        text-align: left;
        background-color: #f2f4f5;
    }

    .col-4 {
        flex: 0 0 33.33333%;
        max-width: 33.33333%;
    }

    .col-7 {
        flex: 0 0 58.33333%;
        max-width: 58.33333%;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }

    .col,
    .col-1,
    .col-10,
    .col-11,
    .col-12,
    .col-2,
    .col-3,
    .col-4,
    .col-5,
    .col-6,
    .col-7,
    .col-8,
    .col-9,
    .col-auto,
    .col-lg,
    .col-lg-1,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-lg-auto,
    .col-md,
    .col-md-1,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-auto,
    .col-sm,
    .col-sm-1,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-sm-auto,
    .col-xl,
    .col-xl-1,
    .col-xl-10,
    .col-xl-11,
    .col-xl-12,
    .col-xl-2,
    .col-xl-3,
    .col-xl-4,
    .col-xl-5,
    .col-xl-6,
    .col-xl-7,
    .col-xl-8,
    .col-xl-9,
    .col-xl-auto {
        position: relative;
        width: 100%;
        padding-right: 10px;
        padding-left: 10px;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    * {
        outline: 0;
    }

    table {
        border-collapse: collapse;
    }
</style>
<div class="body" style="width: 1000px; border: 0px solid #666; margin: auto; font-family: Rubik,sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td style="background: #fff;" width="5%">&nbsp;</td>
                <td width="40%" style="border: 1px dashed #999; padding: 5px; position: relative;">
                    <?php if ($adhar['language'] == 'HI') { ?>
                        <img src='<?= base_url(); ?>Aadhar/hindi-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'BN') { ?>
                        <img src='<?= base_url(); ?>Aadhar/bangla-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'PA') { ?>
                        <img src='<?= base_url(); ?>Aadhar/punjabi-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'GU') { ?>
                        <img src='<?= base_url(); ?>Aadhar/gujrati-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'MR') { ?>
                        <img src='<?= base_url(); ?>Aadhar/marthi-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'TA') { ?>
                        <img src='<?= base_url(); ?>Aadhar/tamil-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'KN') { ?>
                        <img src='<?= base_url(); ?>Aadhar/kannad-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'TE') { ?>
                        <img src='<?= base_url(); ?>Aadhar/telgu-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'OR') { ?>
                        <img src='<?= base_url(); ?>Aadhar/odiya-fr.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'SD') { ?>
                        <img src='<?= base_url(); ?>Aadha/sindhi-fr.jpg' style="width: 100%;" />
                    <?php } ?>
                    <table style="position: absolute; top: 85px; border: 0; left: 37px;">
                        <tr>
                            <td style="width: 85px; border: none;">
                                <img src="<?= base_url(); ?>adhar_uploads/<?= $adhar['photo']; ?>" style="width: 100%;height:100px" />
                            </td>
                            <td style="border: none; padding-left: 10px;">
                                <p style="margin: 0; color: black; margin-top: -20px;"><?= $adhar['full_name_local_language']; ?></p>
                                <p style="margin: 0; color: black;"><?= $adhar['full_name']; ?></p>
                                <p style="margin: 0; color: black;">
                                    <?php if ($adhar['language'] == 'HI') { ?>
                                        जन्म तिथि
                                    <?php } else if ($adhar['language'] == 'BN') { ?>
                                        জন্ম তারিখ
                                    <?php } else if ($adhar['language'] == 'PA') { ?>
                                        ਜਨਮ ਤਾਰੀਖ
                                    <?php } else if ($adhar['language'] == 'GU') { ?>
                                        જન્મ તારીખ
                                    <?php } else if ($adhar['language'] == 'MR') { ?>
                                        जन्मतारीख
                                    <?php } else if ($adhar['language'] == 'TA') { ?>
                                        పుట్టిన తేది
                                    <?php } else if ($adhar['language'] == 'KN') { ?>
                                        ಹುಟ್ತಿದ ದಿನ
                                    <?php } else if ($adhar['language'] == 'TE') { ?>
                                        பிறந்த தேதி
                                    <?php } else if ($adhar['language'] == 'OR') { ?>
                                        ଜନ୍ମଦିନ
                                    <?php } else if ($adhar['language'] == 'SD') { ?>
                                        xxxx
                                    <?php } ?>
                                    /DOB :<?= $adhar['dob']; ?>7</p>
                                <p style="margin: 0; color: black;"><?= $adhar['gender_local_language']; ?>/<?= $adhar['gender']; ?></p>
                            </td>
                        </tr>

                    </table>
                    <h3 style="position: absolute; top: 82%; left: 50%; transform: translate(-50%, -50%); color: #000; font-weight: 400; font-size: 1.5rem; margin:0;">
                        <?php

                        $adharNo = explode('-', $adhar['adhar_no']);

                        echo $adharNo[0] . '  ' . $adharNo[1] . '  ' . $adharNo[2];
                        ?>
                    </h3>
                </td>
                <td width="40%" style="border-top: 1px dashed #999; border-right: 1px dashed #999; border-bottom: 1px dashed #999; padding: 5px; position: relative;">
                    <?php if ($adhar['language'] == 'HI') { ?>
                        <img src='<?= base_url(); ?>Aadhar/hindi-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'BN') { ?>
                        <img src='<?= base_url(); ?>Aadhar/bangla-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'PA') { ?>
                        <img src='<?= base_url(); ?>Aadhar/punjabi-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'GU') { ?>
                        <img src='<?= base_url(); ?>Aadhar/gujrati-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'MR') { ?>
                        <img src='<?= base_url(); ?>Aadhar/marthi-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'TA') { ?>
                        <img src='<?= base_url(); ?>Aadhar/tamil-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'KN') { ?>
                        <img src='<?= base_url(); ?>Aadhar/kannad-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'TE') { ?>
                        <img src='<?= base_url(); ?>Aadhar/telgu-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'OR') { ?>
                        <img src='<?= base_url(); ?>Aadhar/odiya-back.jpg' style="width: 100%;" />
                    <?php } else if ($adhar['language'] == 'SD') { ?>
                        <img src='<?= base_url(); ?>Aadha/sindhi-back.jpg' style="width: 100%;" />
                    <?php } ?>
                    <div class="row" style="position: absolute; top: 50px; border: 0; left: 25px;width: 100%;">
                        <div class="col-7" style="margin-top: 9px;">
                            <b>
                                <?php if ($adhar['language'] == 'HI') { ?>
                                    पता:
                                <?php } else if ($adhar['language'] == 'BN') { ?>
                                    ঠিকানা:
                                <?php } else if ($adhar['language'] == 'PA') { ?>
                                    ਪਤਾ
                                <?php } else if ($adhar['language'] == 'GU') { ?>
                                    સરનામું
                                <?php } else if ($adhar['language'] == 'MR') { ?>
                                    पत्ता
                                <?php } else if ($adhar['language'] == 'TA') { ?>
                                    முகவரி
                                <?php } else if ($adhar['language'] == 'KN') { ?>
                                    ವಿಳಾಸ
                                <?php } else if ($adhar['language'] == 'TE') { ?>
                                    చిరునామా
                                <?php } else if ($adhar['language'] == 'OR') { ?>
                                    ଠିକଣା
                                <?php } else if ($adhar['language'] == 'SD') { ?>
                                    xxxx
                                <?php } ?>
                            </b>

                            <small style="margin: 0; color: black; display: block;  line-height: 20px;"><?= $adhar['address_local_language']; ?></small>

                            <b>Address:</b>
                            <br />
                            <samll style="margin: 0; color: black; display: block; line-height: 20px; word-wrap: break-word;"><?= $adhar['address']; ?></samll>
                        </div>
                        <div class="col-4" style="top:30px">
                            <article style="display: none;">
                                <textarea id="plain_text">UID : <?php
                                                                $adharNo = explode('-', $adhar['adhar_no']);

                                                                echo $adharNo[0] . '  ' . $adharNo[1] . '  ' . $adharNo[2];
                                                                ?>
                                Name : <?= $adhar['full_name']; ?>
                                Date of Birth : <?= $adhar['dob']; ?>
                                Gender : <?= $adhar['gender']; ?>
                                Address : <?= $adhar['address']; ?>
                                </textarea>
                            </article>
                            <div id="qrcode"></div>
                            <div id="previewImg"></div>
                        </div>
                    </div>
                    <h3 style="position: absolute; top: 82%; left: 50%; transform: translate(-50%, -50%); color: #000; font-weight: 400; font-size: 1.5rem; margin:0;">
                        <?php

                        $adharNo = explode('-', $adhar['adhar_no']);

                        echo $adharNo[0] . '  ' . $adharNo[1] . '  ' . $adharNo[2];
                        ?>
                    </h3>
                </td>
                <td style="background: #fff;" width="5%">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>

<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/130527/qrcode.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.9.0/html-to-image.js"></script>


<script>
    function qr_generate() {
        $('#qrcode').empty();
        let select_val = 'text';
        if (select_val == 'text') {
            let plain_text = $('#plain_text').val();
            if (plain_text == '' || plain_text == null) {
                blank_qr();
            } else {
                $('#qrcode').qrcode({
                    width: 134,
                    height: 134,
                    text: plain_text
                });
            }
        }
    }

    function blank_qr() {
        $('#qrcode').empty();
        $('#qrcode').qrcode({
            width: 190,
            height: 190,
            text: '',
            rander: 'svg'
        });
    }
    $('input').on('change keyup', function() {
        qr_generate();
    })
    $('textarea').on('change keyup', function() {
        qr_generate();
    })
    $(document).ready(function() {
        qr_generate();
    })

    function download(canvas, filename) {
        var canvas = document.getElementById('canvas');
        var lnk = document.createElement('a'),
            e;

        lnk.download = filename;

        lnk.href = canvas.toDataURL("image/png;base64");

        if (document.createEvent) {
            e = document.createEvent("MouseEvents");
            e.initMouseEvent("click", true, true, window,
                0, 0, 0, 0, 0, false, false, false,
                false, 0, null);

            lnk.dispatchEvent(e);
        } else if (lnk.fireEvent) {
            lnk.fireEvent("onclick");
        }
    }
</script>