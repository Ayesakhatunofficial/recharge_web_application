<div style="width: 1000px; border: 0px solid #666; margin: auto;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td width="10%">&nbsp;</td>
                <td width="40%" style="border: 1px dashed #999; padding: 5px; position: relative;">

                    <img src="<?= base_url(); ?>votercard/profile_image/<?= $voter['profile_photo']; ?>" width="100" height="130" alt="" style="position: absolute; top: 90px; left: 22px; z-index: 9;">
                    <span style="position: absolute; z-index: 999; margin: 0 auto; left: 0; right: 123px; top: 24%; font-family: Arial, sans-serif; color: #030303; width: 60%; font-weight: bold; text-transform: uppercase;"><?= $voter['epic_no']; ?>
                    </span>

                    <div style="position: absolute; left: 136px; top: 90px; font-family: arial; font-size: 14px; color: #000; font-weight: bold; "><?php if ($voter['language'] == 'HI') { ?>
                            नाम
                        <?php } else if ($voter['language'] == 'BN') { ?>
                            নাম
                        <?php } else if ($voter['language'] == 'PA') { ?>
                            ਨਾਮ
                        <?php } else if ($voter['language'] == 'GU') { ?>
                            નામ
                        <?php } else if ($voter['language'] == 'MR') { ?>
                            नाव
                        <?php } else if ($voter['language'] == 'TA') { ?>
                            பெயர்
                        <?php } else if ($voter['language'] == 'KN') { ?>
                            ಹೆಸರು
                        <?php } else if ($voter['language'] == 'TE') { ?>
                            పేరు
                        <?php } else if ($voter['language'] == 'OR') { ?>
                            ନାମ
                        <?php } else if ($voter['language'] == 'SD') { ?>
                            NA
                            <?php } ?>:<?= $voter['full_name_local_language']; ?></div>
                    <div style="position: absolute; left: 136px; top: 110px; font-family: arial; font-size: 14px; color: #000; font-weight: bold; ">Name:<?= $voter['name']; ?> </div>
                    <div style="position: absolute; left: 136px; top: 128px; font-family: arial; font-size: 14px; color: #000; font-weight: bold; "><?php if ($voter['language'] == 'HI') { ?>
                            पिता का नाम
                        <?php } else if ($voter['language'] == 'BN') { ?>
                            বাবার নাম
                        <?php } else if ($voter['language'] == 'PA') { ?>
                            ਪਿਤਾ ਦਾ ਨਾਮ
                        <?php } else if ($voter['language'] == 'GU') { ?>
                            પિતાનું નામ
                        <?php } else if ($voter['language'] == 'MR') { ?>
                            वडिलांचे नाव
                        <?php } else if ($voter['language'] == 'TA') { ?>
                            தந்தையின் பெயர்
                        <?php } else if ($voter['language'] == 'KN') { ?>
                            ತಂದೆಯ ಹೆಸರು
                        <?php } else if ($voter['language'] == 'TE') { ?>
                            తండ్రి పేరు
                        <?php } else if ($voter['language'] == 'OR') { ?>
                            ପିତାଙ୍କ ନାମ
                        <?php } else if ($voter['language'] == 'SD') { ?>
                            NA
                            <?php } ?>: <?= $voter['f_h_name_local_language']; ?></div>
                    <div style="position: absolute; left: 136px; top: 145px; font-family: arial; font-size: 14px; color: #000; font-weight: bold; ">Father's Name:<?= $voter['f_h_name']; ?> </div>
                    <?php
                    $img_url = '';
                    if ($voter['language'] == 'HI') {
                        $img_url = base_url() . 'votercard/e-voter/hindi.jpg';
                    } else if ($voter['language'] == 'BN') {
                        $img_url = base_url() . 'votercard/e-voter/Bengali.jpg';
                    } else if ($voter['language'] == 'PA') {
                        $img_url = base_url() . 'votercard/e-voter/punjabi.jpg';
                    } else if ($voter['language'] == 'GU') {
                        $img_url = base_url() . 'votercard/e-voter/gujarati.jpg';
                    } else if ($voter['language'] == 'MR') {
                        $img_url = base_url() . 'votercard/e-voter/marathi.jpg';
                    } else if ($voter['language'] == 'TA') {
                        $img_url = base_url() . 'votercard/e-voter/tamil.jpg';
                    } else if ($voter['language'] == 'KN') {
                        $img_url = base_url() . 'votercard/e-voter/kannada.jpg';
                    } else if ($voter['language'] == 'TE') {
                        $img_url = base_url() . 'votercard/e-voter/telgu.jpg';
                    } else if ($voter['language'] == 'OR') {
                        $img_url = base_url() . 'votercard/e-voter/odiya.jpg';
                    }
                    ?>
                    <img src="<?= $img_url; ?>" width="421" height="266" alt="">
                </td>

                <td width="40%" style="border-top: 1px dashed #999; border-right: 1px dashed #999; border-bottom: 1px dashed #999; padding: 5px; position: relative;">
                    <div style="position: absolute; left: 15px; top: 15px;">
                        <p style="margin: 0px; color: #000;"><?php if ($voter['language'] == 'HI') { ?>
                                लिंग
                            <?php } else if ($voter['language'] == 'BN') { ?>
                                লিঙ্গ
                            <?php } else if ($voter['language'] == 'PA') { ?>
                                ਲਿੰਗ
                            <?php } else if ($voter['language'] == 'GU') { ?>
                                લિંગ
                            <?php } else if ($voter['language'] == 'MR') { ?>
                                लिंग
                            <?php } else if ($voter['language'] == 'TA') { ?>
                                பாலினம்
                            <?php } else if ($voter['language'] == 'KN') { ?>
                                ಲಿಂಗ
                            <?php } else if ($voter['language'] == 'TE') { ?>
                                లింగం
                            <?php } else if ($voter['language'] == 'OR') { ?>
                                ଲିଙ୍ଗ
                            <?php } else if ($voter['language'] == 'SD') { ?>
                                NA
                                <?php } ?>/Gender : <?= $voter['gender']; ?></p>
                        <p style="margin: 0px; color: #000;"><?php if ($voter['language'] == 'HI') { ?>
                                जन्म तिथि
                            <?php } else if ($voter['language'] == 'BN') { ?>
                                জন্ম তারিখ
                            <?php } else if ($voter['language'] == 'PA') { ?>
                                ਜਨਮ ਤਾਰੀਖ
                            <?php } else if ($voter['language'] == 'GU') { ?>
                                જન્મ તારીખ
                            <?php } else if ($voter['language'] == 'MR') { ?>
                                जन्मतारीख
                            <?php } else if ($voter['language'] == 'TA') { ?>
                                పుట్టిన తేది
                            <?php } else if ($voter['language'] == 'KN') { ?>
                                ಹುಟ್ತಿದ ದಿನ
                            <?php } else if ($voter['language'] == 'TE') { ?>
                                பிறந்த தேதி
                            <?php } else if ($voter['language'] == 'OR') { ?>
                                ଜନ୍ମଦିନ
                            <?php } else if ($voter['language'] == 'SD') { ?>
                                xxxx
                                <?php } ?>/(Age):<?= $voter['dob']; ?></p>
                        <p style="margin: 0px; color: #000;"><?php if ($voter['language'] == 'HI') { ?>
                                पता:
                            <?php } else if ($voter['language'] == 'BN') { ?>
                                ঠিকানা:
                            <?php } else if ($voter['language'] == 'PA') { ?>
                                ਪਤਾ:
                            <?php } else if ($voter['language'] == 'GU') { ?>
                                સરનામું:
                            <?php } else if ($voter['language'] == 'MR') { ?>
                                पत्ता:
                            <?php } else if ($voter['language'] == 'TA') { ?>
                                முகவரி:
                            <?php } else if ($voter['language'] == 'KN') { ?>
                                ವಿಳಾಸ:
                            <?php } else if ($voter['language'] == 'TE') { ?>
                                చిరునామా:
                            <?php } else if ($voter['language'] == 'OR') { ?>
                                ଠିକଣା:
                            <?php } else if ($voter['language'] == 'SD') { ?>
                                xxxx
                                <?php } ?>:<?= $voter['address_local_language']; ?></p>
                        <p style="margin: 0px; color: #000;">Address:<?= $voter['address']; ?></p>
                    </div>
                    <div style="position: absolute; top: 160px; left: 70px; text-align: center;width:200px;">
                        <img width="120" height="28" alt="" src="<?= base_url(); ?>votercard/votersign.png" style="background: #fff;">
                        <p style="margin: 0px; color: #000;"><?= $voter['assembly_local']; ?></p>
                        <p style="margin: 0px; color: #000;"><?= $voter['assembly']; ?></p>
                        <p style="margin: 0px; color: #000;">Download Date:
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            $date = date('d-m-y');
                            echo $date;
                            ?>
                        </p>
                    </div>

                    <div style="position: absolute;top: 166px;left: 321px;z-index: 9;border: 4px solid #fff;">
                        <article style="display: none;">
                            <textarea id="plain_text">Voter ID : <?php $voter['epic_no']; ?>
                                Name : <?= $voter['name']; ?>
                                Date of Birth : <?= $voter['dob']; ?>
                                Gender : <?= $voter['gender']; ?>
                                Address : <?= $voter['address']; ?>
                                </textarea>
                        </article>
                        <div id="qrcode"></div>
                        <div id="previewImg"></div>
                    </div>
                    <?php
                    $img_back_url = '';
                    if ($voter['language'] == 'HI') {
                        $img_back_url = base_url() . 'votercard/e-voter/hindiback.jpg';
                    } else if ($voter['language'] == 'BN') {
                        $img_back_url = base_url() . 'votercard/e-voter/Bengaliback.jpg';
                    } else if ($voter['language'] == 'PA') {
                        $img_back_url = base_url() . 'votercard/e-voter/punjabiback.jpg';
                    } else if ($voter['language'] == 'GU') {
                        $img_back_url = base_url() . 'votercard/e-voter/gujaratiback.jpg';
                    } else if ($voter['language'] == 'MR') {
                        $img_back_url = base_url() . 'votercard/e-voter/marathiback.jpg';
                    } else if ($voter['language'] == 'TA') {
                        $img_back_url = base_url() . 'votercard/e-voter/tamilback.jpg';
                    } else if ($voter['language'] == 'KN') {
                        $img_back_url = base_url() . 'votercard/e-voter/kannadaback.jpg';
                    } else if ($voter['language'] == 'TE') {
                        $img_back_url = base_url() . 'votercard/e-voter/telguback.jpg';
                    } else if ($voter['language'] == 'OR') {
                        $img_back_url = base_url() . 'votercard/e-voter/odiyaback.jpg';
                    }
                    ?>
                    <img src="<?= $img_back_url; ?>" width="421" height="266" alt="">

                </td>
                <td width="10%">&nbsp;</td>
            </tr>
        </tbody>
    </table>

    &nbsp; &nbsp;
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
                    width: 94,
                    height: 94,
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

<script>
    window.addEventListener('load', function(e) {
        window.print();
    });
</script>