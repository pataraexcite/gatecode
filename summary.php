<script type='text/javascript' src='/ext/adapter/jquery/canvasjs/jquery.canvasjs.min.js'></script>

<!-- row -->

          <!-- page header -->
          <div class="pageheader"><h2><i class="fa fa-bar-chart-o"></i> HOTEL SUMMARY</h2></div>
          <!-- /page header -->
            <div class="row">

              <div class="col-lg-6 col-md-12">
                <section class="tile transparent">
                  <div class="tile-header rounded-top-corners">
                    <!-- <h1><strong>Statistic</strong> This year & Last year</h1> -->
                  </div>
                  <div class="tile-widget"><div id="chart00" class="chart statistics" style="height: 350px;"></div></div>
                </section>
              </div>
        

              <div class="col-lg-6 col-md-12">
                <section class="tile transparent">
                  <div class="tile-header rounded-top-corners">
                    <!-- <h1><strong>Statistic</strong> This year & Last year</h1> -->
                  </div>
                  <div class="tile-widget"><div id="chart01" class="chart statistics" style="height: 350px;"></div></div>
                </section>
              </div>
 
             </div>
            
            <div class="row">             
              
               <div class="col-lg-6 col-md-12">
                <section class="tile transparent">
                  <div class="tile-header rounded-top-corners">
                    <!-- <h1><strong>Statistic</strong> This year & Last year</h1> -->
                  </div>
                  <div class="tile-widget"><div id="chart02" class="chart statistics" style="height: 350px;"></div></div>
                </section>
              </div>       


              <div class="col-lg-6 col-md-12">
                <section class="tile transparent">
                  <div class="tile-header rounded-top-corners">
                    <!-- <h1><strong>Statistic</strong> This year & Last year</h1> -->
                  </div>
                  <div class="tile-widget"><div id="chart03" class="chart statistics" style="height: 350px;"></div></div>
                </section>
              </div>
        
            </div>
            
            <div class="row">

              <div class="col-lg-6 col-md-12">
                <section class="tile transparent">
                  <div class="tile-header rounded-top-corners">
                    <!-- <h1><strong>Statistic</strong> This year & Last year</h1> -->
                  </div>
                  <div class="tile-widget"><div id="chart04" class="chart statistics" style="height: 350px;"></div></div>
                </section>
              </div>
        
            </div>
            
                                    
          </div>
          <!-- /content container -->

    <script>

