<?php
class kirim_email_model extends CI_Model{ 

	function kirim_email_model()
	{
		parent::__construct();
	}
	function get_data($limit='',$offset=''){
			$menus='';
			$email=$this->input->post('email');		 
			$addTag="";
			$query=$this->db->query("select *   from kirim_email 
			where kirim_email.email like'%$email%'
			order by id DESC
			LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}
	}
	function count(){
			$email=$this->input->post('email');		
			$query=$this->db->query("select count(1) as jumlah from kirim_email where kirim_email.email like'%$email%'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function get_data_user(){
		$query=$this->db->query("select *,t_user.id as iduser,t_role.role as namarole from t_user 
				left join t_role on t_role.id=t_user.role
				left join m_unit_kerja on m_unit_kerja.id_divisi=t_user.unit
				order by t_user.id desc   ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}
	}
	function getUpdate($id=''){
			$query=$this->db->query("select * from m_unit_kerja where id_divisi='$id'");
			return $query->row();
	}
		 
	function act(){
		$id=$this->input->post('id');
		$subjek=$this->input->post('subjek');
		$nama=$this->input->post('nama');
		$pesan=$this->input->post('pesan');
		$email=$this->input->post('email');
		$data=array(
	 	 'email'=>$email,
		 'pesan'=>$pesan,
		 'subjek'=>$subjek,
		 'tanggal'=>date('Y-m-d')
		);
		$this->db->trans_start();
		$this->db->insert('kirim_email',$data);
		$this->db->trans_complete();
		$this->send_mail();
	}
	function send_mail(){
		$id=$this->input->post('id');
		$subjek=$this->input->post('subjek');
		$nama=$this->input->post('nama');
		$pesan=$this->input->post('pesan');
		$email=$this->input->post('email');

		$this->load->library('email');
	    $this->email->from('biskemendagri@gmail.com', 'Administrator Ditjen Bina Pembangunan Daerah');
	    $this->email->to($email);	 
	    $this->email->subject($subjek);
	    $this->email->message($pesan);
		$this->email->send(); 
	} 
   
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>