
  <script type="text/javascript">
		var chart1;  
		$(document).ready(function() {
      	chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'pnbp_chart_nya',
            type: 'column',
		 },   
         title: {
            text: ''
         },
		 
         xAxis: {
			categories: ['BELANJA NON OPERASIONAL'],
            tickmarkPlacement: 'off'
         },
         plotOptions: {         
          series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function() {
                          load_direktorat(this.series.name , "pnbp_chart_nya");
                        }
                     }
                 }
              }
           },
         yAxis: {
            title: {
               text: 'BELANJA NON OPERASIONAL'
            },
			labels: {
                     format: '{value:,.0f}  '
                }
         },
          series:             
            [ <?php echo isset($series1) ? $series1 : ''; ?>]
		});
	});	
</script>
 
  <div id="pnbp_chart_nya"  style="width: 98%; height: 100%; margin:0px">
                                        
  </div>
  <center>
    
  </center>