<?php  

class pengingat extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function pengingat() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){
 		$this->load->model("pengingat_model"); 
		$this->load->model("init"); 
		$this->init->getLasturl();
		$data['judul']='Pengingat / Reminder';
		$this->load->model("pengingat_model"); 		 
		$data['view']='pengingat/list';
		$data['get_direktorat']=$this->pengingat_model->get_direktorat();
		$data['get_capaian']=$this->pengingat_model->get_capaian();
		$data['get_direktorat_capaian']=$this->pengingat_model->get_direktorat();
		$this->load->view('index',$data);
	}
	function get_capaian_target($id_table=""){
		if($id_table==""){
			$id_table=$this->this->input->post('id');
		}
		$this->load->model("pengingat_model"); 
		$data['table']=$this->pengingat_model->get_table_table($id_table,0);
		$this->load->view('pengingat/capaian',$data);
	} 
	function get_capaian_realisasi($id_table=""){
		if($id_table==""){
			$id_table=$this->this->input->post('id');
		}
		$this->load->model("pengingat_model"); 
		$data['table']=$this->pengingat_model->get_table_table($id_table,1);
		$this->load->view('pengingat/capaian',$data);
	} 
	function send_mail(){
		$this->load->model("pengingat_model");
		$this->pengingat_model->send_mail();
	}
	function form_mail_capaian($id_direktorat='',$bulan=''){
		$this->load->model("pengingat_model"); 
		$data['judul']='Tambah / Ubah';
		$data['email']=$this->pengingat_model->get_email($id_direktorat);
		$data['subject']='Pengisian Data Capaian';
		$data['id_direktorat']=$id_direktorat;	
		$bulan=$this->pengingat_model->get_bulan($bulan);
		$data['text']="Data Capaian Bulan ".$bulan." Harus Segera Diisi";  
 		$this->load->view('pengingat/form_mail',$data);
	}
	function act(){
		$this->load->model("pengingat_model"); 
		$this->pengingat_model->act();		 
	}	
	function delete($id=''){
		$this->load->model("pengingat_model"); 
		$this->pengingat_model->delete_unit($id);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */