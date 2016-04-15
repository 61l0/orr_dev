<?php
class user_model extends CI_Model{ 

	function user_model()
	{
		parent::__construct();
	}
	function cek(){
		$username=$this->input->post('username');
		$username = str_replace("'", "", $username);
		$password=md5($this->input->post('password'));
		$query=$this->db->query("select *,m_unit_kerja.nama_unit_kerja,t_user.nama,t_user.nik,
		t_user.username,t_user.password,t_user.id as id_user,
		t_user.status,t_user.role ,m_unit_kerja.id_divisi as divisi
		from t_user 
		left join m_unit_kerja on m_unit_kerja.id_divisi=t_user.unit
		where username='$username' and password='$password'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$data=array('LOGIN'=>TRUE,
						'NAMA'=>$data->nama,
						'STATUS'=>$data->status,
						'NIK'=>$data->nik,
						'ROLE'=>$data->role,
						'ID_DIREKTORAT'=>$data->unit,
 						'ID_DIVISI'=>$data->divisi,
						'NAMA_UNIT_KERJA'=>$data->nama_unit_kerja,
						'ID_USER'=>$data->id_user,
						'KODE_DIREKTORAT'=>$data->kd_unit_kerja,
						'PUSAT'=>$data->pusat
 						);
					$this->session->set_userdata($data);
					$this->load->model("init"); 
					$this->init->simpan_log('MASUK KE DALAM SISTEM');
					redirect('home/index');		
				}
			} else {
				redirect('home/login');
			}			
	}
	function getMenu(){
			$menus='';
			$role=$this->session->userdata('ROLE');
			$query=$this->db->query("select * from t_menu where role='$role' and aktif='1' order by urut ASC");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus .="<li><a href='".base_url().$data->url."'><i class='icon-tasks'></i>".$data->name."</a></li> ";
				}
				return $menus;
			}
	}
	function getRole(){
		$query=$this->db->query("select * from t_role");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
	}	
	function getDataPegawai($id=''){
			$query=$this->db->query("select * from t_user
			 	where t_user.id='$id'");
			return $query->row();
	}
	function detailPegawai($nik=''){
		$nik=$this->input->post('nik');
			$query=$this->db->query("select nama from pegawai
			where pegawai.nik='$nik'");			
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					echo $data->nama;
				}
 			}
	}

	function count($id=''){
		$jumlah='';
		$judul=$this->input->post('judul');
		$status=$this->session->userdata('STATUS');
		
		$query=$this->db->query("select count(1) as jumlah from t_user 
		left join m_unit_kerja on m_unit_kerja.id_divisi=t_user.unit
		");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
	}
	function get_data($limit='',$offset=''){
			$menus='';
			$judul=$this->input->post('judul');
			$query=$this->db->query("select *,t_user.id as iduser,t_role.role as namarole from t_user 
				left join t_role on t_role.id=t_user.role
				left join m_unit_kerja on m_unit_kerja.id_divisi=t_user.unit
				order by t_user.id desc   LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
	}
	function cekUser(){
			$username=$this->input->post('username');
			$id=$this->input->post('id');
			$query=$this->db->query("select count(1) as jumlah from t_user where username='$username' and id !='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
	}
	function simpan(){
 		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		$tipeuser=$this->input->post('tipeuser');
		$role=$this->input->post('role');
		$nama=$this->input->post('nama');
		$unit=$this->input->post('unit');
		$nik=$this->input->post('nik');
		$email=$this->input->post('email');
 		$id=$this->input->post('id');
		$temp_password=($this->input->post('password'));

		$data=array(
		 'nik'=>$nik,	
	 	 'username'=>$username,
		 'nama'=>$nama,
		 'password'=>$password,
		 'status'=>$tipeuser,
 		 'role'=>$role,
 		 'unit'=>$unit,
 		 'email'=>$email,
		);
	 

		if($id==''){
		$this->db->trans_start();
		$this->db->insert('t_user',$data);
		$this->db->trans_complete(); 		 	
		} else {
			if($temp_password==''){
			  
			$this->db->query("update t_user set role='$role', nik='$nik',  email='$email', username='$username',  unit='$unit', nama='$nama', status='$tipeuser' where id='$id'");	
			 } else if ($temp_password!=''){
			 	 
			$this->db->query("update t_user set role='$role' ,nik='$nik',email='$email',  username='$username',  unit='$unit',   password='$password', nama='$nama', status='$tipeuser' where id='$id'");	
			 }	
		}
		}
	function simpan_change_pass(){
 		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
 
		$nama=$this->input->post('nama');
 
		$nik=$this->input->post('nik');
 		$id=$this->input->post('id');
		$temp_password=($this->input->post('password'));

		$cek=$this->cekUser();
		if($cek > 0) {
			echo "Username Sudah Tersedia , Harap Diganti !!!!";
			return false;
		}
		$data=array(
		 'nik'=>$nik,	
	 	 'username'=>$username,
		 'nama'=>$nama,
		 'password'=>$password,
		);
	 

		if($id==''){
		$this->db->trans_start();
		$this->db->insert('t_user',$data);
		$this->db->trans_complete(); 		 	
		} else {
			if($temp_password==''){
				$this->db->query("update t_user set   nik='$nik', username='$username',   nama='$nama'   where id='$id'");	
			 } else if ($temp_password!=''){
			 	$this->db->query("update t_user set  nik='$nik', username='$username',    password='$password', nama='$nama'   where id='$id'");	
			 }	
		}
	}	
	function deleteuser($id){
			$this->db->query("delete from t_user where id='$id'");	
	}
	function get_parent($id=''){
		$select="";
		$select.="<select id='parent' class='form-control input-sm' name='parent' style='width:200px'>";
		$select.="<option value=''>-Pilih Parent-</option>";
		$q2 = $this->db->query("select * from t_menu order by name asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($id==$row->id){
				 $selected="selected='selected'";
				 }
				 $select.="<option $selected value='$row->id'>$row->name</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function get_unit($id=''){
		$select="";
		$select.="<select id='unit' class='form-control input-sm' name='unit' style='width:200px'>";
		$select.="<option value=''>-Pilih Unit-</option>";
		$q2 = $this->db->query("select * from m_unit_kerja order by nama_unit_kerja asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($id==$row->id_divisi){
				 $selected="selected='selected'";
				 }
				 $select.="<option $selected value='$row->id_divisi'>$row->nama_unit_kerja</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>