                   </ul>
	<?php 
 
			 
		 getMenu1();	 
 	?>
	
	<?php 
		function getChild1($parent=''){
 		$menu="";

 		$CI =& get_instance();
 		$role=$CI->session->userdata('ROLE');
		$menu_id=$CI->session->userdata('id_session_menu');
 		
 		$menu   = '<ul class="dropdown-menu">';
		$sql    = "select *  from t_otoritas a 
					left JOIN t_menu on t_menu.id=a.menu   where t_menu.parent='$parent' and a.role='$role'    order by urut asc";
         $q      = $CI->db->query($sql);
		foreach ($q->result() as $row) {
            $class_li='';
				if(($row->url=='' || $row->url=='#'|| $row->parent=="")){
					$row->url='#';
					$class_tree = 'treeview';
				}
			$style='';
			$style2='';
			if($row->icon==''){
				$icon="glyphicon glyphicon-align-justify";
			} else {
				$icon=$row->icon;
			}
			if(($row->url=='') || ($row->url=='#') ||($row->parent=="")) { $class_li.=$class_tree; $style='style="font-weight:bold"';}
			$cekChild1=cekChild1($row->id);
			if($cekChild1==TRUE) {  $class_li.=" dropdown "; }
 			 
 			$menu .="<li class='".$class_li."'><a  href='".base_url().$row->url."'><i class='".$icon."'></i> &nbsp; ".$row->name."</a>";
					if(cekChild1($row->id)){
						$menu.= getChild1($row->id);
	 				}
			$menu.="</li> ";			 
		 
		}	
		$menu.='</ul>';
		return $menu;
	}
	function cekChild1($parent=''){
		$CI =& get_instance();
		$q=$CI->db->query("select id from t_menu where parent='$parent'");
 		if($q->num_rows() > 0){
			return TRUE;
		}
	}
	function getMenu1(){  
		$CI =& get_instance();
		$menu='<ul class="nav navbar-nav">';
		$class_li="";
		$class_tree="";
		$role=$CI->session->userdata('ROLE');
		$menu_id=$CI->session->userdata('id_session_menu');
		$sql    = "select *  from t_otoritas a 
			left JOIN t_menu on t_menu.id=a.menu
			where a.role='$role' and   parent='' order by urut asc";
        $q      = $CI->db->query($sql);
		foreach ($q->result() as $row) {
            $class_li='';
				if(($row->url=='' || $row->url=='#'|| $row->parent=="")){
					$row->url='#';
					$class_tree = '';
				}
			$style='';
			$style2='';
			$caret="";
			if($row->icon==''){
				$icon="icon-book icon-white";
			} else {
				$icon=$row->icon;
			}	
			if(($row->url=='') || ($row->url=='#') ||($row->parent=="")) { $class_li.=$class_tree; $style='style="font-weight:bold"';}
		 
			$cekChild1=cekChild1($row->id);
			if($cekChild1==TRUE) {  $class_li.="dropdown"; $caret="<span class='caret'></span>";}
			$icondown=""; 
  			$menu .="<li class='".$class_li."'><a   class='dropdown-toggle' data-toggle='dropdown'
  			 href='".base_url().$row->url."'><i class='".$icon." icon-white'></i> ".$icondown." &nbsp; ".$row->name." ".$caret." </a>";
					if(cekChild1($row->id)){
						$menu.= getChild1($row->id);
	 				}
			$menu.="</li> ";
			 
 
		}	
		$menu.='</ul>';
 		echo $menu;
	}
	 
	?>

 
  </ul>


	 