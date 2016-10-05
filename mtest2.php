<?php
include("../config.php");
include("../function.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "connecttion is ";
print_r($connection_string);

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
        //test_bi("linecompare");
        //test_bi("pie");

        function test_bi(act){
            console.log("//--------------------------------------------------");
            $.getJSON("bi/bi_action.php?act="+act,function(r){
                console.log(r);
                $("#content").html(r);
            }); 
        }

        $.getJSON("bi/bi_action.php?act=linecompare",function(r){
        var plot = $.plotAnimator($("#statistics-chart"), 
                [
                      {data:r.data1,label:'This Mouth',lines:{lineWidth:3,show:true},points:{show:true,fill:true,radius:5,fillColor:"rgba(0,0,0,.5)",lineWidth:2},shadowSize:2,color:'#00ff00'},
                      {data:r.data2,label:'Last Mouth',lines:{lineWidth:3,show:true},points:{show:true,fill:true,radius:4,fillColor:"rgba(255,255,255,.2)",lineWidth:2},shadowSize:1,color:'#ffffff'}
                ],{         
                    xaxis:{
                      tickLength: 0,tickDecimals:0,min:1,
                      ticks: [[1,"JAN"], [2, "FEB"], [3, "MAR"], [4, "APR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AUG"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DEC"]],
                      font:{lineHeight:24,weight:"300",color:"#ffffff",size:14}
                    },        
                    yaxis:{ticks:4,tickDecimals:0,tickColor:"rgba(255,255,255,.3)",font:{lineHeight:13,weight:"300",color:"#ffffff"}},        
                    grid:{borderWidth:{top:0,right:0,bottom:1,left:1},borderColor:'rgba(255,255,255,.3)',margin:0,minBorderMargin:0,labelMargin:20,hoverable:true,clickable:true,mouseActiveRadius:6},
                    legend:{show:true,position:"nw"}
                  });
                  
                  $("#statistics-chart div.legend >div").css("background", "transparent");
                  $("#statistics-chart div.legend table").css("color", "rgba(255,255,255,.8)");
                  // tooltips showing
                  $('#statistics-chart').bind("plothover", function (event, pos, item) {
                    if (item) {
                      var x = item.datapoint[0],
                          y = item.datapoint[1];
                      $("#flotTip").css({top: item.pageY-30});
                    } else {
                      $("#flotTip").hide();
                    }
                  });        
                  
               }); 
        });
  </script> 
<style type="text/css">
    body{
        background: #333;
    }
</style>
  <div id='content'>
      <div id="statistics-chart" class="chart statistics" style="height: 250px;">statistics-chart</div></div>
  </div>