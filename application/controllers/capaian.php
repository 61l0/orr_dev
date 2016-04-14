<?php  

class capaian extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function capaian() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){

 	
 	   $this->load->model("capaian_renja_model");     
  
 	   $data['judul']='Data Capaian Renja'; 
       $data['view']='capaian/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("capaian_renja_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->capaian_renja_model->count();
		$config['base_url'] = base_url().'capaian/search/';
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
		$data['query']=$this->capaian_renja_model->get_data($limit,$offset);
		$this->load->view('capaian/data',$data);
	}
	function get_total_capaian($id="",$table=""){
		$this->load->model("capaian_renja_model");     
		$this->capaian_renja_model->get_total_capaian($id);  
	} 
	function delete_data($id=""){
		$this->load->model("capaian_renja_model");     
		$this->capaian_renja_model->delete_data($id);     
	}
	function hapus_detail_dokumen($id=""){
		$this->load->model("capaian_renja_model");     
		$this->capaian_renja_model->hapus_detail_dokumen($id);   
	} 
	function download_app($id=""){
		
		$this->load->helper('download');

		$this->load->model("capaian_renja_model");  
		$info=$this->capaian_renja_model->get_download_dokumen($id);
 		$data = file_get_contents("uploads/".$info->url); // Read the file's contents
		$name = $info->nama_dokumen;
		force_download($name, $data);
	}
	function rekap_renja($id=""){
		$this->load->model("capaian_renja_model"); 
		
		/*$data['table_capaian_kinerja']=$this->capaian_renja_model->get_data_rekap($id,1);
		$data['table_capaian_keuangan']=$this->capaian_renja_model->get_data_rekap($id,2);
		$data['table_capaian_phln']=$this->capaian_renja_model->get_data_rekap($id,3);
		$data['table_capaian_dktp']=$this->capaian_renja_model->get_data_rekap($id,4);
		$data['table_capaian_lakip']=$this->capaian_renja_model->get_data_rekap($id,5);
		$data['table_capaian_renaksi']=$this->capaian_renja_model->get_data_rekap($id,6);*/
		 
		$info=$this->capaian_renja_model->get_update($id);			
		$data['target_capaian']=$this->capaian_renja_model->get_target_capaian($id);	
		$data['capaian_dktp_realisasi']=$info->capaian_dktp_realisasi;
		$data['capaian_dktp_target']=$info->capaian_dktp_target;
		$data['capaian_keuangan_realisasi']=$info->capaian_keuangan_realisasi;
		$data['capaian_keuangan_target']=$info->capaian_keuangan_target;
		$data['capaian_kinerja_realisasi']=$info->capaian_kinerja_realisasi;
		$data['capaian_kinerja_target']=$info->capaian_kinerja_target;
		$data['capaian_phln_realisasi']=$info->capaian_phln_realisasi;
		$data['capaian_phln_target']=$info->capaian_phln_target;
		$data['capaian_renaksi_realisasi']=$info->capaian_renaksi_realisasi;
		$data['capaian_renaksi_target']=$info->capaian_renaksi_target;

		/* GET KEWENANGAN MAKE TAB */
		$data['nama_capaian_nya']="";
		$data['get_kewenangan']=$this->capaian_renja_model->get_kewenangan();
		/*-------------------------*/
		$data['status_perbaikan']=$info->status_perbaikan;
		$data['tahun_anggaran']=$info->tahun_anggaran;	
		$data['id_tahun_anggaran']=$info->id_tahun_anggaran;
		$data['direktorat']=$info->dari;
		$data['judul']='Capaian - '. $data['direktorat'] ;		 
		$data['view']='capaian/detail';
		$data['id']=$id; 
	    $this->load->view('index',$data);
	}
	function detail_capaian($id=""){
		$this->load->model("capaian_renja_model"); 
		$data['query']=$this->capaian_renja_model->get_data_detail($id);
		$this->load->view('capaian/status_detail',$data);
	}
	function simpan_persetujuan(){
		$this->load->model("capaian_renja_model"); 
		$this->capaian_renja_model->simpan_persetujuan();
	}
	function load_komparasi($id="",$table=""){
		$this->load->model("capaian_renja_model"); 
		$info=$this->capaian_renja_model->get_update($id);	
		$data['direktorat']=$info->dari;
		$data['tabelnya']=$this->capaian_renja_model->table_komparasi($id,$table);
		$data['selisih']=$this->capaian_renja_model->get_selisih_all($id,$table);
 		
		//echo $data['capaian_kinerja_target']."<br>";
		//echo $data['capaian_kinerja']."<br>";

		$data['id']=$id; 
		$this->load->view('capaian/perbandingan/perbandingan',$data);
	}
	function simpan_persentase_target(){
		$this->load->model("capaian_renja_model"); 
		$this->capaian_renja_model->simpan_persentase_target();
	}
	function cek_is_open_lock($tipe=""){
 		$this->load->model("capaian_renja_model");
		$bulan=$this->session->userdata('bulan');
		$tipe_capaian=$this->session->userdata('tipe_capaian');
		return $this->capaian_renja_model->cek_is_open_lock($tipe_capaian,$bulan);
	}
	function status_locking_is_disetujui($tipe=""){
		$this->load->model("capaian_renja_model");
		return $this->capaian_renja_model->status_locking_is_disetujui($tipe);
	}
	function simpan_target(){
		$jumlah=$this->input->post('value');
		$this->load->model("capaian_renja_model"); 
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$tipe_analisis=$this->input->post('tipe_analisis');
		$status_locking=$this->cek_is_open_lock('capaian_target');
		$status_locking_is_disetujui=$this->status_locking_is_disetujui('target');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}
		if($status_locking_is_disetujui=="1"){
			echo "<i class='glyphicon glyphicon-lock'></i> Data Capaian Sudah Disetujui , Perubahan Tidak Bisa Dilakukan ....";
			return false;
		}
		if(!is_numeric($jumlah)){
			echo "Nominal Harus Bilangan Angka";
			return false;
		} else {
			if($tipe_analisis!="kinerja"){
				$this->load->model("capaian_renja_model"); 
				$this->capaian_renja_model->simpan_selain_kinerja_target();
			} else {				 
				$this->load->model("capaian_renja_model"); 
				$this->capaian_renja_model->simpan_target();
			}
		}
	} 

	function simpan_realisasi(){
		$jumlah=$this->input->post('value');
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$jumlah=trim($jumlah);
		$tipe_analisis=$this->input->post('tipe_analisis');
		$status_locking=$this->cek_is_open_lock('capaian_realisasi');
		$status_locking_is_disetujui=$this->status_locking_is_disetujui('realisasi');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}
		if($status_locking_is_disetujui=="1"){
			echo "<i class='glyphicon glyphicon-lock'></i> Data Capaian Sudah Disetujui , Perubahan Tidak Bisa Dilakukan ....";
			return false;
		}
		if(!is_numeric($jumlah)){
			echo "Nominal Harus Bilangan Angka";
			return false;
		} else {
			if($tipe_analisis!="kinerja"){
				$this->load->model("capaian_renja_model"); 
				$this->capaian_renja_model->simpan_selain_kinerja_realisasi();
			} else {
				$this->load->model("capaian_renja_model"); 
				$this->capaian_renja_model->simpan_realisasi();
			}
		}
	} 
	function get_deskrpsi(){
		$this->load->model("capaian_renja_model"); 
		//$this->capaian_renja_model->get_deskrpsi(); 
		$bulan=$this->session->userdata('bulan');
		$tipe_capaian=$this->session->userdata('tipe_capaian');
		$table_add="";
		$table="";
		$kinerja_or_keuangan=$this->session->userdata('kinerja_or_keuangan');
		if($tipe_capaian=="capaian_target"){
			$table_add="_target";
		}
		if($kinerja_or_keuangan=="0"){
			$table="capaian_kinerja";
		} else {
			$table="capaian_keuangan";
		}
  		$kode="";
		$parent="";
		$kode_direktorat_child="";
		$tahun_berlaku="";
		$table=$table.$table_add;
		$id_template_renja=$this->session->userdata('id_template_renja');
		$query=$this->db->query("select a.kode,a.parent,a.kode_direktorat_child,a.tahun_berlaku,m_unit_kerja.id_divisi as id_divisi,
		(select id from tahun_anggaran where tahun_anggaran=a.tahun_berlaku) as tahun_berlaku
		from data_template_renja a 
		left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child
		where a.id='".$id_template_renja."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$kode=$data->kode;
					$parent=$data->parent;
					$kode_direktorat_child=$data->kode_direktorat_child;
					$tahun_berlaku=$data->tahun_berlaku;
				}
 			}
  		$query2=$this->db->query("select d_".$bulan." as deskripsi from ".$table." where kode='".$kode."' and parent='".$parent."' and tahun='".$tahun_berlaku."'");
 			 if ($query2->num_rows() > 0) {
				foreach ($query2->result() as $row) {
					echo $row->deskripsi;
 				}
 			}
		

	}
	function simpan_bulan($bulan="",$tipe="",$target_or_realisasi="",$id_template_renja="",$kinerja_or_keuangan=""){
		$panjang=strlen($bulan);
		$tipe_capaian="";
		if($panjang=="1"){
			$bulan='0'.$bulan;
		}
		if($tipe=="0"){
			$tipe_capaian="capaian_target";
		} else {
			$tipe_capaian="capaian_realisasi";
		}
		$data=array(
			'bulan'=>$bulan,
			'tipe_capaian'=>$tipe_capaian,
			'target_or_realisasi'=>$target_or_realisasi,
			'id_template_renja'=>$id_template_renja,
			'kinerja_or_keuangan'=>$kinerja_or_keuangan
		);
		$this->session->set_userdata($data);
	}
	function tele(){
		echo date("m");
	}
	function refresh(){
		$id=$this->input->post('id');
		$this->load->model("capaian_renja_model"); 
		$data['table']=$this->capaian_renja_model->get_data_rekap($id);
		echo  $data['table'];
	}
	function load_capaian_lainnya($id="",$id_kewenangan=""){
		$this->load->model("capaian_renja_model"); 
		$data['table_capaian']=$this->capaian_renja_model->load_capaian_lainnya($id,$id_kewenangan);
		$data['nama_capaian_nya']="";
		echo $data['table_capaian'];
	}
	function load_capaian_realisasi($id="",$tipe_capaian=""){
		$this->load->model("capaian_renja_model"); 
		$data['table_capaian']=$this->capaian_renja_model->get_capaian_realisasi($id,$tipe_capaian);
		echo $data['table_capaian'];
	} 
	function load_capaian_all($id="",$tipe_capaian=""){
		$this->load->model("capaian_renja_model"); 
		$data['table_capaian']=$this->capaian_renja_model->get_capaian_all($id,$tipe_capaian);
		echo $data['table_capaian'];
	}
	function load_capaian_target($id="",$tipe_capaian=""){
		$this->load->model("capaian_renja_model"); 
		$data['table_capaian']=$this->capaian_renja_model->get_capaian_target($id,$tipe_capaian);
		echo $data['table_capaian'];
	} 
	function export_excel(){
		$this->load->model("capaian_renja_model"); 
		$data['judul']='Export Renja';
		$data['tahun_anggaran']=$this->capaian_renja_model->filter_tahun_anggaran();
		$data['get_direktorat']=$this->capaian_renja_model->filter_get_direktorat();
		$data['table']=$this->capaian_renja_model->get_data_export();				 
		$data['view']='capaian/export'; 
	    $this->load->view('index',$data);
	}
	function refresh_export(){
		$id=$this->input->post('id');
		$this->load->model("capaian_renja_model"); 
		$data['table']=$this->capaian_renja_model->get_data_export();	
 		echo  $data['table'];
	}
	function export_now(){
		$this->load->model("capaian_renja_model"); 
		$data['table']=$this->capaian_renja_model->get_data_export();	
		$data['file_name']="LAPORAN_RENJA_".date("YMDHIS");
		$this->load->view('capaian/export/excel',$data);
		 
	}
	function get_executiv_view($id_direktorat=""){
		$this->load->model("capaian_renja_model"); 
		$data['judul']="Executiv View";
		$this->load->view('capaian/dashboard/dashboard',$data);
	}
	function get_total_capaian_keuangan($id_direktorat=""){
		$this->load->model("capaian_renja_model"); 
		$data['id']=$id_direktorat;
		$data['capaian_renja']=$this->capaian_renja_model->cek_total_data_renja($id_direktorat,'keuangan');
		$data['capaian']=$this->capaian_renja_model->get_capaian_for_dashboard($id_direktorat,'2');
		//if($data['capaian_renja']!="0") {
			$data['series']=$this->capaian_renja_model->get_total_capaian_keuangan($id_direktorat);
			$this->load->view('capaian/dashboard/capaian_keuangan',$data);
		//} else {
		//	echo "<h4><i class='glyphicon glyphicon-remove'></i> Data Tidak Tersedia</h4>";
		//}
	}
	function get_total_capaian_kinerja($id_direktorat=""){
		$this->load->model("capaian_renja_model"); 
		$data['id']=$id_direktorat;
		$data['capaian_renja']=$this->capaian_renja_model->cek_total_capaian_kinerja($id_direktorat);	 
		//if(($data['capaian_renja']!="0") and ($data['capaian_renja']!="")) {
			$data['series']=$this->capaian_renja_model->get_total_capaian_kinerja($id_direktorat);
			$this->load->view('capaian/dashboard/capaian_kinerja',$data);
		//} else if (($data['capaian_renja']=="") or ($data['capaian_renja']=="0")){
		//	echo "<h4><i class='glyphicon glyphicon-remove'></i> Data Tidak Tersedia</h4>";
		//}
		 
	}
	
	function get_total_capaian_phln($id_direktorat=""){
		$this->load->model("capaian_renja_model"); 
		$data['id']=$id_direktorat;
		$data['capaian_renja']=$this->capaian_renja_model->cek_total_data_renja($id_direktorat,'phln');
		$data['capaian']=$this->capaian_renja_model->get_capaian_for_dashboard($id_direktorat,'3');
		//if($data['capaian_renja']!="0") {
			$data['series']=$this->capaian_renja_model->get_total_capaian_phln($id_direktorat);
			$this->load->view('capaian/dashboard/capaian_phln',$data);
		//} else {
		//	echo "<h4><i class='glyphicon glyphicon-remove'></i> Data Tidak Tersedia</h4>";
		//}
	}
	function get_total_capaian_dktp($id_direktorat=""){
		$this->load->model("capaian_renja_model"); 
		$data['id']=$id_direktorat;
		$data['capaian_renja']=$this->capaian_renja_model->cek_total_data_renja($id_direktorat,'dktp');
		$data['capaian']=$this->capaian_renja_model->get_capaian_for_dashboard($id_direktorat,'4');
		//if($data['capaian_renja']!="0") {
			$data['series']=$this->capaian_renja_model->get_total_capaian_dktp($id_direktorat);
			$this->load->view('capaian/dashboard/capaian_dktp',$data);
		//} else {
			//echo "<h4><i class='glyphicon glyphicon-remove'></i> Data Tidak Tersedia</h4>";
		//}
	}
	function get_total_capaian_renaksi($id_direktorat=""){
		$this->load->model("capaian_renja_model"); 
		$data['id']=$id_direktorat;
		$data['capaian_renja']=$this->capaian_renja_model->cek_total_data_renja($id_direktorat,'renaksi');
		$data['capaian']=$this->capaian_renja_model->get_capaian_for_dashboard($id_direktorat,'6');
		//if($data['capaian_renja']!="0") {
			$data['series']=$this->capaian_renja_model->get_total_capaian_renaksi($id_direktorat);
			$this->load->view('capaian/dashboard/capaian_renaksi',$data);
		//} else {
			//echo "<h4><i class='glyphicon glyphicon-remove'></i> Data Tidak Tersedia</h4>";
		//}
	}
	function get_detail($tipe_capaian="",$direktorat=""){
			$this->load->model("capaian_renja_model"); 
			$data['nama_capaian']="";
			if($tipe_capaian=="1"){
		        $data['nama_capaian']="Capaian Kinerja";
	        } else  if($tipe_capaian=="2"){
		        $data['nama_capaian']="Capaian Keuangan";
	        } else  if($tipe_capaian=="3"){
		        $data['nama_capaian']="Capaian PHLN";
	        } else  if($tipe_capaian=="4"){
		        $data['nama_capaian']="Capaian DKTP";
	        } else  if($tipe_capaian=="5"){
		        $data['nama_capaian']="Capaian LAKIP";
	        } else  if($tipe_capaian=="6"){
		        $data['nama_capaian']="Capaian RENAKSI";
	        }
	        $info=$this->capaian_renja_model->get_update($direktorat);	
			 $data['tahun_anggaran']=$info->tahun_anggaran;	
		 	$data['series']=$this->capaian_renja_model->get_detail($tipe_capaian,$direktorat);
		 	//echo "DATA LOADED";
			 $this->load->view('capaian/dashboard/detail_per_bulan',$data);
	}
	function export_excel_atu_atu_sob($id_renja="",$tipe="",$jenis="",$komparasi=""){
		$this->load->model("capaian_renja_model"); 
		if($tipe=="1"){
           $data['file_name']="CAPAIAN KINERJA DAN KEUANGAN";
           $data['judul']=strtoupper("CAPAIAN KINERJA DAN KEUANGAN");
        } else  if($tipe=="2"){
           $data['file_name']="CAPAIAN KEUANGAN";
           $data['judul']=strtoupper("Capaian Keuangan");
        } else  if($tipe=="3"){
           $data['file_name']="CAPAIAN PHLN";
           $data['judul']=strtoupper("Capaian PHLN");
        } else  if($tipe=="4"){
           $data['file_name']="CAPAIAN DKTP";
           $data['judul']=strtoupper("Capaian DKTP");
        } else  if($tipe=="5"){
           $data['file_name']="CAPAIAN LAKIP";
           $data['judul']=strtoupper("Capaian LAKIP");
        } else  if($tipe=="6"){
           $data['file_name']="CAPAIAN RENAKSI";
           $data['judul']=strtoupper("Capaian Renaksi");
		}
		if($jenis=="0"){
           $data['table']=$this->capaian_renja_model->get_capaian_target($id_renja,$tipe);
           $data['tipe']="Target ";
        } else  if($jenis=="1"){
           $data['table']=$this->capaian_renja_model->get_capaian_realisasi($id_renja,$tipe,$komparasi);
           $data['tipe']="Realisasi ";
        } 
		$this->load->model("capaian_renja_model"); 
 		$this->load->view('capaian/export/excel',$data);
	}
	function export_excel_atu_atu_sob_komparasi($id="",$table=""){
		$this->load->model("capaian_renja_model"); 
		$info=$this->capaian_renja_model->get_update($id);	
		$data['direktorat']=$info->dari;
		$data['tabelnya']=$this->capaian_renja_model->table_komparasi($id,$table);
		$data['selisih']=$this->capaian_renja_model->get_selisih_all($id,$table);
 	 
		if($table=="capaian_kinerja"){
           $data['file_name']="Capaian_Kinerja";
           $data['judul']=" Capaian Kinerja";
        } else  if($table=="capaian_keuangan"){
           $data['file_name']="Capaian_Keuangan";
           $data['judul']=" Capaian Keuangan";
        } else  if($table=="capaian_phln"){
           $data['file_name']="Capaian_PHLN";
           $data['judul']=" Capaian PHLN";
        } else  if($table=="capaian_dktp"){
           $data['file_name']="Capaian_DKTP";
           $data['judul']=" Capaian DKTP";
        } else  if($table=="capaian_lakip"){
           $data['file_name']="Capaian_LAKIP";
           $data['judul']= "Capaian LAKIP";
        } else  if($table=="capaian_renaksi"){
           $data['file_name']="Capaian_Renaksi";
           $data['judul']=" Capaian Renaksi";
		}
		$data['tipe']="Perbandingan Target dan Realisasi ";
		$data['id']=$id; 
		$this->load->view('capaian/export/excel_perbandingan',$data);
	}
	function echo_table_renja($id=""){
		$this->load->model("capaian_renja_model"); 
		$data['table']=$this->capaian_renja_model->get_data_rekap($id);	
		$this->load->view('capaian/table',$data);
	}
	function get_detail_dokumen($id=""){
		$this->load->model("capaian_renja_model"); 
		$data['judul']="Detail Dokumen";
		$data['id']=$id;
		
 
		$data['query']=$this->capaian_renja_model->get_detail_dokumen($id);	
		$kode_direktorat_child="";
		$tahun_berlaku="";
		$id_divisi="";
		$dari="";
		$query1=$this->db->query("select a.kode_direktorat_child,a.tahun_berlaku,m_unit_kerja.id_divisi as id_divisi,
		(select id from tahun_anggaran where tahun_anggaran=a.tahun_berlaku) as tahun_berlaku
		from data_template_renja a 
		left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child
		where a.id='".$id."'");
			if ($query1->num_rows() > 0) {
				foreach ($query1->result() as $datax) {
 				  $kode_direktorat_child=$datax->kode_direktorat_child;
 				  $tahun_berlaku=$datax->tahun_berlaku;
 				  $id_divisi=$datax->id_divisi;
 			}
 		} 
 		$query1=$this->db->query("select  dari as dari from template_renja a where a.dari='".$id_divisi."' and tahun_anggaran='".$tahun_berlaku."'");
			if ($query1->num_rows() > 0) {
				foreach ($query1->result() as $datax) {
					$data['dari']=$datax->dari;
  			}
 		} 
 		$this->load->view('capaian/detail_dokumen',$data);
	}
	function upload_file(){
		$this->load->model("capaian_renja_model"); 
		$targetFolder = 'uploads'; 
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		$name=date("Ymdsi").'';
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$userfile_name=$_FILES['Filedata']['name'];
			$ext = substr($userfile_name, strrpos($userfile_name, '.')+1);	
			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' .$name.'.'.$ext;			
			// Validate the file type
			$fileTypes = array('pdf','PDF','ppt','PPT','pptx','PPTX','jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG','doc','docx','txt','xls','xlsx',); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);			
			if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				//$this->do_resize($targetFile);
				$this->capaian_renja_model->update_upload($userfile_name,$name.'.'.$ext);
 				echo '1';
			} else {
				echo 'Invalid file type.';
			}
		}
	}
	function do_resize($file_name){
 		$image_upload_folder =$file_name;
 		$source_path = $image_upload_folder ;
		$target_path = 'uploads/avatar/';
		$config_manip = array(
			'image_library' => 'gd2',
			'source_image' => $source_path,
			'new_image' => $target_path,
			'maintain_ratio' => TRUE,
			'width' => 250,
			'height' => 250
		);
		$this->load->library('image_lib', $config_manip);
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}
		// clear //
		$this->image_lib->clear();
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */