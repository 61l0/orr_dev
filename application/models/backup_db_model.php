<?php
class backup_db_model extends CI_Model{ 

	function backup_db_model()
	{
		parent::__construct();
	}
	function getdata($limit='',$offset=''){
			$tanggal=$this->input->post('tanggal');
			if(!empty($tanggal)){
				$tanggal=date("Y-m-d",strtotime($this->input->post('tanggal')));
			}
			$query=$this->db->query("select * from backup_db		
  			where tanggal like '%".$tanggal."%'
  			order by  id DESC
			LIMIT $limit,$offset");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}

	}
	function count(){ 
			$tanggal=$this->input->post('tanggal');
			if(!empty($tanggal)){
				$tanggal=date("Y-m-d",strtotime($this->input->post('tanggal')));
			}
			$query=$this->db->query("select count(1) as jumlah from  backup_db
			where tanggal like '%".$tanggal."%'
			");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function get_update($id=''){
 			$query=$this->db->query("select * from backup_db where id='$id'");
			return $query->row();
	}
	function act(){
		$this->load->dbutil();

        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'my_db_backup.sql'
         );


        $backup =& $this->dbutil->backup($prefs); 
        $db_name = 'backup-on-'. date("Ymdhis") .'.zip';
        $save = 'db/'.$db_name;
        $this->load->helper('file');
        write_file($save, $backup); 
        $data=array(
 		 'url'=>$db_name,
 		 'tanggal'=>date("Y-m-d-h-i-s")
		); 

		$this->db->trans_start();
		$this->db->insert('backup_db',$data);
		$this->db->trans_complete(); 
 
	}
	function deletedata($id=""){
		$this->db->query("delete from backup_db where id='$id'");	
	}

	function di_restore_dulu_sob(){
		$isi_file=file_get_contents("db/extract/my_db_backup.sql");
		$string_query=rtrim($isi_file, "\n;" );
		$array_query=explode(";\n", $string_query);
		/*foreach($array_query as $query){
			$query=str_replace('\"','',$query);
 			echo $query."<br>";
		}*/	
		$array_query=explode(";\n", $string_query);
		$hitung=count($array_query);
		$progress=0;
		$i=1;
 		foreach($array_query as $query){
			$this->db->query($query);		
			$i++;
 		}
 	}
	 
    
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>