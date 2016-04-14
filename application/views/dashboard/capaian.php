 
  <script type="text/javascript">
	$(function () {
    $('#graph_capaian_keuangan').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Capaian Keuangan'
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
                }
            }
        },
        series: [{
            name: 'Capaian Keuangan',
            colorByPoint: true,
            data: [<?php echo $series;?>]
        }]
    });
});
</script>

 
<div id="graph_capaian_keuangan"></div>
 <?php //echo number_format($capaian_renja);?> 
			<td><?php //echo number_format($capaian);?> 