<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
  <style>    
    #tagih {
        position: relative;
        width: 922px;
        height: 100px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 100,
                width: 922            
            });             
        });   
    

  
     
    function submit(){
        if (ctk==''){
            alert('Pilih Jenis Cetakan');
            exit();
        }
        document.getElementById("frm_ctk").submit();    
    }
        

        
    $(function(){
   	    //$("#status").attr("option",false);
        $("#tagih").hide();
   	});   
        
    function opt(val){        
        ctk = val; 
        if (ctk=='1'){
            $("#tagih").hide();
            
        } else if (ctk=='2'){
           $("#tagih").show();
           } else {
            exit();
        }                 
    }   
    function cek($ct){
           
               
                    cetak($ct);           
      
    }
    function cetak($ct)
        {
            var ct = $ct;
            var nm = document.getElementById('nama').value;
            var no = document.getElementById('nip').value;
            var jbt = document.getElementById('jabatan').value;
            var jabatan1 =jbt.split(" ").join("kk");
            var jabatan =jabatan1.split(",").join("qq");
            var nip =no.split(" ").join("123456789");
            var nama1 =nm.split(" ").join("123456789");
            var nama =nama1.split(",").join("jj");
            
		
			var url    = "<?php echo site_url(); ?>/rka/preview_umum";	  
			window.open(url+'/'+ct+'/'+nama+'/'+nip+'/'+jabatan, '_blank');
			window.focus();

//        $(document).ready(function(){
//                $.ajax({
//                    type: "POST",
//                    url: '<?php echo site_url(); ?>/master/cetak_giat_mdg1',
//                    data: ({lap:lap,ctk:ctk,ct:ct,skpd:skpd}),
//                    dataType:"json"
//                });
//            }); 
        }
     
     function runEffect() {
        var selectedEffect = 'blind';            
        var options = {};                      
        $( "#tagih" ).toggle( selectedEffect, options, 500 );
        };
        
      function pilih() {
       op = '1';       
      };   
        
    
    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
	</STYLE> 

</head>
<body>

<div id="content">



<h3>Cetak Formulir 1 Umum</h3>
<div id="accordion">
    
    <p align="right">         
        <table id="sp2d" title="Cetak" style="width:1225px;height:200px;" >          
        
		
        <tr >
			
            <td colspan="2">Pejabat Yang Berwenang:</td>
		</tr>
        <tr >
			
            <td colspan="2">Nama&nbsp;&nbsp;&nbsp;&nbsp;: <input id="nama" name="nama" style="width:250px;" /></td>
		</tr>
        <tr >
			
            <td colspan="2">Jabatan&nbsp;: <input id="jabatan" name="jabatan" style="width:250px;" /></td>
		</tr>
        <tr >
			
            <td colspan="2">NIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input id="nip" name="nip" style="width:250px;" /></td>
		</tr>
        
        <tr >
			
            <td colspan="2"><a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cek(1);">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-print_pdf" plain="true" onclick="javascript:cek(2);">Cetak PDF</a>
            <a class="easyui-linkbutton" iconCls="icon-excel" plain="true" onclick="javascript:cek(3);">Cetak excel</a>
            <a class="easyui-linkbutton" iconCls="icon-word" plain="true" onclick="javascript:cek(4);">Cetak word</a></td>
            
		</tr>
		
        </table>                      
    </p> 
    

</div>

</div>

 	
</body>

</html>