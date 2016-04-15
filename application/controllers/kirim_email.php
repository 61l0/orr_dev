<?php  

class kirim_email extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function kirim_email() {
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
		$this->load->model("kirim_email_model"); 
		$data['judul']='Master Kiriman Email';
		$data['view']='kirim_email/list';
		$this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("kirim_email_model"); 
		$data['judul']='Master Barang';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->kirim_email_model->count();
		$config['base_url'] = base_url().'kirim_email/search/';
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
		$data['query']=$this->kirim_email_model->get_data($limit,$offset);
		$this->load->view('kirim_email/data',$data);
	}
	function form($id=''){
		$this->load->model("kirim_email_model"); 
		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->kirim_email_model->getUpdate($id);		 
			$data['infouser']['kd_unit_kerja']=$info->kd_unit_kerja;
			$data['infouser']['nama']=$info->nama_unit_kerja;
			$data['pusat']=$info->pusat;
		} else {
			$data['pusat']="0";
		}
		$data['query']=$this->kirim_email_model->get_data_user();
 		$data['id']=$id;	
		$data['view']='kirim_email/form';
		$this->load->view('index',$data);
	}
	function act(){
		$subjek=$this->input->post('subjek');
		$nama=$this->input->post('nama');
		$pesan=$this->input->post('pesan');
		$email=$this->input->post('email');
		if($email==""){
			echo "TUJUAN TIDAK BOLEH KOSONG ..";
			return false;
		} else if($pesan==""){
			echo "PESAN TIDAK BOLEH KOSONG ..";
			return false;
		}
		$this->load->model("kirim_email_model"); 
		$this->kirim_email_model->act();		 
	}	
	function delete($id=''){
		$this->load->model("kirim_email_model"); 
		$this->kirim_email_model->delete_unit($id);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */