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
            height: 430,
            width: 650,
            modal: true,
            autoOpen:false
        });
        get_skpd();
        });    
     
     $(function(){  
        
     $('#kode_p').combogrid({  
       panelWidth:500,  
       idField:'kd_program',  
       textField:'kd_program',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_program',  
       columns:[[  
           {field:'kd_program',title:'Kode Program',width:100},  
           {field:'nm_program',title:'Nama Program',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
           kd_prog = rowData.kd_program;
           $("#nm_u").attr("value",rowData.nm_program.toUpperCase());
          // muncul();  
           
                          
       }  
     });     
        
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_kegiatan_baru',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {field:'kd_kegiatan',
    		title:'Kode Kegiatan',
    		width:10,
            align:"center"},
    	    {field:'kd_program',
    		title:'Kode program',
    		width:10,
            align:"center"},
            {field:'nm_kegiatan',
    		title:'Nama Kegiatan',
    		width:50},
            {field:'pelaksana',
    		title:'Pelaksana',
    		width:10},
            {field:'kl',
    		title:'K/L-N-B',
    		width:10},
            {field:'ket',
    		title:'Status',
    		width:10}
        ]],
        onSelect:function(rowIndex,rowData){
          kd_k = rowData.kd_kegiatan;
          kd_p = rowData.kd_program;
          nm_k = rowData.nm_kegiatan;
          pl   = rowData.pelaksana;
          kl   = rowData.kl;
          st = rowData.status;
          get(kd_k,kd_p,nm_k,pl,kl,st); 
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
           lcidx = rowIndex;
           judul = 'Edit Data Urusan'; 
           edit_data();   
        }
        
        });
       
    }); 
    
   // $(function(){
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
    
    function get(kd_k,kd_p,nm_k,pl,kl,st) {
        
        $("#kode").attr("value",kd_k);
        $("#kode_p").combogrid("setValue",kd_p);
        $("#nama").attr("value",nm_k);
        $("#pelaksana").attr("value",pl);
        $("#kl").attr("value",kl);     
       // $("#ket").combogrid("setValue",st);                
    }
       
    function kosong(){
        $("#kode").attr("value",'');
        $("#kode_p").combogrid("setValue",'');
        $("#nama").attr("value",'');
        $("#pelaksana").attr("value",'');
        $("#kl").attr("value",'');
        $("#ket").combogrid("setValue",'4');
    }
    
    function muncul(){
        var c_prog=kd_prog+'.';
        var c_keg=kd_k
        if(lcstatus=='tambah'){ 
            $("#kode").attr("value",c_prog);
        } else {
        $("#kode").attr("value",c_keg);
        }     
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_kegiatan_baru',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_skpd(){
        var cdept = document.getElementById('sskpd').value;
        var cunit = document.getElementById('kdunit').value;
        var ckode = document.getElementById('kode').value;
        var ckode_p= $('#kode_p').combogrid('getValue');
        var cnama = document.getElementById('nama').value;
        var cplk = document.getElementById('pelaksana').value;
        var ckl = document.getElementById('kl').value;
        var cket = '4';
                
        if (ckode==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (ckode_p==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (cnama==''){
            alert('Nama Golongan Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kddept,kdgiat,kdprogram,kdunit,nmgiat,pelaksana,kl,status)";
            lcvalues = "('"+cdept+"','"+ckode+"','"+ckode_p+"','"+cunit+"','"+cnama+"','"+cplk+"','"+ckl+"','"+cket+"')";
            //alert(lcinsert+'/'+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master',
                    data: ({tabel:'t_giat',kolom:lcinsert,nilai:lcvalues,cid:'kdgiat',lcid:ckode}),
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
            
            lcquery = "UPDATE t_giat SET nmgiat='"+cnama+"',kdprogram='"+ckode_p+"',pelaksana='"+cplk+"',kl='"+ckl+"',status='"+cket+"' where kddept='"+cdept+"' and kdgiat='"+ckode+"'";

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
        judul = 'Edit Data Kegiatan';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=true;
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Kegiatan';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kode").disabled=false;
        document.getElementById("kode").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
        lcstatus = 'edit';
     }    
    
     function hapus(){
        var ckode = document.getElementById('kode').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
        $(document).ready(function(){
         $.post(urll,({tabel:'t_giat',cnid:ckode,cid:'kdgiat'}),function(data){
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
    
       
    
  
    
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INPUTAN MASTER KEGIATAN</a></b></u></h3>
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
        <table id="dg" title="LISTING DATA KEGIATAN" style="width:1180px;height:440px;" >  
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
                <td><input id="kdunit" name="kdunut" readonly="true" style="width:55px;border: 0;" />
                <input id="nmunit" name="nmunit" readonly="true" style="width: 300px; border:0;  " /></td>  
            </tr> 
            <tr>
                <td width="30%">KODE PROGRAM</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode_p" style="width:130px;"/></td>  
            </tr>
            <tr>
                <td width="30%">NAMA PROGRAM</td>
                <td width="1%">:</td>
                <td><input type="text" id="nm_u" style="width:350px;"/></td>  
            </tr> 
           <tr>
                <td width="30%">KODE KEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode" style="width:130px;"/></td>  
            </tr>
                       
            <tr>
                <td width="30%">NAMA KEGIATAN</td>
                <td width="1%">:</td>
                <td><textarea name="nama" id="nama" cols="50" rows="1" ></textarea></td>  
            </tr>
            
            <!--<tr>
                <td width="30%">STATUS</td>
                <td width="1%">:</td>
                <td><input type="ket" id="ket" style="width:30px;"/> <input id="nmket" name="nmket" style="width:100px;"  /></td>  
            </tr>-->
            
            <tr>
                <td width="30%">PELAKSANAN</td>
                <td width="1%">:</td>
               <td><input type="text" id="pelaksana" style="width:300px;"/></td>  
            </tr>
            
            <tr>
                <td width="30%">K/L-N-B-NS-BS</td>
                <td width="1%">:</td>
                <td><input type="text" id="kl" style="width:30px;"/></td>  
            </tr>
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_skpd();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>