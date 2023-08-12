<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="Babumoshai-Restora" />
	<meta property="og:title" content="Babumoshai-Restora" />
	<meta property="og:description" content="Babumoshai-Restora" />
	<meta property="og:image" content="Babumoshai-Restora" />
	<meta name="format-detection" content="telephone=no">
    <title>Babumoshai Restora </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url(); ?>assets/img/logo.png">
    <link href="<?php echo site_url(); ?>assets/admin/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/vendor/chartist/css/chartist.min.css">
	<link href="<?php echo site_url(); ?>assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?php echo site_url(); ?>assets/admin/css/style.css" rel="stylesheet">
    <?= $this->renderSection("stylesheets"); ?>
	<!-- <link href="../../cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet"> -->
    <style>
        .content-overlay{
            position: absolute;
            top:0px;
            right:0px;
            width:100%;
            height:100%;
            background-color:#eceaea;
            background-size: 50px;
            background-repeat:no-repeat;
            background-position:center;
            z-index:10000000;
            opacity: 0.4;
            filter: alpha(opacity=40);
            display: none;
        }
    </style>
</head>
    <body>
        <div id="main-wrapper">
            <div class="content-overlay">
                <div class="spinner-border text-primary" role="status" style="top: 40%; left: 50%; position: relative;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="nav-header">
                <a href="<?php echo site_url(); ?>super-admin-dashboard" class="brand-logo">
                    <img class="logo-abbr" src="<?php echo site_url(); ?>assets/img/BABUMOSHAI.png" alt="">
                </a>
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="line"></span><span class="line"></span><span class="line"></span>
                    </div>
                </div>
            </div>
            <?= $this->include('super_admin/layout/header'); ?>
            <?= $this->include('super_admin/layout/menu') ?>
            <div class="content-body">
                <div class="container-fluid">
                <?= $this->include('super_admin/layout/flashmessage'); ?>
                <?= $this->renderSection("content"); ?>
                </div>
            </div>
            <?= $this->include('super_admin/layout/footer') ?>
        </div>
         <!-- Required vendors -->
        <script src="<?php echo site_url(); ?>assets/admin/vendor/global/global.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/vendor/chart.js/Chart.bundle.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/js/custom.min.js"></script>
        <!-- Counter Up -->
        <script src="<?php echo site_url(); ?>assets/admin/js/deznav-init.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/vendor/waypoints/jquery.waypoints.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/vendor/jquery.counterup/jquery.counterup.min.js"></script>	
            
        <!-- Apex Chart -->
        <script src="<?php echo site_url(); ?>assets/admin/vendor/apexchart/apexchart.js"></script>	
        
        <!-- Chart piety plugin files -->
        <script src="<?php echo site_url(); ?>assets/admin/vendor/peity/jquery.peity.min.js"></script>
        
        <!-- Dashboard 1 -->
        <script src="<?php echo site_url(); ?>assets/admin/js/dashboard/dashboard-1.js"></script>
        <script>
            $(function() {
            // setTimeout() function will be fired after page is loaded
            // it will wait for 5 sec. and then will fire
            // $("#successMessage").hide() function
                
                $(".flashsmessages").hide(5000);

            });
        </script>
        <?= $this->renderSection("scripts"); ?>
     <body>
</html>