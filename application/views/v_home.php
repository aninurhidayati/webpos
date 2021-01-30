
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Aplikasi Web Pos</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
<!--     Google Fonts
		============================================ 
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">-->
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
    <!-- owl.carousel CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/owl.carousel.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/owl.theme.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/owl.transitions.css'); ?>">
    <!-- animate CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/animate.css'); ?>">
    <!-- normalize CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/normalize.css'); ?>">
    <!-- meanmenu icon CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/meanmenu.min.css'); ?>">
    <!-- main CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/main.css'); ?>">
    <!-- educate icon CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/educate-custon-icon.css'); ?>">
    <!-- morrisjs CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/morrisjs/morris.css'); ?>">
    <!-- mCustomScrollbar CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/scrollbar/jquery.mCustomScrollbar.min.css'); ?>">
    <!-- metisMenu CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/metisMenu/metisMenu.min.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/metisMenu/metisMenu-vertical.css'); ?>">
    <!-- calendar CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/calendar/fullcalendar.min.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/calendar/fullcalendar.print.min.css'); ?>">
    <!-- datapicker CSS============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/datapicker/datepicker3.css'); ?>">
    <!-- x-editor CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/editor/select2.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/editor/datetimepicker.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/editor/bootstrap-editable.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/editor/x-editor-style.css'); ?>">
    <!-- normalize CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/data-table/bootstrap-table.css'); ?>">
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/data-table/bootstrap-editable.css'); ?>">
    <!-- style CSS============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
    <!-- responsive CSS============================================ -->
    <link rel="stylesheet"  href="<?php echo base_url('assets/css/responsive.css'); ?>">
    <!-- modernizr JS============================================ -->
    <script src="<?php echo base_url('assets/js/vendor/modernizr-2.8.3.min.js'); ?>"></script>
    <!-- calendar CSS============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/calendar/fullcalendar.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/calendar/fullcalendar.print.min.css'); ?>">
    <!-- chosen CSS====================================== -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/chosen/bootstrap-chosen.css'); ?>">
</head>

