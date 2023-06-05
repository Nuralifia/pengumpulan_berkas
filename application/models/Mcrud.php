<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcrud extends CI_Model {

	var $tbl_users				 = 'tbl_user';
	var $tbl_bagian		 		 = 'tbl_bagian';
	var $tbl_ns		 				 = 'tbl_ns';
	var $tbl_sm		 				 = 'tbl_sm';
	var $tbl_sk		 				 = 'tbl_sk';
	var $tbl_memo	 				 = 'tbl_memo';
	var $dosen_industri 		     = 'dosen_industri';
	var $ipk_lulusan                 = 'ipk_lulusan';
	var $kepuasan_mhs                = 'kepuasan_mhs';
	var $karya_mhs_disitasi          = 'karya_mhs_disitasi';
	var $karya_dtps_disitasi         = 'karya_dtps_disitasi';
	var $integrasi_penelitian_pembelajaran  	 = 'integrasi_penelitian_pembelajaran';
	var $kepuasan_pengguna_lulusan		  		 = 'kepuasan_pengguna_lulusan';
	var $ewmp_dosen_tetap            = 'ewmp_dosen_tetap';
	var $dosen_pembimbing_utama_pa   = 'dosen_pembimbing_utama_pa';
	var $kesesuaian_bidang_kerja   	 = 'kesesuaian_bidang_kerja';
	var $mahasiswa_asing		 	 = 'mahasiswa_asing';
	var $penelitian_dtps		 	 = 'penelitian_dtps';
	var $penelitian_dtps_mhs		 = 'penelitian_dtps_mhs';
	var $prestasi_akademik		 	 = 'prestasi_akademik';
	var $prestasi_nonakademik		 = 'prestasi_nonakademik';
	var $produk_jasa_dtps		 	 = 'produk_jasa_dtps';
	var $produk_jasa_mhs_diapdosi	 = 'produk_jasa_mhs_diapdosi';
	var $publikasi_ilmiah_dtps		 = 'publikasi_ilmiah_dtps';
	var $publikasi_ilmiah_mhs		 = 'publikasi_ilmiah_mhs';
	var $refrensi		 			 = 'refrensi';
	var $seleksi_mahasiswa		 	 = 'seleksi_mahasiswa';
	var $tempat_kerja_lulusan		 = 'tempat_kerja_lulusan';
	var $waktu_tunggu_d3		 	 = 'waktu_tunggu_d3';
	var $waktu_tunggu_s		 		 = 'waktu_tunggu_s';
	var $waktu_tunggu_st		 	 = 'waktu_tunggu_st';
	var $dosen_tetap			 	 = 'dosen_tetap';
	var $dosen_tidak_tetap			 = 'dosen_tidak_tetap';
	var $kerjasama_tridharma_pendidikan		= 'kerjasama_tridharma_pendidikan';
	var $kerjasama_tridharma_penelitian		= 'kerjasama_tridharma_penelitian';
	var $kerjasama_tridharma_pengabdian		= 'kerjasama_tridharma_pengabdian';
	var $kurikulum							= 'kurikulum';
	var $luaran_penelitianlainnya_dtps		= 'luaran_penelitianlainnya_dtps';
	var $luaran_pkm_lainnya_dtps		= 'luaran_pkm_lainnya_dtps';
	var $luaran_penelitian_mhs_1		= 'luaran_penelitian_mhs_1';
	var $luaran_penelitian_mhs_2		= 'luaran_penelitian_mhs_2';
	var $luaran_penelitian_mhs_3		= 'luaran_penelitian_mhs_3';
	var $luaran_penelitian_mhs_4		= 'luaran_penelitian_mhs_4';
	var $masa_studi_d					= 'masa_studi_d';
	var $masa_studi_do					= 'masa_studi_do';
	var $masa_studi_m					= 'masa_studi_m';
	var $masa_studi_s					= 'masa_studi_s';
	var $pagelaran_ilmiah_dtps			= 'pagelaran_ilmiah_dtps';
	var $pagelaran_ilmiah_mhs			= 'pagelaran_ilmiah_mhs';
	var $penelitian_dtps_tesis			= 'penelitian_dtps_tesis';
	var $pengakuan_rekognisi_dtps		= 'pengakuan_rekognisi_dtps';
	var $penggunaan_dana				= 'penggunaan_dana';
	var $pkm_dtps						= 'pkm_dtps';
	var $pkm_dtps_mhs					= 'pkm_dtps_mhs';
	var $luaran_penelitianlainnya_dtps_3	= 'luaran_penelitianlainnya_dtps_3';
	var $luaran_penelitianlainnya_dtps_4	= 'luaran_penelitianlainnya_dtps_4';
	var $saran								= 'saran';
	var $program							= 'program';
	var $upps								= 'upps';


	//Sent mail
			public function sent_mail($username, $email, $aksi)
			{
				$email_saya = "";
				$pass_saya  = "";

				//konfigurasi email
				$config = array();
				$config['charset'] = 'utf-8';
				$config['useragent'] = 'jkp.ordodev.com';
				$config['protocol']= "smtp";
				$config['mailtype']= "html";
				$config['smtp_host']= "ssl://smtp.gmail.com";
				$config['smtp_port']= "465";
				$config['smtp_timeout']= "465";
				$config['smtp_user']= "$email_saya";
				$config['smtp_pass']= "$pass_saya";
				$config['crlf']="\r\n";
				$config['newline']="\r\n";

				$config['wordwrap'] = TRUE;
				//memanggil library email dan set konfigurasi untuk pengiriman email

				$this->email->initialize($config);
				//$ipaddress = get_real_ip(); //untuk mendeteksi alamat IP

				date_default_timezone_set('Asia/Jakarta');
				$waktu 	  = date('Y-m-d H:i:s');
				$tgl 			= date('Y-m-d');

				$id = md5("$email * $tgl");

				if ($aksi == 'reg') {
						$link			= base_url().'web/verify';
						$pesan    = "Hello $username,
													<br /><br />
													Selamat Datang!<br/>
													Untuk melengkapi pendaftaran Anda, silahkan klik link berikut<br/>
													<br /><br />
													<b><a href='$link/$id/$username'>Klik Aktivasi disini :)</a></b>
													<br /><br />
													Terimakasih ^_^,
													";
						$subject = 'Aktivasi Akun | Akreditasi';

				}elseif ($aksi == 'lp') {
						$link			= base_url().'web/konfirm_pass';
						$pesan    = "Hello $username,
													<br /><br />
													Selamat Datang!<br/>
													Untuk membuat password baru, silahkan klik link berikut<br/>
													<br /><br />
													<b><a href='$link/$id/$username'>Klik disini untuk merubah Password baru :)</a></b>
													<br /><br />
													Terimakasih ^_^,
													";
						 $subject = 'Lupa Password | Akreditasi';
				}

				$this->email->from("$email_saya");
				$this->email->to("$email");
				$this->email->subject($subject);
				$this->email->message($pesan);
			}
	//End Sent mail


	public function get_users()
	{
			$this->db->from($this->tbl_users);
			$query = $this->db->get();

			return $query;
	}


	public function get_users_daftar()
	{
			$this->db->from($this->tbl_users);
			$this->db->where('status','terdaftar');
			$query = $this->db->get();

			return $query;
	}

	public function get_level_users()
	{
			$this->db->from($this->tbl_users);
			// $this->db->where('tbl_user.level', 'user');
			$query = $this->db->get();

			return $query;
	}

	public function get_users_by_un($id)
	{
				$this->db->from($this->tbl_users);
				$this->db->where('username',$id);
				$query = $this->db->get();

				return $query;
	}

	public function get_level_users_by_id($id)
	{
			$this->db->from($this->tbl_users);
			$this->db->where('tbl_user.level', 'user');
			$this->db->where('tbl_user.id_user', $id);
			$query = $this->db->get();

			return $query->row();
	}

	public function save_user($data)
	{
		$this->db->insert($this->tbl_users, $data);
		return $this->db->insert_id();
	}

	public function update_user($where, $data)
	{
		$this->db->update($this->tbl_users, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_user_by_id($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete($this->tbl_users);
	}


	public function save_bagian($data)
	{
		$this->db->insert($this->tbl_bagian, $data);
		return $this->db->insert_id();
	}

	public function update_bagian($where, $data)
	{
		$this->db->update($this->tbl_bagian, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_bagian_by_id($id)
	{
		$this->db->where('id_bagian', $id);
		$this->db->delete($this->tbl_bagian);
	}

	public function save_ns($data)
	{
		$this->db->insert($this->tbl_ns, $data);
		return $this->db->insert_id();
	}

	public function update_ns($where, $data)
	{
		$this->db->update($this->tbl_ns, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_ns_by_id($id)
	{
		$this->db->where('id_ns', $id);
		$this->db->delete($this->tbl_ns);
	}


	// get data dropdown
    function data_ns($aksi='', $id='')
    {
        // ambil data dari db
				if ($aksi != 'semua') {
					$this->db->where('jenis_ns', $aksi);
				}
				// $this->db->where('id_user', $id);
				$this->db->order_by('no_surat', 'asc');
				$query = $this->db->get('tbl_ns')->result();

        return $query;
    }


	public function delete_lampiran($id)
	{
		$this->db->where('token_lampiran', $id);
		$this->db->delete('tbl_lampiran');
	}

	public function update_lampiran($id)
	{
		$this->db->where('token_lampiran', $id);
		$this->db->update('tbl_lampiran');

	}




	public function save_dosen_industri($data)
	{
		$this->db->insert($this->dosen_industri, $data);
		return $this->db->insert_id();
	}

	public function update_dosen_industri($where, $data)
	{
		$this->db->update($this->dosen_industri, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_dosen_industri_by_id($id)
	{
		$this->db->where('id_dosen_industri', $id);
		$this->db->delete($this->dosen_industri);
	}



	public function save_ipk_lulusan($data)
	{
		$this->db->insert($this->ipk_lulusan, $data);
		return $this->db->insert_id();
	}

	public function update_ipk_lulusan($where, $data)
	{
		$this->db->update($this->ipk_lulusan, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_ipk_lulusan_by_id($id)
	{
		$this->db->where('id_ipk_lulusan', $id);
		$this->db->delete($this->ipk_lulusan);
	}


	public function save_kepuasan_mhs($data)
	{
		$this->db->insert($this->kepuasan_mhs, $data);
		return $this->db->insert_id();
	}

	public function update_kepuasan_mhs($where, $data)
	{
		$this->db->update($this->kepuasan_mhs, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kepuasan_mhs_by_id($id)
	{
		$this->db->where('id_kepuasan_mhs', $id);
		$this->db->delete($this->kepuasan_mhs);
	}


	public function save_karya_mhs_disitasi($data)
	{
		$this->db->insert($this->karya_mhs_disitasi, $data);
		return $this->db->insert_id();
	}

	public function update_karya_mhs_disitasi($where, $data)
	{
		$this->db->update($this->karya_mhs_disitasi, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_karya_mhs_disitasi_by_id($id)
	{
		$this->db->where('id_karya_mhs_disitasi', $id);
		$this->db->delete($this->karya_mhs_disitasi);
	}

	public function save_karya_dtps_disitasi($data)
	{
		$this->db->insert($this->karya_dtps_disitasi, $data);
		return $this->db->insert_id();
	}

	public function update_karya_dtps_disitasi($where, $data)
	{
		$this->db->update($this->karya_dtps_disitasi, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_karya_dtps_disitasi_by_id($id)
	{
		$this->db->where('id_karya_dtps_disitasi', $id);
		$this->db->delete($this->karya_dtps_disitasi);
	}

	public function save_integrasi_penelitian_pembelajaran($data)
	{
		$this->db->insert($this->integrasi_penelitian_pembelajaran, $data);
		return $this->db->insert_id();
	}

	public function update_integrasi_penelitian_pembelajaran($where, $data)
	{
		$this->db->update($this->integrasi_penelitian_pembelajaran, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_integrasi_penelitian_pembelajaran_by_id($id)
	{
		$this->db->where('id_integrasi_penelitian_pembelajaran', $id);
		$this->db->delete($this->integrasi_penelitian_pembelajaran);
	}

	public function save_kepuasan_pengguna_lulusan($data)
	{
		$this->db->insert($this->kepuasan_pengguna_lulusan, $data);
		return $this->db->insert_id();
	}

	public function update_kepuasan_pengguna_lulusan($where, $data)
	{
		$this->db->update($this->kepuasan_pengguna_lulusan, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kepuasan_pengguna_lulusan_by_id($id)
	{
		$this->db->where('id_kepuasan_pengguna_lulusan', $id);
		$this->db->delete($this->kepuasan_pengguna_lulusan);
	}

	public function save_ewmp_dosen_tetap($data)
	{
		$this->db->insert($this->ewmp_dosen_tetap, $data);
		return $this->db->insert_id();
	}

	public function update_ewmp_dosen_tetap($where, $data)
	{
		$this->db->update($this->ewmp_dosen_tetap, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_ewmp_dosen_tetap_by_id($id)
	{
		$this->db->where('id_ewmp_dosen_tetap', $id);
		$this->db->delete($this->ewmp_dosen_tetap);
	}

	public function save_dosen_pembimbing_utama_pa($data)
	{
		$this->db->insert($this->dosen_pembimbing_utama_pa, $data);
		return $this->db->insert_id();
	}

	public function update_dosen_pembimbing_utama_pa($where, $data)
	{
		$this->db->update($this->dosen_pembimbing_utama_pa, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_dosen_pembimbing_utama_pa_by_id($id)
	{
		$this->db->where('id_dosen_pembimbing_utama_pa', $id);
		$this->db->delete($this->dosen_pembimbing_utama_pa);
	}

	public function save_kesesuaian_bidang_kerja($data)
	{
		$this->db->insert($this->kesesuaian_bidang_kerja, $data);
		return $this->db->insert_id();
	}

	public function update_kesesuaian_bidang_kerja($where, $data)
	{
		$this->db->update($this->kesesuaian_bidang_kerja, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kesesuaian_bidang_kerja_by_id($id)
	{
		$this->db->where('id_kesesuaian_bidang_kerja', $id);
		$this->db->delete($this->kesesuaian_bidang_kerja);
	}

	public function save_mahasiswa_asing($data)
	{
		$this->db->insert($this->mahasiswa_asing, $data);
		return $this->db->insert_id();
	}

	public function update_mahasiswa_asing($where, $data)
	{
		$this->db->update($this->mahasiswa_asing, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_mahasiswa_asing_by_id($id)
	{
		$this->db->where('id_mahasiswa_asing', $id);
		$this->db->delete($this->mahasiswa_asing);
	}

	public function save_penelitian_dtps($data)
	{
		$this->db->insert($this->penelitian_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_penelitian_dtps($where, $data)
	{
		$this->db->update($this->penelitian_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_penelitian_dtps_by_id($id)
	{
		$this->db->where('id_penelitian_dtps', $id);
		$this->db->delete($this->penelitian_dtps);
	}

	public function save_penelitian_dtps_mhs($data)
	{
		$this->db->insert($this->penelitian_dtps_mhs, $data);
		return $this->db->insert_id();
	}

	public function update_penelitian_dtps_mhs($where, $data)
	{
		$this->db->update($this->penelitian_dtps_mhs, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_penelitian_dtps_mhs_by_id($id)
	{
		$this->db->where('id_penelitian_dtps_mhs', $id);
		$this->db->delete($this->penelitian_dtps_mhs);
	}

	public function save_prestasi_akademik($data)
	{
		$this->db->insert($this->prestasi_akademik, $data);
		return $this->db->insert_id();
	}

	public function update_prestasi_akademik($where, $data)
	{
		$this->db->update($this->prestasi_akademik, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_prestasi_akademik_by_id($id)
	{
		$this->db->where('id_prestasi_akademik', $id);
		$this->db->delete($this->prestasi_akademik);
	}

	public function save_prestasi_nonakademik($data)
	{
		$this->db->insert($this->prestasi_nonakademik, $data);
		return $this->db->insert_id();
	}

	public function update_prestasi_nonakademik($where, $data)
	{
		$this->db->update($this->prestasi_nonakademik, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_prestasi_nonakademik_by_id($id)
	{
		$this->db->where('id_prestasi_nonakademik', $id);
		$this->db->delete($this->prestasi_nonakademik);
	}

	public function save_produk_jasa_dtps($data)
	{
		$this->db->insert($this->produk_jasa_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_produk_jasa_dtps($where, $data)
	{
		$this->db->update($this->produk_jasa_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_produk_jasa_dtps_by_id($id)
	{
		$this->db->where('id_produk_jasa_dtps', $id);
		$this->db->delete($this->produk_jasa_dtps);
	}

	public function save_produk_jasa_mhs_diapdosi($data)
	{
		$this->db->insert($this->produk_jasa_mhs_diapdosi, $data);
		return $this->db->insert_id();
	}

	public function update_produk_jasa_mhs_diapdosi($where, $data)
	{
		$this->db->update($this->produk_jasa_mhs_diapdosi, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_produk_jasa_mhs_diapdosi_by_id($id)
	{
		$this->db->where('id_produk_jasa_mhs_diapdosi', $id);
		$this->db->delete($this->produk_jasa_mhs_diapdosi);
	}

	public function save_publikasi_ilmiah_dtps($data)
	{
		$this->db->insert($this->publikasi_ilmiah_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_publikasi_ilmiah_dtps($where, $data)
	{
		$this->db->update($this->publikasi_ilmiah_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_publikasi_ilmiah_dtps_by_id($id)
	{
		$this->db->where('id_publikasi_ilmiah_dtps', $id);
		$this->db->delete($this->publikasi_ilmiah_dtps);
	}

	public function save_publikasi_ilmiah_mhs($data)
	{
		$this->db->insert($this->publikasi_ilmiah_mhs, $data);
		return $this->db->insert_id();
	}

	public function update_publikasi_ilmiah_mhs($where, $data)
	{
		$this->db->update($this->publikasi_ilmiah_mhs, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_publikasi_ilmiah_mhs_by_id($id)
	{
		$this->db->where('id_publikasi_ilmiah_mhs', $id);
		$this->db->delete($this->publikasi_ilmiah_mhs);
	}

	public function save_refrensi($data)
	{
		$this->db->insert($this->refrensi, $data);
		return $this->db->insert_id();
	}

	public function update_refrensi($where, $data)
	{
		$this->db->update($this->refrensi, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_refrensi_by_id($id)
	{
		$this->db->where('id_refrensi', $id);
		$this->db->delete($this->refrensi);
	}

	public function save_seleksi_mahasiswa($data)
	{
		$this->db->insert($this->seleksi_mahasiswa, $data);
		return $this->db->insert_id();
	}

	public function update_seleksi_mahasiswa($where, $data)
	{
		$this->db->update($this->seleksi_mahasiswa, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_seleksi_mahasiswa_by_id($id)
	{
		$this->db->where('id_seleksi_mahasiswa', $id);
		$this->db->delete($this->seleksi_mahasiswa);
	}

	public function save_tempat_kerja_lulusan($data)
	{
		$this->db->insert($this->tempat_kerja_lulusan, $data);
		return $this->db->insert_id();
	}

	public function update_tempat_kerja_lulusan($where, $data)
	{
		$this->db->update($this->tempat_kerja_lulusan, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_tempat_kerja_lulusan_by_id($id)
	{
		$this->db->where('id_tempat_kerja_lulusan', $id);
		$this->db->delete($this->tempat_kerja_lulusan);
	}

	public function save_waktu_tunggu_d3($data)
	{
		$this->db->insert($this->waktu_tunggu_d3, $data);
		return $this->db->insert_id();
	}

	public function update_waktu_tunggu_d3($where, $data)
	{
		$this->db->update($this->waktu_tunggu_d3, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_waktu_tunggu_d3_by_id($id)
	{
		$this->db->where('id_waktu_tunggu_d3', $id);
		$this->db->delete($this->waktu_tunggu_d3);
	}
	
	public function save_waktu_tunggu_s($data)
	{
		$this->db->insert($this->waktu_tunggu_s, $data);
		return $this->db->insert_id();
	}

	public function update_waktu_tunggu_s($where, $data)
	{
		$this->db->update($this->waktu_tunggu_s, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_waktu_tunggu_s_by_id($id)
	{
		$this->db->where('id_waktu_tunggu_s', $id);
		$this->db->delete($this->waktu_tunggu_s);
	}

	public function save_waktu_tunggu_st($data)
	{
		$this->db->insert($this->waktu_tunggu_st, $data);
		return $this->db->insert_id();
	}

	public function update_waktu_tunggu_st($where, $data)
	{
		$this->db->update($this->waktu_tunggu_st, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_waktu_tunggu_st_by_id($id)
	{
		$this->db->where('id_waktu_tunggu_st', $id);
		$this->db->delete($this->waktu_tunggu_st);
	}

	public function save_dosen_tetap($data)
	{
		$this->db->insert($this->dosen_tetap, $data);
		return $this->db->insert_id();
	}

	public function update_dosen_tetap($where, $data)
	{
		$this->db->update($this->dosen_tetap, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_dosen_tetap_by_id($id)
	{
		$this->db->where('id_dosen_tetap', $id);
		$this->db->delete($this->dosen_tetap);
	}

	public function save_dosen_tidak_tetap($data)
	{
		$this->db->insert($this->dosen_tidak_tetap, $data);
		return $this->db->insert_id();
	}

	public function update_dosen_tidak_tetap($where, $data)
	{
		$this->db->update($this->dosen_tidak_tetap, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_dosen_tidak_tetap_by_id($id)
	{
		$this->db->where('id_dosen_tidak_tetap', $id);
		$this->db->delete($this->dosen_tidak_tetap);
	}
	public function save_kerjasama_tridharma_pendidikan($data)
	{
		$this->db->insert($this->kerjasama_tridharma_pendidikan, $data);
		return $this->db->insert_id();
	}

	public function update_kerjasama_tridharma_pendidikan($where, $data)
	{
		$this->db->update($this->kerjasama_tridharma_pendidikan, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kerjasama_tridharma_pendidikan_by_id($id)
	{
		$this->db->where('id_kerjasama_tridharma_pendidikan', $id);
		$this->db->delete($this->kerjasama_tridharma_pendidikan);
	}

	public function save_kerjasama_tridharma_penelitian($data)
	{
		$this->db->insert($this->kerjasama_tridharma_penelitian, $data);
		return $this->db->insert_id();
	}

	public function update_kerjasama_tridharma_penelitian($where, $data)
	{
		$this->db->update($this->kerjasama_tridharma_penelitian, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kerjasama_tridharma_penelitian_by_id($id)
	{
		$this->db->where('id_kerjasama_tridharma_penelitian', $id);
		$this->db->delete($this->kerjasama_tridharma_penelitian);
	}

	public function delete_kerjasama_tridharma_penelitian_lampiran_by_id($id)
	{
		$this->db->where('token_lampiran', $token);
		$this->db->delete($this->kerjasama_tridharma_penelitian);
	}

	public function save_kerjasama_tridharma_pengabdian($data)
	{
		$this->db->insert($this->kerjasama_tridharma_pengabdian, $data);
		return $this->db->insert_id();
	}

	public function update_kerjasama_tridharma_pengabdian($where, $data)
	{
		$this->db->update($this->kerjasama_tridharma_pengabdian, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kerjasama_tridharma_pengabdian_by_id($id)
	{
		$this->db->where('id_kerjasama_tridharma_pengabdian', $id);
		$this->db->delete($this->kerjasama_tridharma_pengabdian);
	}

	public function save_kurikulum($data)
	{
		$this->db->insert($this->kurikulum, $data);
		return $this->db->insert_id();
	}

	public function update_kurikulum($where, $data)
	{
		$this->db->update($this->kurikulum, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_kurikulum_by_id($id)
	{
		$this->db->where('id_kurikulum', $id);
		$this->db->delete($this->kurikulum);
	}

	public function save_luaran_penelitianlainnya_dtps($data)
	{
		$this->db->insert($this->luaran_penelitianlainnya_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitianlainnya_dtps($where, $data)
	{
		$this->db->update($this->luaran_penelitianlainnya_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitianlainnya_dtps_by_id($id)
	{
		$this->db->where('id_luaran_penelitianlainnya_dtps', $id);
		$this->db->delete($this->luaran_penelitianlainnya_dtps);
	}

	public function save_luaran_pkm_lainnya_dtps($data)
	{
		$this->db->insert($this->luaran_pkm_lainnya_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_pkm_lainnya_dtps($where, $data)
	{
		$this->db->update($this->luaran_pkm_lainnya_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_pkm_lainnya_dtps_by_id($id)
	{
		$this->db->where('id_luaran_pkm_lainnya_dtps', $id);
		$this->db->delete($this->luaran_pkm_lainnya_dtps);
	}

	public function save_luaran_penelitian_mhs_1($data)
	{
		$this->db->insert($this->luaran_penelitian_mhs_1, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitian_mhs_1($where, $data)
	{
		$this->db->update($this->luaran_penelitian_mhs_1, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitian_mhs_1_by_id($id)
	{
		$this->db->where('id_luaran_penelitian_mhs_1', $id);
		$this->db->delete($this->luaran_penelitian_mhs_1);
	}

	public function save_luaran_penelitian_mhs_2($data)
	{
		$this->db->insert($this->luaran_penelitian_mhs_2, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitian_mhs_2($where, $data)
	{
		$this->db->update($this->luaran_penelitian_mhs_2, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitian_mhs_2_by_id($id)
	{
		$this->db->where('id_luaran_penelitian_mhs_2', $id);
		$this->db->delete($this->luaran_penelitian_mhs_2);
	}

	public function save_luaran_penelitian_mhs_3($data)
	{
		$this->db->insert($this->luaran_penelitian_mhs_3, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitian_mhs_3($where, $data)
	{
		$this->db->update($this->luaran_penelitian_mhs_3, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitian_mhs_3_by_id($id)
	{
		$this->db->where('id_luaran_penelitian_mhs_3', $id);
		$this->db->delete($this->luaran_penelitian_mhs_3);
	}

	public function save_luaran_penelitian_mhs_4($data)
	{
		$this->db->insert($this->luaran_penelitian_mhs_4, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitian_mhs_4($where, $data)
	{
		$this->db->update($this->luaran_penelitian_mhs_4, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitian_mhs_4_by_id($id)
	{
		$this->db->where('id_luaran_penelitian_mhs_4', $id);
		$this->db->delete($this->luaran_penelitian_mhs_4);
	}

	public function save_masa_studi_d($data)
	{
		$this->db->insert($this->masa_studi_d, $data);
		return $this->db->insert_id();
	}

	public function update_masa_studi_d($where, $data)
	{
		$this->db->update($this->masa_studi_d, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_masa_studi_d_by_id($id)
	{
		$this->db->where('id_masa_studi_d', $id);
		$this->db->delete($this->masa_studi_d);
	}

	public function save_masa_studi_do($data)
	{
		$this->db->insert($this->masa_studi_do, $data);
		return $this->db->insert_id();
	}

	public function update_masa_studi_do($where, $data)
	{
		$this->db->update($this->masa_studi_do, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_masa_studi_do_by_id($id)
	{
		$this->db->where('id_masa_studi_do', $id);
		$this->db->delete($this->masa_studi_do);
	}

	public function save_masa_studi_m($data)
	{
		$this->db->insert($this->masa_studi_m, $data);
		return $this->db->insert_id();
	}

	public function update_masa_studi_m($where, $data)
	{
		$this->db->update($this->masa_studi_m, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_masa_studi_m_by_id($id)
	{
		$this->db->where('id_masa_studi_m', $id);
		$this->db->delete($this->masa_studi_m);
	}

	public function save_masa_studi_s($data)
	{
		$this->db->insert($this->masa_studi_s, $data);
		return $this->db->insert_id();
	}

	public function update_masa_studi_s($where, $data)
	{
		$this->db->update($this->masa_studi_s, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_masa_studi_s_by_id($id)
	{
		$this->db->where('id_masa_studi_s', $id);
		$this->db->delete($this->masa_studi_s);
	}

	public function save_pagelaran_ilmiah_dtps($data)
	{
		$this->db->insert($this->pagelaran_ilmiah_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_pagelaran_ilmiah_dtps($where, $data)
	{
		$this->db->update($this->pagelaran_ilmiah_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_pagelaran_ilmiah_dtps_by_id($id)
	{
		$this->db->where('id_pagelaran_ilmiah_dtps', $id);
		$this->db->delete($this->pagelaran_ilmiah_dtps);
	}

	public function save_pagelaran_ilmiah_mhs($data)
	{
		$this->db->insert($this->pagelaran_ilmiah_mhs, $data);
		return $this->db->insert_id();
	}

	public function update_pagelaran_ilmiah_mhs($where, $data)
	{
		$this->db->update($this->pagelaran_ilmiah_mhs, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_pagelaran_ilmiah_mhs_by_id($id)
	{
		$this->db->where('id_pagelaran_ilmiah_mhs', $id);
		$this->db->delete($this->pagelaran_ilmiah_mhs);
	}

	public function save_penelitian_dtps_tesis($data)
	{
		$this->db->insert($this->penelitian_dtps_tesis, $data);
		return $this->db->insert_id();
	}

	public function update_penelitian_dtps_tesis($where, $data)
	{
		$this->db->update($this->penelitian_dtps_tesis, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_penelitian_dtps_tesis_by_id($id)
	{
		$this->db->where('id_penelitian_dtps_tesis', $id);
		$this->db->delete($this->penelitian_dtps_tesis);
	}

	public function save_pengakuan_rekognisi_dtps($data)
	{
		$this->db->insert($this->pengakuan_rekognisi_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_pengakuan_rekognisi_dtps($where, $data)
	{
		$this->db->update($this->pengakuan_rekognisi_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_pengakuan_rekognisi_dtps_by_id($id)
	{
		$this->db->where('id_pengakuan_rekognisi_dtps', $id);
		$this->db->delete($this->pengakuan_rekognisi_dtps);
	}

	public function save_penggunaan_dana($data)
	{
		$this->db->insert($this->penggunaan_dana, $data);
		return $this->db->insert_id();
	}

	public function update_penggunaan_dana($where, $data)
	{
		$this->db->update($this->penggunaan_dana, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_penggunaan_dana_by_id($id)
	{
		$this->db->where('id_penggunaan_dana', $id);
		$this->db->delete($this->penggunaan_dana);
	}

	public function save_pkm_dtps($data)
	{
		$this->db->insert($this->pkm_dtps, $data);
		return $this->db->insert_id();
	}

	public function update_pkm_dtps($where, $data)
	{
		$this->db->update($this->pkm_dtps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_pkm_dtps_by_id($id)
	{
		$this->db->where('id_pkm_dtps', $id);
		$this->db->delete($this->pkm_dtps);
	}

	public function save_pkm_dtps_mhs($data)
	{
		$this->db->insert($this->pkm_dtps_mhs, $data);
		return $this->db->insert_id();
	}

	public function update_pkm_dtps_mhs($where, $data)
	{
		$this->db->update($this->pkm_dtps_mhs, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_pkm_dtps_mhs_by_id($id)
	{
		$this->db->where('id_pkm_dtps_mhs', $id);
		$this->db->delete($this->pkm_dtps_mhs);
	}

	public function save_luaran_penelitianlainnya_dtps_3($data)
	{
		$this->db->insert($this->luaran_penelitianlainnya_dtps_3, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitianlainnya_dtps_3($where, $data)
	{
		$this->db->update($this->luaran_penelitianlainnya_dtps_3, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitianlainnya_dtps_3_by_id($id)
	{
		$this->db->where('id_luaran_penelitianlainnya_dtps_3', $id);
		$this->db->delete($this->luaran_penelitianlainnya_dtps_3);
	}

	public function save_luaran_penelitianlainnya_dtps_4($data)
	{
		$this->db->insert($this->luaran_penelitianlainnya_dtps_4, $data);
		return $this->db->insert_id();
	}

	public function update_luaran_penelitianlainnya_dtps_4($where, $data)
	{
		$this->db->update($this->luaran_penelitianlainnya_dtps_4, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_luaran_penelitianlainnya_dtps_4_by_id($id)
	{
		$this->db->where('id_luaran_penelitianlainnya_dtps_4', $id);
		$this->db->delete($this->luaran_penelitianlainnya_dtps_4);
	}

	public function save_saran($data)
	{
		$this->db->insert($this->saran, $data);
		return $this->db->insert_id();
	}

	public function update_saran($where, $data)
	{
		$this->db->update($this->saran, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_saran_by_id($id)
	{
		$this->db->where('id_saran', $id);
		$this->db->delete($this->saran);
	}

	public function save_program($data)
	{
		$this->db->insert($this->program, $data);
		return $this->db->insert_id();
	}

	public function update_program($where, $data)
	{
		$this->db->update($this->program, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_program_by_id($id)
	{
		$this->db->where('id_program', $id);
		$this->db->delete($this->program);
	}

	public function save_upps($data)
	{
		$this->db->insert($this->upps, $data);
		return $this->db->insert_id();
	}

	public function update_upps($where, $data)
	{
		$this->db->update($this->upps, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_upps_by_id($id)
	{
		$this->db->where('id_upps', $id);
		$this->db->delete($this->upps);
	}

}
