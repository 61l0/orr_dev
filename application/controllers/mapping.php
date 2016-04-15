<?php  

class mapping extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function mapping() {
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
		$this->load->model("mapping_model"); 
		$data['judul']='Master Kiriman Email';
		$data['view']='mapping/list';
		$this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("mapping_model"); 
		$data['judul']='Master Barang';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->mapping_model->count();
		$config['base_url'] = base_url().'mapping/search/';
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
		$data['query']=$this->mapping_model->get_data($limit,$offset);
		$this->load->view('mapping/data',$data);
	}
	function form($id=''){
		$this->load->model("mapping_model"); 
		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->mapping_model->getUpdate($id);		 
 			$data['infouser']['nama']=$info->nama;
 		} else {
			$data['pusat']="0";
		}
 		$data['id']=$id;	
		$data['view']='mapping/form';
		$this->load->view('index',$data);
	}
	function act(){
 		$nama=$this->input->post('mapping');
 		if($nama==""){
			echo "TUJUAN TIDAK BOLEH KOSONG ..";
			return false;
		} 
			 
		$this->load->model("mapping_model"); 
		$this->mapping_model->act();		 
	}	
	function delete($id=''){
		$this->load->model("mapping_model"); 
		$this->mapping_model->delete_data($id);
	}
	function buat($id=""){
		
		$this->load->model("mapping_model"); 
		$data['tahun_anggaran']=$this->mapping_model->filter_tahun_anggaran();
		$data['get_direktorat']=$this->mapping_model->filter_get_direktorat();
		$data['table']="&nbsp;";
		$data['id']=$id;
		$data['view']='mapping/detail';
		$this->load->view('index',$data);
	}
	function refresh_export(){
		$id=$this->input->post('id');
		$this->load->model("mapping_model"); 
		$data['table']=$this->mapping_model->get_data_rekap();	
 		echo  $data['table'];
	}
	function simpan_kode(){
		$this->load->model("mapping_model");
		$this->mapping_model->simpan_kode(); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */