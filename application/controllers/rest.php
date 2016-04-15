<?php  

class rest extends CI_Controller {
 
	var $limit=10;
	var $offset=10;	
	public function rest() {
        parent::__construct();
        
    }	
  	function cek_connection(){
  		
		$db['hostname'] = 'localhost';
		$db['username'] = 'siminternal';
		$db['password'] = 'siminternal';
		$db['database'] = 'idaf';
		$db['dbdriver'] = 'mysql';
		$db['dbprefix'] = '';
		$db['pconnect'] = TRUE;
		$db['db_debug'] = TRUE;
		$db['cache_on'] = FALSE;
		$db['cachedir'] = '';
		$db['char_set'] = 'utf8';
		$db['dbcollat'] = 'utf8_general_ci';
		$db['swap_pre'] = '';
		$db['autoinit'] = TRUE;
		$db['stricton'] = FALSE;
		$db_obj=$this->load->database($db, TRUE);
		if($db_obj->conn_id) {
		    echo "KONEKSI BERHASIL|";
		} else {
		    echo "KONEKSI GAGAL|";
		}
  	}

  	function get_notification(){
  		$this->load->model("rest_model");   
  		$data['notification']=$this->rest_model->get_notification();  

  	}
	function cek_login($username="",$password=""){
		$this->load->model("rest_model");  
  		$data['cek_login']=$this->rest_model->cek_login($username,$password);  
	} 

	function count_notifikasi($status_user="",$id_direktorat=""){
		$this->load->model("rest_model");  
  		$data['cek_login']=$this->rest_model->count_notifikasi($status_user,$id_direktorat);  
	}
	function get_detail_notifikasi($status_user="",$id_direktorat=""){
		$this->load->model("rest_model");  
  		$data['cek_login']=$this->rest_model->get_detail_notifikasi($status_user,$id_direktorat);  
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */