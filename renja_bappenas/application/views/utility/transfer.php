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
    
     var kode = '';
    var giat = '';
    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = ''; 
                    
      $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 350,
            width: 600,
            modal: true,
            autoOpen:false
        });
        });    
     
     $(function(){   
        
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/utility/load_transfer',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",  
		singleSelect:false,
        columns:[[
		    {field:'ck',
			checkbox:true,
    		title:'ck',
            align:"center"},
            {field:'no_spm',
    		title:'No. SPM',
    		width:20,
            align:"left"},
    	    {field:'no_spp',
    		title:'No. SPP',
    		width:20,
            align:"left"},
            {field:'kd_skpd',
    		title:'Kode SKPD',
    		width:20,
			align:"left"},
            {field:'nm_skpd',
    		title:'Nama SKPD',
    		width:30,
			align:"left"}
        ]],
        onSelect:function(rowIndex,rowData){
          no_spm = rowData.no_spm;
          no_spp = rowData.no_spp;
          kd_s = rowData.kd_skpd;
          nm_s = rowData.nm_skpd;
          get(no_spm,no_spp,kd_s,nm_s); 
          lcidx = rowIndex;  
                                       
        }

        });
       
    });         

       function get(no_spm,no_spp,kd_s,nm_s) {
        
        $("#kode").attr("value",no_spm);
        $("#kode_u").combogrid("setValue",no_spp);
        $("#nama").attr("value",kd_s);
        $("#npwp").attr("value",nm_s);                  
    }  
       
   
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/utility/load_transfer',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
     
	
    function transfer(){
	
	var rows=$('#dg').datagrid('getSelections');

	 if(rows.length==0){
		alert ('Silahkan Pilih Data Terlebih Dahulu!');
     return;
	}  
	
  	 nospm=[];
	nospp=[];
 	for (var i=0;i<rows.length;i++){
		nospm.push(rows[i].no_spm);
		nospp.push(rows[i].no_spp);
	}  
	
	string_no_spm =  nospm.join('|');
	string_no_spp =  nospp.join('|'); 
	/* console.log(string_no_spm);
	return;  */
	//console.log(string_no_spm);
	
			
 	 $.get('<?php echo base_url('index.php/utility/backup_data')?>',{str_no_spm:string_no_spm,str_no_spp:string_no_spp},
	function(data){
		alert('Data Berhasil di Transfer Folder C:backup/spm');
	}); 
	
	} 
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>TRANSFER DATA SPP / SPM</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
       <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
	   <td><input type="text" value="" id="txtcari" style="width:300px;"/></td> 

	   <td width="20%">
        <a class="easyui-linkbutton" name="tambah" iconCls="icon-add" plain="true" onclick="javascript:transfer()"><b />&nbsp;MULAI TRANSFER DATA</a></td>      
        
        </tr> 
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA SPM" style="width:900px;height:440px;" >  
        </table>
        </td>
        </tr>
    </table>  
    </p> 
    </div>   
</div>



</body>

</html>

<!-- doni end -->