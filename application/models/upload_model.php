<?php
class upload_model extends CI_Model
 {
     function __construct(){
         parent::__construct();
     }
     
 
    function get_data($limit='',$offset=''){
     		$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and a.dari='".$dari."'";
     		} else {
     			$sql=" and a.status='upload'";
     		}
     		$dari=$this->input->post('dari');
     		$tujuan=$this->input->post('tujuan');
			$query=$this->db->query("select *,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from upload a 
			left join t_user on t_user.id=a.add_by 
			where 1=1 and  a.dari like'%$dari%' and  a.kepada like'%$tujuan%'   $sql   order by a.id desc LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
     }     
    function count(){
			$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and upload.dari='".$dari."'";
     		} else {
     			$sql=" and upload.status='upload'";
     		}	
     		$dari=$this->input->post('dari');
     		$tujuan=$this->input->post('tujuan');

			$query=$this->db->query("select count(1) as jumlah from upload  
			left join t_user on t_user.id=upload.add_by 
			where 1=1 and  dari like'%$dari%' and   kepada like'%$tujuan%'  $sql");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
 	function get_url_file($id=""){
 		$query=$this->db->query("select a.url  from upload a where id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->url;
				}
				return $menus;
			}
 	}
 	function get_file_name($id=""){
 		$query=$this->db->query("select a.nama_file  from upload a where id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->nama_file;
				}
				return $menus;
			}
 	}
	function get_update($id=""){
     	$query=$this->db->query("select *,(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  from upload a where a.id='$id'");
		return 	$query->row();
    }
   
    function get_kepada($id=''){
		$sql="";
		$selected_pusat="";
		$opsi_pilihan_direktorat="";
    	$status_user=$this->session->userdata('STATUS');
      	if($status_user=="1"){
     		$sql=" and pusat='1'";
     		$selected_pusat=" selected='selected' ";
     		$opsi_pilihan_direktorat="";
     	}  else {
     		$opsi_pilihan_direktorat="<option value=''>-Pilih Direktorat Tujuan-</option>";
     	}

		$select="";
		$select.="<select id='kepada' class='form-control' style='width:300px' name='kepada'>";
		$select.=$opsi_pilihan_direktorat;
		$q2 = $this->db->query("select * from m_unit_kerja where 1=1 ".$sql." order by nama_unit_kerja asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($id==$row->id_divisi){
					 $selected="selected='selected'";
				 }
				 $select.="<option $selected $selected_pusat value='$row->id_divisi'>$row->nama_unit_kerja</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function simpan($newname="",$nama_file=""){
		$id=$this->input->post('id');
		$judul=$this->input->post('judul');
		$note=$this->input->post('note');
		$kepada=$this->input->post('kepada');
		$is_pusat=$this->session->userdata('STATUS');
		$status="";
		if($is_pusat=="1"){
			$status='download';
		}  else {
			$status='upload';
		}
		if (strpos($newname,'.') !== false) {
		    $data=array(
		 	 'judul'=>$judul,
			 'note'=>$note,
			 'tanggal'=>date("Y-m-d"),
			 'jam'=>date("H:m:i"),
			 'url'=>$newname,
			 'dari'=>$this->session->userdata('ID_DIREKTORAT'),
			 'kepada'=>$kepada,
			 'status'=>$status,
			 'nama_file'=>$nama_file,
			 'add_by'=>$this->session->userdata('ID_USER'),
			 'status_baca'=>"1",
			);
		} else {
			 $data=array(
		 	 'judul'=>$judul,
			 'note'=>$note,
			 'tanggal'=>date("Y-m-d"),
			 'jam'=>date("H:m:i"),
			 'dari'=>$this->session->userdata('ID_DIREKTORAT'),
			 'kepada'=>$kepada,
			 'status'=>$status,
			 'add_by'=>$this->session->userdata('ID_USER'),
			 'status_baca'=>"1",
			);
		}

		
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('upload',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('upload', $data); 
			$this->db->trans_complete();
		}	
		$this->load->model("init"); 
		$this->init->simpan_log('MELAKUKAN PENAMBAHAN / PERUBAHAN DATA RENJA');
		redirect(base_url()."upload");
	}
	function delete_data($id=""){
		$this->load->model("init"); 
		$this->init->simpan_log('MELAKUKAN PENGHAPUSAN DATA RENJA');
		$this->db->delete('upload', array('id' => $id)); 
	}
	function filter_dari($id=''){	 
		$select="";
		$select.="<select id='dari' onchange='return refreshtable()' class='form-control input-sm pull-left' style='width:300px;margin-right:10px' name='dari'>";
		$select.="<option value=''>-Pilih Direktorat Dari </option>";
		$q2 = $this->db->query("select * from m_unit_kerja  order by nama_unit_kerja asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $select.="<option value='$row->id_divisi'>$row->nama_unit_kerja</option>";
			}
		}
		$select.="</select>";
		return $select;
	} 
	function filter_tujuan($id=''){	 
		$select="";
		$select.="<select id='tujuan' onchange='return refreshtable()' class='form-control input-sm' style='width:300px;' name='tujuan'>";
		$select.="<option value=''>-Pilih Direktorat Tujuan </option>";
		$q2 = $this->db->query("select * from m_unit_kerja  order by nama_unit_kerja asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $select.="<option  value='$row->id_divisi'>$row->nama_unit_kerja</option>";
			}
		}
		$select.="</select>";
		return $select;
	} 
}		
 ?>
