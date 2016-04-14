<?php  

class locking extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function locking() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){
		$this->load->model("init"); 
		$this->init->getLasturl();
		$data['judul']='Penguincian Isian';
		$this->load->model("locking_model"); 		 
		$data['view']='locking/list';
		$this->load->view('index',$data);
	}
	function search_renja(){
	 	$this->load->model("locking_model"); 
		$data['judul']='Master Barang';
		$data["id"]="0";
		$data['query']=$this->locking_model->get_data('renja');
		$this->load->view('locking/data',$data);
	}
	function search_capaian_target(){
	 	$this->load->model("locking_model"); 
		$data["id"]="1";
		$data['judul']='Master Barang';
		$data['query']=$this->locking_model->get_data('capaian_target');
		$this->load->view('locking/data',$data);
	}
	function search_capaian_realisasi(){
	 	$this->load->model("locking_model"); 
		$data["id"]="2";
		$data['judul']='Master Barang';
		$data['query']=$this->locking_model->get_data('capaian_realisasi');
		$this->load->view('locking/data',$data);
	}
	function form($id=''){
		$this->load->model("locking_model"); 
		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->locking_model->getUpdate($id);		 
			$data['infouser']['judul']=$info->judul;
			$data['infouser']['tipe']=$info->tipe;
 			$data['status']=$info->status;
 		} else {
			$data['status']="0";
		}
 		$data['id']=$id;	
		$data['view']='locking/form';
		$this->load->view('index',$data);
	}
	function act(){
		$this->load->model("locking_model"); 
		$this->locking_model->act();		 
	}	
	function delete($id=''){
		$this->load->model("locking_model"); 
		$this->locking_model->delete_unit($id);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */