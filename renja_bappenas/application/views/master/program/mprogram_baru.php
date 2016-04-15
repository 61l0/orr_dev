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
        get_skpd();
        });    
     
     $(function(){        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_program_baru',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
    	    {field:'kd_program',
    		title:'Kode Program',
    		width:10,
            align:"center"},
            {field:'nm_program',
    		title:'Nama Program',
    		width:70},
            {field:'pelaksana',
    		title:'Pelaksana',
    		width:10},
            {field:'ket',
    		title:'Status',
    		width:10}
        ]],
        onSelect:function(rowIndex,rowData){
          kd = rowData.kd_program;
          nm = rowData.nm_program;
          pl = rowData.pelaksana;
          st = rowData.status;
          lcidx = rowIndex; 
          get(kd,nm,pl,st);  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Fungsi'; 
           edit_data();   
        }
        
        });
       
    });        
    
    //$(function(){
//            $('#ket').combogrid({  
//            panelWidth : 200,  
//            idField    : 'kd',  
//            textField  : 'kd',  
//            mode       : 'remote',
//            url        : '<?php echo base_url(); ?>index.php/master/ket2',  
//            columns    : [[  
//                  
//                {field:'ket',title:'Ket',width:680}    
//            ]],
//            onSelect:function(rowIndex,rowData){
//                ket = rowData.kd;
//                $("#nmket").attr("value",rowData.ket.toUpperCase());
//                
//            }
//            }); 
//            });
    
    function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/master/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd.toUpperCase());
        								kdskpd = data.kd_skpd;
                                        get_unit();
        							  }                                     
        	});
        }
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
                                        
                                        
        							  }                                     
        	});
        }
    function get(kd,nm,pl,st) {
        
        $("#kode").attr("value",kd);
        $("#nama").attr("value",nm); 
        //$("#pelaksana").attr("value",pl);    
        //$("#ket").combogrid("setValue",st);               
    }
       
    function kosong(){
        $("#kode").attr("value",'');
        $("#nama").attr("value",'');
        //$("#pelaksana").attr("value",'');
        //$("#ket").combogrid("setValue",'4');
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_program_baru',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_program(){
        var cdept = document.getElementById('sskpd').value;
        var cunit = document.getElementById('kdunit').value;
        var ckode = document.getElementById('kode').value;
        var cnama = document.getElementById('nama').value;
        var cplk = '';
        var cket = '4';
                
        if (ckode==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (cnama==''){
            alert('Nama  Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kddept,kdunit,kdprogram,nmprogram,pelaksana,status)";
            lcvalues = "('"+cdept+"','"+cunit+"','"+ckode+"','"+cnama+"','"+cplk+"','"+cket+"')";
            //alert(lcinsert+"/"+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master_prog',
                    data: ({tabel:'t_program',kolom:lcinsert,nilai:lcvalues,cid:'kdprogram',lcid:ckode}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE t_program SET nmprogram='"+cnama+"',pelaksana='"+cplk+"',status='"+cket+"' where kddept='"+cdept+"' and kdunit='"+cunit+"' and kdprogram='"+ckode+"'";

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data Program';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Program';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=false;
        document.getElementById("kode").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
     }    
    
     function hapus(){
        var ckode = document.getElementById('kode').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
        $(document).ready(function(){
         $.post(urll,({tabel:'t_program',cnid:ckode,cid:'kdprogram'}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                $('#dg').datagrid('deleteRow',lcidx);   
                alert('Data Berhasil Dihapus..!!');
                exit();
            }
         });
        });    
    } 
    
       
    function addCommas(nStr)
    {
    	nStr += '';
    	x = nStr.split(',');
        x1 = x[0];
    	x2 = x.length > 1 ? ',' + x[1] : '';
    	var rgx = /(\d+)(\d{3})/;
    	while (rgx.test(x1)) {
    		x1 = x1.replace(rgx, '$1' + '.' + '$2');
    	}
    	return x1 + x2;
    }
    
     function delCommas(nStr)
    {
    	nStr += ' ';
    	x2 = nStr.length;
        var x=nStr;
        var i=0;
    	while (i<x2) {
    		x = x.replace(',','');
            i++;
    	}
    	return x;
    }
  
    
  
   </script>

</head>
<body>

<div id="content"> 

<h3 align="center"><u><b><a>INPUTAN MASTER PROGRAM</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="10%">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td>               
        
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
        </tr>
        <tr>
        <td colspan="4">
        <table id="dg" title="LISTING DATA PROGRAM" style="width:1180px;height:440px;" >  
        </table>
        </td>
        </tr>
    </table>    
    
        
 
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
           <tr>
                <td width="30%">KEMENTRIAN/LEMBAGA</td>
                <td width="1%">:</td>
                <td><input id="sskpd" name="sskpd" readonly="true" style="width:55px;border: 0;" />
    <input id="nmskpd" name="nmskpd" readonly="true" style="width: 300px; border:0;  " /></td>  
            </tr> 
             <tr>
                <td width="30%">Unit</td>
                <td width="1%">:</td>
                <td><input id="kdunit" name="kdunit" readonly="true" style="width:55px;border: 0;" />
    <input id="nmunit" name="nmunit" readonly="true" style="width: 300px; border:0;  " /></td>  
            </tr> 
           <tr>
                <td width="30%">KODE PROGRAM</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode" style="width:100px;"/></td>  
            </tr>            
            <tr>
                <td width="30%">NAMA PROGRAM</td>
                <td width="1%">:</td>
                <td><input type="text" id="nama" style="width:360px;"/></td>  
            </tr>
            <!--<tr>
                <td width="30%">STATUS</td>
                <td width="1%">:</td>
                <td><input type="ket" id="ket" style="width:30px;"/> <input id="nmket" name="nmket" style="width:100px;"  /></td>  
            </tr>
            
            <tr>
                <td width="30%">PELAKSANA</td>
                <td width="1%">:</td>
                <td><input type="text" id="pelaksana" style="width:360px;"/></td>  
            </tr>-->
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_program();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>