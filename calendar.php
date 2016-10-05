          <!-- content main container -->
          <div class="main as-table">        
            <div class="col-md-12 tile color transparent-white rounded-corners">
              <div class="tile-body">                
                <div class="cal-options">                  
                  <div class="date-info">
                    <h2 class="text-center">
                      <i class="fa fa-angle-left pull-left" id="cal-prev"></i>
                      <span id="cal-current-date"></span>
                      <i class="fa fa-angle-right pull-right" id="cal-next"></i>
                    </h2>
                    <h3 class="large-thin text-center"> % OCC</h3>
                  </div>
                  <div id='calendar' class="rounded-corners"></div>
                </div>
              </div>
            </div>
          </div>  
          <!-- /content container -->
          
    <link rel="stylesheet" href="assets/js/vendor/fullcalendar/fullcalendar.css">
    <script src="assets/js/vendor/fullcalendar/old/jquery-ui-1.10.4.custom.min.js"></script>    
    <script src="assets/js/vendor/fullcalendar/lib/moment.min.js"></script>   
    <script src="assets/js/vendor/fullcalendar/fullcalendar.min.js"></script>
    <style>
	.fc-event {
	    font-size: 16px;background-color: #FFffff;
	    height: 18px; text-align: center;border-radius: 50%;
	}
	.fc-title {
		font-size: 16px; text-align: center;
	}
    .fc-sun {
		background-color: #FFffff;
		color: #000000;
  	}
	.fc-day {
	    background-color:white;
	}		
    </style>    
    <script>
    $(function(){
    
      // Initialize the calendar 

      $('#calendar').fullCalendar({
        header: false,
			eventLimit: false, // allow "more" link when too many events
			events:[{
				title:'99%',start:'2016-09-01',color:'#ff0000'				
			},{
				title:'97%',start:'2016-09-02',color:'#ff9f89'
			},{
				title:'95%',start:'2016-09-03',color:'#ff9f89'							
			},{
				title:'96%',start:'2016-09-04',color:'#ff9f89'	
			}]
      });

      // Show current date
      var currentDate = $('#calendar').fullCalendar('getDate');
      
      $('#cal-current-day').html(moment(currentDate).format("dddd"));
      $('#cal-current-date').html(moment(currentDate).format("MMM YYYY"));
    
      // Previous month action
      $('#cal-prev').click(function(){
        $('#calendar').fullCalendar( 'prev' );
        currentDate = $('#calendar').fullCalendar('getDate'); 
        $('#cal-current-day').html(moment(currentDate).format("dddd"));
        $('#cal-current-date').html(moment(currentDate).format("MMM YYYY"));
      });

      // Next month action
      $('#cal-next').click(function(){
        $('#calendar').fullCalendar( 'next' );
        currentDate = $('#calendar').fullCalendar('getDate');
        $('#cal-current-day').html(moment(currentDate).format("dddd"));
        $('#cal-current-date').html(moment(currentDate).format("MMM YYYY"));
      });
      



      
    })
      
    </script>