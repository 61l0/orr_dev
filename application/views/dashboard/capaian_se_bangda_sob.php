
  <script type="text/javascript">
		$(function () {
			
    $('#capaian_sebangda_sob_ok').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'CAPAIAN <?php echo $tipe_capaian ? $tipe_capaian : "-";?> <?php echo date("Y");?>'
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
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [ <?php echo isset($series1) ? $series1 : ''; ?>]
        }]
    });
});
</script>
 
  <div id="capaian_sebangda_sob_ok"  style="width: 98%; height: 100%; margin:0px">
                                        
  </div>
  