var loadData=function(x){

CanvasJS.addColorSet("taskstatus",["#ff9933","#0099ff","#009900","#ff3300","#c0c0c0","blue"]);

function displayChart(data,c) {
	for (var i = 0; i <= data.length - 1; i++) {
		var dataPointss = [];
		for (var j = 0; j <= data[i].dataPoints.length - 1; j++) {
			dataPointss.push({ label: data[i].dataPoints[j].x, y: data[i].dataPoints[j].y });
		}
		data[i].dataPoints = dataPointss;
		c.options.data[i] = data[i];
	}
	c.render();
}


  $.getJSON("../bi/bi_action.php?act=barsummary"+x,function(result){
		var chart = new CanvasJS.Chart("chart00",{
			animationEnabled: true,
			title:{text:"ROOM REVENUE (Click to drilldown)", fontSize:16}, 
			axisY:{title:"THB",titleFontSize:12,labelFontSize:12, suffix : "M"}, 
			axisY2:{title: " % OCC.",titleFontSize:12,labelFontSize:12,suffix:"%",
				gridColor:"#ffffff",gridThickness:0,tickColor:"#009900",labelFontColor: "#007700",
				interval: 10,lineColor:"#009900",maximum: 100,titleFontColor: "#007700"
			}, 	
			axisX:{title: "",fontSize: 11,labelFontSize:11,interval:1,intervalType: "day"}, 
			data:[{ 
				type:"column",showInLegend: true,legendText: "ACTUAL",color: "#ff9900",
				click:function(e){loadData(e.dataPoint.params);},
				toolTipContent:"{label} {text} - Actual : {y}M",
				indexLabelFontFamily:"Tahoma",indexLabelFontSize:9,indexLabelFontColor: "white",
				indexLabelOrientation:"vertical",indexLabelPlacement: "inside",indexLabel: "{y} M ",
				dataPoints:result.data1
			},{
				type:"column",showInLegend: true,legendText: "BUDGET",color: "#81DAF5",
				click:function(e){loadData(e.dataPoint.params);},
				toolTipContent:"{label} {text} - Budget : {y}M",
				indexLabelFontFamily:"Tahoma",indexLabelFontSize:9,indexLabelFontColor: "white",
				indexLabelOrientation:"vertical",indexLabelPlacement: "inside",indexLabel: "{y} M ",
				dataPoints:result.data3
			},{			
				type:"spline",showInLegend: true,legendText: "% OCC",color: "#009900",axisYType:"secondary",
				click:function(e){loadData(e.dataPoint.params);},
				toolTipContent:"{label} {text} - OCC. {y}%",
				indexLabelFontFamily:"Tahoma",indexLabelFontSize:10,indexLabelOrientation:"horizontal",//indexLabel: "{y}%",
				dataPoints:result.data2
			}] 
		}); 
        chart.render();
   });

   
  $.getJSON("../bi/bi_action.php?act=pie"+x,function(result){
		var chart = new CanvasJS.Chart("chart01",{
			animationEnabled: true,
			title:{text: "ROOM REVENUE BY MARKET GROUP",fontSize: 16},
			//colorSet: "taskstatus",
			data:[{
				type: "doughnut",       
				indexLabelFontFamily: "Tahoma",indexLabelFontSize: 11,
				indexLabel: "{code} : {y}% ({all} M)",
				startAngle:-20,      
				showInLegend: true,
				toolTipContent:"{text} - {legendText} {y}% ({all} M)",
				dataPoints: result
			}]
		});
        chart.render();
   });

  $.getJSON("../bi/bi_action.php?act=barmarket"+x,function(result){
		var chart = new CanvasJS.Chart("chart02",{
			animationEnabled: true,
			title:{text:"AVERAGE ROOM RATE BY MARKET", fontSize:16}, 
			axisY:{title:"THB",titleFontSize:12,labelFontSize:12,valueFormatString: "#,##0.##"}, 	
			axisX:{title: "",fontSize: 11,labelFontSize:11,interval:1}, 
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center"
			},
			data:[{ 
				type:"bar",showInLegend: false,legendText: "ADR BY MARKET",
				toolTipContent:"{label} {text} - ADR : {y} THB",
				indexLabelFontFamily:"Tahoma",indexLabelFontSize:12,indexLabelFontColor: "white",
				indexLabelOrientation:"horizontal",indexLabelPlacement: "inside",indexLabel: "{y} THB ",
				dataPoints:result.data
			}] 
		}); 
        chart.render();

   });
   

  $.getJSON("../bi/bi_action.php?act=pieoccmarket"+x,function(result){
		var chart = new CanvasJS.Chart("chart04",{
			animationEnabled: true,
			title:{text: "OCCUPANCY (ROOM NIGHT) BY MARKET GROUP",fontSize: 16},
			//colorSet: "taskstatus",
			data:[{
				type: "pie",       
				indexLabelFontFamily: "Tahoma",indexLabelFontSize: 11,
				indexLabel: "{code} : {y}% ({all} RN)",
				startAngle:-20,      
				showInLegend: false,
				toolTipContent:"{text} - {legendText} {y}% ({all} RN)",
				dataPoints: result
			}]
		});
        chart.render();
   });

   
$.getJSON("../bi/bi_action.php?act=linenational"+x,function(r){

     var chart = new CanvasJS.Chart("chart03",{
	zoomEnabled:false,
	animationEnabled:true,
	title:{text:"TOP 7 NATIONALITY (ROOM REVENUE) ", fontSize:16},  
	axisX:{title:"",fontSize: 11,labelFontSize:10,interval:1},                        
	axisY:{title:"THB",titleFontSize:12,labelFontSize:12, suffix : "M"}, 
	theme: "theme1",
	toolTip: {
		shared: true,
		content: function(e){
			var body = new String;
			var head ;
			for (var i = 0; i < e.entries.length; i++){
				var  str="<span style= 'color:"+e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + " M</strong> <br/>" ; 
				body = body.concat(str);
			}
			head = "<span style = 'color:DodgerBlue; '><strong>"+ (e.entries[0].dataPoint.label) + "</strong></span><br/>";
			return (head.concat(body));
		}
	},
	legend:{
		verticalAlign: "bottom",
		horizontalAlign: "center",
		fontSize: 12,
		fontFamily: "Tahoma",
		cursor:"pointer",
		itemclick : function(e) {
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else {
			e.dataSeries.visible = true;
		}
		chart.render();
		}
	},
	data: []
   });
   displayChart(r,chart);
});
   
}

    
$(function(){

	loadData('');
            
})     
</script>

      