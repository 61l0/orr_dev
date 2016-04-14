<?php
class history_model extends CI_Model
 {
     function __construct(){
         parent::__construct();
     }
     
 
    
	 
 	 
	 
	function simpan($tipe="",$text="",$json=""){
		$id_user=$this->session->userdata('ID_USER'); 		
		    $data=array(
		 	 'id_user'=>$id_user,
			 'tipe'=>$tipe,
			 'tanggal'=>date("Y-m-d"),
			 'jam'=>date("H:m:i"),
			 'text'=>strtoupper($text),
			 'data'=>$json,
 			);
		 

 			$this->db->trans_start();
			$this->db->insert('history',$data);
			$this->db->trans_complete();
		 
	}
	 
	 
	 
}		
 ?>
