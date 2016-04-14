   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
 	<script type="text/javascript">
	$(document).ready(function() { 
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		   $.ajax({
			  type: "POST",
			  data: "",
			  url: url,
			  beforeSend: function() {
				$(".panel").mask("Loading...");
			  },
			  success: function(msg) {
			  	 
					$("#tabledata").html(msg);
				$(".panel").unmask();
 			  }
			});
			 return false;
			});
		}
	  }); 
	});
  
 </script>
 
 <table class="table table-striped table-hover">
    <thead>
        <tr>
           <th>Nama Menu  </th>
           <th>Url  </th>
		   <th>Urutan  </th>
		   <th>Parent  </th>
           <th>Edit </th>
        </tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
           
            <td>
			<?php echo $row->name ?>
			</td>
            <td>
			<?php echo base_url().$row->url ?>
			</td>
             <td>
			<?php echo  $row->urut ?>
			</td>
			 <td>
			<?php echo  $row->parent ?>
			</td>
            <td>
    
 <a href="<?php echo base_url();?>menus/add/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
        	<i class="glyphicon glyphicon-edit"></i>
        	Edit</a>							
        	<a href="#" onclick="return deletemenu(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
        	<i class="glyphicon glyphicon-trash"></i>
        	Hapus</a> 

            </td>
        </tr>
		 
		<?php }} ?>
    </tbody>
</table> 
                   <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		
  