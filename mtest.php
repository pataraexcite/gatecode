<?php

include("../config.php");
include("../function.php");

/*
 include("con/config.php");
 include("con/function.php");
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "connecttion is ";
print_r($connection_string);
/*
 $filename="../files/".$_SESSION["login"]["photo"];
 $filetype = strtolower(strrchr($filename,'.'));
 $avatar="../files/thumbs/avatar/".md5_file($filename).$filetype;
 if(is_file($filename)){ if(is_file($avatar)){}else{createthumb($filename,$avatar,100,100);}}else{$avatar="../images/avatar.png";} 
 $p=(isset($_REQUEST["p"]))?$_REQUEST["p"]:"dashboard";
 $dpath="../";

 echo  $p;
 */
?>

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

      <script>
  $(function(){
    $(".linkmenu").click(function(e){
        e.preventDefault();   
        var url = $(this).attr("data-url");     
        $("#content").load(url,function(result){
            
        });
    });
    // load first tab content

    var firstTab = 'dashboard.php';
    $("#content").load(firstTab,function(result){ 
        
     });    
  });
  </script> 

  <div id='content'>load...</div>