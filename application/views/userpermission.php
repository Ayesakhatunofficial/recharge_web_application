<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<style>
    .child_items {
        list-style: none;
        margin-left: 24%;
    }

    .action_items {
        list-style: none;
        margin-left: 20%;
    }
</style>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">User Permission</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <!----------------- USER Type ------------------->

                                <div class="form-group col-md-12">
                                    <label class="form-control-label"> User Type </label>
                                    <select class="form-control select2_demo_1" id="user_type" name='user_type'>
                                        <option>--Select User Type--</option>
                                        <?php foreach ($user_types as $user_type) : ?>
                                            <option value="<?= $user_type['slug']; ?>"><?= $user_type['user_type']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- <span style="color: red; font-size: 13px;">*** Plaease Select Menu For Menu Permission And Please Select Action For Action Permission</span> -->
                                <table class="table">
                                    <thead>
                                        <th></th>
                                        <th>Features (Menu)</th>
                                        <th></th>
                                        <th>Capabilities (Actions)</th>
                                        <th></th>
                                    </thead>

                                    <?php $i = 1;
                                    foreach ($menus as $menu) : ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="checkbox" class="parent_menu" id="pm<?= $i; ?>" value="<?= $menu['id']; ?>" name="menu[]" onchange="parentMenu(<?= $i; ?>)">&nbsp; &nbsp;<?= $menu['menu_name']; ?>&nbsp; &nbsp;&nbsp; &nbsp;
                                            </td>
                                            <td></td>
                                            <td>
                                                <ul class="child" style="list-style: none;">
                                                    <?php
                                                    $actionss = $this->db->query("SELECT * FROM menu_action WHERE menu_id = {$menu['id']}")->result_array();
                                                    // echo $this->db->last_query(); die;

                                                    $actions[] = count($actionss);

                                                    $j = 1;
                                                    foreach ($actionss as $action) :
                                                    ?>
                                                        <li>
                                                            <input type="checkbox" class="child_item" name="action[]" id="ac<?= $i; ?><?= $j; ?>" value="<?= $action['id']; ?>">&nbsp; &nbsp;<?= $action['action_name']; ?>&nbsp; &nbsp;&nbsp; &nbsp; <br><br>
                                                        </li>
                                                    <?php $j++;
                                                    endforeach; ?>
                                                </ul>
                                            </td>
                                            <td></td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </table>

                                <!-------------------- Submit Button ------------------------->
                                <div class="form-group col-md-12">
                                    <button class="btn btn-primary btn-lg" name="submitBtn" type="submit">Submit</button>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END PAGE CONTENT-->

<?php include 'includes/footer.php'; ?>

<script>
    function parentMenu(i) {

        var action_length = [];

        action_length = <?php echo json_encode($actions); ?>

        if ($(`#pm${i}`).prop('checked', true)) {
            for(var j=1; j<=action_length[2]; j++){
                $(`#ac${i}${j}`).prop('checked', true);
            }
        }
    }
</script>

<script>
    $(document).ready(() => {

        // console.log('hello');

        $('#user_type').on('change', function() {

            $('input:checkbox').prop('checked', false);

            var ut = $(this).val();

            var obj = {
                ut: ut
            };

            console.log(obj);

            $.ajax({
                url: '<?= base_url('Userpermission/userType'); ?>',
                type: 'POST',
                data: obj,
                success: (data) => {
                    var output = JSON.parse(data)

                    var menu = output.menu;

                    var act = output.action;

                    console.log(menu);

                    console.log(act);

                    var menu_length = <?= count($menus); ?>

                    var action_length = [];

                    action_length = <?php echo json_encode($actions); ?>

                    // console.log(menu_length);

                    // console.log(action_length);

                    var pm = [];

                    var ac = [
                        [],
                        []
                    ];

                    for (i = 1; i <= menu_length; i++) {
                        pm[i] = $(`#pm${i}`).val();

                        for (j = 0; j < menu.length; j++) {

                            if (menu[j] == pm[i]) {
                                $(`#pm${i}`).prop('checked', true);

                                // console.log(menu[j]);
                                // console.log(pm[i]);
                            }
                        }

                        for (a = 1; a <= action_length[i - 1]; a++) {
                            ac[[i][a]] = $(`#ac${i}${a}`).val();

                            // console.log(i,a);
                            // console.log(ac[[i][a]]);

                            for (c = 0; c < act.length; c++) {

                                if (act[c] == ac[[i][a]]) {
                                    $(`#ac${i}${a}`).prop('checked', true);

                                    // console.log(act[c]);
                                    // console.log(ac[a]);
                                }
                            }
                        }
                    }
                }
            });
        });
    });
</script>