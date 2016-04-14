<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>   
   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
  
  <script type="text/javascript">
    var program='';
	var kdskpd='';
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
                kdskpd=data.kd_skpd;
                get_unit(); 
                  }
    
        });
        
	});
	 
	function get_unit()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/master/config_unit',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#kdunit").attr("value",data.kdunit);
        								$("#nmunit").attr("value",data.nmunit.toUpperCase());
        								unit = data.kdunit;
                                        validate_prog();
                                        
                                        
        							  }                                     
        	});
        }
 
	
    function validate_prog(){
	  	    $(function(){
            $('#kdprog').combogrid({  
            panelWidth : 700,  
            idField    : 'kdprogram',  
            textField  : 'kdprogram',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/pprog/'+kdskpd+'/'+unit,  
            columns    : [[  
                {field:'kdprogram',title:'Kode Program',width:70},  
                {field:'nmprogram',title:'Nama Program',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                program = rowData.kdprogram;
                $("#nmprog").attr("value",rowData.nmprogram);
                validate_giat();
            }
            }); 
            });
		}
     function validate_giat(){
        //alert('<?php echo base_url(); ?>index.php/master/ambil_giat/'+kdskpd+'/'+program);
	  	    $(function(){
            $('#kdgiat').combogrid({  
            panelWidth : 700,  
            idField    : 'kdgiat',  
            textField  : 'kdgiat',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/ambil_giat/'+program,  
            columns    : [[  
                {field:'kdgiat',title:'Kode Giat',width:70},  
                {field:'nmgiat',title:'Nama Giat',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdgiat = rowData.kdgiat;
                $("#nmgiat").attr("value",rowData.nmgiat.toUpperCase());
                
            }
            }); 
            });
		}
    
    function transfer_kl(){
	var kode=document.getElementById('kode_skpd').value;
	var nama=document.getElementById('nm_skpd').value;
 	
	  
	
	$.get('<?php echo base_url('index.php/utility/backup_data_renja_kl')?>',{kdskpd:kode,nmskpd:nama},
	function(data){
		alert("Data Berhasil di Transfer di C:\\backup\\Renja");
	}
	); 

	
	}    
    
    function transfer(){
	var kode=document.getElementById('kode_skpd').value;
	var nama=document.getElementById('nm_skpd').value;
    var unit=document.getElementById('kdunit').value;
	var nmunit=document.getElementById('nmunit').value;
	//alert('kdskpd:'+kode+'/'+'nmskpd:'+nama+'/'+'kdunit:'+unit+'/'+'nmunit:'+nmunit)
 	
	  
	
	$.get('<?php echo base_url('index.php/utility/backup_data_renja')?>',{kdskpd:kode,nmskpd:nama,kdunit:unit,nmunit:nmunit},
	function(data){
		alert("Data Berhasil di Transfer di C:\\backup\\Renja");
	}
	); 

	
	}
    
    function transfer_prog(){
	var kode=document.getElementById('kode_skpd').value;
	var nama=document.getElementById('nm_skpd').value;
    var unit=document.getElementById('kdunit').value;
	var nmunit=document.getElementById('nmunit').value;
    var prog=$('#kdprog').combogrid('getValue');
	
 	if (prog==''){
	alert ("Pilih  Kegiatan terlebih dahulu!");
	return;
	} 
	
	$.get('<?php echo base_url('index.php/utility/backup_data_renja_prog')?>',{kdskpd:kode,nmskpd:nama,kdunit:unit,nmunit:nmunit,kdprog:prog},
	function(data){
		alert("Data Berhasil di Transfer di C:\\backup\\Renja");
	}
	); 

	
	}
    
    function transfer_giat(){
	var kode=document.getElementById('kode_skpd').value;
	var nama=document.getElementById('nm_skpd').value;
    var unit=document.getElementById('kdunit').value;
	var nmunit=document.getElementById('nmunit').value;
    var prog=$('#kdprog').combogrid('getValue');
    var giat=$('#kdgiat').combogrid('getValue');
	
    if (prog==''){
	alert ("Pilih  Program terlebih dahulu!");
	return;
	}
    
    if (giat==''){
	alert ("Pilih  Kegiatan terlebih dahulu!");
	return;
	}  
	
    //alert(giat);
	$.get('<?php echo base_url('index.php/utility/backup_data_renja_giat')?>',{kdskpd:kode,nmskpd:nama,kdunit:unit,nmunit:nmunit,kdprog:prog,kdgiat:giat},
	function(data){
		alert("Data Berhasil di Transfer di C:\\backup\\Renja");
	}
	); 

	
	}
    
    function transfer_ref(){
	var kode=document.getElementById('kode_skpd').value;
	var nama=document.getElementById('nm_skpd').value;
    
	$.get('<?php echo base_url('index.php/utility/backup_data_renja_ref')?>',{kdskpd:kode,nmskpd:nama},
	function(data){
		alert("Data Berhasil di Transfer di C:\\backup\\Renja");
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
	   <td width="71%"><input type="text" id="kode_skpd" readonly="true" style="width:50px;" />-<input type="text" id="nm_skpd" readonly="true" style="width:620px;"/></td> 
	   
        </tr> 
        <tr>
       <td width="9%">Unit</a></td>
	   <td width="71%"><input type="text" id="kdunit" readonly="true" style="width:50px;" />-<input type="text" id="nmunit" readonly="true" style="width:620px;"/></td> 
	   
        </tr>
        
        <tr>
       <td width="9%">Program</a></td>
	   <td width="71%"><input type="text" id="kdprog" readonly="true" style="width:50px;" />-<input type="text" id="nmprog" readonly="true" style="width:620px;"/></td> 
	   
        </tr> 
        <tr>
       <td width="9%">Kegiatan</a></td>
	   <td width="71%"><input type="text" id="kdgiat" readonly="true" style="width:50px;" />-<input type="text" id="nmgiat" readonly="true" style="width:620px;"/></td> 
	   
        </tr>  
        <tr>
        
	   <td width="20%" colspan="2" align="center">
       <a class="easyui-linkbutton" name="tambah" iconCls="icon-save" plain="true" onclick="javascript:transfer_ref()">&nbsp;BACKUP REF</a>
       <a class="easyui-linkbutton" name="tambah" iconCls="icon-save" plain="true" onclick="javascript:transfer_kl()">&nbsp;BACKUP DATA K/L</a>
        <a class="easyui-linkbutton" name="tambah" iconCls="icon-save" plain="true" onclick="javascript:transfer()">&nbsp;BACKUP DATA UNIT</a>
        <a class="easyui-linkbutton" name="tambah" iconCls="icon-save" plain="true" onclick="javascript:transfer_prog()">&nbsp;BACKUP DATA PROGRAM</a>
        <a class="easyui-linkbutton" name="tambah" iconCls="icon-save" plain="true" onclick="javascript:transfer_giat()">&nbsp;BACKUP DATA KEGIATAN</a></td>      
        
        </tr> 
 
    </table>  
    </p> 
    </div>   
</div>



</body>

</html>

<!-- doni end -->