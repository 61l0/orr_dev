 
  <script type="text/javascript">
	$(function () {
	Highcharts.getOptions().plotOptions.pie.colors=['#2f7ed8', '#E74C3C'];	
    $('#graph_capaian_renaksi').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                     distance: 0,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },point: {
                 events: {
                  click: function() {  
                                          	
                  			$.ajax({
								url:'<?php echo base_url(); ?>capaian/get_detail/6/'+<?php echo $id;?>,		 
								type:'POST',
								data:$('#form_barang').serialize(),
								success:function(data){ 
								  	$( "#infodlg" ).html(data);
									$( "#infodlg" ).dialog({ title:"Info...", draggable: false,modal:true,height:'auto',width:'auto'});	
								 }
							});		



                        }
                     }
                 }
                 	
            }
        },
        series: [{
            name: 'Capaian Renaksi',
            colorByPoint: true,
            data: [<?php echo $series;?>]
        }]
    });
});
</script>
 <div id="graph_capaian_renaksi" ></div>
	 
  
