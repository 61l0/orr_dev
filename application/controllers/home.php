<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller
{
	public function __construct(){
	parent::__construct();

	}	
	
	public function index(){
		 if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/login');			
        } else {
        	$this->load->model("init"); 
        	$data['cek']=$this->init->check_if_db_read_update();		 	
		 	$data['view']='dashboard';		 	 
 	    	$this->load->view('index',$data);	
		}
	}
	function change_pass($id=""){
		$this->load->model("user_model"); 
 		$data['judul']='Ganti Password User';
		$data['menu']=$this->user_model->getMenu();
		if($id!=''){
		$info=$this->user_model->getDataPegawai($id);		 
			$data['infouser']['username']=$info->username;
			$data['infouser']['status']=$info->status;
			$data['infouser']['role']=$info->role;
			$data['infouser']['nama']=$info->nama;
			$data['infouser']['nik']=$info->nik;
			$data['role']=$this->user_model->getRole($data['infouser']['role']);	
			$data['unit']=$this->user_model->get_unit($info->unit);	
		}	else {
			$data['unit']=$this->user_model->get_unit();	
		}

		$data['id']=$id;
		$data['role']=$this->user_model->getRole();
		$data['view']='user/change_pass';
		$this->load->view('index',$data);
	}
	function simpan_change_pass(){
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
		} 
		
		$this->user_model->simpan_change_pass();
	}
	function not_found(){
		$data['view']='not_found';
 	   	$this->load->view('index',$data);	
	}

	function login(){
		$data['view']='dashboard';
 	    $this->load->view('login',$data);	
	}
 	function loginpage(){
		$this->load->view('login');
	}
	function loginact(){
		$this->load->model("user_model");
		$this->user_model->cek();
	}
	function logout(){
		$this->load->model("init"); 
		$this->init->simpan_log('KELUAR DARI DALAM SISTEM');
		$this->session->sess_destroy();
		redirect('home/loginpage');		
	}
	function _error404(){
		$data['judul']='Oooops !!!!';
		$data['view']='eyoy_ye';
		$this->load->view('index',$data);
	}
	function error_donk(){
		$data['judul']='Oooops !!!!';
		$data['view']='close_akses';
		$this->load->view('index',$data);
	}
	function export_doc(){
		
	}
	function phpinfo(){
		phpinfo();
	}
}

?>
