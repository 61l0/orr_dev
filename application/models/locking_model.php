<?php
class locking_model extends CI_Model{ 

	function locking_model()
	{
		parent::__construct();
	}
	function get_data($tipe=''){		
			$query=$this->db->query("select * from locking where tipe='".$tipe."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}

	}
	function count(){
			$query=$this->db->query("select count(1) as jumlah from locking ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function getUpdate($id=''){
			$query=$this->db->query("select * from locking where id='$id'");
			return $query->row();
	}
		 
	function act(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');
 		$data=array(
	 	 'status'=>$status,
 		);
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('locking',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('locking', $data); 
			$this->db->trans_complete();
		}	
	}
	 
   
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>