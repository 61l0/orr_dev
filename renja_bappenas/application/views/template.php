<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $title; ?></title>
<link rel="shortcut icon" href="<? echo base_url(); ?>image/ico-msm.ico" type="image/x-icon" />
<link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet" type="text/css" />
 <base href="<?php echo base_url();?>" />
 <link type="text/css" href="<?php echo base_url();?>assets/menu.css" rel="stylesheet" />

  <!-- set javascript base_url -->
    <script type="text/javascript">
        <![CDATA[
        var base_url = '<?php echo base_url();?>';
        ]]>
    </script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/menu.js"></script>

	<SCRIPT LANGUAGE="JavaScript">

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

	</SCRIPT>


</head>
<body  onload="InitializeTimer(); StartTheTimer();" >

<script language=JavaScript>
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

//var message="Function Disabled!";
//
/////////////////////////////////////
//function clickIE4(){
//if (event.button==2){
//alert(message);
//return false;
//}
//}
//
//function clickNS4(e){
//if (document.layers||document.getElementById&&!document.all){
//if (e.which==2||e.which==3){
//alert(message);
//return false;
//}
//}
//}
//
//if (document.layers){
//document.captureEvents(Event.MOUSEDOWN);
//document.onmousedown=clickNS4;
//}
//else if (document.all&&!document.getElementById){
//document.onmousedown=clickIE4;
//}
//
//document.oncontextmenu=new Function("alert(message);return false")
//
////  <?php echo $this->session->userdata('Display_name'); ?>, <?php echo $pk; ?>--> 
</script>
<?php
$kd_skpd = $this->session->userdata('kdskpd');
$esselon1 = $this->session->userdata('esselon1');

$sqltpk="SELECT nmdept AS nama FROM t_dept WHERE kddept = '$kd_skpd'";
	 $sqlpk=$this->db->query($sqltpk);
        foreach ($sqlpk->result() as $rowpk)
        {
        $pk=$rowpk->nama;
        }		
		
?>
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
		Rencana Kerja Kementerian/Lembaga<!--@ 2014 MSM Consultant-->
	</div>
</div>

</body>
</html>