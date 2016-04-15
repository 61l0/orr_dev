<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- doni star -->
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
  
  <script type="text/javascript">
/*      $(function(){ 
	$('#kode_skpd').combogrid({  
       panelWidth:500,  
       idField:'kd_skpd',  
       textField:'kd_skpd',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_skpd',  
       columns:[[  
           {field:'kd_skpd',title:'Kode SKPD',width:100},  
           {field:'nm_skpd',title:'Nama SKPD',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
            kd_skpd = rowData.kd_skpd;
            $("#nm_skpd").attr("value",rowData.nm_skpd.toUpperCase());
                      
       }  
     });  
	});  */
	
	 $(document).ready(function(){
	
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php/master/config_skpd',
               // data: ({aa:a}),
                dataType:"json",
                success: function (data) {
				//$("#kode_skpd").combogrid("setValue",data.kd_skpd);
				$("#kode_skpd").attr("value",data.kd_skpd);  
				$("#nm_skpd").attr("value",data.nm_skpd);  
                  }
        });
	});
	 
	 
    function transfer(){
	//var kode=$('#kode_skpd').combogrid('getValue');
	var kode=document.getElementById('kode_skpd').value;
	var nama=document.getElementById('nm_skpd').value;
	
 	 if (kode==''){
	alert ("Pilih Kode SKPD terlebih dahulu!");
	return;
	}  
	
	$.get('<?php echo base_url('index.php/utility/backup_data_anggaran')?>',{kdskpd:kode,nmskpd:nama},
	function(data){
		alert("Data Berhasil di Transfer di C:\\backup\\anggaran");
	}
	); 

	
	}
  
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>BACKUP DATA RENJA</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:100%;" border="0">
        <tr>
       <td width="9%">Kementerian/Lembaga</a></td>
	   <td width="71%"><input type="text" id="kode_skpd" readonly="true" style="width:100px;" />-<input type="text" id="nm_skpd" readonly="true" style="width:520px;"/></td> 
	   <td width="20%">
        <a class="easyui-linkbutton" name="tambah" iconCls="icon-add" plain="true" onclick="javascript:transfer()"><b />&nbsp;MULAI TRANSFER DATA</a></td>      
        
        </tr> 
 
    </table>  
    </p> 
    </div>   
</div>



</body>

</html>

<!-- doni end -->