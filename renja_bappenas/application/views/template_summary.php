<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $title; ?></title>
<link rel="shortcut icon" href="<? echo base_url(); ?>image/ico-msm.ico" type="image/x-icon" />
<link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet" type="text/css" />
 <base href="<?php echo base_url();?>" />
 <link type="text/css" href="<?php echo base_url();?>assets/menu.css" rel="stylesheet" />
 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css" />


<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/highcharts/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/highcharts/themes/grid.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>


<script type="text/javascript">

jQuery(function(){
	new Highcharts.Chart({
		chart: {
			renderTo: 'chart',
			type: 'column',
		},
		title: {
			text: '<?php echo $data['utility'][1]; ?>',
			x: -20
		},
		subtitle: {
			text: '<?php echo $data['utility'][3]; ?>',
			x: -20
		},
		xAxis: {
			categories: <?php echo json_encode($data['var']);?>
		},
		yAxis: {
			title: {
				text: '<?php echo "<br>".$data['utility'][2]; ?>'
			}
		},
		series: [
					<?php 
					$count = count($data['aspec']); 
					$count2 = count($data['value0']); 
					for ($i=0;$i<$count;$i++)
					{
					echo "{name: '".$data['aspec'][$i]."',";
					echo "data: [";
						for ($q=0;$q<$count2;$q++){echo $data['value'.$i][$q].",";}
					echo "]},";
					} 
					?>]
		
	});
}); 





</script>

 <script type="text/javascript">
        <![CDATA[
        var base_url = '<?php echo base_url();?>';
        ]]>
    </script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/menu.js"></script>

	<script LANGUAGE="JavaScript">

	var secs;
	var timerID = null;
	var timerRunning = false;
	var delay = 2000;

	function InitializeTimer(){
		secs = 1;
		StopTheClock();
		StartTheTimer();
	}

	function StopTheClock(){
		if(timerRunning)
		clearTimeout(timerID);
		timerRunning = false;
	}

	function StartTheTimer(){
		if (secs==0){
			StopTheClock();
			ceklogin();
			secs = 1;
			timerRunning = true;
			timerID = self.setTimeout("StartTheTimer()", delay);
		}else{
			self.status = secs;
			secs = secs - 1;
			timerRunning = true;
			timerID = self.setTimeout("StartTheTimer()", delay);
		}
	}


	function ceklogin(){
        $(function(){      
         $.ajax({
            type: 'POST',
            dataType:"json",
            url:"<?php echo base_url(); ?>index.php/welcome/ceklogin/",
            success:function(data){
			   if (data==1){
				  document.location.href = '<?php echo base_url(); ?>index.php'; 
			   }
			}
         });
        });
	}	

	</script>

</head>

<body>
<div id="wrapper">
	<div id="header">
    	<div class="title"></div>
	 <div class="clear"></div>
	</div>

<?php

 $otori = $this->session->userdata('pcOtoriName');
 echo $this->dynamic_menu->build_menu('dyn_menu', '1',$otori);

?>
    
 
    <?php echo $contents; ?>
    <div id="footer">
	<!--	@ 2014 MSM Consultant-->
	</div>
</div>
</body>
</html>
