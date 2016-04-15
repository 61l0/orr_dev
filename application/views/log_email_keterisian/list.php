	<script type="text/javascript">
	$(document).ready(function() { 
	refreshtable();
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		    var email =$("#email").val();
		   $.ajax({
			  type: "POST",
			  data: "email="+email,
			  url: url,
			  beforeSend: function() {
				$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
 
			  }
			});
			 return false;
			});
		}
	  }); 
	});
	function refreshtable(){
			 
			 var email =$("#email").val();
			   $.ajax({
			  type: "POST",
			  data: "email="+email,
			  url: "<?php echo base_url()?>log_email_keterisian/search",
			  beforeSend: function() {
				$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
	 
			  }
			});
			 return false;
	}
	 
	</script>
 
<br>

	<div class="panel panel-primary"> 
 
   <div class="panel-heading">Data Log Kiriman Keterisian

   </div>
  <div class="well" style="margin:0px">
  <input type="text" class="form-control input-sm" onchange="return refreshtable()" 
            id="email" name="email" placeholder="Nama Email" style="width:300px">
	 <div id="tabledata">
	 </div>
 </div>
 </div>
