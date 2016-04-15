<?php  

class export extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function export() {
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
 	   $this->load->model("export_model");  
 	   $data['judul']='Export Data Renja'; 
       $data['view']='export/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("export_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->export_model->count();
		$config['base_url'] = base_url().'export/search/';
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
		$data['query']=$this->export_model->get_data($limit,$offset);
		$this->load->view('export/data',$data);
	}
	 
	 
	 
	function rekap_renja($id="",$tipe=""){
		$this->load->model("export_model"); 
		$data['judul']='Export Data Renja';
		//$data['table']=$this->export_model->get_data_rekap($id);		
		$data['table']="<tr><td colspan='15'><center><img src='".base_url()."images/loading.gif'></center></td></tr>";
		$info=$this->export_model->get_update($id);	
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['direktorat']=$info->dari;	
		$data['nama']=strtoupper($info->nama_user);	 
		$data['kd_unit_kerja']=$info->kd_unit_kerja;		 
		$data['view']='export/detail';
		$data['id']=$id; 
		$data['tipe']=$tipe; 
	    $this->load->view('index',$data);
	}
	function echo_table_renja($id=""){
		$this->load->model("export_model"); 
		$data['table']=$this->export_model->get_data_rekap($id);	
		$this->load->view('export/table',$data);
	}
	function simpan($id=""){
		$this->load->model("export_model"); 
		$this->export_model->simpan($id);
	} 
	function export_renja_bappenas($id=""){
		$this->load->model("export_model"); 
		$this->export_model->export_renja_bappenas($id);
	}
 	function export_now(){
		$this->load->model("export_model"); 
		$data['table']=$this->export_model->get_data_export();	
		$data['file_name']="LAPORAN_RENJA_".date("YMDHIS");
		$this->load->view('export/export/excel',$data);	 
	}
	function export_to_excel($id=""){
		$this->load->model("export_model"); 
		$data['judul']='Export Data Renja';
		$data['table']=$this->export_model->get_data_rekap($id);		
		$info=$this->export_model->get_update($id);	
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['direktorat']=$info->dari;		 
		$data['kd_unit_kerja']=$info->kd_unit_kerja;		 
		$data['nama_user']=$info->nama_user;		 
		$data['view']='export/detail';
		$data['id']=$id; 
		
		$data['t_sum_bo_01']=$this->input->post('t_sum_bo_01');
		$data['t_sum_bo_02']=$this->input->post('t_sum_bo_02');
		$data['t_sum_bno_rm_p']=$this->input->post('t_sum_bno_rm_p');
		$data['t_sum_bno_rm_d']=$this->input->post('t_sum_bno_rm_d');
		$data['t_sum_bno_phln_p']=$this->input->post('t_sum_bno_phln_p');
		$data['t_sum_bno_phln_d']=$this->input->post('t_sum_bno_phln_d');
		$data['t_sum_bno_pnbp']=$this->input->post('t_sum_bno_pnbp');
		$data['t_sum_pagu']=$this->input->post('t_sum_pagu');

		$data['file_name']="EXCEL-".strtoupper(trim($this->session->userdata('NAMA_UNIT_KERJA'))).strtoupper(date("dFY"));
	    $this->load->view('export/export/excel',$data);

	} 
	function mpdfku($id=""){
		$this->load->library('mpdf');
		$data['judul']="tes";
		$data['view']='eyoy_ye';
		$html = $this->load->view('index', $data, true);
        $this->mpdf->setTitle('Posts');
        $this->mpdf->writeHTML($html);
 		$this->mpdf->Output();
	}
	function v($id="68"){
		$this->load->model("export_model"); 
		$data['judul']='Export Data Renja';
		$data['table']= strip_tags($this->export_model->get_data_rekap($id), '<table>'); ;		
		$info=$this->export_model->get_update($id);	
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['direktorat']=$info->dari;		 
		$data['kd_unit_kerja']=$info->kd_unit_kerja;		 
		$data['nama_user']=$info->nama_user;		 
		$data['view']='export/detail';
		$data['id']=$id; 
 	    $this->load->view('export/export/2',$data);
	}
	function e(){
		$this->load->library("PHPExcel/PHPExcel");
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
	                ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'Ini')
                    ->setCellValue('C3', 'Excel')
                    ->setCellValue('D4', 'Pertamaku');


        $objPHPExcel->getActiveSheet()->setTitle('RENJA');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="hasilExcel.xlsx"');
        $objWriter->save("php://output");
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */