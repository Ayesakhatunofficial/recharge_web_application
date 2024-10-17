<style>
    @page {
        size: 8.5in 11.5in;
        margin: 15mm 15mm 5mm 15mm;
    }
</style>

<body style="margin: 0;" onload="window.print()" class="pace-done">
    <div class="pace pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <!-- <body > -->

    <div style="width: 1000px; border: 0px solid #666; margin: auto;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="40%" style="border: 1px dashed #999; padding: 5px; position: relative;">
                        <img src="<?= base_url(); ?>pan_uploads/<?= $pan['photo']; ?>" width="75" height="74" alt="" style="position: absolute; top: 79px; left: 22px; z-index: 9;" />
                        <span style="position: absolute; z-index: 999; margin: 0 auto; left: 0; right: 25px; text-align: center; top: 39%; font-family: Arial, sans-serif; color: #030303; width: 60%; font-weight:bold; text-transform: uppercase;"><?= $pan['pan_no']; ?>
                        </span>
                        <div style="position: absolute;top: 79px;left: 282px;z-index: 9;border: 4px solid #fff;">
                            <article style="display: none;">
                                <textarea id="plain_text">PAN No : <?= $pan['pan_no']; ?>
                                Name : <?= $pan['full_name']; ?>
                                Date of Birth : <?= $pan['dob']; ?>
                                </textarea>
                            </article>
                            <div id="qrcode"></div>
                            <div id="previewImg"></div>
                        </div>

                        <div style="position: absolute; left: 32px; top: 165px; font-family: arial; font-size: 14px; color: #000; font-weight: bold; text-transform: uppercase;"><?= $pan['full_name']; ?></div>
                        <div style="position: absolute; left: 32px; top: 200px; font-family: arial; font-size: 14px; color: #000; font-weight: bold; text-transform: uppercase;"><?= $pan['father_name']; ?></div>
                        <div style="position: absolute; left: 32px; top: 244px; font-family: arial; font-size: 14px; color: #000; font-weight: bold;"><?= $pan['dob']; ?></div>
                        <img width="120" height="28" alt="" style="position: absolute; top: 217px; left: 144px; z-index: 9;" src="<?= base_url(); ?>pan_uploads/<?= $pan['sign_photo']; ?>" />
                        <img src="<?= base_url(); ?>Pancard/UTIfront.jpg" width="421" height="266" alt="" />
                    </td>

                    <td width="40%" style="border-top: 1px dashed #999; border-right: 1px dashed #999; border-bottom: 1px dashed #999; padding: 5px;">
                        <img src="<?= base_url(); ?>Pancard/UTIback.jpg" width="421" height="266" alt="" />
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
                        width: 115,
                        height: 115,
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


</body>