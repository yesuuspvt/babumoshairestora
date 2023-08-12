<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <?php
                if($_SESSION['role']=='Admin')
                {
            ?>
                <li>
                    <a href="<?php echo site_url(); ?>super-admin-dashboard" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Order Mangement</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href="<?php echo site_url(); ?>orders" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <span class="nav-text">Make Order</span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } 
            elseif($_SESSION['role']=='Super_Admin'){ ?>
                <li>
                    <a href="<?php echo site_url(); ?>super-admin-dashboard" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url(); ?>super-admin-restaurant-list" aria-expanded="false">
                        <i class="fas fa-utensils"></i>
                        <span class="nav-text">Manage Restaurant</span>
                    </a>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Manage Product</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo site_url(); ?>super-admin-product-list">Product List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo site_url(); ?>super-admin-user-list" aria-expanded="false">
                        <i class="fas fa-utensils"></i>
                        <span class="nav-text">Restaurant User</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>