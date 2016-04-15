<?php
class tahapan_dokumen_model extends CI_Model{ 

	function tahapan_dokumen_model()
	{
		parent::__construct();
	}
	function get_data($limit='',$offset='',$id=''){
			$menus='';
			$kewenangan=$this->input->post('kewenangan');		 
			$addTag="";
			$query=$this->db->query("select * from tahapan_dokumen 
			where tahapan_dokumen.nama_tahapan like'%$kewenangan%'
			order by id_dokumen asc
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
			$query=$this->db->query("select count(1) as jumlah from tahapan_dokumen where tahapan_dokumen.nama_tahapan like'%$kewenangan%'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
		function getUpdate($id=''){
			$query=$this->db->query("select * from tahapan_dokumen where id='$id'");
			return $query->row();
		}
		 
	function act(){
		$id=$this->input->post('id');
 		$nama=$this->input->post('nama');
 		$kode=$this->input->post('kode');
   		$data=array(
 		 'nama_tahapan'=>$nama,
 		 'id_dokumen'=>$kode,
  		);
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('tahapan_dokumen',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('tahapan_dokumen', $data); 
			$this->db->trans_complete();
		}	
	}
	function delete_data($id){
		if($this->db->query("delete from tahapan_dokumen where id_divisi='$id'")){
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