<body>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
    <!-- Start Left menu area -->
    <?php $this->load->view('v_menu'); ?>
    <!-- End Left menu area -->
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="<?php echo base_url('assets/img/logo/logo.png');?>" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                    <i class="educate-icon educate-nav"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n">
                                            <!-- top left menu header-->
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                
                                                <!--                                                <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="educate-icon educate-bell" aria-hidden="true"></i><span class="indicator-nt"></span></a>
                                                    <div role="menu" class="notification-author dropdown-menu animated zoomIn">
                                                        <div class="notification-single-top">
                                                            <h1>Notifications</h1>
                                                        </div>
                                                        <ul class="notification-menu">
                                                            <li>
                                                                <a href="#">
                                                                    <div class="notification-icon">
                                                                        <i class="educate-icon educate-checked edu-checked-pro admin-check-pro" aria-hidden="true"></i>
                                                                    </div>
                                                                    <div class="notification-content">
                                                                        <span class="notification-date">16 Sept</span>
                                                                        <h2>Advanda Cro</h2>
                                                                        <p>Please done this project as soon possible.</p>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="notification-view">
                                                            <a href="#">View All Notification</a>
                                                        </div>
                                                    </div>
                                                </li>-->
                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                        <i class="fa fa-user"></i> <i class="fa fa-sign-in"></i>
                                                        <span class="admin-name"><?php echo $this->session->userdata('namapegawai'); ?></span>
                                                        <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                                    </a>
                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                        <li><a href="<?php echo base_url('Home/logout');?>"><i class="fa fa-sign-out"></i> Keluar</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-item nav-setting-open">
                                                    <a href="#" role="button" aria-expanded="false" class="nav-link dropdown-toggle">&nbsp;</a>
                                                    
                                                </li>
                                                <li>&nbsp;&nbsp;</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                        <li><a data-toggle="collapse" data-target="#Charts" href="#">Home <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul class="collapse dropdown-header-top">
                                                <li><a href="index.html">Dashboard v.1</a></li>
                                                <li><a href="index-1.html">Dashboard v.2</a></li>
                                                <li><a href="index-3.html">Dashboard v.3</a></li>
                                                <li><a href="analytics.html">Analytics</a></li>
                                                <li><a href="widgets.html">Widgets</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="events.html">Event</a></li>                                        
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu end -->
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list single-page-breadcome" style="padding-bottom: 1px!important;padding-top: 0px!important;">
                                <div class="row" >
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <h4 class="text-primary" style="margin-top: 6px!important;">
                                            <i class="fa fa-bookmark text-primary"></i> <?php echo $page_title; ?>
                                        </h4>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Data Table</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Static Table Start -->
        <?php $this->load->view($page_content); ?>
        <!-- Static Table End -->
        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="footer-copy-right">
                            <p>Copyright © <?php echo date("Y");?> <a href="https://colorlib.com/wp/templates/">NoorDev</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="alert_warning" class="modal modal-edu-general default-popup-WarningModal fade" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header header-color-modal bg-color-3">
                  <h4 class="modal-title">Peringatan!</h4>
                  <div class="modal-close-area modal-close-df">
                      <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                  </div>
              </div>
              <div class="modal-body">
                  <i class="educate-icon educate-warning modal-check-pro information-icon-pro"></i>
                  <h2 id="warning_title"></h2>
                  <p id="warning_message"></p>
              </div>
              <div class="modal-footer">
                  <a data-dismiss="modal" href="#">OK</a>
              </div>
          </div>
      </div>
  </div>

    <!-- jquery============================================ -->
    <script src="<?php echo base_url('assets/js/vendor/jquery-1.12.4.min.js'); ?>"></script>
    <!-- bootstrap JS============================================ -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- wow JS============================================ -->
    <script src="<?php echo base_url('assets/js/wow.min.js'); ?>"></script>
    <!-- price-slider JS============================================ -->
    <script src="<?php echo base_url('assets/js/jquery-price-slider.js'); ?>"></script>
    <!-- meanmenu JS============================================ -->
    <script src="<?php echo base_url('assets/js/jquery.meanmenu.js'); ?>"></script>
    <!-- owl.carousel JS============================================ -->
    <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
    <!-- sticky JS============================================ -->
    <script src="<?php echo base_url('assets/js/jquery.sticky.js'); ?>"></script>
    <!-- scrollUp JS============================================ -->
    <script src="<?php echo base_url('assets/js/jquery.scrollUp.min.js'); ?>"></script>
    <!-- input-mask JS============================================ -->
    <script src="<?php echo base_url('assets/js/input-mask/jasny-bootstrap.min.js'); ?>"></script>
    <!-- mCustomScrollbar JS============================================ -->
    <script src="<?php echo base_url('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/scrollbar/mCustomScrollbar-active.js'); ?>"></script>
    <!-- metisMenu JS============================================ -->
    <script src="<?php echo base_url('assets/js/metisMenu/metisMenu.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/metisMenu/metisMenu-active.js'); ?>"></script>
    <!-- data table JS============================================ -->
    <script src="<?php echo base_url('assets/js/data-table/bootstrap-table.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/tableExport.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/data-table-active.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/bootstrap-table-editable.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/bootstrap-editable.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/bootstrap-table-resizable.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/colResizable-1.5.source.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/data-table/bootstrap-table-export.js'); ?>"></script>
    <!--  editable JS============================================ -->
    <script src="<?php echo base_url('assets/js/editable/jquery.mockjax.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/editable/mock-active.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/editable/select2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/editable/moment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/editable/bootstrap-datetimepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/editable/bootstrap-editable.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/editable/xediable-active.js'); ?>"></script>

    <!-- Chart JS============================================ -->
    <script src="<?php echo base_url('assets/js/chart/jquery.peity.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/peity/peity-active.js'); ?>"></script>
    <!-- tab JS============================================ -->
    <script src="<?php echo base_url('assets/js/tab.js'); ?>"></script>
    <!-- plugins JS============================================ -->
    <script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
    <!-- main JS============================================ -->
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <!-- tawk chat JS============================================ -->
<!--    <script src="<?php echo base_url('assets/js/tawk-chat.js'); ?>"></script>-->
    <!-- datapicker JS=========================================== -->
    <script src="<?php echo base_url('assets/js/datapicker/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datapicker/datepicker-active.js'); ?>"></script>
    <!-- chosen JS============================================ -->
    <script src="<?php echo base_url('assets/js/chosen/chosen.jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/chosen/chosen-active.js'); ?>"></script>    
    <!-- select2 CSS============================================ -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/select2/select2.min.css'); ?>">
    <script src="<?php echo base_url('assets/custom_function.js'); ?>"></script>
    <script src="<?php echo base_url('assets/fungsi_terbilang.js'); ?>"></script>
    <script src="<?php echo base_url('assets/custom_reports.js'); ?>"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var nilai_bm = $('#totalpayment_bm').val();
        var nilai_bk = $('#subtotal').val();
        if(nilai_bk){
            $('#terbilang_fakturbk').append(terbilang(nilai_bk));
        } else 
        if(nilai_bm){
            $('#terbilang_fakturbm').append(terbilang(nilai_bm));
        }
    });
    </script>
    
</body>

</html>