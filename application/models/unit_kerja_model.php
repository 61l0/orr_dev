<?php
class unit_kerja_model extends CI_Model{ 

	function unit_kerja_model()
	{
		parent::__construct();
	}
	function list_skkpd($limit='',$offset='',$id=''){
			$menus='';
			$unit_kerja=$this->input->post('skkpd');		 
			$addTag="";
			$query=$this->db->query("select *,m_unit_kerja.id_divisi as id  from m_unit_kerja 
			where m_unit_kerja.nama_unit_kerja like'%$unit_kerja%'
			order by id_divisi DESC
			LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}

	}
	function count(){
			$unit_kerja=$this->input->post('skkpd');		
			$query=$this->db->query("select count(1) as jumlah from m_unit_kerja where m_unit_kerja.nama_unit_kerja like'%$unit_kerja%'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
		function getUpdate($id=''){
			$query=$this->db->query("select * from m_unit_kerja where id_divisi='$id'");
			return $query->row();
		}
		 
	function act(){
		$id=$this->input->post('id');
		$id_divisi=$this->input->post('id_divisi');
		$nama=$this->input->post('nama');
		$pusat=$this->input->post('pusat');
		$data=array(
	 	 'kd_unit_kerja'=>$id_divisi,
		 'nama_unit_kerja'=>$nama,
		 'pusat'=>$pusat,
		);
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('m_unit_kerja',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id_divisi',$id);
			$this->db->update('m_unit_kerja', $data); 
			$this->db->trans_complete();
		}	
	}
	function delete_unit($id){
		if($this->db->query("delete from m_unit_kerja where id_divisi='$id'")){
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