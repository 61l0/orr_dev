<?php
class kewenangan_model extends CI_Model{ 

	function kewenangan_model()
	{
		parent::__construct();
	}
	function list_skkpd($limit='',$offset='',$id=''){
			$menus='';
			$kewenangan=$this->input->post('kewenangan');		 
			$addTag="";
			$query=$this->db->query("select * from kewenangan 
			where kewenangan.nama_kewenangan like'%$kewenangan%'
			order by id DESC
			LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}

	}
	function count(){
			$kewenangan=$this->input->post('kewenangan');		
			$query=$this->db->query("select count(1) as jumlah from kewenangan where kewenangan.nama_kewenangan like'%$kewenangan%'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
		function getUpdate($id=''){
			$query=$this->db->query("select * from kewenangan where id='$id'");
			return $query->row();
		}
		 
	function act(){
		$id=$this->input->post('id');
 		$nama=$this->input->post('nama');
 		$kode=$this->input->post('kode');
 		$status_kewenangan=$this->input->post('status_kewenangan');
 		$data=array(
 		 'nama_kewenangan'=>$nama,
 		 'kode'=>$kode,
 		 'mark_as_kewenangan'=>$status_kewenangan,
 		);
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('kewenangan',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('kewenangan', $data); 
			$this->db->trans_complete();
		}	
	}
	function delete_data($id){
		if($this->db->query("delete from kewenangan where id_divisi='$id'")){
			echo"SUKSES MENGHAPUS DATA";
		} else {
			echo"GAGAL MENYIMPAN KARENA SESUATUNYA SYAHRINI";
		}					
	}
   
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>