<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CodeIgniter with Highcharts</title>
    <script type="text/javascript" src="<?php echo base_url('/assets/jquery-1.7.2.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/assets/highcharts/highcharts.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/assets/highcharts/modules/exporting.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/assets/highcharts/themes/grid.js'); ?>"></script>
    <script type="text/javascript">
        
       
        function proses(thn){
        window.location.href='<?php echo base_url()?>index.php/welcome/summary/'+thn
        }
                        
        jQuery(function(){
        	new Highcharts.Chart({
        		chart: {
        			renderTo: 'chart2',
        			type: 'line',
        		},
        		title: {
        			text: 'Proyeksi Tahun <?php echo $tahun ?>',
        			x: -20
        		},
        		subtitle: {
        			text: '',
        			x: -20
        		},
        		xAxis: {
        			categories: <?php echo json_encode($data4);?>
        		},
        		yAxis: {
        			title: {
        				text: 'Jumlah'
        			}
        		},
        		series: [{
        			name: 'BLK',
        			data: <?php echo json_encode($data); ?>
        		},
                {
                    name: 'BAK',
                    data: <?php echo json_encode($data2);?>   
                }
                ]
        	});
        });
        
        jQuery(function(){
        	new Highcharts.Chart({
        		chart: {
        			renderTo: 'chart',
        			type: 'column',
        		},
        		title: {
        			text: 'Proyeksi Tahun <?php echo $tahun ?>',
        			x: -20
        		},
        		subtitle: {
        			text: 'Kementerian Lembaga',
        			x: -20
        		},
        		xAxis: {
        			categories: <?php echo json_encode($data4);?>
        		},
        		yAxis: {
        			title: {
        				text: 'Jumlah'
        			}
        		},
        		series: [{
        			name: 'BAK',
        			data: <?php echo json_encode($data); ?>
        		},
                {
                    name: 'BLK',
                    data: <?php echo json_encode($data2);?>   
                }
                ]
        	});
        }); 
        
        
        
        jQuery(function(){
        	new Highcharts.Chart({
        		chart: {
        			renderTo: 'chart3',
        			type: 'pie'
        		},
        		title: {
        			text: 'Proyeksi Program  Tahun <?php echo $tahun ?>',
        			x: -20
        		},        
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            color: '#000011',
                            connectorColor: '#000011',
                            enabled: true,
                            format: '<b>{series.name}: {series.data:.1f}%</b>',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}},
                            showInLegend: true
                }},
                tooltip: {
                    Format: '<b>{series.name}: {series.data:.1f}%</b>'
                },
        		series: [{
                    type: 'pie',
        			name: 'Proyeksi Program',
        			data: <?php echo json_encode($data_pie); ?>
        		}
                ]
        	});
        }); 
        
        
        
    </script>
    
    
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<table width="100%" border="0">
    <tr>
        <td width="70%">
            <div id="container">
            	<div id="body">
            		<div id="chart"></div><br />
                    <div id="chart2"></div><br />
                    <div id="chart3"></div>
            	</div>
                <!--pembaca kecepatan-->
            	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
            </div>
        </td>
        <td  width="30%" valign="top">
            <input id="tahun_periode" name="tahun_periode" class="easyui-combobox" value="<?php echo $tahun ?>" style="width:100px;" data-options="
                    		valueField: 'tahun',
                    		textField: 'tahun',
                    		data: [{
                    		    tahun:'2015'  
                    		},{
                    			tahun:'2016'
                    		},{
                    		    tahun:'2017'  
                  		    },{
                    		    tahun:'2018'  
                  		    },{
                    		    tahun:'2019'  
                  		    }],onSelect:function(rec){
                                 proses(rec.tahun);
                    		}" />
               
            <br /><br />
            <?php echo $tabel;?>
        </td>
    </tr>
</table>
</body>
</html>