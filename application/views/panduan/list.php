 	<script>
 		$(document).ready(function () {
    	 $("#judul_header").hide();
		});

 	</script>
 	<style type="text/css">
  
    .full_img {
    width: 100%;
    height: auto;
    max-width: 100%;
}
 img{
     border-color: #ecf0f1;
  margin-bottom: 21px;
  background-color: #ffffff;
  border: 1px solid transparent;
  border-radius:0px;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
 
 }
</style>

 <h3><i class="glyphicon glyphicon-cog"></i> Struktur Renja</h3>

 <div class="panel panel-default">
  <div class="panel-body">
    <img class="full_img"  src="<?php echo base_url();?>images/panduan/struktur_renja.png">
  </div>
  <div class="panel-footer"><center><b>Struktur Excel Renja</b></center></div>
</div>

<div class="bs-callout bs-callout-warning" id="callout-btn-group-anchor-btn">
	<div class="alert alert-info" role="alert">
    	 <h4 style="margin:0px"><i class="glyphicon glyphicon-th"></i> Struktur Renja Yang Digunakan</h4>
	</div>

	     <h5 style="margin-left:20px"><b>1.</b>&nbsp;&nbsp;<b>Program</b> harus berada pada kolom ( <b>A</b> ) dan urutan kolom No ( <b>1</b> ).</h5>
	     <h5 style="margin-left:20px"><b>2.</b>&nbsp;&nbsp;<b>Indikator</b> Berada  Dibawah Program Dengan Urutan Berupa Angka  contoh ( <b> 1 , 2 , 3 , 4 , 5 </b> ).</h5>
	     <h5 style="margin-left:20px"><b>3.</b>&nbsp;&nbsp;<b>Komponen Input </b>  Berada dibawah Indikator , Dengan Format Penomoran 
	     Berupa Urutan <b>Indikator</b> dan Urutan Turunan Pada <b>Komponen Input</b> Contoh <i class="glyphicon glyphicon-arrow-down"></i>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <br> <br> <span style="color:red;font-size:20px">
	      &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>1</b> . Indikator<br>
	      &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>1.1 </b> . Komponen Input </span>
	     </h5>
	     <h5 style="margin-left:20px"><b>4.</b>&nbsp;&nbsp;Sub Komponen Input / Tahapan Berada Dibawah Komponen Input , dengan urutan berupa karakter kecil yaitu <b>(a , b , c , d , e , f , g , h)</b>  Contoh  <i class="glyphicon glyphicon-arrow-down"></i>   
	     <br> <br> <span style="color:red;font-size:20px">
	      &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>1</b> . Indikator<br>
	      &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>1.1 </b> . Komponen Input <br>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>a </b> . Sub Komponen Input / Tahapan </span><br>
	     </h5>
	     <h5 style="margin-left:20px"><b>5.</b>&nbsp;&nbsp;Struktur tersebut wajib diikuti karena akan mempengaruhi proses perhitungan pada aplikasi .</h5>
	     <h5 style="margin-left:20px"><b>6.</b>&nbsp;&nbsp;Bila kolom "TAHAPAN" Digunakan Sebaiknya ditampilkan / Jangan di "HIDE" / "DISEMBUNYIKAN" Dari excel nya </h5>
