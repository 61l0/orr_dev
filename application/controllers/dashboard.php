<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller
{
	public function __construct(){
	parent::__construct();

	}	
	
	public function index(){
		$this->load->model("dashboard_model");
	 	$data['view']='executiv_view';
	 	$data['capaian']=$this->dashboard_model->capaian();
  	    $this->load->view('index',$data);	
	}
	
 	function belanja_operasional(){
 		$this->load->model("dashboard_model");
 		$data['series1']=$this->dashboard_model->belanja_operasional();
 	    $this->load->view('dashboard/belanja_operasional',$data);	
 	}
 	function belanja_operasional_list(){
 		$this->load->model("dashboard_model");
 		$this->dashboard_model->belanja_operasional_list();
 	}
 	function belanja_non_operasional(){
 		$this->load->model("dashboard_model");
 		$data['series1']=$this->dashboard_model->belanja_non_operasional();
 	    $this->load->view('dashboard/belanja_non_operasional',$data);	
 	}
 	function get_kegiatan_dit(){
 		$this->load->model("dashboard_model");
 		$data['series1']=$this->dashboard_model->get_kegiatan_dit();
 	   // $this->load->view('dashboard/belanja_non_operasional',$data);	
 	}
 	function capaian_se_bangda_sob(){
 		$this->load->model("dashboard_model");
 		$id_capaian=$this->input->post('id_capaian');
		$table_capaian="";
		if($id_capaian=="1"){
           $data['tipe_capaian']="KINERJA";
        } else  if($id_capaian=="2"){
           $data['tipe_capaian']="KEUANGAN";
        } else  if($id_capaian=="3"){
           $data['tipe_capaian']="PHLN";
        } else  if($id_capaian=="4"){
           $data['tipe_capaian']="DKTP";
        } else  if($id_capaian=="5"){
           $data['tipe_capaian']="LAKIP";
        } else  if($id_capaian=="6"){
           $data['tipe_capaian']="RENAKSI";
		}  else  if($id_capaian=="1"){
           $data['tipe_capaian']="KINERJA";
		}

 		

 		$data['series1']=$this->dashboard_model->capaian_se_bangda_sob();
 	    $this->load->view('dashboard/capaian_se_bangda_sob',$data);	
 	}
 	function belanja_non_operasional_list(){
 		$this->load->model("dashboard_model");
 		$this->dashboard_model->belanja_non_operasional_list();
 	}
 	function belanja_non_operasional_list_group(){
 		$this->load->model("dashboard_model");
 		$this->dashboard_model->belanja_non_operasional_list_group();
 	}
 	function pnbp(){
 		$this->load->model("dashboard_model");
 		$data['series1']=$this->dashboard_model->pnbp();
 	    $this->load->view('dashboard/pnbp',$data);	
 	}
 	function pnbp_list(){
 		$this->load->model("dashboard_model");
 		$this->dashboard_model->pnbp_list();
 	}
 	function per_direktorat(){
 		$this->load->model("dashboard_model");
 		$data['series1']=$this->dashboard_model->belanja_operasional_direktorat();
 		$data['divnya']=$this->input->post('divnya');
 	    $this->load->view('dashboard/per_direktorat',$data);	
 	}
}

?>
