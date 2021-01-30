
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $titlehead; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <!-- Bootstrap CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- Bootstrap CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">    
    <!-- animate CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css'); ?>">
    <!-- normalize CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/normalize.css'); ?>">
    <!-- main CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <!-- forms CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/form/all-type-forms.css'); ?>">
    <!-- style CSS============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
    <!-- responsive CSS ============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/alerts.css'); ?>">
    <!-- modernizr JS ============================================ -->
    <script src="<?php echo base_url('assets/js/vendor/modernizr-2.8.3.min.js'); ?>"></script>
</head>

<body>
    <div class="error-pagewrap">
        <div class="error-page-int">
            <div class="text-center m-b-md custom-login">
                <h2><i class="fa fa-lock"></i> <?php echo $titlehead; ?></h2>
                    <p></p>
            </div>
            <?php /*tampilkan form login*/ 
            if(empty($action)){     
            ?>                
            <div class="content-error">
                <div class="hpanel">
                    <div class="panel-body">                              
                        <!-- alert -->
                        <?php if (!empty($this->session->flashdata('infologin'))) { ?>
                        <div class="alert alert-danger fontred" role="alert">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php echo $this->session->flashdata('infologin'); ?>
                        </div>
                        <?php } ?> 
                        
                        <form action="<?php echo base_url('AdminLogin/ceklogin'); ?>" method="POST" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="" 
                                       required="true" name="username" id="username" 
                                       class="form-control form-control-lg"
                                       oninvalid="this.setCustomValidity('Username belum diisi')"
                                    oninput="setCustomValidity('')">

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" placeholder="******" required="true" value="" 
                                       name="password" id="password" class="form-control"
                                       oninvalid="this.setCustomValidity('password belum diisi')"
                                        oninput="setCustomValidity('')">
                            </div>
                            <button class="btn btn-success btn-lg btn-block loginbtn">
                                <i class="fa fa-sign-in"></i> Login</button>                                
                        </form>
                    </div>
                </div>
            </div>
<!--            <div class="contentnew">
                <div class="hpanelnew">
                    <a href="<?php //echo base_url($modul)."/ForgotPassword"; ?>">
                        <i class="fa fa-question-circle"></i> Lupa Password</span>
                    </a>
                </div>                    
            </div>  -->
            <?php } 
            else if(!empty($action) && $action === 'ForgotPassword'){
            ?>
            <div class="contentnew">
                <div class="hpanelnew">
                    <div class="panel-body">
                        <form action="<?php echo base_url('AdminLogin/resetpass'); ?>" method="POST" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="emailre">Email Terdaftar</label>
                                <input type="text" placeholder="" 
                                       required="true" name="emailre" id="emailre" 
                                       class="form-control form-control-lg"
                                       oninvalid="this.setCustomValidity('Email belum diisi')"
                                    oninput="setCustomValidity('')">
                                <span class="help-block small">Masukan email yang telah tedaftar</span>
                            </div>
                            <button class="btn btn-success btn-lg btn-block loginbtn">
                                <i class="fa fa-resolving"></i> Reset Password</button>   
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="text-center login-footer"> 
                <p>Copyright &copy; <?php echo date('Y'); ?> Aplikasi Web POS </p>
            </div>
        </div>   
    </div>
    <!-- jquery
		============================================ -->
    <script src="<?php echo base_url('assets/js/vendor/jquery-1.12.4.min.js'); ?>"></script>
    <!-- bootstrap JS =========================================== -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- wow JS ============================================ -->
    <script src="<?php echo base_url('assets/js/wow.min.js'); ?>"></script>
    <!-- icheck JS ============================================ -->
    <script src="<?php echo base_url('assets/js/icheck/icheck.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/icheck/icheck-active.js'); ?>"></script>
    <!-- plugins JS============================================ -->
    <script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
    <!-- price-slider JS ============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-price-slider.js"></script>
    <!-- scrollUp JS ============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollUp.min.js"></script>
    <!-- owl.carousel JS ============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
    <!-- sticky JS ============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.sticky.js"></script>
    <!-- meanmenu JS ============================================ -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.meanmenu.js"></script>
    <!-- main JS ============================================ -->
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
</body>

</html>