</div>
<br><br>
<div class="bs-callout bs-callout-warning" id="callout-btn-group-anchor-btn">
	<div class="alert alert-warning" role="alert">
	    	 <h4 style="margin:0px"><i class="glyphicon glyphicon-th"></i> Permulaan / Memulai Dari Awal  Alur Aplikasi RENJA</h4>
	</div>
	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">1</a> . </b>&nbsp;&nbsp;Menyediakan template renja pada  <b>"KERTA KERJA /  SHEETS"</b>  <b>
	("RENJA_UTAMA") . </b> Template tersebut sudah tersedia item/komponen yang diperlukan .</h5>
	 	 <center><div style="width:90%" class="panel panel-default">
		  <div class="panel-body">
		    <img style="width:90%" src="<?php echo base_url();?>images/panduan/renja_utuh.png">
		  </div>
		  <div class="panel-footer"><center><b>Kebutuhan Awal Renja</b></center></div>
		</div></center>

	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">2</a> .</b>&nbsp;&nbsp;Melakukan <b>"COPY DATA"</b> ke setiap <b>"KERTA KERJA / SHEETS"</b> direktorat .</h5>
	 	 <center><div style="width:90%" class="panel panel-default">
		  <div class="panel-body">
		    <img style="width:90%" src="<?php echo base_url();?>images/panduan/tahap_copy.png">
		    <div style="margin-left:32px">
		    <h5 style="margin-left:20px;text-align:left"><b>1.</b>&nbsp;&nbsp; 
			    Pastikan anda berada di Kertas Kerja / Sheets <b>"RENJA_UTAMA" .</b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>2.</b>&nbsp;&nbsp; 
			    Pilih Menu <b>"ADS INS"</b> Kemudian Pilih Menu <b>"RENJA"</b>  </b> .</b>
		    </h5>
			<h5 style="margin-left:20px;text-align:left"><b>3.</b>&nbsp;&nbsp; 
			    Kemudian Pilih Kembali Sub Menu <b>"COPY FORM"</b> .</b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>4.</b>&nbsp;&nbsp; 
			    Maka akan muncul form <b>"COPY"</b> , Pilih Opsi <b>"DARI RENJA UTAMA MENUJU DIREKTORAT". </b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>5.</b>&nbsp;&nbsp; 
			    Tentukan tujuan direktorat yang akan dituju.  </b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>6.</b>&nbsp;&nbsp; 
			    Klik Tombol <b>"OK"</b>  </b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>7.</b>&nbsp;&nbsp; 
			     Bila sudah sukses maka akan muncul pesan <b>"SUKSES MELAKUKAN COPY DATA"</b>
		    </h5>
		    <img  src="<?php echo base_url();?>images/panduan/sukses_copy.png">
		    <h5 style="margin-left:20px;text-align:left"><b>7.</b>&nbsp;&nbsp; 
			     Setelah Itu maka kita lihat hasilnya pada <b>"Kertas Kerja / Sheets"</b>  Direktorat , datanya akan sama persis dengan hasil data pada <b> <br> &nbsp; &nbsp; &nbsp; &nbsp;"KERTA KERJA  SHEETS" ,"RENJA_UTAMA"</b>
		    </h5>
		    <img style="width:90%" src="<?php echo base_url();?>images/panduan/hasil_copy.png">
		    </div>
		  </div>
		  <div class="panel-footer"><center><b>Tahapan Copy</b></center></div>
		</div></center>

	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">3</a> .</b>&nbsp;&nbsp;
	Tahapan Selanjutnya adalah Melakukan <b>"EXPORT DATA"</b> ke setiap "FILE" yang akan diberikan kepada direktorat .</h5>	
	<center>
	<div style="width:90%" class="panel panel-default">
		  <div class="panel-body">
		    
		    <div style="margin-left:32px">
		    <h5 style="margin-left:20px;text-align:left"><b>1.</b>&nbsp;&nbsp; 
			   File yang akan diberikan kepada <b>DIREKTORAT</b> terkait .</b>
		    </h5>
		    </div>
		    <img style="width:90%" src="<?php echo base_url();?>images/panduan/file_direktorat.png">
		    <img style="width:90%" src="<?php echo base_url();?>images/panduan/tahapan_export_satu.png">
		    <h5 style="margin-left:20px;text-align:left"><b>2.</b>&nbsp;&nbsp; 
			     Pilih Menu <b>"ADS INS"</b> Kemudian Pilih Menu <b>"IMPORT"</b>  </b> .</b></b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>3.</b>&nbsp;&nbsp; 
			    Kemudian Pilih <b>"TOOLS' </b> .</b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>4.</b>&nbsp;&nbsp; 
			    Kemudian  Sub Menu <b>"EXPORT"</b> .</b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>5.</b>&nbsp;&nbsp; 
			    Maka akan muncul form <b>"OPSI"</b> , Pilih Opsi <b> "RENJA" </b>
		    </h5>
		    <img style="width:90%" src="<?php echo base_url();?>images/panduan/tahapan_export_dua.png">
		    <h5 style="margin-left:20px;text-align:left"><b>6.</b>&nbsp;&nbsp; 
			    Tentukan tujuan direktorat yang akan dituju.  </b>
		    </h5>
		    <h5 style="margin-left:20px;text-align:left"><b>7.</b>&nbsp;&nbsp; 
			    Klik Tombol <b>"OK"</b>  </b>
		    </h5>
		     <img style="width:90%" src="<?php echo base_url();?>images/panduan/finish_export.png">
		      <h5 style="margin-left:20px;text-align:left"><b>8.</b>&nbsp;&nbsp; 
			    Bila sudah selesai melakukan proses export maka akanmuncul pesan sukses   </b>
		    </h5>
		  </div>
		  <div class="panel-footer"><center><b>Tahapan Copy</b></center></div>
		</div></center>
	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">4</a> .</b>&nbsp;&nbsp;
	Tahapan selanjutnya adalah <b>PENGIRIMAN</b> file menuju <b>DIREKTORAT</b> .</h5>	
		<center>
	<div style="width:90%" class="panel panel-default">
		  <div class="panel-body">		    
		    <div style="margin-left:32px">
			    <h5 style="margin-left:20px;text-align:left"><b>1.</b>&nbsp;&nbsp; 
				  File yang akan di distribusikan kepada "DIREKTORAT" bisa dilakukan dengan berbagai cara sebagai contoh bisa dilakukan dengan cara pertukaran perangkat seperti "Flashdisk" atau dengan menggunakan "EMAIL" , Maupun "APLIKASI" yang sudah disediakan
			    </h5>
			    <img style="width:90%" src="<?php echo base_url();?>images/panduan/perangkat_kirim_file.png">
			     <h5 style="margin-left:20px;text-align:left"><b>2.</b>&nbsp;&nbsp; 
				 Sekarang kita akan menggunakan aplikasa sebagai cara untuk mendistribusikan file kepada direktorat yang ditunjuk untuk melakukan akomodir terhadap Aplikasi Renstra maupun Renja.
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>3.</b>&nbsp;&nbsp; 
				 Halaman Utama Aplikasi.
			    </h5>
			    <img style="width:90%" src="<?php echo base_url();?>images/panduan/halaman_utama_app.png">
			    <h5 style="margin-left:20px;text-align:left"><b>4.</b>&nbsp;&nbsp; 
				Klik Menu <b>"PENGIRIMAN FILE"</b>
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>5.</b>&nbsp;&nbsp; 
				Klik Menu <b>"KIRIM FILE"</b>
			    </h5>
			    <img style="width:90%" src="<?php echo base_url();?>images/panduan/tahap_satu_kirim_file.png">
			    <h5 style="margin-left:20px;text-align:left"><b>6.</b>&nbsp;&nbsp; 
				Klik Tombol <b>"TAMBAH"</b>
			    </h5>
			   
			    <img style="width:90%" src="<?php echo base_url();?>images/panduan/tahap_dua_kirim_file.png">
			    <h5 style="margin-left:20px;text-align:left"><b></b>&nbsp;&nbsp; 
					<b>Tampilan Form Input</b>
			    </h5>
			    <img style="width:90%" src="<?php echo base_url();?>images/panduan/form_input_kirim_file.png">
			    <h5 style="margin-left:20px;text-align:left"><b>7.</b>&nbsp;&nbsp; 
					Kolom Untuk Judul File
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>8.</b>&nbsp;&nbsp; 
					Kolom Digunakan Untuk Tujuan
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>9.</b>&nbsp;&nbsp; 
					Kolom Digunakan Catatan
			    </h5>
			      <h5 style="margin-left:20px;text-align:left"><b>10.</b>&nbsp;&nbsp; 
					Tombol Yang digunakan memilih file yang akan dikirim / upload ,  
					<b>(Catatan)</b> 
					File yang di upload adalah file Excel yang memiliki extensi *xlms.
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>11.</b>&nbsp;&nbsp; 
					Bila Sudah tekan tombol simpan dan bila ada kotak konfirmasi muncul maka tekan Tombol <b>"YA"</b>
			    </h5>
			    <img  src="<?php echo base_url();?>images/panduan/konfirmasi_kirim_file.png"><br>
			    <h5 style="margin-left:20px;text-align:left"><b>12.</b>&nbsp;&nbsp; 
					Bila sudah selesai maka aplikasi akan kembali ke halaman Depan dengan menampilkan data yang sudah berhasil 
					dikirimkan.
			    </h5>
			    <img  style="width:90%"  src="<?php echo base_url();?>images/panduan/kirim_file_data_terisi.png">
			     <h5 style="margin-left:20px;text-align:left"><b>13.</b>&nbsp;&nbsp; 
					Lokasi Pengiriman Berasal , yaitu <b>"SEKRETARIAT" </b>
			    </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>14.</b>&nbsp;&nbsp; 
					Lokasi tujuan pengiriman File , yaitu <b>"SUPD1"  </b>
			    </h5>
			  </div>
			  <div class="panel-footer"><center><b>Tahapan Pengiriman File Menuju Direktorat</b></center></div>
			</div></center>
	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">5</a> .</b>&nbsp;&nbsp;
	Untuk tahapan pengiriman file dari <b>"DIREKTORAT"</b> menuju <b>"SEKRETARIAT"</b> dilakukan dengan tahapan yang sama dengan yang diatas  .</h5>	
			
	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">6</a> .</b>&nbsp;&nbsp;
	Tahapan selanjutnya adalah <b>MENERIMA</b> file yang diberikan oleh <b>DIREKTORAT</b> .</h5>			
			<center>
	<div style="width:90%" class="panel panel-default">
		  <div class="panel-body">		    
		    <div style="margin-left:32px">
			   <img  style="width:90%"  src="<?php echo base_url();?>images/panduan/penngiriman_terima_file.png">
			   	<h5 style="margin-left:20px;text-align:left"><b>1.</b>&nbsp;&nbsp; 
				Klik Menu <b>"PENGIRIMAN FILE"</b>
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>2.</b>&nbsp;&nbsp; 
				Klik Menu <b>"TERIMA FILE"</b>
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>3.</b>&nbsp;&nbsp; 
				Klik Tombol <b>"DOWNLOAD"</b>
			    </h5>
			    <img  style="width:90%"  src="<?php echo base_url();?>images/panduan/file_hasil_download.png">
			    <h5 style="margin-left:20px;text-align:left"><b>4.</b>&nbsp;&nbsp; 
				 File Yang Sudah Di <b>"DOWNLOAD"</b> 
			    </h5>
			    <img  style="width:90%"  src="<?php echo base_url();?>images/panduan/replace_file_kiriman.png">
			    <h5 style="margin-left:20px;text-align:left"><b>5.</b>&nbsp;&nbsp; 
				<b>"REPLACE" / "TIMPAH" </b> file yang sudah ada dengan file yang baru di <b>"DOWNLOAD"</b>
			    </h5>
			  </div>
			  <div class="panel-footer"><center><b>Tahapan Pengiriman File Menuju Direktorat</b></center></div>
			</div></center>

	

	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">7</a> .</b>&nbsp;&nbsp;
	Tahapan selanjutnya adalah <b>MELAKUKAN IMPORT</b> file yang diberikan oleh <b>DIREKTORAT</b> .</h5>			
			<center>
	<div style="width:90%" class="panel panel-default">
		  <div class="panel-body">		    
		    <div style="margin-left:32px">
			   
			   	<h5 style="margin-left:20px;text-align:left"><b>1.</b>&nbsp;&nbsp; 
				Buka kembali file Excel <b>"KERTAS_KERJA"</b>
			    </h5>
			    <img  style="width:90%"  src="<?php echo base_url();?>images/panduan/tahap_satu_import.png">
			    
			    <h5 style="margin-left:20px;text-align:left"><b>2.</b>&nbsp;&nbsp; 
				Klik Menu <b>"ADS-INS"</b>
			    </h5>
			    
			    <h5 style="margin-left:20px;text-align:left"><b>3.</b>&nbsp;&nbsp; 
				Klik Menu <b>"TOOLS"</b>
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>4.</b>&nbsp;&nbsp; 
				Klik Menu <b>"IMPORT"</b>
			    </h5>
			    <img  style="width:90%"  src="<?php echo base_url();?>images/panduan/tahap_dua_import_file.png">
			    <h5 style="margin-left:20px;text-align:left"><b>5.</b>&nbsp;&nbsp; 
				 PILIH <b>"RENJA"</b>
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>6.</b>&nbsp;&nbsp; 
				 Ganti Opsi Menjadi <b>"ALL-FILES" </b>
			    </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>7.</b>&nbsp;&nbsp; 
				  Pilih File Excel Yang Diberikan Oleh Direktorat Tadi Dengan Extensi <b>*.XLMS</b>
			    </h5>
			    <h5 style="margin-left:20px;text-align:left"><b>8.</b>&nbsp;&nbsp; 
				  TEKAN TOMBOL <b>"OPEN"</b>
			    </h5>
			     <img     src="<?php echo base_url();?>images/panduan/tahap_tiga_import_file.png">
			    <h5 style="margin-left:20px;text-align:left"><b>9.</b>&nbsp;&nbsp; 
				 Pilih DIREKTORAT yang akan dituju
			    </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>10.</b>&nbsp;&nbsp; 
				  Pilih Kertas Kerja yang tersedia pada Excel
			    </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>11.</b>&nbsp;&nbsp; 
				  Tekan Tombol OK
			    </h5>
			     <img     src="<?php echo base_url();?>images/panduan/sukses_import.png">
			      <h5 style="margin-left:20px;text-align:left"><b>12.</b>&nbsp;&nbsp; 
				  Bila Sudah Selesai Maka , Akan Muncul Sukses Import Data
			    </h5>
			     <img   style="width:90%"   src="<?php echo base_url();?>images/panduan/final_import.png">
			      <h5 style="margin-left:20px;text-align:left"><b>13.</b>&nbsp;&nbsp; 
				  Data pada kertas kerja <b>"DIREKTORAT"</b> sudah sesuai dengan data yang diberikan oleh <b>"DIREKTORAT"</b>
			    </h5>
			  </div>
			  <div class="panel-footer"><center><b>Tahapan Penerimaan File Dari Direktorat</b></center></div>
			</div></center>	

	
	<h5 style="margin-left:20px"><b><a class="btn btn-success" style="border-radius:50px">8</a> .</b>&nbsp;&nbsp;
	Tahapan Pengakhiran Dari Proses ini adalah melakukan Copy Dari Kertas Kerja Direktorat Menuju <b>"RENJA_UTAMA"</b>.</h5>			
			<center>
	<div style="width:90%" class="panel panel-default">
		  <div class="panel-body">		    
		    <div style="margin-left:32px">
		     <h5 style="margin-left:20px;text-align:left"><b></b>&nbsp;&nbsp; 
				  Buka Kembali File EXCEL
			     </h5>
			    
		     	 <img   style="width:90%"   src="<?php echo base_url();?>images/panduan/finalisasi_tahap_satu.png">
			     <h5 style="margin-left:20px;text-align:left"><b>1.</b>&nbsp;&nbsp; 
				  Klik Menu <b>"ADS-IN"</b>
			     </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>2.</b>&nbsp;&nbsp; 
				  Klik Menu <b>"RENJA"</b>
			     </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>3.</b>&nbsp;&nbsp; 
				  Klik Menu <b>"COPY FORM"</b>
			     </h5>
			    <img    src="<?php echo base_url();?>images/panduan/finalisasi_tahap_dua.png">

			     <h5 style="margin-left:20px;text-align:left"><b>4.</b>&nbsp;&nbsp; 
				   Pilih Program / Direktorat yang akan dituju
			     </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>5.</b>&nbsp;&nbsp; 
				  Pilih Opsi <b>"DARI DIREKTORAT MENUJU RENJA UTAMA"</b>
			     </h5>
			     <h5 style="margin-left:20px;text-align:left"><b>6.</b>&nbsp;&nbsp; 
				  Klik Tombol <b>"OK"</b>
			     </h5>
			     <img   style="width:90%"    src="<?php echo base_url();?>images/panduan/finalisasi_tahap_akhir_import.png">
			     <h5 style="margin-left:20px;text-align:left"><b>7.</b>&nbsp;&nbsp; 
				  Bila Proses Tersebut Sudah Selesai Maka Data Pada Kertas Kerja <b>"RENJA_UTAMA"</b> suda sesuai dengan yang diberikan oleh direktorat 
			     </h5>
			     
			  </div>
			  <div class="panel-footer"><center><b>Tahapan Penyelsaian File Dari Direktorat</b></center></div>
			</div></center>				
</div>
