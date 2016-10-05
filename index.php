<?php
 include("../config.php");
 include("../function.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 $filename="../files/".$_SESSION["login"]["photo"];
 $filetype = strtolower(strrchr($filename,'.'));
 $avatar="../files/thumbs/avatar/".md5_file($filename).$filetype;
 if(is_file($filename)){ if(is_file($avatar)){}else{createthumb($filename,$avatar,100,100);}}else{$avatar="../images/avatar.png";} 
 $p=(isset($_REQUEST["p"]))?$_REQUEST["p"]:"dashboard";
 $dpath="../";
 
?>
<!DOCTYPE html>
<html>
  <head>
	  
	<title><?=$site_config["title"];?> <?=$page_title;?></title>
	<meta name="description" content="<?=$site_config["description"];?>" />
	<meta name="keywords" content="<?=$site_config["keyword"];?> <?=$page_keyword;?> " />
	<link href="<?=$dpath;?><?=$site_config["icon"];?>" rel="shortcut icon" type="image/x-icon" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <!-- Bootstrap -->
    <link href="assets/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/vendor/animate/animate.min.css">
    <link type="text/css" rel="stylesheet" media="all" href="assets/js/vendor/mmenu/css/jquery.mmenu.all.css" />
    <link rel="stylesheet" href="assets/js/vendor/videobackground/css/jquery.videobackground.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap-checkbox.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap/bootstrap-dropdown-multilevel.css">

    <link rel="stylesheet" href="assets/js/vendor/rickshaw/css/rickshaw.min.css">
    <link rel="stylesheet" href="assets/js/vendor/morris/css/morris.css">
    <link rel="stylesheet" href="assets/js/vendor/tabdrop/css/tabdrop.css">
    <link rel="stylesheet" href="assets/js/vendor/summernote/css/summernote.css">
    <link rel="stylesheet" href="assets/js/vendor/summernote/css/summernote-bs3.css">
    <link rel="stylesheet" href="assets/js/vendor/chosen/css/chosen.min.css">
    <link rel="stylesheet" href="assets/js/vendor/chosen/css/chosen-bootstrap.css">
    
    <link href="assets/css/minimal.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/vendor/bootstrap/bootstrap-dropdown-multilevel.js"></script>
    <script src="assets/js/vendor/mmenu/js/jquery.mmenu.min.js"></script>
    <script src="assets/js/vendor/sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/vendor/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="assets/js/vendor/animate-numbers/jquery.animateNumbers.js"></script>
    <script src="assets/js/vendor/videobackground/jquery.videobackground.js"></script>
    <script src="assets/js/vendor/blockui/jquery.blockUI.js"></script>
    <script src="assets/js/minimal.min.js"></script>

    <script src="assets/js/vendor/flot/jquery.flot.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.categories.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.pie.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.stack.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.tooltip.min.js"></script>  
    <script src="assets/js/vendor/flot/jquery.flot.time.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.selection.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.animator.min.js"></script>
    <script src="assets/js/vendor/flot/jquery.flot.orderBars.js"></script>     
    <script src="assets/js/vendor/graphtable/jquery.graphTable-0.3.js"></script>

    <script src="assets/js/vendor/rickshaw/raphael-min.js"></script> 
    <script src="assets/js/vendor/rickshaw/d3.v2.js"></script>
    <script src="assets/js/vendor/rickshaw/rickshaw.min.js"></script>
    <script src="assets/js/vendor/morris/morris.min.js"></script>
    <script src="assets/js/vendor/easypiechart/jquery.easypiechart.min.js"></script>
    <script src="assets/js/vendor/justgage/justgage.js"></script>
    <script src="assets/js/vendor/tabdrop/bootstrap-tabdrop.min.js"></script>

    <script src="assets/js/vendor/summernote/summernote.min.js"></script>
    <script src="assets/js/vendor/chosen/chosen.jquery.min.js"></script>
  
  <style>
	 .navbar .navbar-header .navbar-logo { 
	 	font-weight: 300; font-size: 18px; font-family: "Roboto Condensed", sans-serif; color: white; 
	 	padding: 0; padding-left: 30px;line-height: 45px; 
	 	background-image:url(<?=$dpath.$site_config["logo"];?>) !important;background-repeat:no-repeat;
	 	background-size:22px 22px; 
	 	height:45px;width:45px;
	 } 
	 .navbar .navbar-header .navbar-logo img { vertical-align: top; }
	 .navbar.collapsed .navbar-header .navbar-logo { display: none; }
	  
  </style>  
  <script>
  $(function(){
	$(".linkmenu").click(function(e){
		e.preventDefault();	  
		var url = $(this).attr("data-url");		
		$("#content").load(url,function(result){
			
		});
	});
	// load first tab content
	$("#content").load($(".menu .active a").attr("data-url"),function(result){ 
		alert($(".menu .active a").attr("data-url"));
	 });	
  });
  </script>                 
  </head>
  <body class="bg-2">
    <form style="height:100%; overflow: hidden;">
    <!-- Preloader -->
    <div class="mask"><div id="loader"></div></div>
    <!--/Preloader -->
    <!-- Wrap all page content here -->
    <div id="wrap">
      <!-- Make page fluid -->
      <div class="row">

        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top collapsed" role="navigation" id="navbar">
          <!-- Branding -->
          <div class="navbar-header col-md-2">
            <a href="index.php" class="navbar-logo"><strong><?=$site_config["system"];?></strong></a>
            <div class="sidebar-collapse"><a href="#"><i class="fa fa-bars"></i></a></div>
          </div>
          <!-- Branding end -->

          <!-- .nav-collapse -->
          <div class="navbar-collapse">
                        
            <!-- Page refresh 
            <ul class="nav navbar-nav refresh">
              <li class="divided">
                <a href="#" class="page-refresh"><i class="fa fa-refresh"></i></a>
              </li>
            </ul>-->
            <!-- /Page refresh -->

            <!-- Search 
            <div class="search" id="main-search">
              <i class="fa fa-search"></i> <input type="text" placeholder="Search...">
            </div>-->
            <!-- Search end -->

            <!-- Quick Actions -->
            <ul class="nav navbar-nav quick-actions">
               <!-- task 
              <li class="dropdown divided">                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#"><i class="fa fa-tasks"></i><span class="label label-transparent-black">2</span></a>
                <ul class="dropdown-menu wide arrow nopadding bordered">
                  <li><h1>You have <strong>2</strong> new tasks</h1></li>
                  <li>
                    <a href="#">
                      <div class="task-info"><div class="desc">Layout</div><div class="percent">80%</div></div>
                      <div class="progress progress-striped progress-thin">
                        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                          <span class="sr-only">40% Complete (success)</span>
                        </div>
                      </div>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="task-info"><div class="desc">Dropdowns</div><div class="percent">60%</div></div>
                      <div class="progress progress-striped progress-thin">
                        <div class="progress-bar progress-bar-amethyst" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li><a href="#">Check all tasks <i class="fa fa-angle-right"></i></a></li>
                </ul>
              </li>
              -->

			  <!-- Alert 
              <li class="dropdown divided">                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#"><i class="fa fa-bell"></i><span class="label label-transparent-black">3</span></a>
                <ul class="dropdown-menu wide arrow nopadding bordered">
                  <li><h1>You have <strong>3</strong> new notifications</h1></li>                  
                  <li><a href="#"><span class="label label-green"><i class="fa fa-user"></i></span>New user registered.<span class="small">18 mins</span></a></li>
                  <li><a href="#"><span class="label label-red"><i class="fa fa-power-off"></i></span>Server down.<span class="small">27 mins</span></a></li>
                  <li><a href="#">Check all notifications <i class="fa fa-angle-right"></i></a></li>
                </ul>
              </li>-->

              <li class="dropdown divided user" id="current-user">
                <div class="profile-photo avatar"><img src="<?php echo $avatar;?>"  class="img-circle" /></div>
                <a class="dropdown-toggle options" data-toggle="dropdown" href="#"><?php echo $_SESSION["fullname"];?><i class="fa fa-caret-down"></i></a>                
                <ul class="dropdown-menu arrow settings">
                  <li>                    
                    <h3>Backgrounds:</h3>
                    <ul id="color-schemes">
                      <li><a href="#" class="bg-1"></a></li>
                      <li><a href="#" class="bg-2"></a></li>
                      <li><a href="#" class="bg-3"></a></li>
                      <li><a href="#" class="bg-4"></a></li>
                      <li><a href="#" class="bg-5"></a></li>
                      <li><a href="#" class="bg-6"></a></li>
                      <li class="title">Solid Backgrounds:</li>
                      <li><a href="#" class="solid-bg-1"></a></li>
                      <li><a href="#" class="solid-bg-2"></a></li>
                      <li><a href="#" class="solid-bg-3"></a></li>
                      <li><a href="#" class="solid-bg-4"></a></li>
                      <li><a href="#" class="solid-bg-5"></a></li>
                      <li><a href="#" class="solid-bg-6"></a></li>
                    </ul>
                  </li>
                  <li class="divider"></li>                
                  <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                  <li><a href="#"><i class="fa fa-calendar"></i> Setting</a></li>
                  <li class="divider"></li>
                  <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
              </li>
               <!-- Rigt menu 
              <li><a href="#mmenu"><i class="fa fa-comments"></i></a></li>-->
            </ul>
            <!-- /Quick Actions -->

            <!-- Sidebar -->
            <ul class="nav navbar-nav side-nav" id="sidebar">
              <li class="collapsed-content"><ul><li class="search"><!-- Collapsed search pasting here at 768px --></li></ul></li>
              <li class="navigation" id="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="#navigation">Navigation <i class="fa fa-angle-up"></i></a>
                <ul class="menu">
                  <li class="active"><a class="linkmenu" href="#" data-url="dashboard.php"><i class="fa fa-tachometer"></i> Hotel Statistics</a></li>
                  <li><a class="linkmenu" href="#" data-url="hotelstatus.php"><i class="fa fa-tint"></i> Hotel Status</a></li>
                  <li><a class="linkmenu" href="#" data-url="summary.php"><i class="fa fa-pencil"></i> Hotel Summary</a></li>
                  <li><a class="linkmenu" href="#" data-url="calendar.php"><i class="fa fa-th"></i> Monthly %OCC</a></li>
                <!--  
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> t e r m i n a l - J <b class="fa fa-plus dropdown-plus"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="#"><i class="fa fa-caret-right"></i> Job list</a></li>
                      <li><a href="#"><i class="fa fa-caret-right"></i> Room Status</a></li>
                      <li><a href="#"><i class="fa fa-caret-right"></i> Job Report</a></li>
                    </ul>
                  </li>
                -->  
                </ul>
              </li>
            </ul>
            <!-- Sidebar end -->
          </div>
          <!--/.nav-collapse -->
        </div>
        <!-- Fixed navbar end -->

 <!-- Page content -->
        <div id="content" class="col-md-12">
        
        </div>
<!-- /Page content -->  


      </div>
      <!-- Make page fluid-->
    </div>
    <!-- Wrap all page content end -->

    <section class="videocontent" id="video"></section>

  </body>
</html>
      