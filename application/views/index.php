<!DOCTYPE html>
<html lang="en">
  <head>
<title>Aplikasi Optimasi Renstra dan Renja</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>images/icon.jpg" type="image/x-icon" />
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/docs.css" rel="stylesheet">
 
    <script src="<?php echo base_url();?>js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.js"></script>
 	<link href="<?php echo base_url();?>css/stylesheet.css" rel="stylesheet">
   	<link rel="stylesheet" href="<?php echo base_url();?>js/ui/jquery-ui.css" />
	<script src="<?php echo base_url();?>js/jquery-ui-1.10.3.js"></script>
	<link href="<?php echo base_url();?>/js/load_mask/jquery.loadmask.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>js/load_mask/jquery.loadmask.min.js"></script>
	
 	<script>
   $(document).ready(function () {
     	setInterval(function() {
	        $.ajax({
				url:'<?php echo base_url();?>notifikasi/get_notifikasi/',		 
				type:'POST',				 
				success:function(data){ 
				  	 $("#notifikasi_nya").html(data)
				 }
			});		
		    }, 1000);  
		}); 
		function info_server(){
					$("#info_komputer").dialog({
					 resizable: false,
					 modal: true,
					 title:"CPU...",
					 draggable: true,
					 width: 'auto',					 
					 height: 'auto',
					 buttons: {					 
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  });
 
			}
 	</script>
  </head>
  <body>
<input type="hidden" name="base_url_app" id="base_url_app" value="<?php echo base_url();?>">
<div id="infodlg" style="display:none"></div> 
<nav class="navbar navbar-default" style="margin: 0px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url();?>">
      <img alt="Brand" style="margin-right:0px;height:35px;width:30px;    margin-top: -5px;"
       src="<?php echo base_url();?>images/logoutama.png"></a> 
       <a class="navbar-brand" href="<?php echo base_url();?>"> Ditjen Bina Bangda</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
   <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
   <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="<?php echo base_url();?>notifikasi" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="glyphicon glyphicon-volume-up"></i> &nbsp;  NOTIFIKASI  
          
          	<span id="notifikasi_nya" class="label label-danger">0</span> 
          
          </a>            
        </li>
      </ul>
     <?php $this->load->view('menu');?>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="glyphicon glyphicon-user"></i> &nbsp;  <?php echo strtoupper($this->session->userdata('NAMA'));?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
	            <?php if($this->session->userdata('PUSAT')=="1") { ?>
	            <!--<li>
	            	<a href="<?php echo base_url();?>step/"> <i class="glyphicon glyphicon-book"></i> &nbsp; Panduan  </a>
	            </li>-->
	            <?php } ?>
	            <!--<li><a href="<?php echo base_url();?>download_dokumen/sop.docx"> <i class="glyphicon glyphicon-cog"></i> &nbsp Download SOP</a></li>
	            <li><a href="<?php echo base_url();?>client/orr_client.exe"> <i class="glyphicon glyphicon-download"></i> &nbsp Download Aplikasi Client (EXE)</a></li>
	           	-->
	            <li><a href="<?php echo base_url();?>home/change_pass/<?php echo $this->session->userdata('ID_USER');?>">
	            <i class="glyphicon glyphicon-lock"></i> &nbsp; Ganti Username & Password</a></li>
	             <li><a href="<?php echo base_url();?>quick/User Manual Optimasi Renja.html"  >
	            <i class="glyphicon glyphicon-question-sign"></i> &nbsp; User Manual </a></li>

	            <li><a href="#" onclick="info_server()">
	            <i class="glyphicon glyphicon-th"></i> &nbsp; Info ? About Aplikasi</a></li>

	            <li role="separator" class="divider"></li>
	            <li><a href="<?php echo base_url();?>home/logout"> <i class="glyphicon glyphicon-log-out"></i> &nbsp  Log Out</a></li>
            </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse --><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<?php $this->load->view('content');?>
<div class="container">
<span style="font-size:10px;text-align:right;" class="pull-right">
				Ditjen  Bina Pembangunan Daerah<br>
				Kementerian Dalam Negeri Jalan Taman Makam Pahlawan No 20 Kalibata , Jakarta Sleatan 12750  , Telp 021-794653 ,www.bangda.kemendagri.go.id<br>
				<span style='color:#fff'> Developed by : AGNI PRAMESWARA ,  </span> ISO . 9001 : 2008 - CERTIFICATE NO 2013/1202 
				
</span>		
</div>
<div id="info_komputer" style="display:none">
	     <div class="head bg-dot20">
                        
                      <b>Aplikasi</b> Ini merupakan implementasi dan Optimasi dari Aplikasi Renstra dan Renja <br> Kementrian Dalam Negeri Ditjen Bina Pembangunan Daerah<br> yang digunakan untuk mempermudah kinerja pegawai   <br>dalam melaksanakan distribusi data dalam kertas kerja RENSTRA dan RENJA.<hr>

                         <div class="head-panel nm">
                           <div class="hp-info hp-simple pull-left hp-inline">
                              <span class="hp-main">   <?php echo $this->session->userdata('NAMA');?></span>
                                
                            </div>
                            <br>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">   <?php echo php_uname();?></span>
                                
                            </div>
                            <br>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">   <?php echo PHP_OS ?></span>
                               
                            </div>
                        </div>
                    <br>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main"><span class="icon-circle"></span> <?php echo 'Current PHP version: ' . phpversion() ?></span>                                
                            </div>                 
                            <br>
                            <div class="hp-info hp-simple pull-left hp-inline">                                
                                <span class="hp-main"><span class="icon-circle text-info"></span> <?php printf("MySQL server version: %s\n", mysql_get_server_info());        ?></span>
                            </div> 
                            <br> 
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main"><span class="icon-circle"></span> IP Address : 
                                <?php  /*
                                $host= gethostname();
								$ip = gethostbyname($host);  */ 
 								echo "<b>http://202.47.88.197/portal/orr</b>";    ?></span>                                
                            </div>  
                            <br>   
                             <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main"><span class="icon-circle"></span> 
                                 <br>Kontak : Bagian Perencanaan <br>Ditjen Bina Pembangunan Daerah <br>Kementerian Dalam Negeri</span>                                
                            </div>                           
                        </div>                
                    </div>
                </div>
	
</div>
    <script>
	 function load_direktorat(kode,divnya){ 
         $('#'+divnya).mask("Loading...");
         $.ajax({
            url:'<?php echo base_url();?>dashboard/per_direktorat/',      
            type:'POST',
            data:'kode='+kode +"&divnya="+divnya,
            success:function(data){ 
                 $( "#"+divnya ).html(data);
                  $('html, body').animate({
					        scrollTop: $("#"+divnya).offset().top
					    }, 1000);

             }
        });     
         	return false;
    }   
</script>

</body>

</html>
