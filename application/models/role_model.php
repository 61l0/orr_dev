<?php
class role_model extends CI_Model{ 

	function role_model()
	{
		parent::__construct();
	}
	function cek(){
		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		$query=$this->db->query("select t_pegawai.nama,t_user.nik,t_user.username,t_user.password,t_user.status,t_user.role from t_user 
		left join t_pegawai on t_pegawai.nik=t_user.nik
		where username='$username' and password='$password'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$data=array('LOGIN'=>TRUE,'NAMA'=>$data->nama,'STATUS'=>$data->status,'NIK'=>$data->nik,'ROLE'=>$data->role);
					$this->session->set_userdata($data);	
					redirect('home/index');		
				}
			} else {
				redirect('home/loginPage');
			}			
	}
	 
	function getRole(){
			$query=$this->db->query("select * from t_role");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
	}	
	function getRoleByid($id=''){
			$query=$this->db->query("select * from t_role
			where t_role.id='$id'");
			return $query->row();
	}
	 
	function count($id=''){
		$jumlah='';
		$judul=$this->input->post('judul');
		$status=$this->session->userdata('STATUS');		
		$query=$this->db->query("select count(1) as jumlah from t_role ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
	}
	function getUser($limit='',$offset=''){
			$menus='';
			$judul=$this->input->post('judul');
			$query=$this->db->query("select *  from t_user ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
		}
		function cekUser(){
			$nik=$this->input->post('nik');
			$query=$this->db->query("select count(1) as jumlah from t_user where nik='$nik' ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
		}
		function check_have_child($parent=''){
 		$q=$this->db->query("select id from t_menu where parent='$parent'");
		if($q->num_rows() > 0){
			return TRUE;
			}
	}
	function getMenuUp($id=''){
		$filter="";
		$menus='<table class="table multimedia table-striped table-hover">
                                    <thead>
                                        <tr>
											<td>Menu / View</td>
   
                                         </tr>
                                    </thead><tbody>';
		if($id!='')
		{	$filter=" where role='$id'";	}
			
			$role=$id;
			$query=$this->db->query("select * from t_menu   where  parent='' order by urut asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus.='<tr>';
					$check="";
					$check_add="";
					$check_edit="";
					$check_delete="";
					$check_print="";					
					$cekada_menu=$this->get_from_otor($data->id,$role,'menu');
					$cekada_add=$this->get_from_otor($data->id,$role,'tambah');
					$cekada_edit=$this->get_from_otor($data->id,$role,'ubah');
					$cekada_delete=$this->get_from_otor($data->id,$role,'hapus');
					$cekada_print=$this->get_from_otor($data->id,$role,'cetak');
					if($cekada_menu >0){ $check='checked="checked"'; }
					if($cekada_add > 0){ $check_add='checked="checked"'; }
					if($cekada_edit > 0){ $check_edit='checked="checked"'; }
					if($cekada_delete > 0){ $check_delete='checked="checked"'; }
					if($cekada_print > 0){ $check_print='checked="checked"'; }
					$menus.="<td><input $check name='nama[]'   type='checkbox' value='".$data->id."' /> ".$data->name."</td>";
 				
 					$menus.='</tr>';
 					if($this->check_have_child($data->id)){
 		
						$menus.= $this->get_child($data->id,$id);
	 				}
				}
				
			}
			$menus.='<tbody></table>';
			return $menus;
		}
		function get_child($parent='',$role=''){
		$filter="";
		$menus='';
			$query=$this->db->query("select * from t_menu  where parent='$parent' order by urut asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus.='<tr>';
					$check="";
					$check_add="";
					$check_edit="";
					$check_delete="";
					$check_print="";					
					$cekada_menu=$this->get_from_otor($data->id,$role,'menu');
					$cekada_add=$this->get_from_otor($data->id,$role,'tambah');
					$cekada_edit=$this->get_from_otor($data->id,$role,'ubah');
					$cekada_delete=$this->get_from_otor($data->id,$role,'hapus');
					$cekada_print=$this->get_from_otor($data->id,$role,'cetak');
					if($cekada_menu >0){ $check='checked="checked"'; }
					if($cekada_add > 0){ $check_add='checked="checked"'; }
					if($cekada_edit > 0){ $check_edit='checked="checked"'; }
					if($cekada_delete > 0){ $check_delete='checked="checked"'; }
					if($cekada_print > 0){ $check_print='checked="checked"'; }
					$menus.="<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input $check name='nama[]'   type='checkbox' value='".$data->id."' /> ".$data->name."</td>";
 					
 					$menus.='</tr>';
 					
 					if($this->check_have_child($data->id)){
						$menus.=  $this->get_child($data->id,$role);
	 				}
				}				
			}
			$menus.='';
			return $menus;
		}
		function get_from_otor($menu='',$role='',$tipe=''){
			$query=$this->db->query("select  (".$tipe.") as jumlah from t_otoritas where menu='$menu' and role='$role'");
 			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
		}
		function simpan(){
		$role=$this->input->post('role');
		$id=$this->input->post('id');
	 
			$data=array(
			 'role'=>$role,
			);
		 
			if($id==''){
			$this->db->trans_start();
			$this->db->insert('t_role',$data);
			$this->db->trans_complete(); 
			$this->createMenu();
			} else {
			$this->db->query("update t_role set role='$role'  where id='$id'");	
			$this->createMenu();
			}
 		}
		function getnewroleid(){
			$query=$this->db->query("select id from t_role order by id desc LIMIT 1");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					return $data->id;
				}
			}	
		}
		function createMenu(){
			$id=$this->input->post('id');
			$this->db->query("delete from t_otoritas where role='$id'");
			$menu=$this->input->post('nama');
			$count=count($menu);
			if($id==""){
				$id=$this->getnewroleid();
			}
			$i=0;
			foreach($menu as $row){
				$data2=array(
					 'menu'=>$row,
					 'role'=>$id,
					 'tambah'=>$this->input->post('tambah'.'_'.$row),
					 'ubah'=>$this->input->post('ubah'.'_'.$row),
					 'hapus'=>$this->input->post('hapus'.'_'.$row),
					 'cetak'=>$this->input->post('cetak'.'_'.$row),
					);
				$this->db->trans_start();
				$this->db->insert('t_otoritas',$data2);
				$this->db->trans_complete(); 	
			$i++;
			}
		}
		
		function deleterole($id){
			$this->db->query("delete from t_role where id='$id'");	
			$this->db->query("delete from t_menu where role='$id'");	
		}
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>