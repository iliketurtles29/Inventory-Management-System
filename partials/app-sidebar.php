<?php 
    $user = $_SESSION['user'];
?>
<div class="dashboard_sidebar" id="dashboard_sidebar">
            <h3 class="dashboard_logo" id="dashboard_logo">BILLIE INVENTORY</h3>
            <div class="dashboard_sidebar_user">

            <img src="images/user.png" alt="Picture ni Idol" id="userImage">

            <span><?= $user['first_name']. ' ' . $user['last_name'] ?></span>




            </div>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                <!-- <li class="menuActive"> -->
                    <li class="liMainMenu" id="dashmenu">
                        <a href="./dashboard.php"><i class="fa fa-chart-pie"></i> <span class="menuText"> Dashboard</span></a>
                    </li>
                    <li class="liMainMenu" id="dashmenu">
                        <a href="./report.php"><i class="fa fa-file"></i> <span class="menuText"> Report</span></a>
                    </li>
                    <li class="liMainMenu">
                    <a href="javascript:void(0);" class="showHideSubMenu">
                            <i class="fa fa-tag showHideSubMenu"></i> 
                            <span class="menuText showHideSubMenu">Product</span>
                            <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>  
                        </a>
                        <ul class="subMenus">
                            <li><a  class="subMenuLink" href="./product-view.php"><i class="fa-solid fa-boxes-stacked"></i> View Product</a></li>
                            <li><a  class="subMenuLink" href="./product-add.php"><i class="fa-solid fa-bag-shopping"></i> Add Product</a></li>
                        </ul> 
                    </li>
                    <li class="liMainMenu">
                        <a href="javascript:void(0);" class="showHideSubMenu">
                            <i class="fa fa-truck showHideSubMenu"></i> 
                            <span class="menuText showHideSubMenu">Supplier</span>
                            <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>  
                        </a>
                        <ul class="subMenus">
                            <li><a  class="subMenuLink" href="./supplier-view.php"><i class="fa-solid fa-truck-field"></i>  View Supplier</a></li>
                            <li><a  class="subMenuLink" href="./supplier-add.php"><i class="fa-solid fa-plus"></i> Add Supplier</a></li>
                        </ul> 
                    </li>
                    <li class="liMainMenu">
                        <a href="javascript:void(0);" class="showHideSubMenu">
                            <i class="fa fa-shopping-cart showHideSubMenu"></i> 
                            <span class="menuText showHideSubMenu">Purchase Order</span>
                            <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>  
                        </a>
                        <ul class="subMenus">
                            <li><a  class="subMenuLink" href="./view-order.php"><i class="fa-solid fa-magnifying-glass"></i></i> View Orders</a></li>
                            <li><a  class="subMenuLink" href="./product-order.php"><i class="fa fa-cart-plus" aria-hidden="true"></i> Create Order</a></li>
                            
                        </ul> 
                    <li class="liMainMenu showHideSubMenu">
                        <a href="javascript:void(0);" class="showHideSubMenu">
                            <i class="fa-solid fa-user-plus showHideSubMenu"></i> 
                            <span class="menuText showHideSubMenu"> User</span>
                            <i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu"></i>  
                        </a>
                        <ul class="subMenus">
                            <li><a  class="subMenuLink" href="./users-view.php"><i class="fa fa-address-book" aria-hidden="true"></i> View Users</a></li>  
                            <li><a  class="subMenuLink" href="./users-add.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Users</a></li>           
                        </ul> 
                    </li>
                </ul>
            </div>
        </div>
