<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link rel="shortcut icon"href="<? echo base_url(); ?>image/ico-msm.ico" type="image/x-icon" />
<link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet" type="text/css" />
 <base href="<?php echo base_url();?>" />

  
  <style>

.label{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:10px;
    color:#0066FF;
}
.tableBorder{
    border:solid 4px #ffff99;
    margin-top:10px;
    border-radius:10px; 
    box-shadow: 0px 0px 20px black;
}
.message{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:14px;
    font-weight:bold;
    color:#0066FF;
}

</style>


</head>
<body>
<div id="wrapper">
	<div id="header">
    	<div class="title"></div>
	</div>
    
    <?php echo $contents; ?>
    
    <div id="footer">
			<!--<?php echo "@ 2014 MSM Consultant"; ?>-->
	</div>

<div>
</body>
</html>