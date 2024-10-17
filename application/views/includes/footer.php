<footer class="page-footer">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6264418459963919" crossorigin="anonymous"></script>
    <!-- 8X1 Ads -->
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6264418459963919" data-ad-slot="2331845755" data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    <?php
    if ($_SESSION['slug'] == 'admin') {
        $adminId = $_SESSION['user_id'];
        $admin_data = $this->db->get_where('users', ['id' => $adminId])->row_array();
        if (isset($admin_data['title']) && $admin_data['title'] != NULL) {
    ?>

            <div class="font-13">2024 © <b>
                    <?= $admin_data['name'] ?> RECHARGE
                </b> - All rights reserved.</div>
            <a class="px-4" href="<?= $admin_data['url'] ?>" target="_blank">
                <?= $admin_data['title'] ?>
            </a>
            <div class="to-top"><i class="fa fa-angle-double-up"></i></div>

        <?php } else { ?>
            <div class="font-13">2024 © <b>DTPL RECHARGE</b> - All rights reserved.</div>
            <a class="px-4" href="http://desuntechnology.in/" target="_blank">Desun Technology Pvt Ltd</a>
            <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
        <?php }
    } else {

        if ($_SESSION['slug']) {
            $created_by_id = $_SESSION['created_by_id'];  // d
            $create_by = $_SESSION['created_by'];

            $user_1 = $this->db->get_where('users', ['id' => $created_by_id])->row(); //d
            $user_1_createdById = $user_1->created_by_id; // sd

            $user_1_type = $user_1->create_by;

            $user_2 = $this->db->get_where('users', ['id' => $user_1_createdById])->row(); //sd

            $user_2_createdById = $user_2->created_by_id;   // a

            $user_2_type = $user_2->create_by;

            $user_3 = $this->db->get_where('users', ['id' => $user_2_createdById])->row(); //a
            $user_3_type = $user_3->create_by;


            if ($create_by == 'admin' && isset($user_1->title)) {
                $f_title = $user_1->title;
                $f_url = $user_1->url;
                $f_name = $user_1->name;
            } else if ($user_1_type == 'admin' && isset($user_2->title)) {
                $f_title = $user_2->title;
                $f_url = $user_2->url;
                $f_name = $user_2->name;
            } else if ($user_2_type == 'admin' && isset($user_3->title)) {
                $f_title = $user_3->title;
                $f_url = $user_3->url;
                $f_name = $user_3->name;
            } else {
                $f_title = 'Desun Technology Pvt Ltd';
                $f_url = 'http://desuntechnology.in/';
                $f_name = 'DTPL';
            }
        ?>
            <div class="font-13">2024 © <b>
                    <?= $f_name ?> RECHARGE
                </b> - All rights reserved.</div>
            <a class="px-4" href="<?= $f_url ?>" target="_blank">
                <?= $f_title ?>
            </a>
            <div class="to-top"><i class="fa fa-angle-double-up"></i></div>

        <?php } else { ?>

            <div class="font-13">2024 © <b>DTPL RECHARGE</b> - All rights reserved.</div>
            <a class="px-4" href="http://desuntechnology.in/" target="_blank">Desun Technology Pvt Ltd</a>
            <div class="to-top"><i class="fa fa-angle-double-up"></i></div>

    <?php }
    } ?>

</footer>
</div>
</div>
<div class="mob-footer-icon">
    <ul>
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-home"></i>
                <center>Home</center>
            </a></li>
        <li><a href="#"><i class="fa fa-percent"></i>
                <center>Commission</center>
            </a></li>
        <li><a href="#" data-toggle="modal" data-target="#paymentupi"><i class="fas fa-wallet"></i>
                <center>Wallet</center>
            </a></li>
        <li><a href="tel:+918777846136"><i class="fa fa-phone"></i>
                <center>Contact</center>
            </a></li>
        <li>
            <?php
            if (isset($_SESSION['slug'])) {
                $user_code = $_SESSION['user_code'];
                $refer_url = base_url('signup/index/' . $user_code);
            } elseif (isset($_SESSION['role'])) {
                $refer_url = base_url('signup');
            }

            $text = '👉 Register Now  ';
            $text1 = '🎈Dear Friend, Create Your Account, Earn Money With Highest Margin, Hurry Up..!🎈   ';
            $text2 = '🔥EARN UPTO 7% ON MOBILE RECHARGE';
            $text3 = '🔥UPTO 3% ON DTH RECHARGE';
            $text4 = '🔥FLAT ₹1 ON ELECTRICITY BILL';

            $line_break = '%0a';
            // $image_url = base_url(). 'assets/share.jpeg';
            ?>



            <a href="whatsapp://send?text=<?= urlencode($text1) . $line_break . $line_break . $text . urlencode($refer_url) . $line_break . $line_break . urlencode($text2) . $line_break . urlencode($text3) . $line_break . urlencode($text4) ?>" data-action="share/whatsapp/share" target="_blank"><i class="fa fa-share"></i>
                <center>Share</center>
            </a>
        </li>
    </ul>
</div>
<!-- BEGIN PAGA BACKDROPS-->

<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>



<div class="modal fade" id="paymentupi" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Wallet Recharge</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('walletupi/Recharge') ?>" method="post" id="paymentForm">
                <div class="modal-body" style="padding-top: 0;padding-bottom: 0;">


                    <!-- <h5>Gateway Type:</h5> -->
                    <!-- <select type="hidden" name="gateway_type" id="gateway_type" class="form-control" required> -->
                    <!--<option "Advanced">Advanced</option>-->
                    <!-- <option "Robotics">Robotics</option> -->
                    <!--<option "Normal">Normal</option>-->
                    <!-- </select> -->
                    <input type="hidden" value="Robotics" name="gateway_type" id="gateway_type" required>
                    <br>

                    <h5>Mobile No</h5>
                    <input type="text" name="cust_Mobile" id="txn_cust_mobile" placeholder="Enter Your Mobile" maxlength="10" class="form-control" value="<?= isset($_SESSION['mobile']) ? $_SESSION['mobile'] : 8777846136; ?>" readonly required><br>



                    <h5>Remark</h5>
                    <input type="text" name="txnNote" id="txnnote" value="Wallet Recharge" placeholder="Enter Txn Note" class="form-control" readonly required><br>

                    <h5>Amount</h5>
                    <input type="text" name="txnAmount" id="txnamount" value="500" onkeyup="getError()" class="form-control" required>
                    <div id="amt_error" style="color:red"></div>
                    <small><b>Limit Per Day(₹100.00 - ₹50000.00)</b></small>
                    <br>


                    <!-- <h5>Email:</h5> -->
                    <input type="hidden" name="cust_Email" id="txn_cust_email" placeholder="Enter Your Email" class="form-control" value="<?= $_SESSION['email']; ?>" readonly required><br>
                    <!-- <button value="Payment" class="btn btn-primary" onclick="RechargeWallet();"> -->



                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Confirm">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!---<button type="button" class="btn btn-primary">Save changes</button>----->
                </div>
            </form>
        </div>
    </div>
</div>



<!-- END PAGA BACKDROPS-->
<!-- BEGIN THEME CONFIG PANEL-->
<!--<div class="theme-config">
    <div class="theme-config-toggle"><i class="fa fa-cog theme-config-show"></i><i class="ti-close theme-config-close"></i></div>
    <div class="theme-config-box">
        <div class="text-center font-18 m-b-20">SETTINGS</div>
        <div class="font-strong">LAYOUT OPTIONS</div>
        <div class="check-list m-b-20 m-t-10">
            <label class="ui-checkbox ui-checkbox-gray">
                <input id="_fixedNavbar" type="checkbox" checked>
                <span class="input-span"></span>Fixed navbar</label>
            <label class="ui-checkbox ui-checkbox-gray">
                <input id="_fixedlayout" type="checkbox">
                <span class="input-span"></span>Fixed layout</label>
            <label class="ui-checkbox ui-checkbox-gray">
                <input class="js-sidebar-toggler" type="checkbox">
                <span class="input-span"></span>Collapse sidebar</label>
        </div>
        <div class="font-strong">LAYOUT STYLE</div>
        <div class="m-t-10">
            <label class="ui-radio ui-radio-gray m-r-10">
                <input type="radio" name="layout-style" value="" checked="">
                <span class="input-span"></span>Fluid</label>
            <label class="ui-radio ui-radio-gray">
                <input type="radio" name="layout-style" value="1">
                <span class="input-span"></span>Boxed</label>
        </div>
        <div class="m-t-10 m-b-10 font-strong">THEME COLORS</div>
        <div class="d-flex m-b-20">
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Default">
                <label>
                    <input type="radio" name="setting-theme" value="default" checked="">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-white"></div>
                    <div class="color-small bg-ebony"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Blue">
                <label>
                    <input type="radio" name="setting-theme" value="blue">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-blue"></div>
                    <div class="color-small bg-ebony"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Green">
                <label>
                    <input type="radio" name="setting-theme" value="green">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-green"></div>
                    <div class="color-small bg-ebony"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Purple">
                <label>
                    <input type="radio" name="setting-theme" value="purple">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-purple"></div>
                    <div class="color-small bg-ebony"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Orange">
                <label>
                    <input type="radio" name="setting-theme" value="orange">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-orange"></div>
                    <div class="color-small bg-ebony"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Pink">
                <label>
                    <input type="radio" name="setting-theme" value="pink">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-pink"></div>
                    <div class="color-small bg-ebony"></div>
                </label>
            </div>
        </div>
        <div class="d-flex">
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="White">
                <label>
                    <input type="radio" name="setting-theme" value="white">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color"></div>
                    <div class="color-small bg-silver-100"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Blue light">
                <label>
                    <input type="radio" name="setting-theme" value="blue-light">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-blue"></div>
                    <div class="color-small bg-silver-100"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Green light">
                <label>
                    <input type="radio" name="setting-theme" value="green-light">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-green"></div>
                    <div class="color-small bg-silver-100"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Purple light">
                <label>
                    <input type="radio" name="setting-theme" value="purple-light">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-purple"></div>
                    <div class="color-small bg-silver-100"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Orange light">
                <label>
                    <input type="radio" name="setting-theme" value="orange-light">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-orange"></div>
                    <div class="color-small bg-silver-100"></div>
                </label>
            </div>
            <div class="color-skin-box" data-toggle="tooltip" data-original-title="Pink light">
                <label>
                    <input type="radio" name="setting-theme" value="pink-light">
                    <span class="color-check-icon"><i class="fa fa-check"></i></span>
                    <div class="color bg-pink"></div>
                    <div class="color-small bg-silver-100"></div>
                </label>
            </div>
        </div>
    </div>
</div>-->
<!-- END THEME CONFIG PANEL-->
<!-- CORE PLUGINS-->
<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- PAGE LEVEL PLUGINS-->
<script src="<?php echo base_url(); ?>assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
<!-- CORE SCRIPTS-->
<script src="<?php echo base_url(); ?>assets/js/app.min.js" type="text/javascript"></script>

<!-- PAGE LEVEL PLUGINS-->
<!--<script src="<?php //echo base_url(); 
                    ?>assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
<script src="<?php //echo base_url(); 
                ?>assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
<script src="<?php //echo base_url(); 
                ?>assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<script src="<?php //echo base_url(); 
                ?>assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>--->

<!-- PAGE LEVEL SCRIPTS-->
<!--<script src="<?php //echo base_url(); 
                    ?>assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>--->
<script type="text/javascript">
    $(document).ready(function() {
        $('#adhar_no').on('input', function() {
            var text = $(this).val();
            if (text.length == 4) {
                text += '-';
                $(this).val('');
                $(this).val(text);
            } else if (text.length == 9) {
                text += '-';
                $(this).val('');
                $(this).val(text);
            }
            $("#adhar_no").text(text);
        });

        $('#language').on('change', function() {
            var lang = $(this).val();

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#full_name').val();

            $.get(url, function(data, status) {
                var result = '';
                // console.log(data);
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#name_local").val(result);
                    $("#name_local").text(result);
                }
            });

            url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#gender').val();
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    if (result == "नर") {
                        result = "पुरुष";
                    }
                    // else if(result == "मादा"){
                    //     result = "महिला";
                    // }
                    $("#gender_local").val(result);
                    $("#gender_local").text(result);
                }
            });

            url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#address').val();
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    $("#address_local").val(result);
                    $("#address_local").text(result);
                }
            });
        });

        $('#full_name').on('input', function() {
            var text = $(this).val();

            var lang = $('#language').val();

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + text;

            $.get(url, function(data, status) {
                var result = " ";

                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#name_local").val(result);
                    $("#name_local").text(result);
                }
            });
        });

        $('#gender').on('input', function() {
            var text = $(this).val();

            var lang = $('#language').val();

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + text;

            $.get(url, function(data, status) {
                var result = " ";

                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    if (result == "नर") {
                        result = "पुरुष";
                    }
                    // else if(result == "मादा"){
                    //     result = "महिला";
                    // }
                    $("#gender_local").val(result);
                    $("#gender_local").text(result);
                }
            });
        });

        $('#address').on('input', function() {
            var text = $(this).val();

            var lang = $('#language').val();

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + text;

            $.get(url, function(data, status) {
                var result = " ";

                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#address_local").val(result);
                    $("#address_local").text(result);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#language').on('change', function() {
            var lang = $(this).val();

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#name').val();

            $.get(url, function(data, status) {
                var result = '';
                // console.log(data);
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#name_local").val(result);
                    $("#name_local").text(result);
                }
            });

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#f_h_name').val();

            $.get(url, function(data, status) {
                var result = '';
                // console.log(data);
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#f_h_name_local").val(result);
                    $("#f_h_name_local").text(result);
                }
            });

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#assembly').val();

            $.get(url, function(data, status) {
                var result = '';
                // console.log(data);
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#assembly_local").val(result);
                    $("#assembly_local").text(result);
                }
            });

            var url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#part_name').val();
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    $("#part_name_local").val(result);
                    $("#part_name_local").text(result);
                }
            });

            url = "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + $('#address').val();
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 0; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    $("#address_local").val(result);
                    $("#address_local").text(result);
                }
            });
        });
    });
</script>


<script>
    $('[name=tab]').each(function(i, d) {
        var p = $(this).prop('checked');
        if (p) {
            $('article').eq(i)
                .addClass('on');
        }
    });

    $('[name=tab]').on('change', function() {
        var p = $(this).prop('checked');

        // $(type).index(this) == nth-of-type
        var i = $('[name=tab]').index(this);

        $('article').removeClass('on');
        $('article').eq(i).addClass('on');
    });

    function qr_generate() {
        $('#qrcode').empty();
        let select_val = $('input[type=radio]:checked').val();
        if (select_val == 'url') {
            let url = $('#url').val();
            if (url == '' || url == null) {
                blank_qr();
            } else {
                $('#qrcode').qrcode({
                    width: 190,
                    height: 190,
                    text: url
                });
            }
        } else if (select_val == 'phone') {
            let phone = $('#phone').val();
            if (phone == '' || phone == null) {
                blank_qr();
            } else {
                $('#qrcode').qrcode({
                    width: 190,
                    height: 190,
                    text: 'tel:' + phone
                });
            }
        } else if (select_val == 'sms') {
            let phone = $('#sms_phone').val();
            let text = $('#sms_text').val();
            if (phone == '' || phone == null) {
                blank_qr();
            } else {
                console.log({
                    width: 190,
                    height: 190,
                    text: 'smsto:' + phone + ':' + text
                })
                $('#qrcode').qrcode({
                    width: 190,
                    height: 190,
                    text: 'smsto:' + phone + ':' + text
                });
            }
        } else if (select_val == 'text') {
            let plain_text = $('#plain_text').val();
            if (plain_text == '' || plain_text == null) {
                blank_qr();
            } else {
                $('#qrcode').qrcode({
                    width: 190,
                    height: 190,
                    text: plain_text
                });
            }
        } else if (select_val == 'email') {
            let email = $('#email').val();
            let subject = $('#subject').val();
            let message = $('#message').val();
            if (email == '' || email == null) {
                blank_qr();
            } else {
                $('#qrcode').qrcode({
                    width: 190,
                    height: 190,
                    text: 'mailto:' + email + '?subject=' + subject + '&body=' + message
                });
            }
        }
    }

    function blank_qr() {
        $('#qrcode').empty();
        $('#qrcode').qrcode({
            width: 190,
            height: 190,
            text: 'https://codepen.io/shehbaz72',
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


    $('.qr-png-download').on('click', function() {
        $('canvas').attr('id', 'canvas');
        var canvas = document.getElementById('canvas');
        download(canvas, 'qrcode.png')

    })
    $('.qr-svg-download').on('click', function() {

        htmlToImage.toSvg(document.getElementById('qrcode'), {})
            .then(function(dataUrl) {
                let svg = decodeURIComponent(dataUrl.split(',')[1])
                const base64doc = btoa(unescape(encodeURIComponent(svg)));
                const a = document.createElement('a');
                const e = new MouseEvent('click');
                a.download = 'qrcode.svg';
                a.href = 'data:image/svg+xml;base64,' + base64doc;
                a.dispatchEvent(e);
            });
    })
</script>









<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 10,
            //"ajax": './assets/demo/data/table_data.json',
            /*"columns": [
                { "data": "name" },
                { "data": "office" },
                { "data": "extn" },
                { "data": "start_date" },
                { "data": "salary" }
            ]*/
        });
    })
</script>
<!-- PAGE ;LEVEL SCRIPTS-->



<script>
    function myFunc(id) {
        $.ajax({
            url: '<?= base_url('Deleteserviceimage') ?>',
            type: 'POST',
            data: {
                imgId: id
            },
            success: (data) => {
                var data1 = JSON.parse(data);
                if (data1.res == 'success') {
                    $(`#${data1.id}`).fadeOut(1000);
                    $('#msg').slideDown(500).html('<div class="alert alert-success">Image deleted successfully</div>').delay(1000).slideUp(1000);
                }
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('select[name="service"]').on('change', function() {
            var service_id = $(this).val();
            if (service_id == 'mobile_recharge') {
                $('#mob_op_box').show(1000);
            } else {
                $('#mob_op_box').hide(1000);
            }
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $('#bus_booking-1').DataTable({
            pageLength: 10,
            //"ajax": './assets/demo/data/table_data.json',
            /*"columns": [
                { "data": "name" },
                { "data": "office" },
                { "data": "extn" },
                { "data": "start_date" },
                { "data": "salary" }
            ]*/
        });
    })
</script>

<script type="text/javascript">
    $(function() {
        $('#api-settings').DataTable({
            pageLength: 10,
            //"ajax": './assets/demo/data/table_data.json',
            /*"columns": [
                { "data": "name" },
                { "data": "office" },
                { "data": "extn" },
                { "data": "start_date" },
                { "data": "salary" }
            ]*/
        });
    })
</script>

<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 10,
            //"ajax": './assets/demo/data/table_data.json',
            /*"columns": [
                { "data": "name" },
                { "data": "office" },
                { "data": "extn" },
                { "data": "start_date" },
                { "data": "salary" }
            ]*/
        });
    })
</script>
<script>
    $(".d-more-serv").click(function() {
        $(".d-more-service").toggle();
    });
</script>

<script type="text/javascript">
    $(function() {
        $('#viewtd').DataTable({
            pageLength: 10,
        });
    });
</script>


<script>
    function getError() {
        var amount = document.getElementById("txnamount").value;
        if (amount < 100) {
            var error = 'Amount Should greater than or equal 100';
            document.getElementById("amt_error").textContent = error;
        } else {
            document.getElementById("amt_error").textContent = "";
        }
    }
</script>

<script>
    var path = window.location.pathname;
    var page = path.split("/").pop();
    let recharge_items=document.querySelectorAll('.recharge-items ul li')

    recharge_items.forEach(recharge_items_element => {
        let recharge_items_element_new=recharge_items_element.getAttribute('name');
        if (recharge_items_element_new == page) {
            
            recharge_items_element.classList.add('active')
        }
    });
    
</script>

<!-- <script>
    function disableBtn() {
        document.getElementById('recharge_button').disabled = true;
    }
</script> -->

</body>

</html>