<?php
class menu_model extends CI_Model{ 

	function menu_model()
	{
		parent::__construct();
	}
	 
 
	function getMenus($limit='',$offset=''){
		$nama=$this->input->post('menu');
			$query=$this->db->query("select *,(select name from t_menu where id=a.parent limit 1) as parent 
				from t_menu a  where a.name like '%$nama%' order by a.urut ASC  LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
	}	
	function cek_url_exist(){
		$url=$this->input->post('url');
		$id=$this->input->post('id');
		$query=$this->db->query("select count(1) as jumlah from t_menu where url='$url' and id!='$id'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
		
	}
	function get_update($id=''){
			$query=$this->db->query("select * from t_menu
			where t_menu.id='$id'");
			return $query->row();
	}
	 
	function count($id=''){
		$jumlah='';
		$nama=$this->input->post('menu');
		
		$query=$this->db->query("select count(1) as jumlah from t_menu  where  name like '%$nama%'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
	}
	 
	function simpan(){
		$name=$this->input->post('name');
		$url=$this->input->post('url');
		$id=$this->input->post('id');
		$parent=$this->input->post('parent');
		$urut=$this->input->post('urut');		
		$iconnyatext=$this->input->post('iconnyatext');	
				$data=array(
				 'name'=>$name,
				 'url'=>$url,
				 'urut'=>$urut,
 				 'aktif'=>'0',
				 'icon'=>$iconnyatext,
		 		 'parent'=>$parent

				);		 
				if($id==''){
				$this->db->trans_start();
				$this->db->insert('t_menu',$data);
				$this->db->trans_complete(); 
				} else {			 
			 	$this->db->query("update t_menu set name='$name' , url='$url', urut='$urut' ,parent='$parent', icon='$iconnyatext' where id='$id'");	
				}
	}
	function getUrl($id=''){
			$query=$this->db->query("select url from t_menu where id='$id' ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$url=$data->url;
				}
				return $url;
			}
	}
	function deletemenu($id=''){
			$url=$this->getUrl($id);
			echo"delete from t_menu where url='$url'";
			$this->db->query("delete from t_menu where id='$id'");	
			$this->db->query("delete from t_otoritas where menu='$id'");	
	}
		 
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>