<?php
class init extends CI_Model{ 

	function init()
	{
		parent::__construct();
	}
	function getLasturl(){
		/*$controllername = $this->router->fetch_class(); 
		$ROLE=$this->session->userdata('ROLE');
		$query=$this->db->query("select id from t_menu where url='$controllername'");
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil= $data->id;
            }
			$data=array('id_session_menu'=>$hasil);
            $this->session->set_userdata($data);
			}*/
		$menu_id="";
		$hasil="";	
		$controllername = $this->router->fetch_class(); 
		$ROLE=$this->session->userdata('ROLE');
		$query=$this->db->query("select id from t_menu where url='$controllername'");
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $menu_id= $data->id;
            }
		}
		$query=$this->db->query("select count(1) as jumlah from t_otoritas where menu='".$menu_id."' and role='".$ROLE."'");
 		if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil= $data->jumlah;
            }
		}
		if ($hasil=="0") {
           redirect('home/error_donk');			
        } 
 	}
	function check_if_db_read_update(){
		$query=$this->db->query("select count(1) as jumlah from backup_db where  tanggal='".date("Y-m-d")."'");
 		if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil= $data->jumlah;
		    }
		}
		return $hasil;
	} 
	function get_otoritas_menu(){
		$role=$this->session->userdata('ROLE');
		$id_session_menu=$this->session->userdata('id_session_menu') ;
		$query=$this->db->query("select count(1) as jumlah from t_otoritas where role='$role' and menu='$id_session_menu'");
 		if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil= $data->jumlah;
		    }
		}
		$this->get_otor_button();
		return $hasil;
	}
	function simpan_log($aksi=""){
		 
		$ip = $_SERVER['REMOTE_ADDR'];
		$data_log=array('id_user'=>$this->session->userdata('ID_USER'),
						'aksi'=>$aksi,
						'tanggal'=>date("Y-m-d"),
						'jam'=>date("H:i:s"),
						'ip'=>$ip
 		);
 		$this->db->trans_start();
		$this->db->insert('log',$data_log);
		$this->db->trans_complete(); 	
	}	
	function get_otor_button(){
		$role=$this->session->userdata('ROLE');
		$id_session_menu=$this->session->userdata('id_session_menu') ;
		$query=$this->db->query("select * from t_otoritas where role='$role' and menu='$id_session_menu'");
  		if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
 				$data=array(
						'AKSI_TAMBAH'=>$data->tambah,
						'AKSI_UBAH'=>$data->ubah,
						'AKSI_HAPUS'=>$data->hapus,
						'AKSI_CETAK'=>$data->cetak						
				);
				$this->session->set_userdata($data);
            }
		}
 	}	
 	
}
 
?>