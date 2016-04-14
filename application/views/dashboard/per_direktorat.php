
  <script type="text/javascript">
		var chart1;  
		$(document).ready(function() {
      	chart1 = new Highcharts.Chart({
         chart: {
            renderTo: '<?php echo $divnya;?>',
            type: 'column',
		 },   
         title: {
            text: ''
         },
		 
         xAxis: {
			categories: ['BELANJA OPERASIONAL'],
            tickmarkPlacement: 'off'
         },
         yAxis: {
            title: {
               text: 'BELANJA OPERASIONAL'
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
 
 
 