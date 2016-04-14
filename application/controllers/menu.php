<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct(){
	parent::__construct();
	$this->is_logged_in();
	$this->load->model('M_menu','',TRUE);
	}

	function is_logged_in(){
	$is_logged_in=$this->session->userdata('is_logged_in');
		if(!isset($is_logged_in)||$is_logged_in!= true) {
		redirect(base_url());
		} 
	}
	
	public function add()
	{
	//set pesan error
	$this->form_validation->set_message('required','Field Tidak boleh dikosongkan');
	//set textboox yang tiak boleh dikosongkan
	$this->form_validation->set_rules('menu','Judul tidak boleh kosong','required');
	$this->form_validation->set_rules('isi_menu','Isi menu tidak boleh kosong','required');			

	

		if($this->form_validation->run() == TRUE)
		{
		$this->M_menu->save();	
		redirect('menu/listing','refresh'); 
		} 
		$data['daftar_parent']=$this->M_menu->list_parent();
		$data['page']='admin/menu/v_add_menu_2';
		$this->load->view('admin',$data);	
	}
	
	public function submenu($parent_id)
	{
	//set pesan error
	$this->form_validation->set_message('required','Field Tidak boleh dikosongkan');
	//set textboox yang tiak boleh dikosongkan
	$this->form_validation->set_rules('menu','Judul tidak boleh kosong','required');
	$this->form_validation->set_rules('isi_menu','Isi menu tidak boleh kosong','required');			

	

		if($this->form_validation->run() == TRUE)
		{
		$this->M_menu->save();	
		redirect('menu/listing','refresh'); 
		} 
		$data['page']='admin/menu/v_add_menu_2';
		$this->load->view('admin',$data);	
	}
	


	
	public function listing()
	{
		$data['menu']=$this->M_menu->listing();
		$data['page']='admin/menu/v_list_menu';
		
		$this->load->view('admin',$data);	
	}


	public function delete($kode)
	{
		$data['menu']=$this->M_menu->delete($kode);
		redirect('menu/listing','refresh'); 
	}
	
	
	public function edit($kode)
	{
		//set pesan error
		$this->form_validation->set_message('required','Field Tidak boleh dikosongkan');
		//set textboox yang tiak boleh dikosongkan
		$this->form_validation->set_rules('menu','Judul tidak boleh kosong','required');
		$this->form_validation->set_rules('isi_menu','Isi menu tidak boleh kosong','required');			

		if($this->form_validation->run() == TRUE)
		{
		$this->M_menu->update($kode);	
		redirect('menu/listing','refresh'); 
		} 

		$data['menu_nya']=$this->M_menu->get_menu($kode);
		$data['daftar_parent']=$this->M_menu->list_parent();

		$data['page']='admin/menu/v_add_menu_2';
		$this->load->view('admin',$data);	
	}
	

}
?>
