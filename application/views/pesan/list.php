 <script>
 $(document).ready(function () {
    	setInterval(function() {
    	 
    		var tujuan ;
    		tujuan=$("#tujuan").val();
    		
		        $.ajax({
					url:'<?php echo base_url();?>pesan/search/',		 
					type:'POST',		
					data:$('#form_text').serialize(),		 
					success:function(data){ 
						 if(tujuan =="") {    	 
					 	 	$("#tabledata").html(data);
					 	 }
					 }
				});		
			    }, 2000);
 		});

 	function select_person(id){
 		 $.ajax({
			  type: "POST",
			  data: "tujuan="+id,
			  url: "<?php echo base_url()?>pesan/search",			 
			  success: function(msg) {
				$("#tabledata").html(msg);
				$('#tabledata').animate({scrollTop: $('#tabledata').get(0).scrollHeight}, 1000);
			  }
			});
		return false;
 	}
 	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>pesan/simpan/',		 
			type:'POST',
			data:$('#form_text').serialize(),
			success:function(data){ 
			 	 select_person($("#tujuan").val());
			 	  $('#tabledata').animate({scrollTop: $('#tabledata').get(0).scrollHeight},1000);
			 	  $("#pesan").val('');
			 }
		});		
	}
 </script>
     <form id="form_text"  name="form_text"  method="POST">
 <div class="row">
        <div class="col-md-3"><div class="list-group">
		  <a href="#" class="list-group-item active">
		    <i class="glyphicon glyphicon-user"> </i> LIST USER YANG TERSEDIA
		  </a>
		  <?php  if(!empty($get_user)) { foreach($get_user as $row) { ?> 
		  	<a href="#" onclick="return select_person(<?php echo $row->id;?>)" class="list-group-item"><i  style="color:#A6E22C" class="glyphicon glyphicon-off"></i> &nbsp; <?php echo strtoupper($row->nama) ?></a>
		  <?php }}  ?>
		</div>
</div>
<div class="col-md-9"> 
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">Pesan</div>
  <div class="panel-body" id="tabledata" style="height:265px;overflow:scroll">
      
  </div>
    <div class="panel-footer">


    <textarea id="pesan" name="pesan" class="form-control" style="width:100%;float:none;margin-bottom:5px"></textarea>
    <a class="btn btn-primary btn-sm" onclick="return save()" style="width:100%;float:none" >Kirim</a>

    </div>
</div>
</div>
</div>
    </form>