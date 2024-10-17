<!-- START SIDEBAR-->
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">

        <!-- <div class="admin-block d-flex">
            <div class="admin-info">
                <div class="font-strong">Recharge Desun</div><small>Admin</small>
            </div>
        </div> -->

        <?php
        if (!empty($_SESSION['slug'])) {

            $ut = $this->db->get_where('user_type', ['slug' => $_SESSION['slug']])->row_array();
        }
        ?>

<!---Mobile Menu Responsive--->
<div class="side-bar">
     <header>
     <div class="close-btn">
       <i class="fas fa-times"></i>
     </div>
     <img class="img" src="<?php echo base_url(); ?>assets/img/dtpl.png" alt="">
          <h1 class="dtpl">DTPL Recharge</h1>
        </header>
     <div class="menu">
       <div class="item"><a href="<?php echo base_url('dashboard'); ?>"><i class="fas fa-desktop"></i>Dashboard</a></div>
       <?php if (
                isset($_SESSION['role']) ||
                (
                    $_SESSION['slug'] == 'admin' ||
                    $_SESSION['slug'] == 'distributor' ||
                    $_SESSION['slug'] == 'super_distributor'
                )
            ) { ?>

       <div class="item">
         <a class="sub-btn"><i class="fas fa-user"></i>Users<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
           <a href="<?php echo base_url('addusers'); ?>" class="sub-item">Add User</a>
           <a href="<?php echo base_url('viewusers'); ?>" class="sub-item">View User</a>
         </div>
       </div>
       <?php }

            if (isset($_SESSION['role']) || ($_SESSION['slug'])) { ?>

       <div class="item">
         <a class="sub-btn"><i class="fas fa-money"></i>Payment<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
                            <a class="sub-item" href="<?= base_url('balancehistory'); ?>">Wallet History</a>
                       
                            <a class="sub-item" href="<?= base_url('walletrecharge'); ?>">Wallet Recharge</a>
                     


                        <?php if ($_SESSION['slug'] != 'reatiler') { ?>

                                <a class="sub-item" href="<?= base_url('balanceadd'); ?>">Balance Add</a>
                           
                                <a class="sub-item" href="<?= base_url('balancededuct'); ?>">Balance Deduct</a>
                            
                                <a class="sub-item" href="<?= base_url('listfundrequest'); ?>">Fund Request</a>
                            
                                <a class="sub-item" href="<?= base_url('viewapprovefund'); ?>">Fund Approved</a>
                                <?php } ?>

                            <a class="sub-item" href="<?= base_url('apicommissionreport'); ?>">Commission Report</a>
                       
                        <?php if ($_SESSION['slug'] == 'reatiler') { ?>

                                <a class="sub-item" href="<?= base_url('commission'); ?>">Commission</a>

                        <?php } ?>
                           
         </div>
       </div>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-support"></i>Support Ticket<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
         <?php if (isset($_SESSION['slug'])) { ?>
                           
                                <a class="sub-item" href="<?= base_url('supportticket'); ?>">Add Support</a>
                            
                                <a class="sub-item" href="<?= base_url('supportticket/viewsupport'); ?>">View Support</a>
                            
                        <?php }

                        if (isset($_SESSION['role'])) { ?>

                                <a class="sub-item" href="<?= base_url('supportticket/requestsupport'); ?>">Request Support</a>
                            
                                <a class="sub-item" href="<?= base_url('supportticket/approvedsupport'); ?>">Approved Support</a>
                            

                        <?php } ?>
         </div>
       </div>
       <?php }

            if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>

       <div class="item">
         <a class="sub-btn"><i class="fas fa-percent"></i>Commission Slot<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
                            <a class="sub-item" href="<?= base_url('addcommission'); ?>">Add Commission</a>
                            <a class="sub-item" href="<?= base_url('viewcommission'); ?>">View Commission</a>
                        
         </div>
       </div>
       <?php }
            if (isset($_SESSION['role'])) { ?>

       <div class="item">
         <a class="sub-btn"><i class="fas fa-bar-chart"></i>Report<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
   
                            <a class="sub-item" href="<?= base_url('mobilereport'); ?>">Mobile Report</a>
                  
                            <a class="sub-item" href="<?= base_url('dthreport'); ?>">DTH Report</a>
                     
                            <a class="sub-item" href="<?= base_url('apirechargereport'); ?>">API Recharge Report</a>
                        
                            <a class="sub-item" href="<?= base_url('apiutilityreport'); ?>">API Utility Report</a>
                        
                            <a class="sub-item" href="<?= base_url('apicommissionreport'); ?>">Commission Report</a>
                     
                            <a class="sub-item" href="<?= base_url('viewwalletupi'); ?>">Upi Payment Report</a>
                        
         </div>
       </div>
       <?php }
            if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-th"></i>Masters<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
   
                            <a class="sub-item" href="<?= base_url('viewnews'); ?>">News</a>

                        <?php if (isset($_SESSION['role'])) { ?>

                                <a class="sub-item" href="<?= base_url('viewbanner'); ?>">Banners</a>

                                <a class="sub-item" href="<?= base_url('privacy/view'); ?>">Privacy Policy</a>

                                <a class="sub-item" href="<?= base_url('terms/view'); ?>">Terms and Conditions</a>

                        <?php }
                        if (isset($_SESSION['slug']) || $_SESSION['role']) { ?>

                                <a class="sub-item" href="<?= base_url('notifications/view'); ?>">Notifications</a>

                                <a class="sub-item" href="<?= base_url('showcommission'); ?>">Show Commission</a>

                        <?php } ?>
         </div>
       </div>
       <?php } ?>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-table"></i>Services<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">

                        <a class="sub-item" href="<?= base_url('mobilerecharge'); ?>">Mobile Reacharge</a>

                        <a class="sub-item" href="<?= base_url('mobilereport'); ?>">Reacharge Report</a>

                        <a class="sub-item" href="<?= base_url('dthrecharge'); ?>">DTH Reacharge</a>

                        <a class="sub-item" href="<?= base_url('dthreport'); ?>">DTH Report</a>

                        <a class="sub-item" href="<?= base_url('electricbill'); ?>">Electric Bill</a>
 
                        <a class="sub-item" href="<?= base_url('electricbillreport'); ?>">Electric Bill Report</a>
       
                        <a class="sub-item" href="<?= base_url('loanpay'); ?>">Loan Payment</a>

                        <a class="sub-item" href="<?= base_url('loanpayreport'); ?>">Loan Payment Report</a>
                  
                        <a class="sub-item" href="<?= base_url('fastagrecharge'); ?>">FASTag Recharge</a>

                        <a class="sub-item" href="<?= base_url('fastagrechargereport'); ?>">FASTag Recharge Report</a>
                   
                        <a class="sub-item" href="<?= base_url('postpaidbill'); ?>">Post Paid Bill</a>

                        <a class="sub-item" href="<?= base_url('postpaidreport'); ?>">Post Paid Bill Report</a>
                    
                        <a class="sub-item" href="<?= base_url('gas'); ?>">LPG Gas</a>

                        <a class="sub-item" href="<?= base_url('gasreport'); ?>">LPG Gas Report</a>
                  
                        <a class="sub-item" href="<?= base_url('insurance'); ?>">Insurance Pay</a>

                        <a class="sub-item" href="<?= base_url('insurancereport'); ?>">Insurance Report</a>
                
                        <a class="sub-item" href="<?= base_url('broadband'); ?>">Broadband Pay</a>

                        <a class="sub-item" href="<?= base_url('broadbandreport'); ?>">Broadband Report</a>
                 
                        <a class="sub-item" href="<?= base_url('municiple'); ?>">Municiple Service Pay</a>

                        <a class="sub-item" href="<?= base_url('municiplereport'); ?>">Municiple Service Report</a>
          
                        <a class="sub-item" href="<?= base_url('creditcard'); ?>">Credit Card Pay</a>
     
                        <a class="sub-item" href="<?= base_url('creditcardreport'); ?>">Credit Card Report</a>
    
                        <a class="sub-item" href="<?= base_url('landline'); ?>">Landline Bill Pay</a>

                        <a class="sub-item" href="<?= base_url('landlinereport'); ?>">Landline Report</a>

                        <a class="sub-item" href="<?= base_url('cable'); ?>">Cable Recharge</a>

                        <a class="sub-item" href="<?= base_url('cablereport'); ?>">Cable Report</a>

                        <a class="sub-item" href="<?= base_url('subscription'); ?>">Subscription Recharge</a>
  
                        <a class="sub-item" href="<?= base_url('subscriptionreport'); ?>">Subscription Report</a>
        

         </div>
       </div>

       <div class="item">
         <a class="sub-btn"><i class="fas fa-share"></i>Share<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
        
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

                        <a class="sub-item" href="https://web.whatsapp.com/send?text=<?= urlencode($text1) . $line_break . $line_break . $text . urlencode($refer_url) . $line_break . $line_break .  urlencode($text2) . $line_break . urlencode($text3) . $line_break . urlencode($text4) ?>" data-action="share/whatsapp/share" target="_blank">Share Web</a>

                        <a class="sub-item" href="whatsapp://send?text=<?= urlencode($text1) . $line_break . $line_break . $text . urlencode($refer_url) . $line_break . $line_break .  urlencode($text2) . $line_break . urlencode($text3) . $line_break . urlencode($text4) ?>" data-action="share/whatsapp/share" target="_blank">Share App</a>

                    
         </div>
       </div>
       <?php if (isset($_SESSION['slug']) || isset($_SESSION['role'])) {
                if ($_SESSION['slug'] == 'admin' || $_SESSION['slug'] == 'super_distributor' || $_SESSION['slug'] == 'distributor' || $_SESSION['role']) {
            ?>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-user"></i>Set UPI ID<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
                                <a class="sub-item" href="<?= base_url('addupi'); ?>">Add UPI ID</a>
                           
            
         </div>
       </div>
       <?php }
            } ?>
       <?php if (isset($_SESSION['role'])) { ?>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-cogs"></i>API Setting<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
                            <a class="sub-item" href="<?php echo base_url('addrechargeapi'); ?>">Add Recharge API</a>
                        
                            <a class="sub-item" class="sub-item" href="<?php echo base_url('viewrechargeapi'); ?>">View Recharge API</a>
                        
                            <a class="sub-item" href="<?php echo base_url('addutilityapi'); ?>">Add Utility API</a>
                      
                            <a class="sub-item" href="<?php echo base_url('viewutilityapi'); ?>">View Utility API</a>
                        
         </div>
       </div>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-file"></i>Operator<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
         <li>
                            <a class="sub-item" href="<?php echo base_url('addoperator'); ?>">Add Operator</a>
                            <a class="sub-item" href="<?php echo base_url('viewoperator'); ?>">View Operator</a>
         </div>
       </div>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-user"></i>Users Permission<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
                            <a class="sub-item" href="<?php echo base_url('addmenu'); ?>"> Add Menu </a>
                            <a class="sub-item" href="<?php echo base_url('menu_action'); ?>"> Menu Action </a>
                            <a class="sub-item" href="<?php echo base_url('userpermission'); ?>"> User Permission</a>
                       
         </div>
       </div>
       <div class="item">
         <a class="sub-btn"><i class="fas fa-bookmark"></i>Users Type<i class="fas fa-angle-right dropdown"></i></a>
         <div class="sub-menu">
                            <a class="sub-item" href="<?php echo base_url('adduserstype'); ?>">Add Users Type</a>
                            <a class="sub-item" href="view_users_type.html">View Users</a>

         </div>
       </div>

       <div class="item"><a href="<?php echo base_url('addservices'); ?>"><i class="fas fa-info-circle"></i>Add Services</a></div>
       <?php } ?>
     </div>
   </div>
   <!---Mobile Menu Responsive--->









        <ul class="side-menu metismenu">

            <li>

                <a class="active" href="<?php echo base_url('dashboard'); ?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>

            </li>


            <?php if (
                isset($_SESSION['role']) ||
                (
                    $_SESSION['slug'] == 'admin' ||
                    $_SESSION['slug'] == 'distributor' ||
                    $_SESSION['slug'] == 'super_distributor'
                )
            ) { ?>


                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-users"></i>
                        <span class="nav-label">Users</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addusers'); ?>">Add Users</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('viewusers'); ?>">View Users</a>
                        </li>

                    </ul>
                </li>

            <?php }

            if (isset($_SESSION['role']) || ($_SESSION['slug'])) { ?>


                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-money"></i>
                        <span class="nav-label">Payments</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">

                        <li>
                            <a href="<?= base_url('balancehistory'); ?>">Wallet History</a>
                        </li>

                        <li>
                            <a href="<?= base_url('walletrecharge'); ?>">Wallet Recharge</a>
                        </li>


                        <?php if ($_SESSION['slug'] != 'reatiler') { ?>

                            <li>
                                <a href="<?= base_url('balanceadd'); ?>">Balance Add</a>
                            </li>

                            <li>
                                <a href="<?= base_url('balancededuct'); ?>">Balance Deduct</a>
                            </li>

                            <li>
                                <a href="<?= base_url('listfundrequest'); ?>">Fund Request</a>
                            </li>

                            <li>
                                <a href="<?= base_url('viewapprovefund'); ?>">Fund Approved</a>
                            </li>


                        <?php } ?>

                        <li>
                            <a href="<?= base_url('apicommissionreport'); ?>">Commission Report</a>
                        </li>

                        <?php if ($_SESSION['slug'] == 'reatiler') { ?>

                            <li>
                                <a href="<?= base_url('commission'); ?>">Commission</a>
                            </li>

                        <?php } ?>

                    </ul>

                </li>

                <li>

                    <a href="#"><i class="sidebar-item-icon fa fa-money"></i>
                        <span class="nav-label">Support Ticket</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">

                        <?php if (isset($_SESSION['slug'])) { ?>
                            <li>
                                <a href="<?= base_url('supportticket'); ?>">Add Support</a>
                            </li>

                            <li>
                                <a href="<?= base_url('supportticket/viewsupport'); ?>">View Support</a>
                            </li>
                        <?php }

                        if (isset($_SESSION['role'])) { ?>

                            <li>
                                <a href="<?= base_url('supportticket/requestsupport'); ?>">Request Support</a>
                            </li>

                            <li>
                                <a href="<?= base_url('supportticket/approvedsupport'); ?>">Approved Support</a>
                            </li>

                        <?php } ?>

                    </ul>

                </li>

            <?php }

            if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>

                <li>

                    <a href="#"><i class="sidebar-item-icon fa fa-percent"></i>
                        <span class="nav-label">Commission Slot</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">

                        <li>
                            <a href="<?= base_url('addcommission'); ?>">Add Commission</a>
                        </li>

                        <li>
                            <a href="<?= base_url('viewcommission'); ?>">View Commission</a>
                        </li>

                    </ul>

                </li>

            <?php }
            if (isset($_SESSION['role'])) { ?>

                <li class="heading">All Report</li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-bar-chart"></i>
                        <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">

                        <li>
                            <a href="<?= base_url('mobilereport'); ?>">Mobile Report</a>
                        </li>

                        <li>
                            <a href="<?= base_url('dthreport'); ?>">DTH Report</a>
                        </li>

                        <li>
                            <a href="<?= base_url('apirechargereport'); ?>">API Recharge Report</a>
                        </li>

                        <li>
                            <a href="<?= base_url('apiutilityreport'); ?>">API Utility Report</a>
                        </li>

                        <li>
                            <a href="<?= base_url('apicommissionreport'); ?>">Commission Report</a>
                        </li>

                        <li>
                            <a href="<?= base_url('viewwalletupi'); ?>">Upi Payment Report</a>
                        </li>

                    </ul>
                </li>



            <?php }
            if (isset($_SESSION['role']) || $_SESSION['slug'] == 'admin') { ?>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-bar-chart"></i>
                        <span class="nav-label">Masters</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?= base_url('viewnews'); ?>">News</a>
                        </li>


                        <?php if (isset($_SESSION['role'])) { ?>
                            <li>
                                <a href="<?= base_url('viewbanner'); ?>">Banners</a>
                            </li>

                            <li>
                                <a href="<?= base_url('privacy/view'); ?>">Privacy Policy</a>
                            </li>

                            <li>
                                <a href="<?= base_url('terms/view'); ?>">Terms and Conditions</a>
                            </li>

                        <?php }
                        if (isset($_SESSION['slug']) || $_SESSION['role']) { ?>

                            <li>
                                <a href="<?= base_url('notifications/view'); ?>">Notifications</a>
                            </li>

                            <li>
                                <a href="<?= base_url('showcommission'); ?>">Show Commission</a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
            <?php } ?>


            <li class="heading">Services</li>

            <li>

                <a href="#"><i class="sidebar-item-icon fa fa-mobile"></i>
                    <span class="nav-label">Mobile Reacharge</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('mobilerecharge'); ?>">Mobile Reacharge</a>
                    </li>

                    <li>
                        <a href="<?= base_url('mobilereport'); ?>">Reacharge Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fa fa-tv"></i>
                    <span class="nav-label">DTH Reacharge</span><i class="fa fa-angle-left arrow"></i>
                </a>


                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('dthrecharge'); ?>">DTH Reacharge</a>
                    </li>

                    <li>
                        <a href="<?= base_url('dthreport'); ?>">DTH Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fa fa-lightbulb-o"></i>
                    <span class="nav-label">Electric Bill Payment</span><i class="fa fa-angle-left arrow"></i>
                </a>


                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('electricbill'); ?>">Electric Bill</a>
                    </li>

                    <li>
                        <a href="<?= base_url('electricbillreport'); ?>">Electric Bill Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fa fa-product-hunt"></i>
                    <span class="nav-label">Loan Payment</span><i class="fa fa-angle-left arrow"></i>
                </a>


                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('loanpay'); ?>">Loan Payment</a>
                    </li>

                    <li>
                        <a href="<?= base_url('loanpayreport'); ?>">Loan Payment Report</a>
                    </li>

                </ul>

            </li>

            <li>

                <a href="#"><i class="sidebar-item-icon fa fa-tags"></i>
                    <span class="nav-label">FASTag Recharge</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('fastagrecharge'); ?>">FASTag Recharge</a>
                    </li>

                    <li>
                        <a href="<?= base_url('fastagrechargereport'); ?>">FASTag Recharge Report</a>
                    </li>

                </ul>

            </li>


            <li>
                <a href="#"><i class="sidebar-item-icon fa fa-product-hunt"></i>
                    <span class="nav-label">Post Paid Bill</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('postpaidbill'); ?>">Post Paid Bill</a>
                    </li>

                    <li>
                        <a href="<?= base_url('postpaidreport'); ?>">Post Paid Bill Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-gas-pump"></i>
                    <span class="nav-label">LPG Gas</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('gas'); ?>">LPG Gas</a>
                    </li>

                    <li>
                        <a href="<?= base_url('gasreport'); ?>">LPG Gas Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-hospital"></i>
                    <span class="nav-label">Insurance</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('insurance'); ?>">Insurance Pay</a>
                    </li>

                    <li>
                        <a href="<?= base_url('insurancereport'); ?>">Insurance Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-wifi"></i>
                    <span class="nav-label">Broadband</span><i class="fa fa-angle-left arrow"></i>
                </a>


                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('broadband'); ?>">Broadband Pay</a>
                    </li>

                    <li>
                        <a href="<?= base_url('broadbandreport'); ?>">Broadband Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-city"></i>
                    <span class="nav-label">Municiple Service</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

                    <li>
                        <a href="<?= base_url('municiple'); ?>">Municiple Service Pay</a>
                    </li>

                    <li>
                        <a href="<?= base_url('municiplereport'); ?>">Municiple Service Report</a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-credit-card"></i>
                    <span class="nav-label">Credit Card</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?= base_url('creditcard'); ?>">Credit Card Pay</a>
                    </li>

                    <li>
                        <a href="<?= base_url('creditcardreport'); ?>">Credit Card Report</a>
                    </li>
                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-phone"></i>
                    <span class="nav-label">Landline</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?= base_url('landline'); ?>">Landline Bill Pay</a>
                    </li>

                    <li>
                        <a href="<?= base_url('landlinereport'); ?>">Landline Report</a>
                    </li>
                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-tv"></i>
                    <span class="nav-label">Cable</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?= base_url('cable'); ?>">Cable Recharge</a>
                    </li>

                    <li>
                        <a href="<?= base_url('cablereport'); ?>">Cable Report</a>
                    </li>
                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fas fa-bell"></i>
                    <span class="nav-label">Subscriptions</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?= base_url('subscription'); ?>">Subscription Recharge</a>
                    </li>

                    <li>
                        <a href="<?= base_url('subscriptionreport'); ?>">Subscription Report</a>
                    </li>
                </ul>

            </li>

            <li>
                <a href="#"><i class="sidebar-item-icon fa fa-bus"></i>
                    <span class="nav-label">Bus Booking</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?= base_url('busbooking'); ?>">Booking Bus</a>
                    </li>

                    <li>
                        <a href="rec_history.html">View Booking</a>
                    </li>

                </ul>

            </li>


            <li>
                <a href="#"><i class="sidebar-item-icon fa fa-share"></i>
                    <span class="nav-label">Share Link</span><i class="fa fa-angle-left arrow"></i>
                </a>

                <ul class="nav-2-level collapse">

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

                        <a href="https://web.whatsapp.com/send?text=<?= urlencode($text1) . $line_break . $line_break . $text . urlencode($refer_url) . $line_break . $line_break .  urlencode($text2) . $line_break . urlencode($text3) . $line_break . urlencode($text4) ?>" data-action="share/whatsapp/share" target="_blank">Share Web</a>

                        <a href="whatsapp://send?text=<?= urlencode($text1) . $line_break . $line_break . $text . urlencode($refer_url) . $line_break . $line_break .  urlencode($text2) . $line_break . urlencode($text3) . $line_break . urlencode($text4) ?>" data-action="share/whatsapp/share" target="_blank">Share App</a>

                    </li>

                </ul>

            </li>

            <?php if (isset($_SESSION['slug']) || isset($_SESSION['role'])) {
                if ($_SESSION['slug'] == 'admin' || $_SESSION['slug'] == 'super_distributor' || $_SESSION['slug'] == 'distributor' || $_SESSION['role']) {
            ?>
                    <li>
                        <a href="#"><i class="sidebar-item-icon fa fa-id-card"></i>
                            <span class="nav-label">Set UPI</span><i class="fa fa-angle-left arrow"></i>
                        </a>

                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="<?= base_url('addupi'); ?>">UPI</a>
                            </li>
                        </ul>

                    </li>


            <?php }
            } ?>

            <?php if (isset($_SESSION['role'])) { ?>
                <!-- <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-id-card"></i>
                        <span class="nav-label">Aadhar Card</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?= base_url('newadharcard'); ?>">New Aadhar Card</a>
                        </li>
                        <li>
                            <a href="<?= base_url('viewadharcard'); ?>">View Aadhar Card List</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-id-card"></i>
                        <span class="nav-label">PAN Card</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?= base_url('panfinder'); ?>">PAN Number Finder</a>
                        </li>
                        <li>
                            <a href="<?= base_url('newpancard'); ?>">New PAN Card</a>
                        </li>
                        <li>
                            <a href="<?= base_url('viewpancard'); ?>">View PAN Card List</a>
                        </li>
                        <li>
                            <a href="<?= base_url('viewpanfinder'); ?>">View PAN Finder List</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-id-card"></i>
                        <span class="nav-label">Voter Card</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?= base_url('evotercard'); ?>">E Voter Card</a>
                        </li>
                        <li>
                            <a href="<?= base_url('newvotercard'); ?>">New Voter Card</a>
                        </li>
                        <li>
                            <a href="<?= base_url('viewvotercard'); ?>">View Voter Card List</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-id-card"></i>
                        <span class="nav-label">Ration Card</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?= base_url('ruralrationcard'); ?>">Rural Ration Card</a>
                        </li>
                        <li>
                            <a href="<?= base_url('urbanrationcard'); ?>">Urban Ration Card</a>
                        </li>
                        <li>
                            <a href="<?= base_url('viewrationcard'); ?>">View Ration Card List</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-id-card"></i>
                        <span class="nav-label">Driving License</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?= base_url('newdrivinglicense'); ?>">New Driving License</a>
                        </li>
                        <li>
                            <a href="<?= base_url('viewdrivinglicense'); ?>">View Driving License List</a>
                        </li>
                    </ul>
                </li> -->







                <li class="heading">Master Setting</li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fas fa-charging-station"></i>
                        <span class="nav-label">Recharge API</span><i class="fa fa-angle-left arrow"></i>
                    </a>


                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addrechargeapi'); ?>">Add Recharge API</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('viewrechargeapi'); ?>">View Recharge API</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-wrench"></i>
                        <span class="nav-label">Utility API</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addutilityapi'); ?>">Add Utility API</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('viewutilityapi'); ?>">View Utility API</a>
                        </li>
                    </ul>

                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-file"></i>
                        <span class="nav-label">Service Master</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addservices'); ?>">Add Service</a>
                        </li>

                        <li>
                            <a href="view_plan.html">View Plans</a>
                        </li>
                    </ul>

                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-file"></i>
                        <span class="nav-label">Operator</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addoperator'); ?>">Add Operator</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('viewoperator'); ?>">View Operator</a>
                        </li>
                    </ul>

                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-bookmark"></i>
                        <span class="nav-label">User Permission</span><i class="fa fa-angle-left arrow"></i>
                    </a>

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


                <!-- <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-language"></i>
                        <span class="nav-label">Language</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addlanguage'); ?>">Add Language</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-language"></i>
                        <span class="nav-label">States</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('addstates'); ?>">Add States</a>
                        </li>
                    </ul>
                </li> -->

                <li>
                    <a href="#"><i class="sidebar-item-icon fa fa-bookmark"></i>
                        <span class="nav-label">User Type</span><i class="fa fa-angle-left arrow"></i>
                    </a>

                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="<?php echo base_url('adduserstype'); ?>">Add Users Type</a>
                        </li>

                        <li>
                            <a href="view_users_type.html">View Users</a>
                        </li>
                    </ul>

                </li>

                <!-- <li>
                    <a href="<?= base_url('apisettings') ?>"><i class="sidebar-item-icon fa fa-code"></i>
                        <span class="nav-label">Payment Gateway</span></a>
                </li> -->

        </ul>

    <?php } ?>

    </div>

</nav>


<? //php } else if (isset($_SESSION['user_type'])) {

// echo "<pre>"; print_r($_SESSION); die;

?>
<!-- <nav class="page-sidebar" id="sidebar">
        <div id="sidebar-collapse">
            <div class="admin-block d-flex">
                <div>
                    <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" width="45px" />
                </div>
                <div class="admin-info">
                    <div class="font-strong"><?= $_SESSION['mobile']; ?></div><small><?= $_SESSION['user_type']; ?></small>
                </div>
            </div>
            <ul class="side-menu metismenu">
                <?php
                // $menus = $this->db->query("SELECT * FROM menu WHERE id IN ({$_SESSION['parent']})")->result_array();

                // echo "<pre>"; print_r($menus); die;

                // foreach ($menus as $menu) {
                ?>
                    <li>
                        <a href="#"><i class="sidebar-item-icon <?= $menu['parent_menu_icon']; ?>"></i>
                            <span class="nav-label"><?= $menu['menu_name']; ?></span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <?php
                            // $actions = $this->db->query("SELECT * FROM menu_action WHERE menu_id = {$menu['id']} AND id IN ({$_SESSION['action']})")->result_array();

                            // echo "<pre>"; print_r($actions); die;

                            // foreach ($actions as $action) :
                            ?>
                                <li>
                                    <a href="<?php echo base_url($action['action_url'] . '/index/' . $action['id']); ?>" style="color: white;"><?= $action['action_name']; ?></a>
                                </li>
                            <? //php endforeach; 
                            ?>
                        </ul>
                    </li>
                <? //php } 
                ?>
            </ul>
        </div>
    </nav> -->
<? //php } 
?>
<!-- END SIDEBAR-->

<!-- Mobile Responsive Menu CSS-->
<style media="screen">
     @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
.dtpl {
    color: #ffee02;
}
.side-bar{
 background: #1b1a1b;
 backdrop-filter: blur(15px);
 width: 250px;
 height: 100vh;
 position: fixed;
 top: 56px;
 left: -250px;
 overflow-y: auto;
 transition: 0.6s ease;
 transition-property: left;
 z-index: 1;
}
.side-bar::-webkit-scrollbar {
  width: 0px;
}



.side-bar.active{
 left: 0;
}
h1{

  text-align: center;
  font-weight: 500;
  font-size: 25px;
  padding-bottom: 13px;
  font-family: sans-serif;
  letter-spacing: 2px;
}

.side-bar .menu{
 width: 100%;
 margin-top: 30px;
}

.side-bar .menu .item{
 position: relative;
 cursor: pointer;
}

.side-bar .menu .item a {
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    display: block;
    padding: 6px 20px;
    line-height: 35px;
}

.side-bar .menu .item a:hover{
 background: #33363a;
 transition: 0.3s ease;
}

.side-bar .menu .item i{
 margin-right: 15px;
}

.side-bar .menu .item a .dropdown{
 position: absolute;
 right: 0;
 margin: 9px 12px;
 transition: 0.3s ease;
}

.side-bar .menu .item .sub-menu{
 background: #262627;
 display: none;
}

.side-bar .menu .item .sub-menu a{
 padding-left: 80px;
}

.rotate{
 transform: rotate(90deg);
}

.close-btn{
 position: absolute;
 color: #fff;

 font-size: 23px;
 right:  0px;
 margin: 15px;
 cursor: pointer;
}

.menu-btn {
    position: absolute;
    color: rgb(0, 0, 0);
    font-size: 35px;
    margin: 2px 12px;
    cursor: pointer;
}

.main{
 height: 100vh;
 display: flex;
 justify-content: center;
 align-items: center;
 padding: 50px;
}

.main h1{
 color: rgba(255, 255, 255, 0.8);
 font-size: 60px;
 text-align: center;
 line-height: 80px;
}

@media (max-width: 900px){
 .main h1{
   font-size: 40px;
   line-height: 60px;
 }
}
.img{
  width: 100px;
  margin: 15px;
  border-radius: 50%;
  margin-left: 70px;
  border: 3px solid #b4b8b9;
}
header{
  background: #33363a;
}
</style>





<?php
include 'all.php';
?>
<!-- Mobile Responsive Menu JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript">
   $(document).ready(function(){
     //jquery for toggle sub menus
     $('.sub-btn').click(function(){
       $(this).next('.sub-menu').slideToggle();
       $(this).find('.dropdown').toggleClass('rotate');
     });

     //jquery for expand and collapse the sidebar
     $('.menu-btn').click(function(){
       $('.side-bar').addClass('active');
       $('.menu-btn').css("visibility", "hidden");
     });

     $('.close-btn').click(function(){
       $('.side-bar').removeClass('active');
       $('.menu-btn').css("visibility", "visible");
     });
   });
   </script>
