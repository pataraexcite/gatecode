        <div class='mtest_box'>mtest_box</div>

          <!-- page header -->
          <div class="pageheader"><h2><i class="fa fa-tachometer"></i> % OCC <span id="hoteldate"> Hotel Summary </span></h2></div>
          <!-- /page header -->

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <div class="row">
              
              <div class="col-lg-3 col-sm-6 col-sm-12">
                <section class="tile transparent rounded-top-corners">
                  <div class="tile-widget color transparent-black textured rounded-corners">
                  	<div id="gauge01" class="inline-block" style="width:100%;height:100%"></div>
                  </div>                
                </section>
              </div>

              <div class="col-lg-3 col-sm-6 col-sm-12">
                <section class="tile transparent rounded-top-corners">
                  <div class="tile-widget color transparent-black textured rounded-corners">
                  	<div id="gauge02" class="inline-block" style="width:100%;height:100%"></div>
                  </div>                
                </section>
              </div>

              <div class="col-lg-3 col-sm-6 col-sm-12">
                <section class="tile transparent rounded-top-corners">
                  <div class="tile-widget color transparent-black textured rounded-corners">
                  	<div id="gauge03" class="inline-block" style="width:100%;height:100%"></div>
                  </div>                
                </section>
              </div>

              <div class="col-lg-3 col-sm-6 col-sm-12">
                <section class="tile transparent rounded-top-corners">
                  <div class="tile-widget color transparent-black textured rounded-corners">
                  	<div id="gauge04" class="inline-block" style="width:100%;height:100%"></div>
                  </div>                
                </section>
              </div>

            </div>
            <!-- /cards -->

<!-- row -->

          <!-- page header -->
          <div class="pageheader"><h2><i class="fa fa-bar-chart-o"></i> Room Revenue Statistics (Million Baht)</h2></div>
          <!-- /page header -->
            <div class="row">


              <div class="col-lg-12 col-md-12">
                <section class="tile transparent">
                  <div class="tile-header color transparent-black textured rounded-top-corners">
                    <!-- <h1><strong>Statistic</strong> This year & Last year</h1> -->
                    <div class="controls">
                      <a href="#" class="minimize"><i class="fa fa-chevron-down"></i></a>
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                    </div>
                  </div>
                  <div class="tile-widget color transparent-black textured"><div id="statistics-chart" class="chart statistics" style="height: 250px;"></div></div>
                </section>
              </div>
        
            </div>
<!-- /row -->

          </div>
          <!-- /content container -->


  <script>

	function showGage(id,value,title,color){
      var g = new JustGage({
        id: id,label:'',title:title,titlePosition:"below",titleFontColor:"rgba(255,255,255,.6)",
        value: value,min:0,max:100,decimals:0,relativeGaugeSize: true,valueFontColor:"rgba(255,255,255,.8)",
        symbol:'%',pointer:true,//gaugeWidthScale: 0.6,
        customSectors:[{color:'#00ff00',lo:50,hi:100},{color:'#ff0000',lo:0,hi:50}],counter: true
      });		
	}
    
  $(function(){

  $.getJSON("bi/bi_action.php?act=gageocc",function(r){
    $(".mtest_box").html(" on "+r.data0);

    $("#hoteldate").html(" on "+r.data0);
  	showGage('gauge01',r.data1,'TODAY','green');
  	showGage('gauge02',r.data2,'YESTERDAY','red');
  	showGage('gauge03',r.data3,'M-T-D','gray');
  	showGage('gauge04',r.data4,'Y-T-D','gray');

   });	

  var act = "gageocc2";
  $.getJSON("bi/bi_action.php?act="+act,function(r){
      console.log(r);
  });

  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  $.getJSON("bi/bi_action.php?act=linecompare",function(r){

  		//console.log(r);
      // flot chart generate
      var plot = $.plotAnimator($("#statistics-chart"), 
        [
          {data:r.data1,label:'This Year',lines:{lineWidth:3,show:true},points:{show:true,fill:true,radius:5,fillColor:"rgba(0,0,0,.5)",lineWidth:2},shadowSize:2,color:'#00ff00'},
          {data:r.data2,label:'Last Year',lines:{lineWidth:3,show:true},points:{show:true,fill:true,radius:4,fillColor:"rgba(255,255,255,.2)",lineWidth:2},shadowSize:1,color:'#ffffff'}
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

    

      $(window).resize(function(){
        // redraw the graph in the correctly sized div
        plot.resize();
        plot.setupGrid();
        plot.draw();
      });

      // tooltips showing
      $("#statistics-chart").bind("plothover", function (event, pos, item) {
        if (item){
          var x=item.datapoint[0],y=item.datapoint[1];
          $("#tooltip").html('<h1 style="color: #418bca">'+months[x-1]+' of '+item.series.label+'</h1>'+'<strong>'+y+'</strong>'+' M.')
            .css({top: item.pageY-30, left: item.pageX+5})
            .fadeIn(200);
        } else {
          $("#tooltip").hide();
        }
      });
      
      //tooltips options
      $("<div id='tooltip'></div>").css({position:"absolute",/*display: "none",*/padding:"10px 20px","background-color":"#ffffff","z-index":"99999"}).appendTo("body");


            
    })     
    </script>

      