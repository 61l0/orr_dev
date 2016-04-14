<?php  

class user extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function user() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/login_page');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
	function index($limit='',$offset=''){
		$this->load->model("init"); 
		$this->init->getLasturl();
		
		if($this->session->userdata('LOGIN')=='TRUE'){
			$this->load->model("user_model"); 
		$data['judul']='User';
		 
		$data['view']='user/list';
		$this->load->view('index',$data);
		}else {
		redirect('home/loginPage');		
		}

	}
	function search($limit='',$offset=''){
	 	$this->load->model("user_model"); 
	 
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->user_model->count();	
		$config['base_url'] = base_url().'user/search/';
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
 
		$data['query']=$this->user_model->get_data($limit,$offset);
		$this->load->view('user/data',$data);
	}
	
	function add($id=''){		 
		$this->load->model("user_model"); 
 		$data['judul']='Tambah / Ubah User';
		$data['menu']=$this->user_model->getMenu();
		if($id!=''){
		$info=$this->user_model->getDataPegawai($id);		 
			$data['infouser']['username']=$info->username;
			$data['infouser']['status']=$info->status;
			$data['infouser']['role']=$info->role;
			$data['infouser']['nama']=$info->nama;
			$data['infouser']['nik']=$info->nik;
			$data['infouser']['email']=$info->email;
			$data['role']=$this->user_model->getRole($data['infouser']['role']);	
			$data['unit']=$this->user_model->get_unit($info->unit);	
		}	else {
			$data['unit']=$this->user_model->get_unit();	
		}
		$data['id']=$id;
		$data['role']=$this->user_model->getRole();
		$data['view']='user/form';
		$this->load->view('index',$data);

	}
 
	function detailPegawai($id=''){
			$this->load->model("user_model"); 
			$this->user_model->detailPegawai($id);
	}
	function simpan(){
		$this->load->model("user_model"); 
		$password=$this->input->post('password');
		if($this->input->post('nama')==''){
			echo "Nama Tidak Boleh Kosong"; return false;
		} else if($this->input->post('username')==''){
			echo "Username Tidak Boleh Kosong"; return false;
		} else if($this->input->post('id')==''){
			if($password==''){
				echo "Password Tidak Boleh Kosong"; return false;
			}
		} else if($this->input->post('tipeuser')==''){
			echo "Status tidak Boleh Kosong"; return false;
		}  
		$this->user_model->simpan();
	}
	 
	function deleteuser($id){
		$this->load->model("user_model"); 
		$this->user_model->deleteuser($id);
	}
	
	public function generate_pdf($limit='',$offset=''){
		$this->load->model("user_model"); 

 	    $this->load->library('mpdf');
	    $mpdf=new mPDF('utf-8','A4');
	    $mpdf->debug = true;	
		$this->load->model("user_model"); 
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=10 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->user_model->count();	
		$config['base_url'] = base_url().'user/search/';
		$config['total_rows'] = $data['count'];
		$config['per_page'] = $this->limit;    
		$config['cur_tag_open'] = '<span class="pg">';
		$config['cur_tag_close'] = '</span>';		
		$this->pagination->initialize($config);
		/*----------------*/
		
		$data['query']=$this->user_model->getUser($limit,$offset);
		$data['view']='user/list';
 		$html = $this->load->view('user/data',$data,TRUE);
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
		
 	}	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */