<style>
    .firstpage {

        height: 500px;
        background-size: contain;
        background-repeat: no-repeat;
        margin-right: 30px;
        width: 1000px;
        float: none;
        position: relative;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .secondpage {
        background-image: url();
        height: 500px;
        background-size: contain;
        background-repeat: no-repeat;
        margin-right: 30px;
        width: 320px;
        top: -510px;
        left: 322px;
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
        padding-left: 20px;
        padding-right: 20px;
    }

    .gender span.label,
    .dob span.label {
        width: 116px;
        display: inline-block;
    }

    .imagecontainer {
        position: absolute;
        top: 123px;
        left: 91px;
    }

    img.picture {
        width: 140px;
        height: 186px;
    }

    .barcode {
        width: 150px;
        height: 30px;
        position: absolute;
        top: 90px;
        left: 38px;
    }

    .epicnumber {
        position: absolute;
        top: 90px;
        left: 200px;
        left: 199px;
        font-size: 13px;
    }

    .settable {
        position: absolute;
        top: 331px;
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
        left: -18px;
        text-align: right;
        position: relative;
    }

    img.officersign {
        position: absolute;
        top: -45px;
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
            <?php
            $img_url = '';
            if ($voter['language'] == 'HI') {
                $img_url = base_url() . 'votercard/voter/hindi.jpg';
            } else if ($voter['language'] == 'BN') {
                $img_url = base_url() . 'votercard/voter/Bengali.jpg';
            } else if ($voter['language'] == 'PA') {
                $img_url = base_url() . 'votercard/voter/punjabi.jpg';
            } else if ($voter['language'] == 'GU') {
                $img_url = base_url() . 'votercard/voter/gujarati.jpg';
            } else if ($voter['language'] == 'MR') {
                $img_url = base_url() . 'votercard/voter/marathi.jpg';
            } else if ($voter['language'] == 'TA') {
                $img_url = base_url() . 'votercard/voter/tamil.jpg';
            } else if ($voter['language'] == 'KN') {
                $img_url = base_url() . 'votercard/voter/kannada.jpg';
            } else if ($voter['language'] == 'TE') {
                $img_url = base_url() . 'votercard/voter/telgu.jpg';
            } else if ($voter['language'] == 'OR') {
                $img_url = base_url() . 'votercard/voter/odiya.jpg';
            }
            ?>
            <div class="firstpage" style="background-image: url(<?= $img_url; ?>);">
                <div><svg id="barcode" class="barcode"></svg></div>
                <div class="epicnumber"><?= $voter['epic_no']; ?></div>
                <div class="imagecontainer">
                    <img src="<?= base_url(); ?>votercard/profile_image/<?= $voter['profile_photo']; ?>" class="picture">
                </div>
                <div class="settable">
                    <table class="tablecss" style="font-weight: bold; font-size: 12px;">
                        <tbody>
                            <tr>
                                <td style="padding-bottom: 15px;">
                                    <?php if ($voter['language'] == 'HI') { ?>
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
                                    <?php } ?>
                                </td>
                                <td style="padding-bottom: 15px;">: <?= $voter['full_name_local_language']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 15px;">NAME</td>
                                <td style="padding-bottom: 15px;">: <?= $voter['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 15px;">
                                    <?php if ($voter['language'] == 'HI') { ?>
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
                                    <?php } ?>
                                </td>
                                <td style="padding-bottom: 15px;">: <?= $voter['f_h_name_local_language']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 15px;">Father NAME</td>
                                <td style="padding-bottom: 15px;">: <?= $voter['f_h_name']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="secondpage">
                <div class="gender">
                    <span class="label">
                        <?php if ($voter['language'] == 'HI') { ?>
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
                        <?php } ?>
                        /Sex</span>
                    <span class="value">:
                        <?= $voter['gender']; ?></span>
                </div>
                <div class="dob">
                    <span class="label">
                        <?php if ($voter['language'] == 'HI') { ?>
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
                        <?php } ?>
                        <br>
                        Date Of Birth
                    </span>
                    <span class="value">: <?= $voter['dob']; ?></span>
                </div>
                <div class="address_regional">
                    <span class="label"><?php if ($voter['language'] == 'HI') { ?>
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
                        <?php } ?> </span>
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
                        <img class="officersign" src="<?= base_url(); ?>votercard/votersign.png">
                        <span class="label">
                            <?php if ($voter['language'] == 'HI') { ?>
                                निर्वाचक पंजीकरण अधिकारी
                            <?php } else if ($voter['language'] == 'BN') { ?>
                                নির্বাচনী নিবন্ধন কর্মকর্তা
                            <?php } else if ($voter['language'] == 'PA') { ?>
                                ਚੋਣਕਾਰ ਰਜਿਸਟ੍ਰੇਸ਼ਨ ਅਫਸਰ
                            <?php } else if ($voter['language'] == 'GU') { ?>
                                ચૂંટણી નોંધણી અધિકારી
                            <?php } else if ($voter['language'] == 'MR') { ?>
                                निवडणूक नोंदणी अधिकारी
                            <?php } else if ($voter['language'] == 'TA') { ?>
                                தேர்தல் பதிவு அதிகாரி
                            <?php } else if ($voter['language'] == 'KN') { ?>
                                ಚುನಾವಣಾ ನೋಂದಣಿ ಅಧಿಕಾರಿ
                            <?php } else if ($voter['language'] == 'TE') { ?>
                                ఎలక్టోరల్ రిజిస్ట్రేషన్ ఆఫీసర్
                            <?php } else if ($voter['language'] == 'OR') { ?>
                                ନିର୍ବାଚନ ପଞ୍ଜୀକରଣ ଅଧିକାରୀ |
                            <?php } else if ($voter['language'] == 'SD') { ?>
                                NA
                            <?php } ?>
                            <br>
                            Electoral Registration Officer
                        </span>
                        <span class="value"></span>
                    </div>
                </div>
                <div class="assemballysankhya">
                    <div class="regional">
                        <span class="label">
                            <?php if ($voter['language'] == 'HI') { ?>
                                विधानसभा निर्वाचन क्षेत्र संख्या और नाम :
                            <?php } else if ($voter['language'] == 'BN') { ?>
                                বিধানসভা নির্বাচনী এলাকার নম্বর এবং নাম
                            <?php } else if ($voter['language'] == 'PA') { ?>
                                ਵਿਧਾਨ ਸਭਾ ਚੋਣ ਖੇਤਰ ਦਾ ਨੰਬਰ ਅਤੇ ਨਾਮ
                            <?php } else if ($voter['language'] == 'GU') { ?>
                                વિધાનસભા મતવિસ્તાર નંબર અને નામ
                            <?php } else if ($voter['language'] == 'MR') { ?>
                                विधानसभा मतदारसंघ क्रमांक आणि नाव
                            <?php } else if ($voter['language'] == 'TA') { ?>
                                சட்டமன்றத் தொகுதி எண் மற்றும் பெயர்
                            <?php } else if ($voter['language'] == 'KN') { ?>
                                ವಿಧಾನಸಭಾ ಕ್ಷೇತ್ರ ಸಂಖ್ಯೆ ಮತ್ತು ಹೆಸರು
                            <?php } else if ($voter['language'] == 'TE') { ?>
                                అసెంబ్లీ నియోజకవర్గం సంఖ్య మరియు పేరు
                            <?php } else if ($voter['language'] == 'OR') { ?>
                                అసెంబ్లీ నియోజకవర్గం సంఖ్య మరియు పేరు
                            <?php } else if ($voter['language'] == 'SD') { ?>
                                NA
                            <?php } ?>
                        </span>
                        <span class="value">
                            <br>
                            <?= $voter['assembly_local']; ?>
                        </span>
                    </div>

                    <div class="actual">
                        Assembly Constituency No. &amp; Name :
                        <span class="value">
                            <br>
                            <?= $voter['assembly']; ?>
                        </span>
                    </div>
                </div>
                <div class="bhagsankhya">
                    <div class="regional">
                        <span class="label">
                            <?php if ($voter['language'] == 'HI') { ?>
                                भाग संख्या और नाम
                            <?php } else if ($voter['language'] == 'BN') { ?>
                                অংশ সংখ্যা এবং নাম
                            <?php } else if ($voter['language'] == 'PA') { ?>
                                ਭਾਗ ਨੰਬਰ ਅਤੇ ਨਾਮ
                            <?php } else if ($voter['language'] == 'GU') { ?>
                                ભાગ નંબર અને નામ
                            <?php } else if ($voter['language'] == 'MR') { ?>
                                भाग क्रमांक आणि नाव
                            <?php } else if ($voter['language'] == 'TA') { ?>
                                பகுதி எண் மற்றும் பெயர்
                            <?php } else if ($voter['language'] == 'KN') { ?>
                                ಭಾಗ ಸಂಖ್ಯೆ ಮತ್ತು ಹೆಸರು
                            <?php } else if ($voter['language'] == 'TE') { ?>
                                భాగం సంఖ్య మరియు పేరు
                            <?php } else if ($voter['language'] == 'OR') { ?>
                                ଅଂଶ ସଂଖ୍ୟା ଏବଂ ନାମ
                            <?php } else if ($voter['language'] == 'SD') { ?>
                                NA
                            <?php } ?>
                            : </span>
                        <span class="value"><?= $voter['part_no']; ?>- <?= $voter['part_name_local']; ?> </span>
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
            fontOptions: "bold",
            textMargin: 1
        });

        window.print();
    }
</script>