<!DOCTYPE html>
<html lang="en" class="h-100">
<!-- Mirrored from davur.dexignzone.com/dashboard/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 Apr 2022 07:59:42 GMT -->
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="Urban-Cafe" />
	<meta property="og:title" content="Urban-Cafe" />
	<meta property="og:description" content="Urban-Cafe" />
	<meta property="og:image" content="Urban-Cafe" />
	<meta name="format-detection" content="Urban-Cafe">
    <title>Urban-Cafe </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url(); ?>assets/img/logo.png">
    <link href="<?php echo site_url(); ?>assets/admin/css/style.css" rel="stylesheet">

</head>
<body class="h-100">
<?= session()->getFlashdata('error') ?>
<?= service('validation')->listErrors() ?>
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index.html"><img src="images/logo-full.png" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form method="post" action="<?php echo site_url(); ?>super_admin/auth/authenticationcheck">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="username" name="username" class="form-control" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?php echo site_url(); ?>assets/admin/vendor/global/global.min.js"></script>
	<script src="<?php echo site_url(); ?>assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/admin/js/custom.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/admin/js/deznav-init.js"></script>

</body>


<!-- Mirrored from davur.dexignzone.com/dashboard/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 Apr 2022 07:59:43 GMT -->
</html>