<?php

// echo "<pre>"; print_r($_SESSION); die("action");

$action = implode(',', $_SESSION['action']);

// var_dump($action) ; die;

$sql = "SELECT ma.id as ma_id, ma.menu_id, ma.action_name, ma.action_url, menu.id, menu.menu_name, menu.url, menu.is_parent, menu.parent_menu FROM menu_action as ma JOIN menu ON ma.action_url = menu.url where ma.id IN ($action)";

$permissions = $this->db->query($sql)->result_array();

// echo "<pre>"; print_r($permissions); die("permission menu");

// echo $sql; die;
?>
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">James Brown</div><small>Admin</small>
                    </div>
                </div>
                <ul class="side-menu metismenu">
                    <!-- <li>
                        <a class="active" href="<?php echo base_url('dashboard'); ?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li> -->
                    <?php

                    $pm = [];

                    if(isset($permissions))
                    {
                        foreach($permissions as $permission)
                        {
                            if($permission['is_parent'] == 'Y'){
                                $pm['parent_menu'] = $this->db->get_where('menu', ['id' => $permission['id'] , 'is_parent' => 'Y'])->result_array();
                            } 

                            else if ($permission['is_parent'] == 'N'){
                                $pm['parent_menu'] = $this->db->get_where('menu', ['id' => $permission['parent_menu'] , 'is_parent' => 'Y'])->result_array();
                            }
                            foreach ($pm['parent_menu'] as $parent_menu) :
                                // if($parent_menu['id'] == )
                            ?>
                                <li>
                                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-id-card"></i>
                                        <span class="nav-label"><?= $parent_menu['menu_name']; ?></span><i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <?php
                                        $child_menus = $this->db->get_where('menu', ['id' => $permission['id'], 'is_parent' => 'N'])->result_array();
        
                                        foreach ($child_menus as $child_menu) :
                                        ?>
                                            <li>
                                                <a href="<?php echo base_url($child_menu['url']); ?>"><?= $child_menu['menu_name']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach;
                        }
                    }
?>
                 
                    <?php
                        if(isset($_SESSION['role'])){
                    ?>

                    <li class="heading">Master Setting</li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">User Permission</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="<?php echo base_url('addmenu'); ?>"> Add Menu </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('menu_action'); ?>"> Menu Action </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('userpermission'); ?>"> User Permission</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.html"><i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">My Profile</span></a>
                    </li>

                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-language"></i>
                            <span class="nav-label">Language</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="<?php echo base_url('addlanguage'); ?>">Add Language</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-language"></i>
                            <span class="nav-label">States</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="<?php echo base_url('addstates'); ?>">Add States</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">User Type</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="<?php echo base_url('adduserstype'); ?>">Add Users Type</a>
                            </li>
                            <!-- <li>
                                <a href="view_users_type.html">View Users</a>
                            </li> -->
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->