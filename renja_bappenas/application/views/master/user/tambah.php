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
<style>
        table{
            border-spacing: 0;
        }
        td{
            padding: 0px;
        }
        input{
            padding: 2px;
            border: 1px solid #ccc;
        }
        input:hover{
            border: 1px solid #000;
        }
        input:focus{
            border: 1px solid #f00;
        }

</style>
    <script type="text/javascript">

    var cid = 0;
    var lcidx = 0;
    var dg='';
    var lcotori='';
    
 $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 220,
            width: 400,
            modal: true,
            autoOpen:false
        });
        get_skpd();
  });          




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
                                        sta    = data.statu;
                                        validate_prog();
                                        validate_jns();
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
            url        : '<?php echo base_url(); ?>index.php/master/punit',  
            columns    : [[  
                {field:'kdunit',title:'Kode',width:50},  
                {field:'nmunit',title:'Nama Unit',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                program = rowData.kdunit;
                $("#nmprog").attr("value",rowData.nmunit.toUpperCase());
            }
            }); 
            });
		}
 function validate_jns(){
	  	    $(function(){
            $('#jns').combogrid({  
            panelWidth : 700,  
            idField    : 'kd',  
            textField  : 'kd',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/jns_user/',  
            columns    : [[  
                {field:'kd',title:'Kode',width:50},  
                {field:'jns',title:'Jenis',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                user = rowData.kd;
                $("#nmjns").attr("value",rowData.jns.toUpperCase());
            }
            }); 
            });
		}
 function kosong(){
        $("#id_user").attr("value",'');
        $("#user_name").attr("value",'');
        $("#password").attr("value",'');
        $("#typeq").attr("value",'');
        $("#nama").attr("value",'');
        $("#dg").combogrid("setvalue",'');
        $("#dg").combogrid("clear");
    };
    
    
 function simpan(){
        var cid_us = document.getElementById('id_user').value;
        var cuser = document.getElementById('user_name').value;
        var cpass = document.getElementById('password').value;
        var cnama = document.getElementById('nama').value;
        var cskpd = document.getElementById('sskpd').value;
        var cprog = $("#kdprog").combogrid("getValue");
        var cjns = $("#jns").combogrid("getValue"); 
        
        if (cid_us==''){
            alert('Id User Tidak Boleh Kosong');
            exit();
        } 
        if (cuser==''){
            alert('User Name Tidak Boleh Kosong');
            exit();
        }
        if (cpass==''){
            alert('Password Tidak Boleh Kosong');
            exit();
        }
        if (cnama==''){
            alert('Nama Tidak Boleh Kosong');
            exit();
        }
        if (cprog==''){
            alert('Esselon 1 Tidak Boleh Kosong');
            exit();
        }
        if (cskpd==''){
            alert('Kode SKPD Tidak Boleh Kosong');
            exit();
        }
          //  lcinsert = "(id_user,user_name,password,type,nama,kd_skpd)";
          //  lcvalues = "('"+cid_us+"','"+cuser+"','"+cpass+"','"+ctype+"','"+cnama+"','"+cskpd+"')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_user',
                   // data: ({tabel:'user',kolom:lcinsert,nilai:lcvalues,cid:'id_user',lcid:cid_us}),
                    data:({cidus:cid_us,cus:cuser,cpa:cpass,cnm:cnama,csikd:cskpd,cprg:cprog,cjs:cjns}),
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
                            kosong();      
                            exit();
                        }
                    }
                });
            });    
     };
</script>
</head>
<body>
<div id="content">        
   <fieldset>
     <table align="center" style="width:100%;">
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>      
           <tr>
                <td width="20%"><span style="font-weight:bold">ID USER</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="id_user" name="id_user" maxlength="3" style="width:40px; height:15px "/></td>  
            </tr>            
            <tr>
                <td width="20%"><span style="font-weight:bold">USER NAME</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="user_name" name="user_name" style="width:260px; height:15px"/></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">PASSWORD</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="password" name="password" style="width: 140px; height:15px" /></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">NAMA</span></td>
                <td width="1%">:</td>
                <td><input type="text" id="nama" name="nama" style="width:260px; height:15px"/></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">Kementrian/Lembaga</span></td>
                <td width="1%">:</td>
                <td><input id="sskpd" name="sskpd" style="width:60px;height:15px; "/><input id="nmskpd" name="nmskpd" readonly="true" style="width: 320px; border:0;  " /></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">Jenis</span></td>
                <td width="1%">:</td>
                <td><input id="jns" name="jns" style="width:50px; height:15px"/><input id="nmjns" name="nmjns" readonly="true" style="width:80px;border:0;background-color:transparent;color: black;" disabled="true"/></td>  
            </tr>
            <tr>
                <td width="20%"><span style="font-weight:bold">Esselon 1</span></td>
                <td width="1%">:</td>
                <td><input id="kdprog" name="kdprog" style="width:100px; height:15px"/><input id="nmprog" name="nmprog" readonly="true" style="width:680px;border:0;background-color:transparent;color: black;" disabled="true"/></td>  
            </tr>
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>       
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan();">Simpan</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" href="<?php echo site_url(); ?>/master/user">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>
        
</body>

</html>