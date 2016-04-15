<?php  

class log_capaian extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function log_capaian() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){
	  $this->load->model("log_capaian_model");     
  	   $data['judul']='Data Template Renja'; 
       $data['view']='log_capaian/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("log_capaian_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->log_capaian_model->count();
		$config['base_url'] = base_url().'log_capaian/search/';
		$config['total_rows'] = $data['count'];
		$config['per_page'] = $this->limit;    
		$config['full_tag_open'] = '<div ><ul class="pagination pages">';
		$config['full_tag_close'] = '</ul></div>'; 
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>'; 
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>'; 
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>'; 
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>'; 		
		$this->pagination->initialize($config);
		/*----------------*/
		$data['query']=$this->log_capaian_model->get_data($limit,$offset);
		$this->load->view('log_capaian/data',$data);
	}
	function rekap_renja($id="",$id_data_renja=""){
		$this->load->model("log_capaian_model"); 
		$data['direktorat']="";
		$info=$this->log_capaian_model->get_update($id,$id_data_renja);	
		$data['direktorat']=$info->nama_unit_kerjax .' (  '.$info->text .' ) ';
		$data['view']='log_capaian/detail';
		$data['id']=$id; 
		$data['id_data_renja']=$id_data_renja; 

		$data['id_restore']=$id_data_renja;
 		$data['id_backup']=$id;
	    $this->load->view('index',$data);
	}	
	function di_restore_dulu_sob(){
		$this->load->model("log_capaian_model"); 
		$this->log_capaian_model->di_restore_dulu_sob();   
	}
	function echo_table_renja($id=""){

	}
	function restore($id="",$id_data_renja=""){
		$this->load->model("log_capaian_model"); 
 		if($id!=''){
			$info=$this->log_capaian_model->get_update($id);		 
 			$data['infouser']['judul']=$info->nama_unit_kerjax;
 			$data['infouser']['note']=$info->note;
 			$data['infouser']['text']=$info->text;
  			$data['infouser']['dari']=$info->nama_unit_kerjax;
 			$data['infouser']['tanggal']=$info->tanggal;
 		} 
 		if($id!=''){
			$info_log=$this->log_capaian_model->get_update_log($id);		 
 			$data['info_log']['judul']=$info_log->judul;
 			$data['info_log']['note']=$info_log->note;
 			$data['info_log']['text']=$info->text;
  			$data['info_log']['dari']=$info->nama_unit_kerjax;
 			$data['info_log']['tanggal']=$info->tanggal;
 		} 
 		$data['direktorat']=$info->nama_unit_kerjax;
 		$data['id_restore']=$id_data_renja;
 		$data['id_backup']=$id;
 		
	 	$data['view']='log_capaian/form_restore';
		$this->load->view('index',$data);
	}
	function log_capaian_renja($id="",$id_data_renja=""){
		$this->load->model("log_capaian_model"); 
		$info=$this->log_capaian_model->get_update_log($id);
		$table_capaian=$info->jenis_capaian;
		$random=$info->random;
		$table_capaian="log_capaian";
 		$data['table_capaian']=$this->log_capaian_model->get_capaian($id,$table_capaian,$id_data_renja,$random);
		echo $data['table_capaian'];
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */