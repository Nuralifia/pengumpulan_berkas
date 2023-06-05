<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']   	 = $this->Mcrud->get_users_by_un($ceks);
			$data['users']  	 = $this->Mcrud->get_users();
			$data['judul_web'] = "Beranda | Berkas Akreditasi";

			$this->load->view('users/header', $data);
			$this->load->view('users/beranda', $data);
			$this->load->view('users/footer');
		}
	}

	public function profile()
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
			$data['level_users']  = $this->Mcrud->get_level_users();
			$data['judul_web'] 		= "Aplikasi | Berkas Akreditasi";

					$this->load->view('users/header', $data);
					$this->load->view('users/profile', $data);
					$this->load->view('users/footer');

					if (isset($_POST['btnupdate'])) {
						$nama_lengkap	 	= htmlentities(strip_tags($this->input->post('nama_lengkap')));
						$email	 				= htmlentities(strip_tags($this->input->post('email')));
						$alamat	 				= htmlentities(strip_tags($this->input->post('alamat')));
						$telp	 					= htmlentities(strip_tags($this->input->post('telp')));
						$pengalaman	 	  = htmlentities(strip_tags($this->input->post('pengalaman')));

									$data = array(
										'nama_lengkap'	=> $nama_lengkap,
										'email'					=> $email,
										'alamat'				=> $alamat,
										'telp'					=> $telp,
										'pengalaman'	  => $pengalaman
									);
									$this->Mcrud->update_user(array('username' => $ceks), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Profile berhasil disimpan.
										</div>'
									);
									redirect('users/profile');
					}


					if (isset($_POST['btnupdate2'])) {
						$password 	= htmlentities(strip_tags($this->input->post('password')));
						$password2 	= htmlentities(strip_tags($this->input->post('password2')));

						if ($password != $password2) {
								$this->session->set_flashdata('msg2',
									'
									<div class="alert alert-warning alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
										 </button>
										 <strong>Gagal!</strong> Katasandi tidak cocok.
									</div>'
								);
						}else{
									$data = array(
										'password'	=> md5($password)
									);
									$this->Mcrud->update_user(array('username' => $ceks), $data);

									$this->session->set_flashdata('msg2',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Katasandi berhasil disimpan.
										</div>'
									);
						}
									redirect('users/profile');
					}


		}
	}

	public function pengguna($aksi='', $id='')
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			if ($data['user']->row()->level == 'admin' or $data['user']->row()->level == 'user') {
					redirect('404_content');
			}

			$this->db->order_by('id_user', 'ASC');
			$data['level_users']  = $this->Mcrud->get_level_users();

				if ($aksi == 't') {
					$p = "pengguna_tambah";

					$data['judul_web'] 	  = "Tambah Pengguna | Aplikasi ";
				}elseif ($aksi == 'd') {
					$p = "pengguna_detail";

					$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
					$data['judul_web'] 	  = "Detail Pengguna | Aplikasi ";
				}elseif ($aksi == 'e') {
					$p = "pengguna_edit";

					$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
					$data['judul_web'] 	  = "Edit Pengguna | Aplikasi ";
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
					$data['judul_web'] 	  = "Hapus Pengguna | Aplikasi ";

					if ($ceks == $data['query']->username) {
						$this->session->set_flashdata('msg',
							'
							<div class="alert alert-warning alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
								 </button>
								 <strong>Gagal!</strong> Maaf, Anda tidak bisa menghapus Nama Pengguna "'.$ceks.'" ini.
							</div>'
						);
					}else{
						$this->Mcrud->delete_user_by_id($id);
						$this->session->set_flashdata('msg',
							'
							<div class="alert alert-success alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
								 </button>
								 <strong>Sukses!</strong> Pengguna berhasil dihapus.
							</div>'
						);
					}
					redirect('users/pengguna');
				}else{
					$p = "pengguna";

					$data['judul_web'] 	  = "Pengguna | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pengaturan/$p", $data);
					$this->load->view('users/footer');

					date_default_timezone_set('Asia/Jakarta');
					$tgl = date('d-m-Y H:i:s');

					if (isset($_POST['btnsimpan'])) {
						$username   	 	= htmlentities(strip_tags($this->input->post('username')));
						$password	 		  = htmlentities(strip_tags($this->input->post('password')));
						$password2	 		= htmlentities(strip_tags($this->input->post('password2')));
						$level	 				= htmlentities(strip_tags($this->input->post('level')));

						$cek_user = $this->db->get_where("tbl_user", "username = '$username'")->num_rows();
						if ($cek_user != 0) {
								$this->session->set_flashdata('msg',
									'
									<div class="alert alert-warning alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
										 </button>
										 <strong>Gagal!</strong> Nama Pengguna "'.$username.'" Sudah ada.
									</div>'
								);
						}else{
								if ($password != $password2) {
										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-warning alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Gagal!</strong> Katasandi tidak cocok.
											</div>'
										);
								}else{
										$data = array(
											'username'	 	 => $username,
											'nama_lengkap' => $username,
											'password'	 	 => md5($password),
											'status' 			 => 'aktif',
											'level'			 	 => $level,
											'tgl_daftar' 	 => $tgl
										);
										$this->Mcrud->save_user($data);

										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Pengguna berhasil ditambahkan.
											</div>'
										);
								}
						}

									redirect('users/pengguna/t');
					}

					if (isset($_POST['btnupdate'])) {
						$nama_lengkap	 	= htmlentities(strip_tags($this->input->post('nama_lengkap')));
						$level	 				= htmlentities(strip_tags($this->input->post('level')));

									$data = array(
										'nama_lengkap' => $nama_lengkap,
										'status' 			 => 'aktif',
										'level'			 	 => $level,
										'tgl_daftar' 	 => $tgl
									);
									$this->Mcrud->update_user(array('id_user' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Pengguna berhasil diupdate.
										</div>'
									);
									redirect('users/pengguna');
					}

		}
	}



	public function bagian($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			if ($data['user']->row()->level == 'user') {
					redirect('404_content');
			}

			$this->db->join('tbl_user', 'tbl_bagian.id_user=tbl_user.id_user');
			if ($data['user']->row()->level == 'user') {
					$this->db->where('tbl_bagian.id_user', "$id_user");
			}
			$this->db->order_by('tbl_bagian.nama_bagian', 'ASC');
			$data['bagian'] 		  = $this->db->get("tbl_bagian");

				if ($aksi == 't') {
					$p = "bagian_tambah";
					if ($data['user']->row()->level == 's_admin') {
							redirect('404_content');
					}

					$data['judul_web'] 	  = "Tambah Bagian | Aplikasi ";
				}elseif ($aksi == 'e') {
					$p = "bagian_edit";
					if ($data['user']->row()->level == 's_admin') {
							redirect('404_content');
					}

					$data['query'] = $this->db->get_where("tbl_bagian", array('id_bagian' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Bagian | Aplikasi ";

					

				}elseif ($aksi == 'h') {

					if ($data['user']->row()->level == 's_admin') {
							redirect('404_content');
					}
					$data['query'] = $this->db->get_where("tbl_bagian", array('id_bagian' => "$id"))->row();
					$data['judul_web'] 	  = "Hapus Bagian | Aplikasi ";

					
							$this->Mcrud->delete_bagian_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Bagian berhasil dihapus.
								</div>'
							);
					// }

					redirect('users/bagian');
				}else{
					$p = "bagian";

					$data['judul_web'] 	  = "Bagian | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pengaturan/$p", $data);
					$this->load->view('users/footer');

					date_default_timezone_set('Asia/Jakarta');
					$tgl = date('d-m-Y H:i:s');

					if (isset($_POST['btnsimpan'])) {
						$nama_bagian   	 	= htmlentities(strip_tags($this->input->post('nama_bagian')));

										$data = array(
											'nama_bagian'	 => $nama_bagian,
											'id_user'		   => $id_user
										);
										$this->Mcrud->save_bagian($data);

										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Bagian berhasil ditambahkan.
											</div>'
										);

									redirect('users/bagian/t');
					}

					if (isset($_POST['btnupdate'])) {
							$nama_bagian   	 	= htmlentities(strip_tags($this->input->post('nama_bagian')));

									$data = array(
										'nama_bagian'	 => $nama_bagian
									);
									$this->Mcrud->update_bagian(array('id_bagian' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Bagian berhasil diupdate.
										</div>'
									);
									redirect('users/bagian');
					}

		}
	}



	public function ns($aksi='', $id='')
	{
		redirect('404_content');
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			$this->db->where('tbl_bagian.id_user', "$id_user");
			$this->db->order_by('nama_bagian', 'ASC');
			$data['bagian']			  = $this->db->get("tbl_bagian")->result();

			if ($data['user']->row()->level == 'admin') {
					redirect('404_content');
			}

			// $this->db->join('tbl_bagian', 'tbl_bagian.id_bagian=tbl_ns.id_bagian');
			$this->db->order_by('tbl_ns.id_ns', 'DESC');
			$data['ns'] 		  = $this->db->get("tbl_ns");

				if ($aksi == 't') {
					$p = "ns_tambah";
					if ($data['user']->row()->level == 's_admin') {
							redirect('404_content');
					}

					$data['judul_web'] 	  = "Tambah Nomor Surat | Aplikasi ";
				}elseif ($aksi == 'e') {
					$p = "ns_edit";
					if ($data['user']->row()->level == 's_admin') {
							redirect('404_content');
					}

					$data['query'] = $this->db->get_where("tbl_ns", array('id_ns' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Edit Nomor Surat | Aplikasi ";

					if ($data['query']->id_user == '') {
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak mengubah data nomor surat.
								</div>'
							);

							redirect('users/ns');
					}

				}elseif ($aksi == 'h') {

					if ($data['user']->row()->level == 's_admin') {
							redirect('404_content');
					}
					$data['query'] = $this->db->get_where("tbl_ns", array('id_ns' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Nomor Surat | Aplikasi ";

					if ($data['query']->id_user == '') {
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data nomor surat.
								</div>'
							);
					}else {
							$this->Mcrud->delete_ns_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Nomor surat berhasil dihapus.
								</div>'
							);
					}

					redirect('users/ns');
				}else{
					$p = "ns";

					$data['judul_web'] 	  = "Nomor surat | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pengaturan/$p", $data);
					$this->load->view('users/footer');

					date_default_timezone_set('Asia/Jakarta');
					$tgl = date('d-m-Y H:i:s');

					if (isset($_POST['btnsimpan'])) {
						$separator 	 		= htmlentities(strip_tags($this->input->post('separator')));

						$no_posisi 	 		= htmlentities(strip_tags($this->input->post('no_posisi')));
						$no 	 					= htmlentities(strip_tags($this->input->post('no')));

						$org_posisi 		= htmlentities(strip_tags($this->input->post('org_posisi')));
						$org 	 					= htmlentities(strip_tags($this->input->post('org')));

						$bag_posisi 		= htmlentities(strip_tags($this->input->post('bag_posisi')));
						$bag 	 					= htmlentities(strip_tags($this->input->post('bag')));

						$subbag_posisi 	= htmlentities(strip_tags($this->input->post('subbag_posisi')));
						$subbag 	 			= htmlentities(strip_tags($this->input->post('subbag')));

						$bln_posisi 	 	= htmlentities(strip_tags($this->input->post('bln_posisi')));
						$bln 	 					= htmlentities(strip_tags($this->input->post('bln')));

						$thn_posisi 	 	= htmlentities(strip_tags($this->input->post('thn_posisi')));
						$thn 	 					= htmlentities(strip_tags($this->input->post('thn')));
						$reset_no 		 	= htmlentities(strip_tags($this->input->post('reset_no')));

						$prefix 	 			= htmlentities(strip_tags($this->input->post('prefix')));
						$prefix_posisi 	= htmlentities(strip_tags($this->input->post('prefix_posisi')));

						$jenis_ns 		 	= htmlentities(strip_tags($this->input->post('jenis_ns')));
						$ket 	 					= htmlentities(strip_tags($this->input->post('ket')));

						//1
						if ($no_posisi == 1) {
								$no1 = $no;
						}elseif ($no_posisi == 2) {
								$no2 = $no;
						}elseif ($no_posisi == 3) {
								$no3 = $no;
						}elseif ($no_posisi == 4) {
								$no4 = $no;
						}elseif ($no_posisi == 5) {
								$no5 = $no;
						}elseif ($no_posisi == 6) {
								$no6 = $no;
						}

						//2
						if ($org_posisi == 1) {
								$no1 = $org;
						}elseif ($org_posisi == 2) {
								$no2 = $org;
						}elseif ($org_posisi == 3) {
								$no3 = $org;
						}elseif ($org_posisi == 4) {
								$no4 = $org;
						}elseif ($org_posisi == 5) {
								$no5 = $org;
						}elseif ($org_posisi == 6) {
								$no6 = $org;
						}

						//3
						if ($bag_posisi == 1) {
								$no1 = $bag;
						}elseif ($bag_posisi == 2) {
								$no2 = $bag;
						}elseif ($bag_posisi == 3) {
								$no3 = $bag;
						}elseif ($bag_posisi == 4) {
								$no4 = $bag;
						}elseif ($bag_posisi == 5) {
								$no5 = $bag;
						}elseif ($bag_posisi == 6) {
								$no6 = $bag;
						}

						//4
						if ($subbag_posisi == 1) {
								$no1 = $subbag;
						}elseif ($subbag_posisi == 2) {
								$no2 = $subbag;
						}elseif ($subbag_posisi == 3) {
								$no3 = $subbag;
						}elseif ($subbag_posisi == 4) {
								$no4 = $subbag;
						}elseif ($subbag_posisi == 5) {
								$no5 = $subbag;
						}elseif ($subbag_posisi == 6) {
								$no6 = $subbag;
						}

						//5
						if ($bln_posisi == 1) {
								$no1 = $bln;
						}elseif ($bln_posisi == 2) {
								$no2 = $bln;
						}elseif ($bln_posisi == 3) {
								$no3 = $bln;
						}elseif ($bln_posisi == 4) {
								$no4 = $bln;
						}elseif ($bln_posisi == 5) {
								$no5 = $bln;
						}elseif ($bln_posisi == 6) {
								$no6 = $bln;
						}

						//6
						if ($thn_posisi == 1) {
								$no1 = $thn;
						}elseif ($thn_posisi == 2) {
								$no2 = $thn;
						}elseif ($thn_posisi == 3) {
								$no3 = $thn;
						}elseif ($thn_posisi == 4) {
								$no4 = $thn;
						}elseif ($thn_posisi == 5) {
								$no5 = $thn;
						}elseif ($thn_posisi == 6) {
								$no6 = $thn;
						}

						if ($no1 != '') {
								if ($no2 != '') {
										$no1 = "$no1$separator";
								}else{
										$no1 = "$no1";
								}
						}
						if ($no2 != '') {
								if ($no3 != '') {
										$no2 = "$no2$separator";
								}else{
										$no2 = "$no2";
								}
						}
						if ($no3 != '') {
								if ($no4 != '') {
										$no3 = "$no3$separator";
								}else{
										$no3 = "$no3";
								}
						}
						if ($no4 != '') {
								if ($no5 != '') {
										$no4 = "$no4$separator";
								}else{
										$no4 = "$no4";
								}
						}
						if ($no5 != '') {
								if ($no6 != '') {
										$no5 = "$no5$separator";
								}else{
										$no5 = "$no5";
								}
						}

						if ($prefix_posisi == "kiri") {
								$p_kiri  = "$prefix$separator";
								$p_kanan = '';
						}elseif ($prefix_posisi == "kanan") {
								$p_kiri  = '';
								$p_kanan = "$separator$prefix";
						}else{
								$p_kiri  = '';
								$p_kanan = '';
						}

						if ($reset_no == '') {
								$reset_no = 'thn';
						}

						$no_surat = "$p_kiri$no1$no2$no3$no4$no5$no6$p_kanan";

						if ($ket == '') {
								$ket = '-';
						}
										$data = array(
											'separator'			 => $separator,
											'no_posisi'			 => $no_posisi,
											'no'			  		 => $no,
											'org_posisi'		 => $org_posisi,
											'org'			  		 => $org,
											'bag_posisi'		 => $bag_posisi,
											'bag'						 => $bag,
											'subbag_posisi'	 => $subbag_posisi,
											'subbag'			   => $subbag,
											'bln_posisi'		 => $bln_posisi,
											'bln'			   		 => $bln,
											'thn_posisi'		 => $thn_posisi,
											'thn'		 				 => $thn,
											'reset_no'			 => $reset_no,
											'prefix'			   => $prefix,
											'prefix_posisi'	 => $prefix_posisi,
											'jenis_ns'			 => $jenis_ns,
											'ket'			   		 => $ket,
											'no_surat'			 => $no_surat,
											'id_user'			   => $id_user,
											'tgl_ns'				 => $tgl
										);
										$this->Mcrud->save_ns($data);

										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Nomor Surat berhasil ditambahkan.
											</div>'
										);

									redirect('users/ns/t');
					}

					if (isset($_POST['btnupdate'])) {
						$separator 	 		= htmlentities(strip_tags($this->input->post('separator')));

						$no_posisi 	 		= htmlentities(strip_tags($this->input->post('no_posisi')));
						$no 	 					= htmlentities(strip_tags($this->input->post('no')));

						$org_posisi 		= htmlentities(strip_tags($this->input->post('org_posisi')));
						$org 	 					= htmlentities(strip_tags($this->input->post('org')));

						$bag_posisi 		= htmlentities(strip_tags($this->input->post('bag_posisi')));
						$bag 	 					= htmlentities(strip_tags($this->input->post('bag')));

						$subbag_posisi 	= htmlentities(strip_tags($this->input->post('subbag_posisi')));
						$subbag 	 			= htmlentities(strip_tags($this->input->post('subbag')));

						$bln_posisi 	 	= htmlentities(strip_tags($this->input->post('bln_posisi')));
						$bln 	 					= htmlentities(strip_tags($this->input->post('bln')));

						$thn_posisi 	 	= htmlentities(strip_tags($this->input->post('thn_posisi')));
						$thn 	 					= htmlentities(strip_tags($this->input->post('thn')));
						$reset_no 		 	= htmlentities(strip_tags($this->input->post('reset_no')));

						$prefix 	 			= htmlentities(strip_tags($this->input->post('prefix')));
						$prefix_posisi 	= htmlentities(strip_tags($this->input->post('prefix_posisi')));

						$jenis_ns 		 	= htmlentities(strip_tags($this->input->post('jenis_ns')));
						$ket 	 					= htmlentities(strip_tags($this->input->post('ket')));

						$no1 = '';
						$no2 = '';
						$no3 = '';
						$no4 = '';
						$no5 = '';
						$no6 = '';

						//1
						if ($no_posisi == 1) {
								$no1 = $no;
						}elseif ($no_posisi == 2) {
								$no2 = $no;
						}elseif ($no_posisi == 3) {
								$no3 = $no;
						}elseif ($no_posisi == 4) {
								$no4 = $no;
						}elseif ($no_posisi == 5) {
								$no5 = $no;
						}elseif ($no_posisi == 6) {
								$no6 = $no;
						}

						//2
						if ($org_posisi == 1) {
								$no1 = $org;
						}elseif ($org_posisi == 2) {
								$no2 = $org;
						}elseif ($org_posisi == 3) {
								$no3 = $org;
						}elseif ($org_posisi == 4) {
								$no4 = $org;
						}elseif ($org_posisi == 5) {
								$no5 = $org;
						}elseif ($org_posisi == 6) {
								$no6 = $org;
						}

						//3
						if ($bag_posisi == 1) {
								$no1 = $bag;
						}elseif ($bag_posisi == 2) {
								$no2 = $bag;
						}elseif ($bag_posisi == 3) {
								$no3 = $bag;
						}elseif ($bag_posisi == 4) {
								$no4 = $bag;
						}elseif ($bag_posisi == 5) {
								$no5 = $bag;
						}elseif ($bag_posisi == 6) {
								$no6 = $bag;
						}

						//4
						if ($subbag_posisi == 1) {
								$no1 = $subbag;
						}elseif ($subbag_posisi == 2) {
								$no2 = $subbag;
						}elseif ($subbag_posisi == 3) {
								$no3 = $subbag;
						}elseif ($subbag_posisi == 4) {
								$no4 = $subbag;
						}elseif ($subbag_posisi == 5) {
								$no5 = $subbag;
						}elseif ($subbag_posisi == 6) {
								$no6 = $subbag;
						}

						//5
						if ($bln_posisi == 1) {
								$no1 = $bln;
						}elseif ($bln_posisi == 2) {
								$no2 = $bln;
						}elseif ($bln_posisi == 3) {
								$no3 = $bln;
						}elseif ($bln_posisi == 4) {
								$no4 = $bln;
						}elseif ($bln_posisi == 5) {
								$no5 = $bln;
						}elseif ($bln_posisi == 6) {
								$no6 = $bln;
						}

						//6
						if ($thn_posisi == 1) {
								$no1 = $thn;
						}elseif ($thn_posisi == 2) {
								$no2 = $thn;
						}elseif ($thn_posisi == 3) {
								$no3 = $thn;
						}elseif ($thn_posisi == 4) {
								$no4 = $thn;
						}elseif ($thn_posisi == 5) {
								$no5 = $thn;
						}elseif ($thn_posisi == 6) {
								$no6 = $thn;
						}

						if ($no1 != '') {
								if ($no2 != '') {
										$no1 = "$no1$separator";
								}else{
										$no1 = "$no1";
								}
						}
						if ($no2 != '') {
								if ($no3 != '') {
										$no2 = "$no2$separator";
								}else{
										$no2 = "$no2";
								}
						}
						if ($no3 != '') {
								if ($no4 != '') {
										$no3 = "$no3$separator";
								}else{
										$no3 = "$no3";
								}
						}
						if ($no4 != '') {
								if ($no5 != '') {
										$no4 = "$no4$separator";
								}else{
										$no4 = "$no4";
								}
						}
						if ($no5 != '') {
								if ($no6 != '') {
										$no5 = "$no5$separator";
								}else{
										$no5 = "$no5";
								}
						}


						if ($prefix_posisi == "kiri") {
								$p_kiri  = "$prefix$separator";
								$p_kanan = '';
						}else{
								$p_kiri  = '';
								$p_kanan = "$separator$prefix";
						}

						if ($reset_no == '') {
								$reset_no = 'thn';
						}

						$no_surat = "$p_kiri$no1$no2$no3$no4$no5$no6$p_kanan";

						if ($ket == '') {
								$ket = '-';
						}
										$data = array(
											'separator'			 => $separator,
											'no_posisi'			 => $no_posisi,
											'no'			  		 => $no,
											'org_posisi'		 => $org_posisi,
											'org'			  		 => $org,
											'bag_posisi'		 => $bag_posisi,
											'bag'						 => $bag,
											'subbag_posisi'	 => $subbag_posisi,
											'subbag'			   => $subbag,
											'bln_posisi'		 => $bln_posisi,
											'bln'			   		 => $bln,
											'thn_posisi'		 => $thn_posisi,
											'thn'		 				 => $thn,
											'reset_no'			 => $reset_no,
											'prefix'			   => $prefix,
											'prefix_posisi'	 => $prefix_posisi,
											'jenis_ns'			 => $jenis_ns,
											'ket'			   		 => $ket,
											'no_surat'			 => $no_surat,
											'id_user'			   => $id_user
										);
									$this->Mcrud->update_ns(array('id_ns' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Nomor Surat berhasil diupdate.
										</div>'
									);
									redirect('users/ns');
					}

		}
	}



	public function ipk_lulusan($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('ipk_lulusan.id_ipk_lulusan', 'ASC');
			$data['ipk_lulusan'] 		  = $this->db->get("ipk_lulusan");

				if ($aksi == 't') {
					$p = "ipk_lulusan_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('ipk_lulusan', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "ipk_lulusan_detail";

					$data['query'] = $this->db->get_where("ipk_lulusan", array('id_ipk_lulusan' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
								'dibaca' => '1'
							);
							$this->Mcrud->update_ipk_lulusan(array('id_ipk_lulusan' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
								'disposisi' => '1'
							);
							$this->Mcrud->update_ipk_lulusan(array('id_ipk_lulusan' => "$id"), $data2);

							redirect('users/ipk_lulusan');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
								'disposisi' => '0'
							);
							$this->Mcrud->update_ipk_lulusan(array('id_ipk_lulusan' => "$id"), $data2);

							redirect('users/ipk_lulusan');
					}
				}elseif ($aksi == 'e') {
					$p = "ipk_lulusan_edit";
					
					$data['query'] = $this->db->get_where("ipk_lulusan", array('id_ipk_lulusan' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					

				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("ipk_lulusan", array('id_ipk_lulusan' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_ipk_lulusan(array('id_ipk_lulusan' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_ipk_lulusan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_ipk_lulusan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/ipk_lulusan');
				}else{
					$p = "ipk_lulusan";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$indeks_min   	= htmlentities(strip_tags($this->input->post('indeks_min')));
							$indeks_rata   	= htmlentities(strip_tags($this->input->post('indeks_rata')));
							$indeks_maks   	= htmlentities(strip_tags($this->input->post('indeks_maks')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('ipk_lulusan', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulus'			 => $tahun_lulus,
										'jumlah_lulusan'		   	 => $jumlah_lulusan,
										'indeks_min'		  	 => $indeks_min,
										'indeks_rata'		  	 => $indeks_rata,
										'indeks_maks'		  	 => $indeks_maks,
										'token_lampiran' => $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_ipk_lulusan($data);

									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$indeks_min   	= htmlentities(strip_tags($this->input->post('indeks_min')));
							$indeks_rata   	= htmlentities(strip_tags($this->input->post('indeks_rata')));
							$indeks_maks   	= htmlentities(strip_tags($this->input->post('indeks_maks')));

						

								$data = array(
										'tahun_lulus'			 => $tahun_lulus,
										'jumlah_lulusan'		   	 => $jumlah_lulusan,
										'indeks_min'		  	 => $indeks_min,
										'indeks_rata'		  	 => $indeks_rata,
										'indeks_maks'		  	 => $indeks_maks,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_ipk_lulusan(array('id_ipk_lulusan' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/ipk_lulusan');
					}

		}
	}




public function kepuasan_mhs($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kepuasan_mhs.id_kepuasan_mhs', 'ASC');
			$data['kepuasan_mhs'] 		  = $this->db->get("kepuasan_mhs");

				if ($aksi == 't') {
					$p = "kepuasan_mhs_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kepuasan_mhs', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kepuasan_mhs_detail";

					$data['query'] = $this->db->get_where("kepuasan_mhs", array('id_kepuasan_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kepuasan_mhs(array('id_kepuasan_mhs' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kepuasan_mhs(array('id_kepuasan_mhs' => "$id"), $data2);

							redirect('users/kepuasan_mhs');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kepuasan_mhs(array('id_kepuasan_mhs' => "$id"), $data2);

							redirect('users/kepuasan_mhs');
					}
				}elseif ($aksi == 'e') {
					$p = "kepuasan_mhs_edit";
					
					$data['query'] = $this->db->get_where("kepuasan_mhs", array('id_kepuasan_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("kepuasan_mhs", array('id_kepuasan_mhs' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kepuasan_mhs(array('id_kepuasan_mhs' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kepuasan_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kepuasan_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kepuasan_mhs');
				}else{
					$p = "kepuasan_mhs";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$aspek   	 	= htmlentities(strip_tags($this->input->post('aspek')));
							$tingkat_sangat  = htmlentities(strip_tags($this->input->post('tingkat_sangat')));
							$tingkat_baik  = htmlentities(strip_tags($this->input->post('tingkat_baik')));
							$tingkat_cukup  = htmlentities(strip_tags($this->input->post('tingkat_cukup')));
							$tingkat_kurang  = htmlentities(strip_tags($this->input->post('tingkat_kurang')));
							$rencana   	= htmlentities(strip_tags($this->input->post('rencana')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kepuasan_mhs', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'aspek'			 => $aspek,
										'tingkat_sangat'		   	 => $tingkat_sangat,
										'tingkat_baik'		   	 => $tingkat_baik,
										'tingkat_cukup'		   	 => $tingkat_cukup,
										'tingkat_kurang'		   	 => $tingkat_kurang,
										'rencana'		  	 => $rencana,
										'token_lampiran' => $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_kepuasan_mhs($data);

									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$aspek   	 	= htmlentities(strip_tags($this->input->post('aspek')));
							$tingkat_sangat  = htmlentities(strip_tags($this->input->post('tingkat_sangat')));
							$tingkat_baik  = htmlentities(strip_tags($this->input->post('tingkat_baik')));
							$tingkat_cukup  = htmlentities(strip_tags($this->input->post('tingkat_cukup')));
							$tingkat_kurang  = htmlentities(strip_tags($this->input->post('tingkat_kurang')));
							$rencana   	= htmlentities(strip_tags($this->input->post('rencana')));

								$data = array(
										'aspek'			 => $aspek,
										'tingkat_sangat'		   	 => $tingkat_sangat,
										'tingkat_baik'		   	 => $tingkat_baik,
										'tingkat_cukup'		   	 => $tingkat_cukup,
										'tingkat_kurang'		   	 => $tingkat_kurang,
										'rencana'		  	 => $rencana,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kepuasan_mhs(array('id_kepuasan_mhs' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kepuasan_mhs');
					}

		}
	}


	public function karya_mhs_disitasi($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('karya_mhs_disitasi.id_karya_mhs_disitasi', 'ASC');
			$data['karya_mhs_disitasi'] 		  = $this->db->get("karya_mhs_disitasi");

				if ($aksi == 't') {
					$p = "karya_mhs_disitasi_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('karya_mhs_disitasi', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "karya_mhs_disitasi_detail";

					$data['query'] = $this->db->get_where("karya_mhs_disitasi", array('id_karya_mhs_disitasi' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_karya_mhs_disitasi(array('id_karya_mhs_disitasi' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_karya_mhs_disitasi(array('id_karya_mhs_disitasi' => "$id"), $data2);

							redirect('users/karya_mhs_disitasi');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_karya_mhs_disitasi(array('id_karya_mhs_disitasi' => "$id"), $data2);

							redirect('users/karya_mhs_disitasi');
					}
				}elseif ($aksi == 'e') {
					$p = "karya_mhs_disitasi_edit";
					
					$data['query'] = $this->db->get_where("karya_mhs_disitasi", array('id_karya_mhs_disitasi' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("karya_mhs_disitasi", array('id_karya_mhs_disitasi' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_karya_mhs_disitasi(array('id_karya_mhs_disitasi' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_karya_mhs_disitasi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_karya_mhs_disitasi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/karya_mhs_disitasi');
				}else{
					$p = "karya_mhs_disitasi";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_mhs   	 	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$judul_artikel_disitasi  = htmlentities(strip_tags($this->input->post('judul_artikel_disitasi')));
							$jumlah_sitasi   	= htmlentities(strip_tags($this->input->post('jumlah_sitasi')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('karya_mhs_disitasi', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_mhs'			 => $nama_mhs,
										'judul_artikel_disitasi'		   	 => $judul_artikel_disitasi,
										'jumlah_sitasi'		  	 => $jumlah_sitasi,
										'token_lampiran' => $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_karya_mhs_disitasi($data);

									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_mhs   = htmlentities(strip_tags($this->input->post('nama_mhs')));
						$judul_artikel_disitasi  = htmlentities(strip_tags($this->input->post('judul_artikel_disitasi')));
						$jumlah_sitasi   	= htmlentities(strip_tags($this->input->post('jumlah_sitasi')));

								$data = array(
									'nama_mhs'			 => $nama_mhs,
									'judul_artikel_disitasi'		   	 => $judul_artikel_disitasi,
									'jumlah_sitasi'		  	 => $jumlah_sitasi,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_karya_mhs_disitasi(array('id_karya_mhs_disitasi' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/karya_mhs_disitasi');
					}

		}
	}


	public function karya_dtps_disitasi($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('karya_dtps_disitasi.id_karya_dtps_disitasi', 'ASC');
			$data['karya_dtps_disitasi'] 		  = $this->db->get("karya_dtps_disitasi");

				if ($aksi == 't') {
					$p = "karya_dtps_disitasi_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('karya_dtps_disitasi', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "karya_dtps_disitasi_detail";

					$data['query'] = $this->db->get_where("karya_dtps_disitasi", array('id_karya_dtps_disitasi' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_karya_dtps_disitasi(array('id_karya_dtps_disitasi' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_karya_dtps_disitasi(array('id_karya_dtps_disitasi' => "$id"), $data2);

							redirect('users/karya_dtps_disitasi');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_karya_dtps_disitasi(array('id_karya_dtps_disitasi' => "$id"), $data2);

							redirect('users/karya_dtps_disitasi');
					}
				}elseif ($aksi == 'e') {
					$p = "karya_dtps_disitasi_edit";
					
					$data['query'] = $this->db->get_where("karya_dtps_disitasi", array('id_karya_dtps_disitasi' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("karya_dtps_disitasi", array('id_karya_dtps_disitasi' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_karya_dtps_disitasi(array('id_karya_dtps_disitasi' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_karya_dtps_disitasi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_karya_dtps_disitasi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/karya_dtps_disitasi');
				}else{
					$p = "karya_dtps_disitasi";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$judul_artikel_disitasi  = htmlentities(strip_tags($this->input->post('judul_artikel_disitasi')));
							$jumlah_sitasi   	= htmlentities(strip_tags($this->input->post('jumlah_sitasi')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('karya_dtps_disitasi', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_dosen'			 => $nama_dosen,
										'judul_artikel_disitasi'		   	 => $judul_artikel_disitasi,
										'jumlah_sitasi'		  	 => $jumlah_sitasi,
										'token_lampiran' => $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_karya_dtps_disitasi($data);

									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_dosen   = htmlentities(strip_tags($this->input->post('nama_dosen')));
						$judul_artikel_disitasi  = htmlentities(strip_tags($this->input->post('judul_artikel_disitasi')));
						$jumlah_sitasi   	= htmlentities(strip_tags($this->input->post('jumlah_sitasi')));

								$data = array(
									'nama_dosen'			 => $nama_dosen,
									'judul_artikel_disitasi'		   	 => $judul_artikel_disitasi,
									'jumlah_sitasi'		  	 => $jumlah_sitasi,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_karya_dtps_disitasi(array('id_karya_dtps_disitasi' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/karya_dtps_disitasi');
					}

		}
	}



	public function integrasi_penelitian_pembelajaran($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('integrasi_penelitian_pembelajaran.id_integrasi_penelitian_pembelajaran', 'ASC');
			$data['integrasi_penelitian_pembelajaran'] 		  = $this->db->get("integrasi_penelitian_pembelajaran");

				if ($aksi == 't') {
					$p = "integrasi_penelitian_pembelajaran_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('integrasi_penelitian_pembelajaran', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "integrasi_penelitian_pembelajaran_detail";

					$this->db->join('tbl_user', 'integrasi_penelitian_pembelajaran.id_user=tbl_user.id_user');
					$data['query'] = $this->db->get_where("integrasi_penelitian_pembelajaran", array('id_integrasi_penelitian_pembelajaran' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'admin') {
							$data2 = array(
								'relasi' => '1'
							);
							$this->Mcrud->update_integrasi_penelitian_pembelajaran(array('id_integrasi_penelitian_pembelajaran' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_integrasi_penelitian_pembelajaran(array('id_integrasi_penelitian_pembelajaran' => "$id"), $data2);

							redirect('users/integrasi_penelitian_pembelajaran');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_integrasi_penelitian_pembelajaran(array('id_integrasi_penelitian_pembelajaran' => "$id"), $data2);

							redirect('users/integrasi_penelitian_pembelajaran');
					}
				}elseif ($aksi == 'e') {
					$p = "integrasi_penelitian_pembelajaran_edit";
					
					$data['query'] = $this->db->get_where("integrasi_penelitian_pembelajaran", array('id_integrasi_penelitian_pembelajaran' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("integrasi_penelitian_pembelajaran", array('id_integrasi_penelitian_pembelajaran' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_integrasi_penelitian_pembelajaran(array('id_integrasi_penelitian_pembelajaran' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_integrasi_penelitian_pembelajaran_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_integrasi_penelitian_pembelajaran_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/integrasi_penelitian_pembelajaran');
				}else{
					$p = "integrasi_penelitian_pembelajaran";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$judul   	 	= htmlentities(strip_tags($this->input->post('judul')));
							$nama_dosen  = htmlentities(strip_tags($this->input->post('nama_dosen')));
							$matkul   	= htmlentities(strip_tags($this->input->post('matkul')));
							$bentuk  = htmlentities(strip_tags($this->input->post('bentuk')));
							$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('integrasi_penelitian_pembelajaran', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'judul'					=> $judul,
										'nama_dosen'			=> $nama_dosen,
										'matkul'			   	 => $matkul,
										'bentuk'			  	 => $bentuk,
										'tahun'					 => $tahun,
										'token_lampiran'		 => $token,
										'relasi'				 => 0,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_integrasi_penelitian_pembelajaran($data);

									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$judul   = htmlentities(strip_tags($this->input->post('judul')));
						$nama_dosen  = htmlentities(strip_tags($this->input->post('nama_dosen')));
						$matkul   	= htmlentities(strip_tags($this->input->post('matkul')));
						$bentuk  = htmlentities(strip_tags($this->input->post('bentuk')));
						$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

								$data = array(
									'judul'					=> $judul,
									'nama_dosen'			=> $nama_dosen,
									'matkul'		   	 => $matkul,
									'bentuk'		  	 => $bentuk,
									'tahun'				=> $tahun,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_integrasi_penelitian_pembelajaran(array('id_integrasi_penelitian_pembelajaran' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/integrasi_penelitian_pembelajaran');
					}

		}
	}


	public function kepuasan_pengguna_lulusan($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kepuasan_pengguna_lulusan.id_kepuasan_pengguna_lulusan', 'ASC');
			$data['kepuasan_pengguna_lulusan'] 		  = $this->db->get("kepuasan_pengguna_lulusan");

				if ($aksi == 't') {
					$p = "kepuasan_pengguna_lulusan_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kepuasan_pengguna_lulusan', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kepuasan_pengguna_lulusan_detail";

					$data['query'] = $this->db->get_where("kepuasan_pengguna_lulusan", array('id_kepuasan_pengguna_lulusan' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kepuasan_pengguna_lulusan(array('id_kepuasan_pengguna_lulusan' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kepuasan_pengguna_lulusan(array('id_kepuasan_pengguna_lulusan' => "$id"), $data2);

							redirect('users/kepuasan_pengguna_lulusan');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kepuasan_pengguna_lulusan(array('id_kepuasan_pengguna_lulusan' => "$id"), $data2);

							redirect('users/kepuasan_pengguna_lulusan');
					}
				}elseif ($aksi == 'e') {
					$p = "kepuasan_pengguna_lulusan_edit";
					
					$data['query'] = $this->db->get_where("kepuasan_pengguna_lulusan", array('id_kepuasan_pengguna_lulusan' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("kepuasan_pengguna_lulusan", array('id_kepuasan_pengguna_lulusan' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kepuasan_pengguna_lulusan(array('id_kepuasan_pengguna_lulusan' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kepuasan_pengguna_lulusan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kepuasan_pengguna_lulusan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kepuasan_pengguna_lulusan');
				}else{
					$p = "kepuasan_pengguna_lulusan";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis_kepuasan   	 	= htmlentities(strip_tags($this->input->post('jenis_kepuasan')));
							$tingkat_kepuasan_sangat  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_sangat')));
							$tingkat_kepuasan_baik  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_baik')));
							$tingkat_kepuasan_cukup  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_cukup')));
							$tingkat_kepuasan_kurang  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_kurang')));
							$rencana   	= htmlentities(strip_tags($this->input->post('rencana')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kepuasan_pengguna_lulusan', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'jenis_kepuasan'		=> $jenis_kepuasan,
										'tingkat_kepuasan_sangat'		=> $tingkat_kepuasan_sangat,
										'tingkat_kepuasan_baik'		=> $tingkat_kepuasan_baik,
										'tingkat_kepuasan_cukup'		=> $tingkat_kepuasan_cukup,
										'tingkat_kepuasan_kurang'		=> $tingkat_kepuasan_kurang,
										'rencana'		   		 => $rencana,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_kepuasan_pengguna_lulusan($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$jenis_kepuasan   	 	= htmlentities(strip_tags($this->input->post('jenis_kepuasan')));
							$tingkat_kepuasan_sangat  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_sangat')));
							$tingkat_kepuasan_baik  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_baik')));
							$tingkat_kepuasan_cukup  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_cukup')));
							$tingkat_kepuasan_kurang  = htmlentities(strip_tags($this->input->post('tingkat_kepuasan_kurang')));
							$rencana   	= htmlentities(strip_tags($this->input->post('rencana')));
								$data = array(
									'jenis_kepuasan'		=> $jenis_kepuasan,
									'tingkat_kepuasan_sangat'		=> $tingkat_kepuasan_sangat,
									'tingkat_kepuasan_baik'		=> $tingkat_kepuasan_baik,
									'tingkat_kepuasan_cukup'		=> $tingkat_kepuasan_cukup,
									'tingkat_kepuasan_kurang'		=> $tingkat_kepuasan_kurang,
									'rencana'		   		 => $rencana,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kepuasan_pengguna_lulusan(array('id_kepuasan_pengguna_lulusan' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kepuasan_pengguna_lulusan');
					}

		}
	}

	public function ewmp_dosen_tetap($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('ewmp_dosen_tetap.id_ewmp_dosen_tetap', 'ASC');
			$data['ewmp_dosen_tetap'] 		  = $this->db->get("ewmp_dosen_tetap");

				if ($aksi == 't') {
					$p = "ewmp_dosen_tetap_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('ewmp_dosen_tetap', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "ewmp_dosen_tetap_detail";

					$data['query'] = $this->db->get_where("ewmp_dosen_tetap", array('id_ewmp_dosen_tetap' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_ewmp_dosen_tetap(array('id_ewmp_dosen_tetap' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_ewmp_dosen_tetap(array('id_ewmp_dosen_tetap' => "$id"), $data2);

							redirect('users/ewmp_dosen_tetap');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_ewmp_dosen_tetap(array('id_ewmp_dosen_tetap' => "$id"), $data2);

							redirect('users/ewmp_dosen_tetap');
					}
				}elseif ($aksi == 'e') {
					$p = "ewmp_dosen_tetap_edit";
					
					$data['query'] = $this->db->get_where("ewmp_dosen_tetap", array('id_ewmp_dosen_tetap' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("ewmp_dosen_tetap", array('id_ewmp_dosen_tetap' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_ewmp_dosen_tetap(array('id_ewmp_dosen_tetap' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_ewmp_dosen_tetap_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_ewmp_dosen_tetap_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/ewmp_dosen_tetap');
				}else{
					$p = "ewmp_dosen_tetap";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$dtps  = htmlentities(strip_tags($this->input->post('dtps')));
							$ekuivalen_pendidikan_akreditasi   	= htmlentities(strip_tags($this->input->post('ekuivalen_pendidikan_akreditasi')));
							$ekuivalen_pendidikan_dalampt  = htmlentities(strip_tags($this->input->post('ekuivalen_pendidikan_dalampt')));
							$ekuivalen_pendidikan_luarpt   	= htmlentities(strip_tags($this->input->post('ekuivalen_pendidikan_luarpt')));
							$penelitian   	 	= htmlentities(strip_tags($this->input->post('penelitian')));
							$pkm  = htmlentities(strip_tags($this->input->post('pkm')));
							$tugas   	= htmlentities(strip_tags($this->input->post('tugas')));
							$jumlah_sks  = htmlentities(strip_tags($this->input->post('jumlah_sks')));
							$rata_persemester   	= htmlentities(strip_tags($this->input->post('rata_persemester')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('ewmp_dosen_tetap', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_dosen'		=> $nama_dosen,
										'dtps'				=> $dtps,
										'ekuivalen_pendidikan_akreditasi' 		 => $ekuivalen_pendidikan_akreditasi,
										'ekuivalen_pendidikan_dalampt'		=> $ekuivalen_pendidikan_dalampt,
										'ekuivalen_pendidikan_luarpt'	 => $ekuivalen_pendidikan_luarpt,
										'penelitian'		=> $penelitian,
										'pkm'				=> $pkm,
										'tugas' 		 => $tugas,
										'jumlah_sks'		=> $jumlah_sks,
										'rata_persemester'	 => $rata_persemester,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_ewmp_dosen_tetap($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$dtps  = htmlentities(strip_tags($this->input->post('dtps')));
							$ekuivalen_pendidikan_akreditasi   	= htmlentities(strip_tags($this->input->post('ekuivalen_pendidikan_akreditasi')));
							$ekuivalen_pendidikan_dalampt  = htmlentities(strip_tags($this->input->post('ekuivalen_pendidikan_dalampt')));
							$ekuivalen_pendidikan_luarpt   	= htmlentities(strip_tags($this->input->post('ekuivalen_pendidikan_luarpt')));
							$penelitian   	 	= htmlentities(strip_tags($this->input->post('penelitian')));
							$pkm  = htmlentities(strip_tags($this->input->post('pkm')));
							$tugas   	= htmlentities(strip_tags($this->input->post('tugas')));
							$jumlah_sks  = htmlentities(strip_tags($this->input->post('jumlah_sks')));
							$rata_persemester   	= htmlentities(strip_tags($this->input->post('rata_persemester')));

								$data = array(
										'nama_dosen'		=> $nama_dosen,
										'dtps'				=> $dtps,
										'ekuivalen_pendidikan_akreditasi' 		 => $ekuivalen_pendidikan_akreditasi,
										'ekuivalen_pendidikan_dalampt'		=> $ekuivalen_pendidikan_dalampt,
										'ekuivalen_pendidikan_luarpt'	 => $ekuivalen_pendidikan_luarpt,
										'penelitian'		=> $penelitian,
										'pkm'				=> $pkm,
										'tugas' 		 => $tugas,
										'jumlah_sks'		=> $jumlah_sks,
										'rata_persemester'	 => $rata_persemester,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_ewmp_dosen_tetap(array('id_ewmp_dosen_tetap' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/ewmp_dosen_tetap');
					}

		}
	}


	public function dosen_pembimbing_utama_pa($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('dosen_pembimbing_utama_pa.id_dosen_pembimbing_utama_pa', 'ASC');
			$data['dosen_pembimbing_utama_pa'] 		  = $this->db->get("dosen_pembimbing_utama_pa");

				if ($aksi == 't') {
					$p = "dosen_pembimbing_utama_pa_tambah";

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('dosen_pembimbing_utama_pa', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "dosen_pembimbing_utama_pa_detail";

					$data['query'] = $this->db->get_where("dosen_pembimbing_utama_pa", array('id_dosen_pembimbing_utama_pa' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_pembimbing_utama_pa(array('id_dosen_pembimbing_utama_pa' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_pembimbing_utama_pa(array('id_dosen_pembimbing_utama_pa' => "$id"), $data2);

							redirect('users/dosen_pembimbing_utama_pa');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_pembimbing_utama_pa(array('id_dosen_pembimbing_utama_pa' => "$id"), $data2);

							redirect('users/dosen_pembimbing_utama_pa');
					}
				}elseif ($aksi == 'e') {
					$p = "dosen_pembimbing_utama_pa_edit";
					
					$data['query'] = $this->db->get_where("dosen_pembimbing_utama_pa", array('id_dosen_pembimbing_utama_pa' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("dosen_pembimbing_utama_pa", array('id_dosen_pembimbing_utama_pa' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_dosen_pembimbing_utama_pa(array('id_dosen_pembimbing_utama_pa' => "$id"), $data2);
							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_pembimbing_utama_pa_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_pembimbing_utama_pa_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/dosen_pembimbing_utama_pa');
				}else{
					$p = "dosen_pembimbing_utama_pa";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$dibimbing_diakreditasi_ts  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_ts')));
							$dibimbing_diakreditasi_ts1  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_ts1')));
							$dibimbing_diakreditasi_ts2  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_ts2')));
							$dibimbing_diakreditasi_rata  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_rata')));
							$dibimbing_pt_ts  = htmlentities(strip_tags($this->input->post('dibimbing_pt_ts')));
							$dibimbing_pt_ts1  = htmlentities(strip_tags($this->input->post('dibimbing_pt_ts1')));
							$dibimbing_pt_ts2  = htmlentities(strip_tags($this->input->post('dibimbing_pt_ts2')));
							$dibimbing_pt_rata  = htmlentities(strip_tags($this->input->post('dibimbing_pt_rata')));
							$ratarata_jumlah_bimbingan   	= htmlentities(strip_tags($this->input->post('ratarata_jumlah_bimbingan')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('dosen_pembimbing_utama_pa', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
									'nama_dosen'					=> $nama_dosen,
									'dibimbing_diakreditasi_ts'		=> $dibimbing_diakreditasi_ts,
									'dibimbing_diakreditasi_ts1'	=> $dibimbing_diakreditasi_ts1,
									'dibimbing_diakreditasi_ts2'	=> $dibimbing_diakreditasi_ts,
									'dibimbing_diakreditasi_rata'	=> $dibimbing_diakreditasi_rata,
									'dibimbing_pt_ts'				=> $dibimbing_pt_ts,
									'dibimbing_pt_ts1'				=> $dibimbing_pt_ts1,
									'dibimbing_pt_ts2'				=> $dibimbing_pt_ts2,
									'dibimbing_pt_rata'				=> $dibimbing_pt_rata,
									'ratarata_jumlah_bimbingan'		=> $ratarata_jumlah_bimbingan,
									'token_lampiran' 				=> $token,
									'id_user'						=> $id_user,
										
									);
									$this->Mcrud->save_dosen_pembimbing_utama_pa($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$dibimbing_diakreditasi_ts  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_ts')));
							$dibimbing_diakreditasi_ts1  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_ts1')));
							$dibimbing_diakreditasi_ts2  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_ts2')));
							$dibimbing_diakreditasi_rata  = htmlentities(strip_tags($this->input->post('dibimbing_diakreditasi_rata')));
							$dibimbing_pt_ts  = htmlentities(strip_tags($this->input->post('dibimbing_pt_ts')));
							$dibimbing_pt_ts1  = htmlentities(strip_tags($this->input->post('dibimbing_pt_ts1')));
							$dibimbing_pt_ts2  = htmlentities(strip_tags($this->input->post('dibimbing_pt_ts2')));
							$dibimbing_pt_rata  = htmlentities(strip_tags($this->input->post('dibimbing_pt_rata')));
							$ratarata_jumlah_bimbingan   	= htmlentities(strip_tags($this->input->post('ratarata_jumlah_bimbingan')));
	
								$data = array(
									'nama_dosen'					=> $nama_dosen,
									'dibimbing_diakreditasi_ts'		=> $dibimbing_diakreditasi_ts,
									'dibimbing_diakreditasi_ts1'	=> $dibimbing_diakreditasi_ts1,
									'dibimbing_diakreditasi_ts2'	=> $dibimbing_diakreditasi_ts,
									'dibimbing_diakreditasi_rata'	=> $dibimbing_diakreditasi_rata,
									'dibimbing_pt_ts'				=> $dibimbing_pt_ts,
									'dibimbing_pt_ts1'				=> $dibimbing_pt_ts1,
									'dibimbing_pt_ts2'				=> $dibimbing_pt_ts2,
									'dibimbing_pt_rata'				=> $dibimbing_pt_rata,
									'ratarata_jumlah_bimbingan'		=> $ratarata_jumlah_bimbingan,
									'id_user'						=> $id_user,
									
								);
								$this->Mcrud->update_dosen_pembimbing_utama_pa(array('id_dosen_pembimbing_utama_pa' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/dosen_pembimbing_utama_pa');
					}

		}
	}


	public function kesesuaian_bidang_kerja($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kesesuaian_bidang_kerja.id_kesesuaian_bidang_kerja', 'ASC');
			$data['kesesuaian_bidang_kerja'] 		  = $this->db->get("kesesuaian_bidang_kerja");

				if ($aksi == 't') {
					$p = "kesesuaian_bidang_kerja_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kesesuaian_bidang_kerja', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kesesuaian_bidang_kerja_detail";

					$data['query'] = $this->db->get_where("kesesuaian_bidang_kerja", array('id_kesesuaian_bidang_kerja' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kesesuaian_bidang_kerja(array('id_kesesuaian_bidang_kerja' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kesesuaian_bidang_kerja(array('id_kesesuaian_bidang_kerja' => "$id"), $data2);

							redirect('users/kesesuaian_bidang_kerja');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kesesuaian_bidang_kerja(array('id_kesesuaian_bidang_kerja' => "$id"), $data2);

							redirect('users/kesesuaian_bidang_kerja');
					}
				}elseif ($aksi == 'e') {
					$p = "kesesuaian_bidang_kerja_edit";
					
					$data['query'] = $this->db->get_where("kesesuaian_bidang_kerja", array('id_kesesuaian_bidang_kerja' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("kesesuaian_bidang_kerja", array('id_kesesuaian_bidang_kerja' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kesesuaian_bidang_kerja(array('id_kesesuaian_bidang_kerja' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kesesuaian_bidang_kerja_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kesesuaian_bidang_kerja_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kesesuaian_bidang_kerja');
				}else{
					$p = "kesesuaian_bidang_kerja";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$jumlah_lulusan_terlacak   	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
							$jumlah_tingkat_rendah   	= htmlentities(strip_tags($this->input->post('jumlah_tingkat_rendah')));
							$jumlah_tingkat_sedang   	= htmlentities(strip_tags($this->input->post('jumlah_tingkat_sedang')));
							$jumlah_tingkat_tinggi   	= htmlentities(strip_tags($this->input->post('jumlah_tingkat_tinggi')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kesesuaian_bidang_kerja', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulus'					=> $tahun_lulus,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak' 		=> $jumlah_lulusan_terlacak,
										'jumlah_tingkat_rendah'				 => $jumlah_tingkat_rendah,
										'jumlah_tingkat_sedang'				 => $jumlah_tingkat_sedang,
										'jumlah_tingkat_tinggi'				 => $jumlah_tingkat_tinggi,
										'token_lampiran' 					 => $token,
										'id_user'							 => $id_user,
										
									);
									$this->Mcrud->save_kesesuaian_bidang_kerja($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$jumlah_lulusan_terlacak   	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
							$jumlah_tingkat_rendah   	= htmlentities(strip_tags($this->input->post('jumlah_tingkat_rendah')));
							$jumlah_tingkat_sedang   	= htmlentities(strip_tags($this->input->post('jumlah_tingkat_sedang')));
							$jumlah_tingkat_tinggi   	= htmlentities(strip_tags($this->input->post('jumlah_tingkat_tinggi')));
	
								$data = array(
										'tahun_lulus'		=> $tahun_lulus,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak' 		 => $jumlah_lulusan_terlacak,
										'jumlah_tingkat_rendah'				 => $jumlah_tingkat_rendah,
										'jumlah_tingkat_sedang'				 => $jumlah_tingkat_sedang,
										'jumlah_tingkat_tinggi'				 => $jumlah_tingkat_tinggi,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kesesuaian_bidang_kerja(array('id_kesesuaian_bidang_kerja' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kesesuaian_bidang_kerja');
					}

		}
	}


	public function mahasiswa_asing($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('mahasiswa_asing.id_mahasiswa_asing', 'ASC');
			$data['mahasiswa_asing'] 		  = $this->db->get("mahasiswa_asing");

				if ($aksi == 't') {
					$p = "mahasiswa_asing_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('mahasiswa_asing', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "mahasiswa_asing_detail";

					$data['query'] = $this->db->get_where("mahasiswa_asing", array('id_mahasiswa_asing' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_mahasiswa_asing(array('id_mahasiswa_asing' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_mahasiswa_asing(array('id_mahasiswa_asing' => "$id"), $data2);

							redirect('users/mahasiswa_asing');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_mahasiswa_asing(array('id_mahasiswa_asing' => "$id"), $data2);

							redirect('users/mahasiswa_asing');
					}
				}elseif ($aksi == 'e') {
					$p = "mahasiswa_asing_edit";
					
					$data['query'] = $this->db->get_where("mahasiswa_asing", array('id_mahasiswa_asing' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("mahasiswa_asing", array('id_mahasiswa_asing' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_mahasiswa_asing(array('id_mahasiswa_asing' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_mahasiswa_asing_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_mahasiswa_asing_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/mahasiswa_asing');
				}else{
					$p = "mahasiswa_asing";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$program_studi   	 	= htmlentities(strip_tags($this->input->post('program_studi')));
							$jumlah_mhs_aktif_ts  = htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_ts')));
							$jumlah_mhs_aktif_ts1  = htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_ts1')));
							$jumlah_mhs_aktif_ts2  = htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_ts2')));
							$jumlah_mhs_fulltime_ts   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_fulltime_ts')));
							$jumlah_mhs_fulltime_ts1   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_fulltime_ts1')));
							$jumlah_mhs_fulltime_ts2   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_fulltime_ts2')));
							$jumlah_mhs_parttime_ts   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime_ts')));
							$jumlah_mhs_parttime_ts1   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime_ts1')));
							$jumlah_mhs_parttime_ts2   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime_ts2')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('mahasiswa_asing', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'program_studi'					 => $program_studi,
										'jumlah_mhs_aktif_ts'			 => $jumlah_mhs_aktif_ts,
										'jumlah_mhs_aktif_ts1'			 => $jumlah_mhs_aktif_ts1,
										'jumlah_mhs_aktif_ts2'		  	 => $jumlah_mhs_aktif_ts2,
										'jumlah_mhs_fulltime_ts' 		 => $jumlah_mhs_fulltime_ts,
										'jumlah_mhs_fulltime_ts1' 		 => $jumlah_mhs_fulltime_ts1,
										'jumlah_mhs_fulltime_ts2' 		 => $jumlah_mhs_fulltime_ts2,
										'jumlah_mhs_parttime_ts'		 => $jumlah_mhs_parttime_ts,
										'jumlah_mhs_parttime_ts1'		 => $jumlah_mhs_parttime_ts1,
										'jumlah_mhs_parttime_ts2'		 => $jumlah_mhs_parttime_ts2,
										'token_lampiran' 				 => $token,
										'id_user'						 => $id_user,
										
									);
									$this->Mcrud->save_mahasiswa_asing($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$program_studi   	 	= htmlentities(strip_tags($this->input->post('program_studi')));
							$jumlah_mhs_aktif_ts  = htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_ts')));
							$jumlah_mhs_aktif_ts1  = htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_ts1')));
							$jumlah_mhs_aktif_ts2  = htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_ts2')));
							$jumlah_mhs_fulltime_ts   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_fulltime_ts')));
							$jumlah_mhs_fulltime_ts1   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_fulltime_ts1')));
							$jumlah_mhs_fulltime_ts2   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_fulltime_ts2')));
							$jumlah_mhs_parttime_ts   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime_ts')));
							$jumlah_mhs_parttime_ts1   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime_ts1')));
							$jumlah_mhs_parttime_ts2   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime_ts2')));
	
								$data = array(
										'program_studi'				 	 => $program_studi,
										'jumlah_mhs_aktif_ts'			 => $jumlah_mhs_aktif_ts,
										'jumlah_mhs_aktif_ts1'			 => $jumlah_mhs_aktif_ts1,
										'jumlah_mhs_aktif_ts2'		  	 => $jumlah_mhs_aktif_ts2,
										'jumlah_mhs_fulltime_ts' 		 => $jumlah_mhs_fulltime_ts,
										'jumlah_mhs_fulltime_ts1' 		 => $jumlah_mhs_fulltime_ts1,
										'jumlah_mhs_fulltime_ts2' 		 => $jumlah_mhs_fulltime_ts2,
										'jumlah_mhs_parttime_ts'		 => $jumlah_mhs_parttime_ts,
										'jumlah_mhs_parttime_ts1'		 => $jumlah_mhs_parttime_ts1,
										'jumlah_mhs_parttime_ts2'		 => $jumlah_mhs_parttime_ts2,
										'token_lampiran' 				 => $token,
										'id_user'						 => $id_user,
									
								);
								$this->Mcrud->update_mahasiswa_asing(array('id_mahasiswa_asing' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/mahasiswa_asing');
					}

		}
	}


	public function penelitian_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('penelitian_dtps.id_penelitian_dtps', 'ASC');
			$data['penelitian_dtps'] 		  = $this->db->get("penelitian_dtps");

				if ($aksi == 't') {
					$p = "penelitian_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('penelitian_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "penelitian_dtps_detail";

					$data['query'] = $this->db->get_where("penelitian_dtps", array('id_penelitian_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps(array('id_penelitian_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps(array('id_penelitian_dtps' => "$id"), $data2);

							redirect('users/penelitian_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps(array('id_penelitian_dtps' => "$id"), $data2);

							redirect('users/penelitian_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "penelitian_dtps_edit";
					
					$data['query'] = $this->db->get_where("penelitian_dtps", array('id_penelitian_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("penelitian_dtps", array('id_penelitian_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_penelitian_dtps(array('id_penelitian_dtps' => "$id"), $data2);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penelitian_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/penelitian_dtps');
				}else{
					$p = "penelitian_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$sumber_pembiayaan   	 	= htmlentities(strip_tags($this->input->post('sumber_pembiayaan')));
							$jumlah_judul_penelitian_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_penelitian_ts')));
							$jumlah_judul_penelitian_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_penelitian_ts1')));
							$jumlah_judul_penelitian_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_penelitian_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							$jumlah_mhs_parttime   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('penelitian_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'sumber_pembiayaan'		=> $sumber_pembiayaan,
										'jumlah_judul_penelitian_ts'				=> $jumlah_judul_penelitian_ts,
										'jumlah_judul_penelitian_ts1'				=> $jumlah_judul_penelitian_ts1,
										'jumlah_judul_penelitian_ts2'				=> $jumlah_judul_penelitian_ts2,
										'jumlah' 		 => $jumlah,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_penelitian_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$sumber_pembiayaan   	 	= htmlentities(strip_tags($this->input->post('sumber_pembiayaan')));
							$jumlah_judul_penelitian_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_penelitian_ts')));
							$jumlah_judul_penelitian_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_penelitian_ts1')));
							$jumlah_judul_penelitian_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_penelitian_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							$jumlah_mhs_parttime   	= htmlentities(strip_tags($this->input->post('jumlah_mhs_parttime')));
	
								$data = array(
										'sumber_pembiayaan'		=> $sumber_pembiayaan,
										'jumlah_judul_penelitian_ts'				=> $jumlah_judul_penelitian_ts,
										'jumlah_judul_penelitian_ts1'				=> $jumlah_judul_penelitian_ts1,
										'jumlah_judul_penelitian_ts2'				=> $jumlah_judul_penelitian_ts2,
										'jumlah' 		 => $jumlah,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_penelitian_dtps(array('id_penelitian_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/penelitian_dtps');
					}

		}
	}


	public function prestasi_akademik($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('prestasi_akademik.id_prestasi_akademik', 'ASC');
			$data['prestasi_akademik'] 		  = $this->db->get("prestasi_akademik");

				if ($aksi == 't') {
					$p = "prestasi_akademik_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('prestasi_akademik', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "prestasi_akademik_detail";

					$data['query'] = $this->db->get_where("prestasi_akademik", array('id_prestasi_akademik' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_prestasi_akademik(array('id_prestasi_akademik' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_prestasi_akademik(array('id_prestasi_akademik' => "$id"), $data2);

							redirect('users/prestasi_akademik');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_prestasi_akademik(array('id_prestasi_akademik' => "$id"), $data2);

							redirect('users/prestasi_akademik');
					}
				}elseif ($aksi == 'e') {
					$p = "prestasi_akademik_edit";
					
					$data['query'] = $this->db->get_where("prestasi_akademik", array('id_prestasi_akademik' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("prestasi_akademik", array('id_prestasi_akademik' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_prestasi_akademik(array('id_prestasi_akademik' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_prestasi_akademik_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_prestasi_akademik_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/prestasi_akademik');
				}else{
					$p = "prestasi_akademik";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_kegiatan   	 	= htmlentities(strip_tags($this->input->post('nama_kegiatan')));
							$waktu_perolehan  = htmlentities(strip_tags($this->input->post('waktu_perolehan')));
							$tingkat  	= htmlentities(strip_tags($this->input->post('tingkat')));
							$prestasi   	= htmlentities(strip_tags($this->input->post('prestasi')));
							$nama_mhs   	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$nrp   	= htmlentities(strip_tags($this->input->post('nrp')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('prestasi_akademik', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_kegiatan'		=> $nama_kegiatan,
										'waktu_perolehan'				=> $waktu_perolehan,
										'tingkat'				=> $tingkat,
										'prestasi' 		 => $prestasi,
										'nama_mhs' 		 => $nama_mhs,
										'nrp' 		 => $nrp,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_prestasi_akademik($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_kegiatan   	 	= htmlentities(strip_tags($this->input->post('nama_kegiatan')));
							$waktu_perolehan  = htmlentities(strip_tags($this->input->post('waktu_perolehan')));
							$tingkat  	= htmlentities(strip_tags($this->input->post('tingkat')));
							$prestasi   	= htmlentities(strip_tags($this->input->post('prestasi')));
							$nama_mhs   	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$nrp   	= htmlentities(strip_tags($this->input->post('nrp')));
								$data = array(
									'nama_kegiatan'		=> $nama_kegiatan,
									'waktu_perolehan'				=> $waktu_perolehan,
									'tingkat'				=> $tingkat,
									'prestasi' 		 => $prestasi,
									'nama_mhs' 		 => $nama_mhs,
									'nrp' 		 => $nrp,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_prestasi_akademik(array('id_prestasi_akademik' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/prestasi_akademik');
					}

		}
	}


	public function prestasi_nonakademik($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('prestasi_nonakademik.id_prestasi_nonakademik', 'ASC');
			$data['prestasi_nonakademik'] 		  = $this->db->get("prestasi_nonakademik");

				if ($aksi == 't') {
					$p = "prestasi_nonakademik_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('prestasi_nonakademik', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "prestasi_nonakademik_detail";

					$data['query'] = $this->db->get_where("prestasi_nonakademik", array('id_prestasi_nonakademik' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_prestasi_nonakademik(array('id_prestasi_nonakademik' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_prestasi_nonakademik(array('id_prestasi_nonakademik' => "$id"), $data2);

							redirect('users/prestasi_nonakademik');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_prestasi_nonakademik(array('id_prestasi_nonakademik' => "$id"), $data2);

							redirect('users/prestasi_nonakademik');
					}
				}elseif ($aksi == 'e') {
					$p = "prestasi_nonakademik_edit";
					
					$data['query'] = $this->db->get_where("prestasi_nonakademik", array('id_prestasi_nonakademik' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("prestasi_nonakademik", array('id_prestasi_nonakademik' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_prestasi_nonakademik(array('id_prestasi_nonakademik' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_prestasi_nonakademik_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_prestasi_nonakademik_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/prestasi_nonakademik');
				}else{
					$p = "prestasi_nonakademik";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_kegiatan   	 	= htmlentities(strip_tags($this->input->post('nama_kegiatan')));
							$waktu_perolehan  = htmlentities(strip_tags($this->input->post('waktu_perolehan')));
							$tingkat  	= htmlentities(strip_tags($this->input->post('tingkat')));
							$prestasi   	= htmlentities(strip_tags($this->input->post('prestasi')));
							$nama_mhs   	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$nrp   	= htmlentities(strip_tags($this->input->post('nrp')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('prestasi_nonakademik', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_kegiatan'		=> $nama_kegiatan,
										'waktu_perolehan'				=> $waktu_perolehan,
										'tingkat'				=> $tingkat,
										'prestasi' 		 => $prestasi,
										'nama_mhs' 		 => $nama_mhs,
										'nrp' 		 => $nrp,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_prestasi_nonakademik($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_kegiatan   	 	= htmlentities(strip_tags($this->input->post('nama_kegiatan')));
							$waktu_perolehan  = htmlentities(strip_tags($this->input->post('waktu_perolehan')));
							$tingkat  	= htmlentities(strip_tags($this->input->post('tingkat')));
							$prestasi   	= htmlentities(strip_tags($this->input->post('prestasi')));
							$nama_mhs   	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$nrp   	= htmlentities(strip_tags($this->input->post('nrp')));
								$data = array(
									'nama_kegiatan'		=> $nama_kegiatan,
									'waktu_perolehan'				=> $waktu_perolehan,
									'tingkat'				=> $tingkat,
									'prestasi' 		 => $prestasi,
									'nama_mhs' 		 => $nama_mhs,
									'nrp' 		 => $nrp,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_prestasi_nonakademik(array('id_prestasi_nonakademik' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/prestasi_nonakademik');
					}

		}
	}



	public function produk_jasa_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('produk_jasa_dtps.id_produk_jasa_dtps', 'ASC');
			$data['produk_jasa_dtps'] 		  = $this->db->get("produk_jasa_dtps");

				if ($aksi == 't') {
					$p = "produk_jasa_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('produk_jasa_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "produk_jasa_dtps_detail";

					$data['query'] = $this->db->get_where("produk_jasa_dtps", array('id_produk_jasa_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_produk_jasa_dtps(array('id_produk_jasa_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_produk_jasa_dtps(array('id_produk_jasa_dtps' => "$id"), $data2);

							redirect('users/produk_jasa_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_produk_jasa_dtps(array('id_produk_jasa_dtps' => "$id"), $data2);

							redirect('users/produk_jasa_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "produk_jasa_dtps_edit";
					
					$data['query'] = $this->db->get_where("produk_jasa_dtps", array('id_produk_jasa_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("produk_jasa_dtps", array('id_produk_jasa_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_produk_jasa_dtps(array('id_produk_jasa_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_produk_jasa_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_produk_jasa_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/produk_jasa_dtps');
				}else{
					$p = "produk_jasa_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nama_produk_jasa  = htmlentities(strip_tags($this->input->post('nama_produk_jasa')));
							$deskripsi  	= htmlentities(strip_tags($this->input->post('deskripsi')));
							$bukti   	= htmlentities(strip_tags($this->input->post('bukti')));
							$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('produk_jasa_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_dosen'		=> $nama_dosen,
										'nama_produk_jasa'				=> $nama_produk_jasa,
										'deskripsi'				=> $deskripsi,
										'bukti' 		 => $bukti,
										'tahun' 		 => $tahun,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_produk_jasa_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
						$nama_produk_jasa  = htmlentities(strip_tags($this->input->post('nama_produk_jasa')));
						$deskripsi  	= htmlentities(strip_tags($this->input->post('deskripsi')));
						$bukti   	= htmlentities(strip_tags($this->input->post('bukti')));
						$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

								$data = array(
									'nama_dosen'		=> $nama_dosen,
									'nama_produk_jasa'				=> $nama_produk_jasa,
									'deskripsi'				=> $deskripsi,
									'bukti' 		 => $bukti,
									'tahun' 		 => $tahun,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_produk_jasa_dtps(array('id_produk_jasa_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/produk_jasa_dtps');
					}

		}
	}



	public function produk_jasa_mhs_diapdosi($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('produk_jasa_mhs_diapdosi.id_produk_jasa_mhs_diapdosi', 'ASC');
			$data['produk_jasa_mhs_diapdosi'] 		  = $this->db->get("produk_jasa_mhs_diapdosi");

				if ($aksi == 't') {
					$p = "produk_jasa_mhs_diapdosi_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('produk_jasa_mhs_diapdosi', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "produk_jasa_mhs_diapdosi_detail";

					$data['query'] = $this->db->get_where("produk_jasa_mhs_diapdosi", array('id_produk_jasa_mhs_diapdosi' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_produk_jasa_mhs_diapdosi(array('id_produk_jasa_mhs_diapdosi' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_produk_jasa_mhs_diapdosi(array('id_produk_jasa_mhs_diapdosi' => "$id"), $data2);

							redirect('users/produk_jasa_mhs_diapdosi');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_produk_jasa_mhs_diapdosi(array('id_produk_jasa_mhs_diapdosi' => "$id"), $data2);

							redirect('users/produk_jasa_mhs_diapdosi');
					}
				}elseif ($aksi == 'e') {
					$p = "produk_jasa_mhs_diapdosi_edit";
					
					$data['query'] = $this->db->get_where("produk_jasa_mhs_diapdosi", array('id_produk_jasa_mhs_diapdosi' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("produk_jasa_mhs_diapdosi", array('id_produk_jasa_mhs_diapdosi' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_produk_jasa_mhs_diapdosi(array('id_produk_jasa_mhs_diapdosi' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_produk_jasa_mhs_diapdosi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_produk_jasa_mhs_diapdosi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/produk_jasa_mhs_diapdosi');
				}else{
					$p = "produk_jasa_mhs_diapdosi";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_mhs   	 	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$produk_jasa  = htmlentities(strip_tags($this->input->post('produk_jasa')));
							$deskripsi  	= htmlentities(strip_tags($this->input->post('deskripsi')));
							$bukti   	= htmlentities(strip_tags($this->input->post('bukti')));
							$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('produk_jasa_mhs_diapdosi', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_mhs'		=> $nama_mhs,
										'produk_jasa'	=> $produk_jasa,
										'deskripsi'		=> $deskripsi,
										'bukti' 		 => $bukti,
										'tahun' 		 => $tahun,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_produk_jasa_mhs_diapdosi($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_mhs   	 	= htmlentities(strip_tags($this->input->post('nama_mhs')));
						$produk_jasa  = htmlentities(strip_tags($this->input->post('produk_jasa')));
						$deskripsi  	= htmlentities(strip_tags($this->input->post('deskripsi')));
						$bukti   	= htmlentities(strip_tags($this->input->post('bukti')));
						$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

								$data = array(
									'nama_mhs'		=> $nama_mhs,
									'produk_jasa'	=> $produk_jasa,
									'deskripsi'		=> $deskripsi,
									'bukti' 		 => $bukti,
									'tahun' 		 => $tahun,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_produk_jasa_mhs_diapdosi(array('id_produk_jasa_mhs_diapdosi' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/produk_jasa_mhs_diapdosi');
					}

		}
	}



	public function publikasi_ilmiah_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('publikasi_ilmiah_dtps.id_publikasi_ilmiah_dtps', 'ASC');
			$data['publikasi_ilmiah_dtps'] 		  = $this->db->get("publikasi_ilmiah_dtps");

				if ($aksi == 't') {
					$p = "publikasi_ilmiah_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('publikasi_ilmiah_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "publikasi_ilmiah_dtps_detail";

					$data['query'] = $this->db->get_where("publikasi_ilmiah_dtps", array('id_publikasi_ilmiah_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_publikasi_ilmiah_dtps(array('id_publikasi_ilmiah_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_publikasi_ilmiah_dtps(array('id_publikasi_ilmiah_dtps' => "$id"), $data2);

							redirect('users/publikasi_ilmiah_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_publikasi_ilmiah_dtps(array('id_publikasi_ilmiah_dtps' => "$id"), $data2);

							redirect('users/publikasi_ilmiah_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "publikasi_ilmiah_dtps_edit";
					
					$data['query'] = $this->db->get_where("publikasi_ilmiah_dtps", array('id_publikasi_ilmiah_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("publikasi_ilmiah_dtps", array('id_publikasi_ilmiah_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_publikasi_ilmiah_dtps(array('id_publikasi_ilmiah_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_publikasi_ilmiah_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_publikasi_ilmiah_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/publikasi_ilmiah_dtps');
				}else{
					$p = "publikasi_ilmiah_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('publikasi_ilmiah_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'	=> $jumlah_judul_ts,
										'jumlah_judul_ts1'	=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'	=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_publikasi_ilmiah_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
								$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'	=> $jumlah_judul_ts,
										'jumlah_judul_ts1'	=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'	=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_publikasi_ilmiah_dtps(array('id_publikasi_ilmiah_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/publikasi_ilmiah_dtps');
					}

		}
	}


		public function publikasi_ilmiah_mhs($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('publikasi_ilmiah_mhs.id_publikasi_ilmiah_mhs', 'ASC');
			$data['publikasi_ilmiah_mhs'] 		  = $this->db->get("publikasi_ilmiah_mhs");

				if ($aksi == 't') {
					$p = "publikasi_ilmiah_mhs_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('publikasi_ilmiah_mhs', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "publikasi_ilmiah_mhs_detail";

					$data['query'] = $this->db->get_where("publikasi_ilmiah_mhs", array('id_publikasi_ilmiah_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_publikasi_ilmiah_mhs(array('id_publikasi_ilmiah_mhs' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_publikasi_ilmiah_mhs(array('id_publikasi_ilmiah_mhs' => "$id"), $data2);

							redirect('users/publikasi_ilmiah_mhs');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_publikasi_ilmiah_mhs(array('id_publikasi_ilmiah_mhs' => "$id"), $data2);

							redirect('users/publikasi_ilmiah_mhs');
					}
				}elseif ($aksi == 'e') {
					$p = "publikasi_ilmiah_mhs_edit";
				
					$data['query'] = $this->db->get_where("publikasi_ilmiah_mhs", array('id_publikasi_ilmiah_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("publikasi_ilmiah_mhs", array('id_publikasi_ilmiah_mhs' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_publikasi_ilmiah_mhs(array('id_publikasi_ilmiah_mhs' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_publikasi_ilmiah_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_publikasi_ilmiah_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/publikasi_ilmiah_mhs');
				}else{
					$p = "publikasi_ilmiah_mhs";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('publikasi_ilmiah_mhs', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'	=> $jumlah_judul_ts,
										'jumlah_judul_ts1'	=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'	=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_publikasi_ilmiah_mhs($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
								$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'	=> $jumlah_judul_ts,
										'jumlah_judul_ts1'	=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'	=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_publikasi_ilmiah_mhs(array('id_publikasi_ilmiah_mhs' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/publikasi_ilmiah_mhs');
					}

		}
	}


	public function refrensi($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('refrensi.id_refrensi', 'ASC');
			$data['refrensi'] 		  = $this->db->get("refrensi");

				if ($aksi == 't') {
					$p = "refrensi_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('refrensi', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "refrensi_detail";

					$data['query'] = $this->db->get_where("refrensi", array('id_refrensi' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_refrensi(array('id_refrensi' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_refrensi(array('id_refrensi' => "$id"), $data2);

							redirect('users/refrensi');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_refrensi(array('id_refrensi' => "$id"), $data2);

							redirect('users/refrensi');
					}
				}elseif ($aksi == 'e') {
					$p = "refrensi_edit";

					$data['query'] = $this->db->get_where("refrensi", array('id_refrensi' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("refrensi", array('id_refrensi' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_refrensi(array('id_refrensi' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_refrensi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_refrensi_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/refrensi');
				}else{
					$p = "refrensi";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_tanggapan  	= htmlentities(strip_tags($this->input->post('jumlah_tanggapan')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('refrensi', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulus'		=> $tahun_lulus,
										'jumlah_lulusan'	=> $jumlah_lulusan,
										'jumlah_tanggapan'		=> $jumlah_tanggapan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_refrensi($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_tanggapan  	= htmlentities(strip_tags($this->input->post('jumlah_tanggapan')));
							
								$data = array(
									'tahun_lulus'		=> $tahun_lulus,
									'jumlah_lulusan'	=> $jumlah_lulusan,
									'jumlah_tanggapan'		=> $jumlah_tanggapan,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_refrensi(array('id_refrensi' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/refrensi');
					}

		}
	}


	public function seleksi_mahasiswa($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('seleksi_mahasiswa.id_seleksi_mahasiswa', 'ASC');
			$data['seleksi_mahasiswa'] 		  = $this->db->get("seleksi_mahasiswa");

				if ($aksi == 't') {
					$p = "seleksi_mahasiswa_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('seleksi_mahasiswa', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "seleksi_mahasiswa_detail";

					$data['query'] = $this->db->get_where("seleksi_mahasiswa", array('id_seleksi_mahasiswa' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_seleksi_mahasiswa(array('id_seleksi_mahasiswa' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_seleksi_mahasiswa(array('id_seleksi_mahasiswa' => "$id"), $data2);

							redirect('users/seleksi_mahasiswa');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_seleksi_mahasiswa(array('id_seleksi_mahasiswa' => "$id"), $data2);

							redirect('users/seleksi_mahasiswa');
					}
				}elseif ($aksi == 'e') {
					$p = "seleksi_mahasiswa_edit";
					
					$data['query'] = $this->db->get_where("seleksi_mahasiswa", array('id_seleksi_mahasiswa' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("seleksi_mahasiswa", array('id_seleksi_mahasiswa' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_seleksi_mahasiswa(array('id_seleksi_mahasiswa' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_seleksi_mahasiswa_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_seleksi_mahasiswa_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/seleksi_mahasiswa');
				}else{
					$p = "seleksi_mahasiswa";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
						$tahun_akademik   	 	= htmlentities(strip_tags($this->input->post('tahun_akademik')));
						$daya_tampung  = htmlentities(strip_tags($this->input->post('daya_tampung')));
						$jumlah_calon_pendaftar  	= htmlentities(strip_tags($this->input->post('jumlah_calon_pendaftar')));
						$jumlah_calon_lulus  	= htmlentities(strip_tags($this->input->post('jumlah_calon_lulus')));
						$jumlah_mhs_baru_reg  = htmlentities(strip_tags($this->input->post('jumlah_mhs_baru_reg')));
						$jumlah_mhs_baru_tra  = htmlentities(strip_tags($this->input->post('jumlah_mhs_baru_tra')));
						$jumlah_mhs_aktif_reg  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_reg')));
						$jumlah_mhs_aktif_tra  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_tra')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('seleksi_mahasiswa', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_akademik'				=> $tahun_akademik,
										'daya_tampung'					=> $daya_tampung,
										'jumlah_calon_pendaftar'		=> $jumlah_calon_pendaftar,
										'jumlah_calon_lulus'			=> $jumlah_calon_lulus,
										'jumlah_mhs_baru_reg'			=> $jumlah_mhs_baru_reg,
										'jumlah_mhs_baru_tra'			=> $jumlah_mhs_baru_tra,
										'jumlah_mhs_aktif_reg'			=> $jumlah_mhs_aktif_reg,
										'jumlah_mhs_aktif_tra'			=> $jumlah_mhs_aktif_tra,
										'token_lampiran' 				=> $token,
										'id_user'						=> $id_user,
										
									);
									$this->Mcrud->save_seleksi_mahasiswa($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$tahun_akademik   	 	= htmlentities(strip_tags($this->input->post('tahun_akademik')));
						$daya_tampung  = htmlentities(strip_tags($this->input->post('daya_tampung')));
						$jumlah_calon_pendaftar  	= htmlentities(strip_tags($this->input->post('jumlah_calon_pendaftar')));
						$jumlah_calon_lulus  	= htmlentities(strip_tags($this->input->post('jumlah_calon_lulus')));
						$jumlah_mhs_baru_reg  = htmlentities(strip_tags($this->input->post('jumlah_mhs_baru_reg')));
						$jumlah_mhs_baru_tra  = htmlentities(strip_tags($this->input->post('jumlah_mhs_baru_tra')));
						$jumlah_mhs_aktif_reg  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_reg')));
						$jumlah_mhs_aktif_tra  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_aktif_tra')));
							
								$data = array(
									'tahun_akademik'				=> $tahun_akademik,
									'daya_tampung'					=> $daya_tampung,
									'jumlah_calon_pendaftar'		=> $jumlah_calon_pendaftar,
									'jumlah_calon_lulus'			=> $jumlah_calon_lulus,
									'jumlah_mhs_baru_reg'			=> $jumlah_mhs_baru_reg,
									'jumlah_mhs_baru_tra'			=> $jumlah_mhs_baru_tra,
									'jumlah_mhs_aktif_reg'			=> $jumlah_mhs_aktif_reg,
									'jumlah_mhs_aktif_tra'			=> $jumlah_mhs_aktif_tra,
									'id_user'						=> $id_user,
									
								);
								$this->Mcrud->update_seleksi_mahasiswa(array('id_seleksi_mahasiswa' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/seleksi_mahasiswa');
					}

		}
	}


	public function tempat_kerja_lulusan($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('tempat_kerja_lulusan.id_tempat_kerja_lulusan', 'ASC');
			$data['tempat_kerja_lulusan'] 		  = $this->db->get("tempat_kerja_lulusan");

				if ($aksi == 't') {
					$p = "tempat_kerja_lulusan_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('tempat_kerja_lulusan', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "tempat_kerja_lulusan_detail";

					$data['query'] = $this->db->get_where("tempat_kerja_lulusan", array('id_tempat_kerja_lulusan' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_tempat_kerja_lulusan(array('id_tempat_kerja_lulusan' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_tempat_kerja_lulusan(array('id_tempat_kerja_lulusan' => "$id"), $data2);

							redirect('users/tempat_kerja_lulusan');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_tempat_kerja_lulusan(array('id_tempat_kerja_lulusan' => "$id"), $data2);

							redirect('users/tempat_kerja_lulusan');
					}
				}elseif ($aksi == 'e') {
					$p = "tempat_kerja_lulusan_edit";
					
					$data['query'] = $this->db->get_where("tempat_kerja_lulusan", array('id_tempat_kerja_lulusan' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("tempat_kerja_lulusan", array('id_tempat_kerja_lulusan' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_tempat_kerja_lulusan(array('id_tempat_kerja_lulusan' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_tempat_kerja_lulusan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_tempat_kerja_lulusan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/tempat_kerja_lulusan');
				}else{
					$p = "tempat_kerja_lulusan";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
						$tahun_lulusan   	 	= htmlentities(strip_tags($this->input->post('tahun_lulusan')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$bekerja_lokal  = htmlentities(strip_tags($this->input->post('bekerja_lokal')));
						$bekerja_nasional  = htmlentities(strip_tags($this->input->post('bekerja_nasional')));
						$bekerja_multi  = htmlentities(strip_tags($this->input->post('bekerja_multi')));
						

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('tempat_kerja_lulusan', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulusan'					=> $tahun_lulusan,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'		=> $jumlah_lulusan_terlacak,
										'bekerja_lokal'					=> $bekerja_lokal,
										'bekerja_nasional'				=> $bekerja_nasional,
										'bekerja_multi'					=> $bekerja_multi,
										'token_lampiran' 				=> $token,
										'id_user'						=> $id_user,
										
									);
									$this->Mcrud->save_tempat_kerja_lulusan($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$tahun_lulusan   	 	= htmlentities(strip_tags($this->input->post('tahun_lulusan')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$bekerja_lokal  = htmlentities(strip_tags($this->input->post('bekerja_lokal')));
						$bekerja_nasional  = htmlentities(strip_tags($this->input->post('bekerja_nasional')));
						$bekerja_multi  = htmlentities(strip_tags($this->input->post('bekerja_multi')));
							
								$data = array(
										'tahun_lulusan'					=> $tahun_lulusan,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'		=> $jumlah_lulusan_terlacak,
										'bekerja_lokal'					=> $bekerja_lokal,
										'bekerja_nasional'				=> $bekerja_nasional,
										'bekerja_multi'					=> $bekerja_multi,
										'id_user'						=> $id_user,
									
								);
								$this->Mcrud->update_tempat_kerja_lulusan(array('id_tempat_kerja_lulusan' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/tempat_kerja_lulusan');
					}

		}
	}


	public function waktu_tunggu_d3($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('waktu_tunggu_d3.id_waktu_tunggu_d3', 'ASC');
			$data['waktu_tunggu_d3'] 		  = $this->db->get("waktu_tunggu_d3");

				if ($aksi == 't') {
					$p = "waktu_tunggu_d3_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('waktu_tunggu_d3', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "waktu_tunggu_d3_detail";

					$data['query'] = $this->db->get_where("waktu_tunggu_d3", array('id_waktu_tunggu_d3' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_d3(array('id_waktu_tunggu_d3' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_d3(array('id_waktu_tunggu_d3' => "$id"), $data2);

							redirect('users/waktu_tunggu_d3');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_d3(array('id_waktu_tunggu_d3' => "$id"), $data2);

							redirect('users/waktu_tunggu_d3');
					}
				}elseif ($aksi == 'e') {
					$p = "waktu_tunggu_d3_edit";
					
					$data['query'] = $this->db->get_where("waktu_tunggu_d3", array('id_waktu_tunggu_d3' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("waktu_tunggu_d3", array('id_waktu_tunggu_d3' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_waktu_tunggu_d3(array('id_waktu_tunggu_d3' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_waktu_tunggu_d3_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_waktu_tunggu_d3_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/waktu_tunggu_d3');
				}else{
					$p = "waktu_tunggu_d3";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$jumlah_dipesan  = htmlentities(strip_tags($this->input->post('jumlah_dipesan')));
						$mendapat_pekerjaan_3  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_3')));
						$mendapat_pekerjaan_36  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_36')));
						$mendapat_pekerjaan_6  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_6')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('waktu_tunggu_d3', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulus'				=> $tahun_lulus,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'	=> $jumlah_lulusan_terlacak,
										'jumlah_dipesan'			=> $jumlah_dipesan,
										'mendapat_pekerjaan_3'		=> $mendapat_pekerjaan_3,
										'mendapat_pekerjaan_36'		=> $mendapat_pekerjaan_36,
										'mendapat_pekerjaan_6'		=> $mendapat_pekerjaan_6,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_waktu_tunggu_d3($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$jumlah_dipesan  = htmlentities(strip_tags($this->input->post('jumlah_dipesan')));
						$mendapat_pekerjaan_3  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_3')));
						$mendapat_pekerjaan_36  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_36')));
						$mendapat_pekerjaan_6  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_6')));
							
								$data = array(
										'tahun_lulus'				=> $tahun_lulus,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'	=> $jumlah_lulusan_terlacak,
										'jumlah_dipesan'			=> $jumlah_dipesan,
										'mendapat_pekerjaan_3'		=> $mendapat_pekerjaan_3,
										'mendapat_pekerjaan_36'		=> $mendapat_pekerjaan_36,
										'mendapat_pekerjaan_6'		=> $mendapat_pekerjaan_6,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_waktu_tunggu_d3(array('id_waktu_tunggu_d3' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/waktu_tunggu_d3');
					}

		}
	}



	public function waktu_tunggu_s($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('waktu_tunggu_s.id_waktu_tunggu_s', 'ASC');
			$data['waktu_tunggu_s'] 		  = $this->db->get("waktu_tunggu_s");

				if ($aksi == 't') {
					$p = "waktu_tunggu_s_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('waktu_tunggu_s', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "waktu_tunggu_s_detail";

					$data['query'] = $this->db->get_where("waktu_tunggu_s", array('id_waktu_tunggu_s' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_s(array('id_waktu_tunggu_s' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_s(array('id_waktu_tunggu_s' => "$id"), $data2);

							redirect('users/waktu_tunggu_s');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_s(array('id_waktu_tunggu_s' => "$id"), $data2);

							redirect('users/waktu_tunggu_s');
					}
				}elseif ($aksi == 'e') {
					$p = "waktu_tunggu_s_edit";
					
					$data['query'] = $this->db->get_where("waktu_tunggu_s", array('id_waktu_tunggu_s' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("waktu_tunggu_s", array('id_waktu_tunggu_s' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_waktu_tunggu_s(array('id_waktu_tunggu_s' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_waktu_tunggu_s_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_waktu_tunggu_s_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/waktu_tunggu_s');
				}else{
					$p = "waktu_tunggu_s";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$mendapat_pekerjaan_6  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_6')));
						$mendapat_pekerjaan_618  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_618')));
						$mendapat_pekerjaan_18  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_18')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('waktu_tunggu_s', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulus'					=> $tahun_lulus,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'		=> $jumlah_lulusan_terlacak,
										'mendapat_pekerjaan_6'			=> $mendapat_pekerjaan_6,
										'mendapat_pekerjaan_618'		=> $mendapat_pekerjaan_618,
										'mendapat_pekerjaan_18'			=> $mendapat_pekerjaan_18,
										'token_lampiran' 				=> $token,
										'id_user'						=> $id_user,
										
									);
									$this->Mcrud->save_waktu_tunggu_s($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$mendapat_pekerjaan_6  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_6')));
						$mendapat_pekerjaan_618  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_618')));
						$mendapat_pekerjaan_18  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_18')));
							
								$data = array(
										'tahun_lulus'					=> $tahun_lulus,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'		=> $jumlah_lulusan_terlacak,
										'mendapat_pekerjaan_6'			=> $mendapat_pekerjaan_6,
										'mendapat_pekerjaan_618'		=> $mendapat_pekerjaan_618,
										'mendapat_pekerjaan_18'			=> $mendapat_pekerjaan_18,
										'id_user'						=> $id_user,
									
								);
								$this->Mcrud->update_waktu_tunggu_s(array('id_waktu_tunggu_s' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/waktu_tunggu_s');
					}

		}
	}



	public function waktu_tunggu_st($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('waktu_tunggu_st.id_waktu_tunggu_st', 'ASC');
			$data['waktu_tunggu_st'] 		  = $this->db->get("waktu_tunggu_st");

				if ($aksi == 't') {
					$p = "waktu_tunggu_st_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('waktu_tunggu_st', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "waktu_tunggu_st_detail";

					$data['query'] = $this->db->get_where("waktu_tunggu_st", array('id_waktu_tunggu_st' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_st(array('id_waktu_tunggu_st' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_st(array('id_waktu_tunggu_st' => "$id"), $data2);

							redirect('users/waktu_tunggu_st');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_waktu_tunggu_st(array('id_waktu_tunggu_st' => "$id"), $data2);

							redirect('users/waktu_tunggu_st');
					}
				}elseif ($aksi == 'e') {
					$p = "waktu_tunggu_st_edit";
					
					$data['query'] = $this->db->get_where("waktu_tunggu_st", array('id_waktu_tunggu_st' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("waktu_tunggu_st", array('id_waktu_tunggu_st' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_waktu_tunggu_st(array('id_waktu_tunggu_st' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_waktu_tunggu_st_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_waktu_tunggu_st_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/waktu_tunggu_st');
				}else{
					$p = "waktu_tunggu_st";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$mendapat_pekerjaan_3  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_3')));
						$mendapat_pekerjaan_36  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_36')));
						$mendapat_pekerjaan_6  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_6')));


							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('waktu_tunggu_st', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_lulus'					=> $tahun_lulus,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'		=> $jumlah_lulusan_terlacak,
										'mendapat_pekerjaan_3'			=> $mendapat_pekerjaan_3,
										'mendapat_pekerjaan_36'			=> $mendapat_pekerjaan_36,
										'mendapat_pekerjaan_6'			=> $mendapat_pekerjaan_6,
										'token_lampiran' 				=> $token,
										'id_user'						=> $id_user,
										
									);
									$this->Mcrud->save_waktu_tunggu_st($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$tahun_lulus   	 	= htmlentities(strip_tags($this->input->post('tahun_lulus')));
						$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
						$jumlah_lulusan_terlacak  	= htmlentities(strip_tags($this->input->post('jumlah_lulusan_terlacak')));
						$mendapat_pekerjaan_3  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_3')));
						$mendapat_pekerjaan_36  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_36')));
						$mendapat_pekerjaan_6  = htmlentities(strip_tags($this->input->post('mendapat_pekerjaan_6')));
							
								$data = array(
										'tahun_lulus'					=> $tahun_lulus,
										'jumlah_lulusan'				=> $jumlah_lulusan,
										'jumlah_lulusan_terlacak'		=> $jumlah_lulusan_terlacak,
										'mendapat_pekerjaan_3'			=> $mendapat_pekerjaan_3,
										'mendapat_pekerjaan_36'			=> $mendapat_pekerjaan_36,
										'mendapat_pekerjaan_6'			=> $mendapat_pekerjaan_6,
										'id_user'						=> $id_user,
									
								);
								$this->Mcrud->update_waktu_tunggu_st(array('id_waktu_tunggu_st' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/waktu_tunggu_st');
					}

		}
	}


	public function penelitian_dtps_mhs($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('penelitian_dtps_mhs.id_penelitian_dtps_mhs', 'ASC');
			$data['penelitian_dtps_mhs'] 		  = $this->db->get("penelitian_dtps_mhs");

				if ($aksi == 't') {
					$p = "penelitian_dtps_mhs_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('penelitian_dtps_mhs', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "penelitian_dtps_mhs_detail";

					$data['query'] = $this->db->get_where("penelitian_dtps_mhs", array('id_penelitian_dtps_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps_mhs(array('id_penelitian_dtps_mhs' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps_mhs(array('id_penelitian_dtps_mhs' => "$id"), $data2);

							redirect('users/penelitian_dtps_mhs');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps_mhs(array('id_penelitian_dtps_mhs' => "$id"), $data2);

							redirect('users/penelitian_dtps_mhs');
					}
				}elseif ($aksi == 'e') {
					$p = "penelitian_dtps_mhs_edit";
					
					$data['query'] = $this->db->get_where("penelitian_dtps_mhs", array('id_penelitian_dtps_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("penelitian_dtps_mhs", array('id_penelitian_dtps_mhs' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_penelitian_dtps_mhs(array('id_penelitian_dtps_mhs' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penelitian_dtps_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penelitian_dtps_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/penelitian_dtps_mhs');
				}else{
					$p = "penelitian_dtps_mhs";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$tema  = htmlentities(strip_tags($this->input->post('tema')));
							$nama_mhs  	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$judul   	= htmlentities(strip_tags($this->input->post('judul')));
							$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('penelitian_dtps_mhs', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_dosen'		=> $nama_dosen,
										'tema'				=> $tema,
										'nama_mhs' 		 => $nama_mhs,
										'judul' 		 => $judul,
										'tahun' 		 => $tahun,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_penelitian_dtps_mhs($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
						$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
						$tema  = htmlentities(strip_tags($this->input->post('tema')));
						$nama_mhs  	= htmlentities(strip_tags($this->input->post('nama_mhs')));
						$judul   	= htmlentities(strip_tags($this->input->post('judul')));
						$tahun   	= htmlentities(strip_tags($this->input->post('tahun')));
								$data = array(
									'nama_dosen'		=> $nama_dosen,
									'tema'				=> $tema,
									'nama_mhs' 		 => $nama_mhs,
									'judul' 		 => $judul,
									'tahun' 		 => $tahun,
									'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_penelitian_dtps_mhs(array('id_penelitian_dtps_mhs' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/penelitian_dtps_mhs');
					}

		}
	}




	public function dosen_tetap($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('dosen_tetap.id_dosen_tetap', 'ASC');
			$data['dosen_tetap'] 		  = $this->db->get("dosen_tetap");

				if ($aksi == 't') {
					$p = "dosen_tetap_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('dosen_tetap', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "dosen_tetap_detail";

					$data['query'] = $this->db->get_where("dosen_tetap", array('id_dosen_tetap' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_tetap(array('id_dosen_tetap' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_tetap(array('id_dosen_tetap' => "$id"), $data2);

							redirect('users/dosen_tetap');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_tetap(array('id_dosen_tetap' => "$id"), $data2);

							redirect('users/dosen_tetap');
					}
				}elseif ($aksi == 'e') {
					$p = "dosen_tetap_edit";
					
					$data['query'] = $this->db->get_where("dosen_tetap", array('id_dosen_tetap' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("dosen_tetap", array('id_dosen_tetap' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_dosen_tetap(array('id_dosen_tetap' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_tetap_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_tetap_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/dosen_tetap');
				}else{
					$p = "dosen_tetap";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nidn_nidk  = htmlentities(strip_tags($this->input->post('nidn_nidk')));
							$pendidikan_magister  	= htmlentities(strip_tags($this->input->post('pendidikan_magister')));
							$pendidikan_doktor  	= htmlentities(strip_tags($this->input->post('pendidikan_doktor')));
							$bidang_keahlian
							   	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$kesesuaian_kompetensi   	= htmlentities(strip_tags($this->input->post('kesesuaian_kompetensi')));
							$jabatan_akademik   	 	= htmlentities(strip_tags($this->input->post('jabatan_akademik')));
							$sertifikat_profesional  = htmlentities(strip_tags($this->input->post('sertifikat_profesional')));
							$sertifikat_kompetensi_profesi  	= htmlentities(strip_tags($this->input->post('sertifikat_kompetensi_profesi')));
							$mata_kuliah_akreditasi   	= htmlentities(strip_tags($this->input->post('mata_kuliah_akreditasi')));
							$kesesuaian_keahlian   	= htmlentities(strip_tags($this->input->post('kesesuaian_keahlian')));
							$mata_kuliah_lain   	= htmlentities(strip_tags($this->input->post('mata_kuliah_lain')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('dosen_tetap', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_dosen'		=> $nama_dosen,
										'nidn_nidk'				=> $nidn_nidk,
										'pendidikan_magister' 		 => $pendidikan_magister,
										'pendidikan_doktor'		=> $pendidikan_doktor,
										'bidang_keahlian' 		 => $bidang_keahlian,
										'kesesuaian_kompetensi' 		 => $kesesuaian_kompetensi,
										'jabatan_akademik'		=> $jabatan_akademik,
										'sertifikat_profesional'	=> $sertifikat_profesional,
										'sertifikat_kompetensi_profesi' 	=> $sertifikat_kompetensi_profesi,
										'mata_kuliah_akreditasi' 		 => $mata_kuliah_akreditasi,
										'kesesuaian_keahlian' 		 => $kesesuaian_keahlian,
										'mata_kuliah_lain' 		=> $mata_kuliah_lain,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_dosen_tetap($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nidn_nidk  = htmlentities(strip_tags($this->input->post('nidn_nidk')));
							$pendidikan_magister  	= htmlentities(strip_tags($this->input->post('pendidikan_magister')));
							$pendidikan_doktor  	= htmlentities(strip_tags($this->input->post('pendidikan_doktor')));
							$bidang_keahlian
							   	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$kesesuaian_kompetensi   	= htmlentities(strip_tags($this->input->post('kesesuaian_kompetensi')));
							$jabatan_akademik   	 	= htmlentities(strip_tags($this->input->post('jabatan_akademik')));
							$sertifikat_profesional  = htmlentities(strip_tags($this->input->post('sertifikat_profesional')));
							$sertifikat_kompetensi_profesi  	= htmlentities(strip_tags($this->input->post('sertifikat_kompetensi_profesi')));
							$mata_kuliah_akreditasi   	= htmlentities(strip_tags($this->input->post('mata_kuliah_akreditasi')));
							$kesesuaian_keahlian   	= htmlentities(strip_tags($this->input->post('kesesuaian_keahlian')));
							$mata_kuliah_lain   	= htmlentities(strip_tags($this->input->post('mata_kuliah_lain')));
								$data = array(
										'nama_dosen'		=> $nama_dosen,
										'nidn_nidk'				=> $nidn_nidk,
										'pendidikan_magister' 		 => $pendidikan_magister,
										'pendidikan_doktor'		=> $pendidikan_doktor,
										'bidang_keahlian' 		 => $bidang_keahlian,
										'kesesuaian_kompetensi' 		 => $kesesuaian_kompetensi,
										'jabatan_akademik'		=> $jabatan_akademik,
										'sertifikat_profesional'	=> $sertifikat_profesional,
										'sertifikat_kompetensi_profesi' 	=> $sertifikat_kompetensi_profesi,
										'mata_kuliah_akreditasi' 		 => $mata_kuliah_akreditasi,
										'kesesuaian_keahlian' 		 => $kesesuaian_keahlian,
										'mata_kuliah_lain' 		=> $mata_kuliah_lain,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_dosen_tetap(array('id_dosen_tetap' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/dosen_tetap');
					}

		}
	}




	public function dosen_tidak_tetap($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('dosen_tidak_tetap.id_dosen_tidak_tetap', 'ASC');
			$data['dosen_tidak_tetap'] 		  = $this->db->get("dosen_tidak_tetap");

				if ($aksi == 't') {
					$p = "dosen_tidak_tetap_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('dosen_tidak_tetap', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "dosen_tidak_tetap_detail";

					$data['query'] = $this->db->get_where("dosen_tidak_tetap", array('id_dosen_tidak_tetap' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_tidak_tetap(array('id_dosen_tidak_tetap' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_tidak_tetap(array('id_dosen_tidak_tetap' => "$id"), $data2);

							redirect('users/dosen_tidak_tetap');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_tidak_tetap(array('id_dosen_tidak_tetap' => "$id"), $data2);

							redirect('users/dosen_tidak_tetap');
					}
				}elseif ($aksi == 'e') {
					$p = "dosen_tidak_tetap_edit";

					$data['query'] = $this->db->get_where("dosen_tidak_tetap", array('id_dosen_tidak_tetap' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("dosen_tidak_tetap", array('id_dosen_tidak_tetap' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_dosen_tidak_tetap(array('id_dosen_tidak_tetap' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_tidak_tetap_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_tidak_tetap_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/dosen_tidak_tetap');
				}else{
					$p = "dosen_tidak_tetap";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nidn_nidk  = htmlentities(strip_tags($this->input->post('nidn_nidk')));
							$pendidikan  	= htmlentities(strip_tags($this->input->post('pendidikan')));
							$bidang_keahlian
							   	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$jabatan_akademik   	 	= htmlentities(strip_tags($this->input->post('jabatan_akademik')));
							$sertifikat_profesional  = htmlentities(strip_tags($this->input->post('sertifikat_profesional')));
							$sertifikat_kompetensi_profesi  	= htmlentities(strip_tags($this->input->post('sertifikat_kompetensi_profesi')));
							$mata_kuliah_diampu   	= htmlentities(strip_tags($this->input->post('mata_kuliah_diampu')));
							$kesesuaian_keahlian   	= htmlentities(strip_tags($this->input->post('kesesuaian_keahlian')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('dosen_tidak_tetap', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'nama_dosen'		=> $nama_dosen,
										'nidn_nidk'				=> $nidn_nidk,
										'pendidikan' 		 => $pendidikan,
										'bidang_keahlian' 		 => $bidang_keahlian,
										'jabatan_akademik'		=> $jabatan_akademik,
										'sertifikat_profesional'	=> $sertifikat_profesional,
										'sertifikat_kompetensi_profesi' 	=> $sertifikat_kompetensi_profesi,
										'mata_kuliah_diampu' 		 => $mata_kuliah_diampu,
										'kesesuaian_keahlian' 		 => $kesesuaian_keahlian,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_dosen_tidak_tetap($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nidn_nidk  = htmlentities(strip_tags($this->input->post('nidn_nidk')));
							$pendidikan  	= htmlentities(strip_tags($this->input->post('pendidikan')));
							$bidang_keahlian
							   	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$jabatan_akademik   	 	= htmlentities(strip_tags($this->input->post('jabatan_akademik')));
							$sertifikat_profesional  = htmlentities(strip_tags($this->input->post('sertifikat_profesional')));
							$sertifikat_kompetensi_profesi  	= htmlentities(strip_tags($this->input->post('sertifikat_kompetensi_profesi')));
							$mata_kuliah_diampu   	= htmlentities(strip_tags($this->input->post('mata_kuliah_diampu')));
							$kesesuaian_keahlian   	= htmlentities(strip_tags($this->input->post('kesesuaian_keahlian')));


								$data = array(
										'nama_dosen'		=> $nama_dosen,
										'nidn_nidk'				=> $nidn_nidk,
										'pendidikan' 		 => $pendidikan,
										'bidang_keahlian' 		 => $bidang_keahlian,
										'jabatan_akademik'		=> $jabatan_akademik,
										'sertifikat_profesional'	=> $sertifikat_profesional,
										'sertifikat_kompetensi_profesi' 	=> $sertifikat_kompetensi_profesi,
										'mata_kuliah_diampu' 		 => $mata_kuliah_diampu,
										'kesesuaian_keahlian' 		 => $kesesuaian_keahlian,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_dosen_tidak_tetap(array('id_dosen_tidak_tetap' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/dosen_tidak_tetap');
					}

		}
	}



	public function kerjasama_tridharma_pendidikan($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kerjasama_tridharma_pendidikan.id_kerjasama_tridharma_pendidikan', 'ASC');
			$data['kerjasama_tridharma_pendidikan'] 		  = $this->db->get("kerjasama_tridharma_pendidikan");

				if ($aksi == 't') {
					$p = "kerjasama_tridharma_pendidikan_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kerjasama_tridharma_pendidikan', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kerjasama_tridharma_pendidikan_detail";

					$data['query'] = $this->db->get_where("kerjasama_tridharma_pendidikan", array('id_kerjasama_tridharma_pendidikan' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_pendidikan(array('id_kerjasama_tridharma_pendidikan' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_pendidikan(array('id_kerjasama_tridharma_pendidikan' => "$id"), $data2);

							redirect('users/kerjasama_tridharma_pendidikan');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_pendidikan(array('id_kerjasama_tridharma_pendidikan' => "$id"), $data2);

							redirect('users/kerjasama_tridharma_pendidikan');
					}
				}elseif ($aksi == 'e') {
					$p = "kerjasama_tridharma_pendidikan_edit";
					
					$data['query'] = $this->db->get_where("kerjasama_tridharma_pendidikan", array('id_kerjasama_tridharma_pendidikan' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("kerjasama_tridharma_pendidikan", array('id_kerjasama_tridharma_pendidikan' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kerjasama_tridharma_pendidikan(array('id_kerjasama_tridharma_pendidikan' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_pendidikan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_pendidikan_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kerjasama_tridharma_pendidikan');
				}else{
					$p = "kerjasama_tridharma_pendidikan";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$lembaga_mitra   	 	= htmlentities(strip_tags($this->input->post('lembaga_mitra')));
							$tingkat = htmlentities(strip_tags($this->input->post('tingkat')));
							$judul_kegiatan_kerjasama  	= htmlentities(strip_tags($this->input->post('judul_kegiatan_kerjasama')));
							$manfaat
							   	= htmlentities(strip_tags($this->input->post('manfaat')));
							$waktu_dan_durasi   	 	= htmlentities(strip_tags($this->input->post('waktu_dan_durasi')));
							$bukti_kerjasama  = htmlentities(strip_tags($this->input->post('bukti_kerjasama')));
							$tahun_berakhir  	= htmlentities(strip_tags($this->input->post('tahun_berakhir')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kerjasama_tridharma_pendidikan', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'lembaga_mitra'		=> $lembaga_mitra,
										'tingkat'				=> $tingkat,
										'judul_kegiatan_kerjasama' 		 => $judul_kegiatan_kerjasama,
										'manfaat' 		 => $manfaat,
										'waktu_dan_durasi'		=> $waktu_dan_durasi,
										'bukti_kerjasama'	=> $bukti_kerjasama,
										'tahun_berakhir' 	=> $tahun_berakhir,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_kerjasama_tridharma_pendidikan($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$lembaga_mitra   	 	= htmlentities(strip_tags($this->input->post('lembaga_mitra')));
							$tingkat  = htmlentities(strip_tags($this->input->post('tingkat')));
							$judul_kegiatan_kerjasama  	= htmlentities(strip_tags($this->input->post('judul_kegiatan_kerjasama')));
							$manfaat
							   	= htmlentities(strip_tags($this->input->post('manfaat')));
							$waktu_dan_durasi   	 	= htmlentities(strip_tags($this->input->post('waktu_dan_durasi')));
							$bukti_kerjasama  = htmlentities(strip_tags($this->input->post('bukti_kerjasama')));
							$tahun_berakhir  	= htmlentities(strip_tags($this->input->post('tahun_berakhir')));


								$data = array(
										'lembaga_mitra'		=> $lembaga_mitra,
										'tingkat'				=> $tingkat,
										'judul_kegiatan_kerjasama' 		 => $judul_kegiatan_kerjasama,
										'manfaat' 		 => $manfaat,
										'waktu_dan_durasi'		=> $waktu_dan_durasi,
										'bukti_kerjasama'	=> $bukti_kerjasama,
										'tahun_berakhir' 	=> $tahun_berakhir,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kerjasama_tridharma_pendidikan(array('id_kerjasama_tridharma_pendidikan' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kerjasama_tridharma_pendidikan');
					}

		}
	}



	public function kerjasama_tridharma_penelitian($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kerjasama_tridharma_penelitian.id_kerjasama_tridharma_penelitian', 'ASC');
			$data['kerjasama_tridharma_penelitian'] 		  = $this->db->get("kerjasama_tridharma_penelitian");

				if ($aksi == 't') {
					$p = "kerjasama_tridharma_penelitian_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kerjasama_tridharma_penelitian', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kerjasama_tridharma_penelitian_detail";

					$data['query'] = $this->db->get_where("kerjasama_tridharma_penelitian", array('id_kerjasama_tridharma_penelitian' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_penelitian(array('id_kerjasama_tridharma_penelitian' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_penelitian(array('id_kerjasama_tridharma_penelitian' => "$id"), $data2);

							redirect('users/kerjasama_tridharma_penelitian');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_penelitian(array('id_kerjasama_tridharma_penelitian' => "$id"), $data2);

							redirect('users/kerjasama_tridharma_penelitian');
					}
				}elseif ($aksi == 'e') {
					$p = "kerjasama_tridharma_penelitian_edit";
					
					$data['query'] = $this->db->get_where("kerjasama_tridharma_penelitian", array('id_kerjasama_tridharma_penelitian' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					}elseif ($aksi == 'f') {

					$data['query'] = $this->db->get_where("kerjasama_tridharma_penelitian", array('token_lampiran' => "$token", 'token_lampiran' => "$token_lampiran"))->row();
					$data['judul_web'] 	  = "Hapus file | Aplikasi";

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_penelitian_lampiran_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					


					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("kerjasama_tridharma_penelitian", array('id_kerjasama_tridharma_penelitian' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kerjasama_tridharma_penelitian(array('id_kerjasama_tridharma_penelitian' => "$id"), $data2);
							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_penelitian_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_penelitian_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kerjasama_tridharma_penelitian');


				}else{
					$p = "kerjasama_tridharma_penelitian";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"update_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$lembaga_mitra   	 	= htmlentities(strip_tags($this->input->post('lembaga_mitra')));
							$tingkat  = htmlentities(strip_tags($this->input->post('tingkat')));
							$judul_kegiatan_kerjasama  	= htmlentities(strip_tags($this->input->post('judul_kegiatan_kerjasama')));
							$manfaat
							   	= htmlentities(strip_tags($this->input->post('manfaat')));
							$waktu_dan_durasi   	 	= htmlentities(strip_tags($this->input->post('waktu_dan_durasi')));
							$bukti_kerjasama  = htmlentities(strip_tags($this->input->post('bukti_kerjasama')));
							$tahun_berakhir  	= htmlentities(strip_tags($this->input->post('tahun_berakhir')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kerjasama_tridharma_penelitian', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'lembaga_mitra'		=> $lembaga_mitra,
										'tingkat'				=> $tingkat,
										'judul_kegiatan_kerjasama' 		 => $judul_kegiatan_kerjasama,
										'manfaat' 		 => $manfaat,
										'waktu_dan_durasi'		=> $waktu_dan_durasi,
										'bukti_kerjasama'	=> $bukti_kerjasama,
										'tahun_berakhir' 	=> $tahun_berakhir,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
										
									);
									$this->Mcrud->save_kerjasama_tridharma_penelitian($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$lembaga_mitra   	 	= htmlentities(strip_tags($this->input->post('lembaga_mitra')));
							$tingkat  = htmlentities(strip_tags($this->input->post('tingkat')));
							$judul_kegiatan_kerjasama  	= htmlentities(strip_tags($this->input->post('judul_kegiatan_kerjasama')));
							$manfaat
							   	= htmlentities(strip_tags($this->input->post('manfaat')));
							$waktu_dan_durasi   	 	= htmlentities(strip_tags($this->input->post('waktu_dan_durasi')));
							$bukti_kerjasama  = htmlentities(strip_tags($this->input->post('bukti_kerjasama')));
							$tahun_berakhir  	= htmlentities(strip_tags($this->input->post('tahun_berakhir')));

							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");


							{
								$data = array(
										'lembaga_mitra'		=> $lembaga_mitra,
										'tingkat'				=> $tingkat,
										'judul_kegiatan_kerjasama' 		 => $judul_kegiatan_kerjasama,
										'manfaat' 		 => $manfaat,
										'waktu_dan_durasi'		=> $waktu_dan_durasi,
										'bukti_kerjasama'	=> $bukti_kerjasama,
										'tahun_berakhir' 	=> $tahun_berakhir,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kerjasama_tridharma_penelitian(array('id_kerjasama_tridharma_penelitian' => $id), $data);

							}
								$nama   = $this->update->data('file_name');
								$ukuran = $this->update->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));


									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kerjasama_tridharma_penelitian');
					}

		}
	}



	public function kerjasama_tridharma_pengabdian($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kerjasama_tridharma_pengabdian.id_kerjasama_tridharma_pengabdian', 'ASC');
			$data['kerjasama_tridharma_pengabdian'] 		  = $this->db->get("kerjasama_tridharma_pengabdian");

				if ($aksi == 't') {
					$p = "kerjasama_tridharma_pengabdian_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kerjasama_tridharma_pengabdian', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kerjasama_tridharma_pengabdian_detail";

					$data['query'] = $this->db->get_where("kerjasama_tridharma_pengabdian", array('id_kerjasama_tridharma_pengabdian' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_pengabdian(array('id_kerjasama_tridharma_pengabdian' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_pengabdian(array('id_kerjasama_tridharma_pengabdian' => "$id"), $data2);

							redirect('users/kerjasama_tridharma_pengabdian');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kerjasama_tridharma_pengabdian(array('id_kerjasama_tridharma_pengabdian' => "$id"), $data2);

							redirect('users/kerjasama_tridharma_penelitian');
					}
				}elseif ($aksi == 'e') {
					$p = "kerjasama_tridharma_pengabdian_edit";
					
					$data['query'] = $this->db->get_where("kerjasama_tridharma_pengabdian", array('id_kerjasama_tridharma_pengabdian' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("kerjasama_tridharma_pengabdian", array('id_kerjasama_tridharma_pengabdian' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kerjasama_tridharma_pengabdian(array('id_kerjasama_tridharma_pengabdian' => "$id"), $data2);
							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_pengabdian_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kerjasama_tridharma_pengabdian_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kerjasama_tridharma_pengabdian');
				}else{
					$p = "kerjasama_tridharma_pengabdian";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$lembaga_mitra   	 	= htmlentities(strip_tags($this->input->post('lembaga_mitra')));
							$tingkat  = htmlentities(strip_tags($this->input->post('tingkat')));
							$judul_kegiatan_kerjasama  	= htmlentities(strip_tags($this->input->post('judul_kegiatan_kerjasama')));
							$manfaat
							   	= htmlentities(strip_tags($this->input->post('manfaat')));
							$waktu_dan_durasi   	 	= htmlentities(strip_tags($this->input->post('waktu_dan_durasi')));
							$bukti_kerjasama  = htmlentities(strip_tags($this->input->post('bukti_kerjasama')));
							$tahun_berakhir  	= htmlentities(strip_tags($this->input->post('tahun_berakhir')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kerjasama_tridharma_pengabdian', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'lembaga_mitra'		=> $lembaga_mitra,
										'tingkat'				=> $tingkat,
										'judul_kegiatan_kerjasama' 		 => $judul_kegiatan_kerjasama,
										'manfaat' 		 => $manfaat,
										'waktu_dan_durasi'		=> $waktu_dan_durasi,
										'bukti_kerjasama'	=> $bukti_kerjasama,
										'tahun_berakhir' 	=> $tahun_berakhir,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_kerjasama_tridharma_pengabdian($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$lembaga_mitra   	 	= htmlentities(strip_tags($this->input->post('lembaga_mitra')));
							$tingkat  = htmlentities(strip_tags($this->input->post('tingkat')));
							$judul_kegiatan_kerjasama  	= htmlentities(strip_tags($this->input->post('judul_kegiatan_kerjasama')));
							$manfaat
							   	= htmlentities(strip_tags($this->input->post('manfaat')));
							$waktu_dan_durasi   	 	= htmlentities(strip_tags($this->input->post('waktu_dan_durasi')));
							$bukti_kerjasama  = htmlentities(strip_tags($this->input->post('bukti_kerjasama')));
							$tahun_berakhir  	= htmlentities(strip_tags($this->input->post('tahun_berakhir')));


								$data = array(
										'lembaga_mitra'		=> $lembaga_mitra,
										'tingkat'				=> $tingkat,
										'judul_kegiatan_kerjasama' 		 => $judul_kegiatan_kerjasama,
										'manfaat' 		 => $manfaat,
										'waktu_dan_durasi'		=> $waktu_dan_durasi,
										'bukti_kerjasama'	=> $bukti_kerjasama,
										'tahun_berakhir' 	=> $tahun_berakhir,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kerjasama_tridharma_pengabdian(array('id_kerjasama_tridharma_pengabdian' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kerjasama_tridharma_pengabdian');
					}

		}
	}


		public function kurikulum($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('kurikulum.id_kurikulum', 'ASC');
			$data['kurikulum'] 		  = $this->db->get("kurikulum");

				if ($aksi == 't') {
					$p = "kurikulum_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('kurikulum', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "kurikulum_detail";

					$data['query'] = $this->db->get_where("kurikulum", array('id_kurikulum' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_kurikulum(array('id_kurikulum' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kurikulum(array('id_kurikulum' => "$id"), $data2);

							redirect('users/kurikulum');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_kurikulum(array('id_kurikulum' => "$id"), $data2);

							redirect('users/kurikulum');
					}
				}elseif ($aksi == 'e') {
					$p = "kurikulum_edit";
					
					$data['query'] = $this->db->get_where("kurikulum", array('id_kurikulum' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("kurikulum", array('id_kurikulum' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_kurikulum(array('id_kurikulum' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kurikulum_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_kurikulum_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/kurikulum');
				}else{
					$p = "kurikulum";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$semester   	 	= htmlentities(strip_tags($this->input->post('semester')));
							$kode_matkul  = htmlentities(strip_tags($this->input->post('kode_matkul')));
							$nama_matkul  	= htmlentities(strip_tags($this->input->post('nama_matkul')));
							$matkul_kom		= htmlentities(strip_tags($this->input->post('matkul_kom')));
							$bobot_kuliah 	= htmlentities(strip_tags($this->input->post('bobot_kuliah')));
							$bobot_seminar   	 	= htmlentities(strip_tags($this->input->post('bobot_seminar')));
							$bobot_praktikum   	 	= htmlentities(strip_tags($this->input->post('bobot_praktikum')));
							$konversi  = htmlentities(strip_tags($this->input->post('konversi')));
							$capaian_sikap  	= htmlentities(strip_tags($this->input->post('capaian_sikap')));
							$capaian_pengetahuan  	= htmlentities(strip_tags($this->input->post('capaian_pengetahuan')));
							$capaian_umum  	= htmlentities(strip_tags($this->input->post('capaian_umum')));
							$capaian_khusus  	= htmlentities(strip_tags($this->input->post('capaian_khusus')));
							$dokumen  = htmlentities(strip_tags($this->input->post('dokumen')));
							$unit  	= htmlentities(strip_tags($this->input->post('unit')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('kurikulum', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'semester'		=> $semester,
										'kode_matkul'				=> $kode_matkul,
										'nama_matkul' 		 => $nama_matkul,
										'matkul_kom' 		 => $matkul_kom,
										'bobot_kuliah'		=> $bobot_kuliah,
										'bobot_seminar'		=> $bobot_seminar,
										'bobot_praktikum'		=> $bobot_praktikum,
										'konversi'	=> $konversi,
										'capaian_sikap' 	=> $capaian_sikap,
										'capaian_pengetahuan' 	=> $capaian_pengetahuan,
										'capaian_umum' 	=> $capaian_umum,
										'capaian_khusus' 	=> $capaian_khusus,
										'dokumen'				 => $dokumen,
										'unit' 	=> $unit,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_kurikulum($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$semester   	 	= htmlentities(strip_tags($this->input->post('semester')));
							$kode_matkul  = htmlentities(strip_tags($this->input->post('kode_matkul')));
							$nama_matkul  	= htmlentities(strip_tags($this->input->post('nama_matkul')));
							$matkul_kom		= htmlentities(strip_tags($this->input->post('matkul_kom')));
							$bobot_kuliah 	= htmlentities(strip_tags($this->input->post('bobot_kuliah')));
							$bobot_seminar   	 	= htmlentities(strip_tags($this->input->post('bobot_seminar')));
							$bobot_praktikum   	 	= htmlentities(strip_tags($this->input->post('bobot_praktikum')));
							$konversi  = htmlentities(strip_tags($this->input->post('konversi')));
							$capaian_sikap  	= htmlentities(strip_tags($this->input->post('capaian_sikap')));
							$capaian_pengetahuan  	= htmlentities(strip_tags($this->input->post('capaian_pengetahuan')));
							$capaian_umum  	= htmlentities(strip_tags($this->input->post('capaian_umum')));
							$capaian_khusus  	= htmlentities(strip_tags($this->input->post('capaian_khusus')));
							$dokumen  = htmlentities(strip_tags($this->input->post('dokumen')));
							$unit  	= htmlentities(strip_tags($this->input->post('unit')));


								$data = array(
										'semester'		=> $semester,
										'kode_matkul'				=> $kode_matkul,
										'nama_matkul' 		 => $nama_matkul,
										'matkul_kom' 		 => $matkul_kom,
										'bobot_kuliah'		=> $bobot_kuliah,
										'bobot_seminar'		=> $bobot_seminar,
										'bobot_praktikum'		=> $bobot_praktikum,
										'konversi'	=> $konversi,
										'capaian_sikap' 	=> $capaian_sikap,
										'capaian_pengetahuan' 	=> $capaian_pengetahuan,
										'capaian_umum' 	=> $capaian_umum,
										'capaian_khusus' 	=> $capaian_khusus,
										'dokumen'				 => $dokumen,
										'unit' 	=> $unit,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_kurikulum(array('id_kurikulum' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/kurikulum');
					}

		}
	}




	public function luaran_penelitianlainnya_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitianlainnya_dtps.id_luaran_penelitianlainnya_dtps', 'ASC');
			$data['luaran_penelitianlainnya_dtps'] 		  = $this->db->get("luaran_penelitianlainnya_dtps");

				if ($aksi == 't') {
					$p = "luaran_penelitianlainnya_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitianlainnya_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitianlainnya_dtps_detail";

					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps", array('id_luaran_penelitianlainnya_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps(array('id_luaran_penelitianlainnya_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps(array('id_luaran_penelitianlainnya_dtps' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps(array('id_luaran_penelitianlainnya_dtps' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitianlainnya_dtps_edit";
					
					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps", array('id_luaran_penelitianlainnya_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps", array('id_luaran_penelitianlainnya_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps(array('id_luaran_penelitianlainnya_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitianlainnya_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitianlainnya_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitianlainnya_dtps');
				}else{
					$p = "luaran_penelitianlainnya_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitianlainnya_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitianlainnya_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitianlainnya_dtps(array('id_luaran_penelitianlainnya_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitianlainnya_dtps');
					}

		}
	}



	public function luaran_penelitianlainnya_dtps_3($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitianlainnya_dtps_3.id_luaran_penelitianlainnya_dtps_3', 'ASC');
			$data['luaran_penelitianlainnya_dtps_3'] 		  = $this->db->get("luaran_penelitianlainnya_dtps_3");

				if ($aksi == 't') {
					$p = "luaran_penelitianlainnya_dtps_3_tambah";
					

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitianlainnya_dtps_3', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitianlainnya_dtps_3_detail";

					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps_3", array('id_luaran_penelitianlainnya_dtps_3' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_3(array('id_luaran_penelitianlainnya_dtps_3' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_3(array('id_luaran_penelitianlainnya_dtps_3' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps_3');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_3(array('id_luaran_penelitianlainnya_dtps_3' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps_3');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitianlainnya_dtps_3_edit";
					
					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps_3", array('id_luaran_penelitianlainnya_dtps_3' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps_3", array('id_luaran_penelitianlainnya_dtps_3' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_3(array('id_luaran_penelitianlainnya_dtps_3' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitianlainnya_dtps_3_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitianlainnya_dtps_3_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitianlainnya_dtps_3');
				}else{
					$p = "luaran_penelitianlainnya_dtps_3";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitianlainnya_dtps_3', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitianlainnya_dtps_3($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitianlainnya_dtps_3(array('id_luaran_penelitianlainnya_dtps_3' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitianlainnya_dtps_3');
					}

		}
	}


	public function luaran_penelitianlainnya_dtps_4($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitianlainnya_dtps_4.id_luaran_penelitianlainnya_dtps_4', 'ASC');
			$data['luaran_penelitianlainnya_dtps_4'] 		  = $this->db->get("luaran_penelitianlainnya_dtps_4");

				if ($aksi == 't') {
					$p = "luaran_penelitianlainnya_dtps_4_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitianlainnya_dtps_4', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitianlainnya_dtps_4_detail";

					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps_4", array('id_luaran_penelitianlainnya_dtps_4' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_4(array('id_luaran_penelitianlainnya_dtps_4' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_4(array('id_luaran_penelitianlainnya_dtps_4' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps_4');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_4(array('id_luaran_penelitianlainnya_dtps_4' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps_4');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitianlainnya_dtps_4_edit";
					
					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps_4", array('id_luaran_penelitianlainnya_dtps_4' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("luaran_penelitianlainnya_dtps_4", array('id_luaran_penelitianlainnya_dtps_4' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitianlainnya_dtps_4(array('id_luaran_penelitianlainnya_dtps_4' => "$id"), $data2);
							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitianlainnya_dtps_4_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitianlainnya_dtps_4_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitianlainnya_dtps_4');
				}else{
					$p = "luaran_penelitianlainnya_dtps_4";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitianlainnya_dtps_4', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitianlainnya_dtps_4($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitianlainnya_dtps_4(array('id_luaran_penelitianlainnya_dtps_4' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitianlainnya_dtps_4');
					}

		}
	}



	public function luaran_pkm_lainnya_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_pkm_lainnya_dtps.id_luaran_pkm_lainnya_dtps', 'ASC');
			$data['luaran_pkm_lainnya_dtps'] 		  = $this->db->get("luaran_pkm_lainnya_dtps");

				if ($aksi == 't') {
					$p = "luaran_pkm_lainnya_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_pkm_lainnya_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_pkm_lainnya_dtps_detail";

					$data['query'] = $this->db->get_where("luaran_pkm_lainnya_dtps", array('id_luaran_pkm_lainnya_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_pkm_lainnya_dtps(array('id_luaran_pkm_lainnya_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_pkm_lainnya_dtps(array('id_luaran_pkm_lainnya_dtps' => "$id"), $data2);

							redirect('users/luaran_pkm_lainnya_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_pkm_lainnya_dtps(array('id_luaran_pkm_lainnya_dtps' => "$id"), $data2);

							redirect('users/luaran_penelitianlainnya_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_pkm_lainnya_dtps_edit";
					
					$data['query'] = $this->db->get_where("luaran_pkm_lainnya_dtps", array('id_luaran_pkm_lainnya_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("luaran_pkm_lainnya_dtps", array('id_luaran_pkm_lainnya_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_pkm_lainnya_dtps(array('id_luaran_pkm_lainnya_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_pkm_lainnya_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_pkm_lainnya_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_pkm_lainnya_dtps');
				}else{
					$p = "luaran_pkm_lainnya_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_pkm_lainnya_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_pkm_lainnya_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_pkm_lainnya_dtps(array('id_luaran_pkm_lainnya_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_pkm_lainnya_dtps');
					}

		}
	}



	public function luaran_penelitian_mhs_1($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitian_mhs_1.id_luaran_penelitian_mhs_1', 'ASC');
			$data['luaran_penelitian_mhs_1'] 		  = $this->db->get("luaran_penelitian_mhs_1");

				if ($aksi == 't') {
					$p = "luaran_penelitian_mhs_1_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitian_mhs_1', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitian_mhs_1_detail";

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_1", array('id_luaran_penelitian_mhs_1' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_1(array('id_luaran_penelitian_mhs_1' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_1(array('id_luaran_penelitian_mhs_1' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_1');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_1(array('id_luaran_penelitian_mhs_1' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_1');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitian_mhs_1_edit";
					
					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_1", array('id_luaran_penelitian_mhs_1' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_1", array('id_luaran_penelitian_mhs_1' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitian_mhs_1(array('id_luaran_penelitian_mhs_1' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_1_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_1_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitian_mhs_1');
				}else{
					$p = "luaran_penelitian_mhs_1";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitian_mhs_1', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitian_mhs_1($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitian_mhs_1(array('id_luaran_penelitian_mhs_1' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitian_mhs_1');
					}

		}
	}






	public function luaran_penelitian_mhs_2($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitian_mhs_2.id_luaran_penelitian_mhs_2', 'ASC');
			$data['luaran_penelitian_mhs_2'] 		  = $this->db->get("luaran_penelitian_mhs_2");

				if ($aksi == 't') {
					$p = "luaran_penelitian_mhs_2_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitian_mhs_2', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitian_mhs_2_detail";

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_2", array('id_luaran_penelitian_mhs_2' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_2(array('id_luaran_penelitian_mhs_2' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_2(array('id_luaran_penelitian_mhs_2' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_2');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_2(array('id_luaran_penelitian_mhs_2' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_2');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitian_mhs_2_edit";
					
					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_2", array('id_luaran_penelitian_mhs_2' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_2", array('id_luaran_penelitian_mhs_2' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitian_mhs_2(array('id_luaran_penelitian_mhs_2' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_2_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_2_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitian_mhs_2');
				}else{
					$p = "luaran_penelitian_mhs_2";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitian_mhs_2', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitian_mhs_2($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitian_mhs_2(array('id_luaran_penelitian_mhs_2' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitian_mhs_2');
					}

		}
	}





	public function luaran_penelitian_mhs_3($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitian_mhs_3.id_luaran_penelitian_mhs_3', 'ASC');
			$data['luaran_penelitian_mhs_3'] 		  = $this->db->get("luaran_penelitian_mhs_3");

				if ($aksi == 't') {
					$p = "luaran_penelitian_mhs_3_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitian_mhs_3', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitian_mhs_3_detail";

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_3", array('id_luaran_penelitian_mhs_3' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_3(array('id_luaran_penelitian_mhs_3' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_3(array('id_luaran_penelitian_mhs_3' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_3');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_3(array('id_luaran_penelitian_mhs_3' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_3');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitian_mhs_3_edit";
					

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_3", array('id_luaran_penelitian_mhs_3' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_3", array('id_luaran_penelitian_mhs_3' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitian_mhs_3(array('id_luaran_penelitian_mhs_3' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_3_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_3_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitian_mhs_3');
				}else{
					$p = "luaran_penelitian_mhs_3";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitian_mhs_3', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitian_mhs_3($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitian_mhs_3(array('id_luaran_penelitian_mhs_3' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitian_mhs_3');
					}

		}
	}



	public function luaran_penelitian_mhs_4($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('luaran_penelitian_mhs_4.id_luaran_penelitian_mhs_4', 'ASC');
			$data['luaran_penelitian_mhs_4'] 		  = $this->db->get("luaran_penelitian_mhs_4");

				if ($aksi == 't') {
					$p = "luaran_penelitian_mhs_4_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('luaran_penelitian_mhs_4', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "luaran_penelitian_mhs_4_detail";

					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_4", array('id_luaran_penelitian_mhs_4' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_4(array('id_luaran_penelitian_mhs_4' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_4(array('id_luaran_penelitian_mhs_4' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_4');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_luaran_penelitian_mhs_4(array('id_luaran_penelitian_mhs_4' => "$id"), $data2);

							redirect('users/luaran_penelitian_mhs_4');
					}
				}elseif ($aksi == 'e') {
					$p = "luaran_penelitian_mhs_4_edit";
					
					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_4", array('id_luaran_penelitian_mhs_4' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("luaran_penelitian_mhs_4", array('id_luaran_penelitian_mhs_4' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_luaran_penelitian_mhs_4(array('id_luaran_penelitian_mhs_4' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_4_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_luaran_penelitian_mhs_4_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/luaran_penelitian_mhs_4');
				}else{
					$p = "luaran_penelitian_mhs_4";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('luaran_penelitian_mhs_4', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_luaran_penelitian_mhs_4($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$luaran_penelitian   	 	= htmlentities(strip_tags($this->input->post('luaran_penelitian')));
							$tahun  = htmlentities(strip_tags($this->input->post('tahun')));
							$keterangan  	= htmlentities(strip_tags($this->input->post('keterangan')));
							
								$data = array(
										'luaran_penelitian'		=> $luaran_penelitian,
										'tahun'				=> $tahun,
										'keterangan' 		 => $keterangan,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_luaran_penelitian_mhs_4(array('id_luaran_penelitian_mhs_4' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/luaran_penelitian_mhs_4');
					}

		}
	}



	public function masa_studi_d($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('masa_studi_d.id_masa_studi_d', 'ASC');
			$data['masa_studi_d'] 		  = $this->db->get("masa_studi_d");

				if ($aksi == 't') {
					$p = "masa_studi_d_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('masa_studi_d', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "masa_studi_d_detail";

					$data['query'] = $this->db->get_where("masa_studi_d", array('id_masa_studi_d' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_d(array('id_masa_studi_d' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_d(array('id_masa_studi_d' => "$id"), $data2);

							redirect('users/masa_studi_d');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_d(array('id_masa_studi_d' => "$id"), $data2);

							redirect('users/masa_studi_d');
					}
				}elseif ($aksi == 'e') {
					$p = "masa_studi_d_edit";
					
					$data['query'] = $this->db->get_where("masa_studi_d", array('id_masa_studi_d' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("masa_studi_d", array('id_masa_studi_d' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_masa_studi_d(array('id_masa_studi_d' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_d_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_d_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/masa_studi_d');
				}else{
					$p = "masa_studi_d";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_mhs_lulus_ts4  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts4')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('masa_studi_d', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_mhs_lulus_ts4'		=> $jumlah_mhs_lulus_ts4,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_masa_studi_d($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_mhs_lulus_ts4  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts4')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
								$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_mhs_lulus_ts4'		=> $jumlah_mhs_lulus_ts4,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_masa_studi_d(array('id_masa_studi_d' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/masa_studi_d');
					}

		}
	}



	public function masa_studi_do($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('masa_studi_do.id_masa_studi_do', 'ASC');
			$data['masa_studi_do'] 		  = $this->db->get("masa_studi_do");

				if ($aksi == 't') {
					$p = "masa_studi_do_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('masa_studi_do', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "masa_studi_do_detail";

					$data['query'] = $this->db->get_where("masa_studi_do", array('id_masa_studi_do' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_do(array('id_masa_studi_do' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_do(array('id_masa_studi_do' => "$id"), $data2);

							redirect('users/masa_studi_do');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_do(array('id_masa_studi_do' => "$id"), $data2);

							redirect('users/masa_studi_do');
					}
				}elseif ($aksi == 'e') {
					$p = "masa_studi_do_edit";
					
					$data['query'] = $this->db->get_where("masa_studi_do", array('id_masa_studi_do' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("masa_studi_do", array('id_masa_studi_do' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_masa_studi_do(array('id_masa_studi_do' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_do_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_do_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/masa_studi_do');
				}else{
					$p = "masa_studi_do";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_mhs_lulus_ts4  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts4')));
							$jumlah_mhs_lulus_ts5  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts5')));
							$jumlah_mhs_lulus_ts6  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts6')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('masa_studi_do', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_mhs_lulus_ts4'		=> $jumlah_mhs_lulus_ts4,
										'jumlah_mhs_lulus_ts5'		=> $jumlah_mhs_lulus_ts5,
										'jumlah_mhs_lulus_ts6'		=> $jumlah_mhs_lulus_ts6,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_masa_studi_do($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_mhs_lulus_ts4  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts4')));
							$jumlah_mhs_lulus_ts5  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts5')));
							$jumlah_mhs_lulus_ts6  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts6')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
								$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_mhs_lulus_ts4'		=> $jumlah_mhs_lulus_ts4,
										'jumlah_mhs_lulus_ts5'		=> $jumlah_mhs_lulus_ts5,
										'jumlah_mhs_lulus_ts6'		=> $jumlah_mhs_lulus_ts6,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_masa_studi_do(array('id_masa_studi_do' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/masa_studi_do');
					}

		}
	}




	public function masa_studi_m($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('masa_studi_m.id_masa_studi_m', 'ASC');
			$data['masa_studi_m'] 		  = $this->db->get("masa_studi_m");

				if ($aksi == 't') {
					$p = "masa_studi_m_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('masa_studi_m', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "masa_studi_m_detail";

					$data['query'] = $this->db->get_where("masa_studi_m", array('id_masa_studi_m' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_m(array('id_masa_studi_m' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_m(array('id_masa_studi_m' => "$id"), $data2);

							redirect('users/masa_studi_m');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_m(array('id_masa_studi_m' => "$id"), $data2);

							redirect('users/masa_studi_m');
					}
				}elseif ($aksi == 'e') {
					$p = "masa_studi_m_edit";
					
					$data['query'] = $this->db->get_where("masa_studi_m", array('id_masa_studi_m' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("masa_studi_m", array('id_masa_studi_m' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_masa_studi_m(array('id_masa_studi_m' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_m_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_m_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/masa_studi_m');
				}else{
					$p = "masa_studi_m";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('masa_studi_m', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_masa_studi_m($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
								$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_masa_studi_m(array('id_masa_studi_m' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/masa_studi_m');
					}

		}
	}




	public function masa_studi_s($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('masa_studi_s.id_masa_studi_s', 'ASC');
			$data['masa_studi_s'] 		  = $this->db->get("masa_studi_s");

				if ($aksi == 't') {
					$p = "masa_studi_s_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('masa_studi_s', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "masa_studi_s_detail";

					$data['query'] = $this->db->get_where("masa_studi_s", array('id_masa_studi_s' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_s(array('id_masa_studi_s' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_s(array('id_masa_studi_s' => "$id"), $data2);

							redirect('users/masa_studi_s');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_masa_studi_s(array('id_masa_studi_s' => "$id"), $data2);

							redirect('users/masa_studi_s');
					}
				}elseif ($aksi == 'e') {
					$p = "masa_studi_s_edit";
					
					$data['query'] = $this->db->get_where("masa_studi_s", array('id_masa_studi_s' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("masa_studi_s", array('id_masa_studi_s' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {
							

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_masa_studi_s(array('id_masa_studi_s' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_s_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_masa_studi_s_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/masa_studi_s');
				}else{
					$p = "masa_studi_s";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_mhs_lulus_ts4  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts4')));
							$jumlah_mhs_lulus_ts5  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts5')));
							$jumlah_mhs_lulus_ts6  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts6')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('masa_studi_s', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_mhs_lulus_ts4'		=> $jumlah_mhs_lulus_ts4,
										'jumlah_mhs_lulus_ts5'		=> $jumlah_mhs_lulus_ts5,
										'jumlah_mhs_lulus_ts6'		=> $jumlah_mhs_lulus_ts6,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_masa_studi_s($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tahun_masuk   	 	= htmlentities(strip_tags($this->input->post('tahun_masuk')));
							$jumlah_mhs_diterima  = htmlentities(strip_tags($this->input->post('jumlah_mhs_diterima')));
							$jumlah_mhs_lulus_ts  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts')));
							$jumlah_mhs_lulus_ts1  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts1')));
							$jumlah_mhs_lulus_ts2  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts2')));
							$jumlah_mhs_lulus_ts3  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts3')));
							$jumlah_mhs_lulus_ts4  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts4')));
							$jumlah_mhs_lulus_ts5  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts5')));
							$jumlah_mhs_lulus_ts6  	= htmlentities(strip_tags($this->input->post('jumlah_mhs_lulus_ts6')));
							$jumlah_lulusan  = htmlentities(strip_tags($this->input->post('jumlah_lulusan')));
							$rata_studi  	= htmlentities(strip_tags($this->input->post('rata_studi')));
							
								$data = array(
										'tahun_masuk'				=> $tahun_masuk,
										'jumlah_mhs_diterima'		=> $jumlah_mhs_diterima,
										'jumlah_mhs_lulus_ts'		=> $jumlah_mhs_lulus_ts,
										'jumlah_mhs_lulus_ts1'		=> $jumlah_mhs_lulus_ts1,
										'jumlah_mhs_lulus_ts2'		=> $jumlah_mhs_lulus_ts2,
										'jumlah_mhs_lulus_ts3'		=> $jumlah_mhs_lulus_ts3,
										'jumlah_mhs_lulus_ts4'		=> $jumlah_mhs_lulus_ts4,
										'jumlah_mhs_lulus_ts5'		=> $jumlah_mhs_lulus_ts5,
										'jumlah_mhs_lulus_ts6'		=> $jumlah_mhs_lulus_ts6,
										'jumlah_lulusan'			=> $jumlah_lulusan,
										'rata_studi' 				=> $rata_studi,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_masa_studi_s(array('id_masa_studi_s' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/masa_studi_s');
					}

		}
	}




	public function pagelaran_ilmiah_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('pagelaran_ilmiah_dtps.id_pagelaran_ilmiah_dtps', 'ASC');
			$data['pagelaran_ilmiah_dtps'] 		  = $this->db->get("pagelaran_ilmiah_dtps");

				if ($aksi == 't') {
					$p = "pagelaran_ilmiah_dtps_tambah";
					

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('pagelaran_ilmiah_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "pagelaran_ilmiah_dtps_detail";

					$data['query'] = $this->db->get_where("pagelaran_ilmiah_dtps", array('id_pagelaran_ilmiah_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_pagelaran_ilmiah_dtps(array('id_pagelaran_ilmiah_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pagelaran_ilmiah_dtps(array('id_pagelaran_ilmiah_dtps' => "$id"), $data2);

							redirect('users/pagelaran_ilmiah_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pagelaran_ilmiah_dtps(array('id_pagelaran_ilmiah_dtps' => "$id"), $data2);

							redirect('users/pagelaran_ilmiah_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "pagelaran_ilmiah_dtps_edit";
					
					$data['query'] = $this->db->get_where("pagelaran_ilmiah_dtps", array('id_pagelaran_ilmiah_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("pagelaran_ilmiah_dtps", array('id_pagelaran_ilmiah_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_pagelaran_ilmiah_dtps(array('id_pagelaran_ilmiah_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pagelaran_ilmiah_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pagelaran_ilmiah_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/pagelaran_ilmiah_dtps');
				}else{
					$p = "pagelaran_ilmiah_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('pagelaran_ilmiah_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'				=> $jumlah_judul_ts,
										'jumlah_judul_ts1'				=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'				=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_pagelaran_ilmiah_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
								$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'				=> $jumlah_judul_ts,
										'jumlah_judul_ts1'				=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'				=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_pagelaran_ilmiah_dtps(array('id_pagelaran_ilmiah_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/pagelaran_ilmiah_dtps');
					}

		}
	}


	public function pagelaran_ilmiah_mhs($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('pagelaran_ilmiah_mhs.id_pagelaran_ilmiah_mhs', 'ASC');
			$data['pagelaran_ilmiah_mhs'] 		  = $this->db->get("pagelaran_ilmiah_mhs");

				if ($aksi == 't') {
					$p = "pagelaran_ilmiah_mhs_tambah";
					

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('pagelaran_ilmiah_mhs', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "pagelaran_ilmiah_mhs_detail";

					$data['query'] = $this->db->get_where("pagelaran_ilmiah_mhs", array('id_pagelaran_ilmiah_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_pagelaran_ilmiah_mhs(array('id_pagelaran_ilmiah_mhs' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pagelaran_ilmiah_mhs(array('id_pagelaran_ilmiah_mhs' => "$id"), $data2);

							redirect('users/pagelaran_ilmiah_mhs');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pagelaran_ilmiah_mhs(array('id_pagelaran_ilmiah_mhs' => "$id"), $data2);

							redirect('users/pagelaran_ilmiah_mhs');
					}
				}elseif ($aksi == 'e') {
					$p = "pagelaran_ilmiah_mhs_edit";
					

					$data['query'] = $this->db->get_where("pagelaran_ilmiah_mhs", array('id_pagelaran_ilmiah_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("pagelaran_ilmiah_mhs", array('id_pagelaran_ilmiah_mhs' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_pagelaran_ilmiah_mhs(array('id_pagelaran_ilmiah_mhs' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pagelaran_ilmiah_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pagelaran_ilmiah_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/pagelaran_ilmiah_mhs');
				}else{
					$p = "pagelaran_ilmiah_mhs";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('pagelaran_ilmiah_mhs', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'				=> $jumlah_judul_ts,
										'jumlah_judul_ts1'				=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'				=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_pagelaran_ilmiah_mhs($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$jenis_publikasi   	 	= htmlentities(strip_tags($this->input->post('jenis_publikasi')));
							$jumlah_judul_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts')));
							$jumlah_judul_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts1')));
							$jumlah_judul_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
								$data = array(
										'jenis_publikasi'		=> $jenis_publikasi,
										'jumlah_judul_ts'				=> $jumlah_judul_ts,
										'jumlah_judul_ts1'				=> $jumlah_judul_ts1,
										'jumlah_judul_ts2'				=> $jumlah_judul_ts2,
										'jumlah'		=> $jumlah,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_pagelaran_ilmiah_mhs(array('id_pagelaran_ilmiah_mhs' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/pagelaran_ilmiah_mhs');
					}

		}
	}




	public function penelitian_dtps_tesis($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('penelitian_dtps_tesis.id_penelitian_dtps_tesis', 'ASC');
			$data['penelitian_dtps_tesis'] 		  = $this->db->get("penelitian_dtps_tesis");

				if ($aksi == 't') {
					$p = "penelitian_dtps_tesis_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('penelitian_dtps_tesis', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "penelitian_dtps_tesis_detail";

					$data['query'] = $this->db->get_where("penelitian_dtps_tesis", array('id_penelitian_dtps_tesis' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps_tesis(array('id_penelitian_dtps_tesis' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps_tesis(array('id_penelitian_dtps_tesis' => "$id"), $data2);

							redirect('users/penelitian_dtps_tesis');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penelitian_dtps_tesis(array('id_penelitian_dtps_tesis' => "$id"), $data2);

							redirect('users/penelitian_dtps_tesis');
					}
				}elseif ($aksi == 'e') {
					$p = "penelitian_dtps_tesis_edit";
					
					$data['query'] = $this->db->get_where("penelitian_dtps_tesis", array('id_penelitian_dtps_tesis' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {



					$data['query'] = $this->db->get_where("penelitian_dtps_tesis", array('id_penelitian_dtps_tesis' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_penelitian_dtps_tesis(array('id_penelitian_dtps_tesis' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penelitian_dtps_tesis_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penelitian_dtps_tesis_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/penelitian_dtps_tesis');
				}else{
					$p = "penelitian_dtps_tesis";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$tema  = htmlentities(strip_tags($this->input->post('tema')));
							$nama_mhs  	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$judul  = htmlentities(strip_tags($this->input->post('judul')));
							$tahun  	= htmlentities(strip_tags($this->input->post('tahun')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('penelitian_dtps_tesis', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'nama_dosen'		=> $nama_dosen,
										'tema'				=> $tema,
										'nama_mhs'		=> $nama_mhs,
										'judul'				=> $judul,
										'tahun'		=> $tahun,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_penelitian_dtps_tesis($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$tema  = htmlentities(strip_tags($this->input->post('tema')));
							$nama_mhs  	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$judul  = htmlentities(strip_tags($this->input->post('judul')));
							$tahun  	= htmlentities(strip_tags($this->input->post('tahun')));
							
								$data = array(
										'nama_dosen'		=> $nama_dosen,
										'tema'				=> $tema,
										'nama_mhs'		=> $nama_mhs,
										'judul'				=> $judul,
										'tahun'		=> $tahun,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_penelitian_dtps_tesis(array('id_penelitian_dtps_tesis' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/penelitian_dtps_tesis');
					}

		}
	}


		public function pengakuan_rekognisi_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('pengakuan_rekognisi_dtps.id_pengakuan_rekognisi_dtps', 'ASC');
			$data['pengakuan_rekognisi_dtps'] 		  = $this->db->get("pengakuan_rekognisi_dtps");

				if ($aksi == 't') {
					$p = "pengakuan_rekognisi_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('pengakuan_rekognisi_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "pengakuan_rekognisi_dtps_detail";

					$data['query'] = $this->db->get_where("pengakuan_rekognisi_dtps", array('id_pengakuan_rekognisi_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_pengakuan_rekognisi_dtps(array('id_pengakuan_rekognisi_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pengakuan_rekognisi_dtps(array('id_pengakuan_rekognisi_dtps' => "$id"), $data2);

							redirect('users/pengakuan_rekognisi_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pengakuan_rekognisi_dtps(array('id_pengakuan_rekognisi_dtps' => "$id"), $data2);

							redirect('users/pengakuan_rekognisi_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "pengakuan_rekognisi_dtps_edit";
					
					$data['query'] = $this->db->get_where("pengakuan_rekognisi_dtps", array('id_pengakuan_rekognisi_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("pengakuan_rekognisi_dtps", array('id_pengakuan_rekognisi_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_pengakuan_rekognisi_dtps(array('id_pengakuan_rekognisi_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pengakuan_rekognisi_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pengakuan_rekognisi_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/pengakuan_rekognisi_dtps');
				}else{
					$p = "pengakuan_rekognisi_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$bidang_keahlian   	 	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$rekognisi_bukti_pendukung  = htmlentities(strip_tags($this->input->post('rekognisi_bukti_pendukung')));
							$tingkat  	= htmlentities(strip_tags($this->input->post('tingkat')));
							$tahun  	= htmlentities(strip_tags($this->input->post('tahun')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('pengakuan_rekognisi_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'nama_dosen'		=> $nama_dosen,
										'bidang_keahlian'		=> $bidang_keahlian,
										'rekognisi_bukti_pendukung'				=> $rekognisi_bukti_pendukung,
										'tingkat'		=> $tingkat,
										'tahun'		=> $tahun,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_pengakuan_rekognisi_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$bidang_keahlian   	 	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$rekognisi_bukti_pendukung  = htmlentities(strip_tags($this->input->post('rekognisi_bukti_pendukung')));
							$tingkat  	= htmlentities(strip_tags($this->input->post('tingkat')));
							$tahun  	= htmlentities(strip_tags($this->input->post('tahun')));
							
								$data = array(
										'nama_dosen'		=> $nama_dosen,
										'bidang_keahlian'		=> $bidang_keahlian,
										'rekognisi_bukti_pendukung'				=> $rekognisi_bukti_pendukung,
										'tingkat'		=> $tingkat,
										'tahun'		=> $tahun,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_pengakuan_rekognisi_dtps(array('id_pengakuan_rekognisi_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/pengakuan_rekognisi_dtps');
					}

		}
	}



	public function pkm_dtps_mhs($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('pkm_dtps_mhs.id_pkm_dtps_mhs', 'ASC');
			$data['pkm_dtps_mhs'] 		  = $this->db->get("pkm_dtps_mhs");

				if ($aksi == 't') {
					$p = "pkm_dtps_mhs_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('pkm_dtps_mhs', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "pkm_dtps_mhs_detail";

					$data['query'] = $this->db->get_where("pkm_dtps_mhs", array('id_pkm_dtps_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'admin') {
							$data2 = array(
								'relasi' => '1'
							);
							$this->Mcrud->update_pkm_dtps_mhs(array('id_pkm_dtps_mhs' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pkm_dtps_mhs(array('id_pkm_dtps_mhs' => "$id"), $data2);

							redirect('users/pkm_dtps_mhs');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pkm_dtps_mhs(array('id_pkm_dtps_mhs' => "$id"), $data2);

							redirect('users/pkm_dtps_mhs');
					}
				}elseif ($aksi == 'e') {
					$p = "pkm_dtps_mhs_edit";
					
					$data['query'] = $this->db->get_where("pkm_dtps_mhs", array('id_pkm_dtps_mhs' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("pkm_dtps_mhs", array('id_pkm_dtps_mhs' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_pkm_dtps_mhs(array('id_pkm_dtps_mhs' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pkm_dtps_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pkm_dtps_mhs_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/pkm_dtps_mhs');
				}else{
					$p = "pkm_dtps_mhs";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$tema  = htmlentities(strip_tags($this->input->post('tema')));
							$nama_mhs  	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$judul  = htmlentities(strip_tags($this->input->post('judul')));
							$tahun  	= htmlentities(strip_tags($this->input->post('tahun')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('pkm_dtps_mhs', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'nama_dosen'		=> $nama_dosen,
										'tema'				=> $tema,
										'nama_mhs'		=> $nama_mhs,
										'judul'				=> $judul,
										'tahun'		=> $tahun,
										'token_lampiran' 		=> $token,
										'relasi'				 => 0,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_pkm_dtps_mhs($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$tema  = htmlentities(strip_tags($this->input->post('tema')));
							$nama_mhs  	= htmlentities(strip_tags($this->input->post('nama_mhs')));
							$judul  = htmlentities(strip_tags($this->input->post('judul')));
							$tahun  	= htmlentities(strip_tags($this->input->post('tahun')));
							
								$data = array(
										'nama_dosen'		=> $nama_dosen,
										'tema'				=> $tema,
										'nama_mhs'		=> $nama_mhs,
										'judul'				=> $judul,
										'tahun'		=> $tahun,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_pkm_dtps_mhs(array('id_pkm_dtps_mhs' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/pkm_dtps_mhs');
					}

		}
	}




	public function penggunaan_dana($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('penggunaan_dana.id_penggunaan_dana', 'ASC');
			$data['penggunaan_dana'] 		  = $this->db->get("penggunaan_dana");

				if ($aksi == 't') {
					$p = "penggunaan_dana_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('penggunaan_dana', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "penggunaan_dana_detail";

					$data['query'] = $this->db->get_where("penggunaan_dana", array('id_penggunaan_dana' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_penggunaan_dana(array('id_penggunaan_dana' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penggunaan_dana(array('id_penggunaan_dana' => "$id"), $data2);

							redirect('users/penggunaan_dana');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_penggunaan_dana(array('id_penggunaan_dana' => "$id"), $data2);

							redirect('users/penggunaan_dana');
					}
				}elseif ($aksi == 'e') {
					$p = "penggunaan_dana_edit";
					
					$data['query'] = $this->db->get_where("penggunaan_dana", array('id_penggunaan_dana' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("penggunaan_dana", array('id_penggunaan_dana' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_penggunaan_dana(array('id_penggunaan_dana' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penggunaan_dana_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_penggunaan_dana_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/penggunaan_dana');
				}else{
					$p = "penggunaan_dana";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis_pengguna   	 	= htmlentities(strip_tags($this->input->post('jenis_pengguna')));
							$unit_pengelola_ts  = htmlentities(strip_tags($this->input->post('unit_pengelola_ts')));
							$unit_pengelola_ts1  = htmlentities(strip_tags($this->input->post('unit_pengelola_ts1')));
							$unit_pengelola_ts2  = htmlentities(strip_tags($this->input->post('unit_pengelola_ts2')));
							$unit_pengelola_rata  = htmlentities(strip_tags($this->input->post('unit_pengelola_rata')));
							$program_studi_ts  	= htmlentities(strip_tags($this->input->post('program_studi_ts')));
							$program_studi_ts1  	= htmlentities(strip_tags($this->input->post('program_studi_ts1')));
							$program_studi_ts2  	= htmlentities(strip_tags($this->input->post('program_studi_ts2')));
							$program_studi_rata  	= htmlentities(strip_tags($this->input->post('program_studi_rata')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('penggunaan_dana', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'jenis_pengguna'		=> $jenis_pengguna,
										'unit_pengelola_ts'				=> $unit_pengelola_ts,
										'unit_pengelola_ts1'				=> $unit_pengelola_ts1,
										'unit_pengelola_ts2'				=> $unit_pengelola_ts2,
										'unit_pengelola_rata'				=> $unit_pengelola_rata,
										'program_studi_ts'		=> $program_studi_ts,
										'program_studi_ts1'		=> $program_studi_ts1,
										'program_studi_ts2'		=> $program_studi_ts2,
										'program_studi_rata'		=> $program_studi_rata,
										'token_lampiran' 		=> $token,
										'id_user'				 => $id_user,
										
									);
									$this->Mcrud->save_penggunaan_dana($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$jenis_pengguna   	 	= htmlentities(strip_tags($this->input->post('jenis_pengguna')));
							$unit_pengelola_ts  = htmlentities(strip_tags($this->input->post('unit_pengelola_ts')));
							$unit_pengelola_ts1  = htmlentities(strip_tags($this->input->post('unit_pengelola_ts1')));
							$unit_pengelola_ts2  = htmlentities(strip_tags($this->input->post('unit_pengelola_ts2')));
							$unit_pengelola_rata  = htmlentities(strip_tags($this->input->post('unit_pengelola_rata')));
							$program_studi_ts  	= htmlentities(strip_tags($this->input->post('program_studi_ts')));
							$program_studi_ts1  	= htmlentities(strip_tags($this->input->post('program_studi_ts1')));
							$program_studi_ts2  	= htmlentities(strip_tags($this->input->post('program_studi_ts2')));
							$program_studi_rata  	= htmlentities(strip_tags($this->input->post('program_studi_rata')));
							
								$data = array(
										'jenis_pengguna'		=> $jenis_pengguna,
										'unit_pengelola_ts'		=> $unit_pengelola_ts,
										'unit_pengelola_ts1'	=> $unit_pengelola_ts1,
										'unit_pengelola_ts2'	=> $unit_pengelola_ts2,
										'unit_pengelola_rata'	=> $unit_pengelola_rata,
										'program_studi_ts'		=> $program_studi_ts,
										'program_studi_ts1'		=> $program_studi_ts1,
										'program_studi_ts2'		=> $program_studi_ts2,
										'program_studi_rata'		=> $program_studi_rata,
										'id_user'				 => $id_user,
									
								);
								$this->Mcrud->update_penggunaan_dana(array('id_penggunaan_dana' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/penggunaan_dana');
					}

		}
	}


	public function pkm_dtps($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('pkm_dtps.id_pkm_dtps', 'ASC');
			$data['pkm_dtps'] 		  = $this->db->get("pkm_dtps");

				if ($aksi == 't') {
					$p = "pkm_dtps_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('pkm_dtps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "pkm_dtps_detail";

					$data['query'] = $this->db->get_where("pkm_dtps", array('id_pkm_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_pkm_dtps(array('id_pkm_dtps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pkm_dtps(array('id_pkm_dtps' => "$id"), $data2);

							redirect('users/pkm_dtps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_pkm_dtps(array('id_pkm_dtps' => "$id"), $data2);

							redirect('users/pkm_dtps');
					}
				}elseif ($aksi == 'e') {
					$p = "pkm_dtps_edit";
					
					$data['query'] = $this->db->get_where("pkm_dtps", array('id_pkm_dtps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("pkm_dtps", array('id_pkm_dtps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_pkm_dtps(array('id_pkm_dtps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pkm_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_pkm_dtps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/pkm_dtps');
				}else{
					$p = "pkm_dtps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$sumber_pembiayaan   	 	= htmlentities(strip_tags($this->input->post('sumber_pembiayaan')));
							$jumlah_judul_pkm_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_pkm_ts')));
							$jumlah_judul_pkm_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_pkm_ts1')));
							$jumlah_judul_pkm_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_pkm_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('pkm_dtps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'sumber_pembiayaan'			=> $sumber_pembiayaan,
										'jumlah_judul_pkm_ts'		=> $jumlah_judul_pkm_ts,
										'jumlah_judul_pkm_ts1'		=> $jumlah_judul_pkm_ts1,
										'jumlah_judul_pkm_ts2'		=> $jumlah_judul_pkm_ts2,
										'jumlah'					=> $jumlah,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_pkm_dtps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$sumber_pembiayaan   	 	= htmlentities(strip_tags($this->input->post('sumber_pembiayaan')));
							$jumlah_judul_pkm_ts  = htmlentities(strip_tags($this->input->post('jumlah_judul_pkm_ts')));
							$jumlah_judul_pkm_ts1  = htmlentities(strip_tags($this->input->post('jumlah_judul_pkm_ts1')));
							$jumlah_judul_pkm_ts2  = htmlentities(strip_tags($this->input->post('jumlah_judul_pkm_ts2')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
								$data = array(
										'sumber_pembiayaan'			=> $sumber_pembiayaan,
										'jumlah_judul_pkm_ts'		=> $jumlah_judul_pkm_ts,
										'jumlah_judul_pkm_ts1'		=> $jumlah_judul_pkm_ts1,
										'jumlah_judul_pkm_ts2'		=> $jumlah_judul_pkm_ts2,
										'jumlah'					=> $jumlah,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_pkm_dtps(array('id_pkm_dtps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/pkm_dtps');
					}

		}
	}



	public function dosen_industri($aksi='', $id='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('dosen_industri.id_dosen_industri', 'ASC');
			$data['dosen_industri'] 		  = $this->db->get("dosen_industri");

				if ($aksi == 't') {
					$p = "dosen_industri_tambah";
					
					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('dosen_industri', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "dosen_industri_detail";

					$data['query'] = $this->db->get_where("dosen_industri", array('id_dosen_industri' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_industri(array('id_dosen_industri' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_industri(array('id_dosen_industri' => "$id"), $data2);

							redirect('users/dosen_industri');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_dosen_industri(array('id_dosen_industri' => "$id"), $data2);

							redirect('users/dosen_industri');
					}
				}elseif ($aksi == 'e') {
					$p = "dosen_industri_edit";
					
					$data['query'] = $this->db->get_where("dosen_industri", array('id_dosen_industri' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("dosen_industri", array('id_dosen_industri' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_dosen_industri(array('id_dosen_industri' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_industri_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_dosen_industri_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/dosen_industri');
				}else{
					$p = "dosen_industri";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nidk   	 	= htmlentities(strip_tags($this->input->post('nidk')));
							$perusahaan  = htmlentities(strip_tags($this->input->post('perusahaan')));
							$pendidikan_tertinggi  	= htmlentities(strip_tags($this->input->post('pendidikan_tertinggi')));
							$bidang_keahlian   	 	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$sertifikat  = htmlentities(strip_tags($this->input->post('sertifikat')));
							$mata_kuliah  	= htmlentities(strip_tags($this->input->post('mata_kuliah')));
							$bobot_kredit  	= htmlentities(strip_tags($this->input->post('bobot_kredit')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('dosen_industri', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'nama_dosen'				=> $nama_dosen,
										'nidk'						=> $nidk,
										'perusahaan'				=> $perusahaan,
										'pendidikan_tertinggi'		=> $pendidikan_tertinggi,
										'bidang_keahlian' 			=> $bidang_keahlian,
										'sertifikat'				=> $sertifikat,
										'mata_kuliah'				=> $mata_kuliah,
										'bobot_kredit'				=> $bobot_kredit,
										'token_lampiran' 			=> $token,
										'id_user'					=> $id_user,
										
									);
									$this->Mcrud->save_dosen_industri($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_dosen   	 	= htmlentities(strip_tags($this->input->post('nama_dosen')));
							$nidk   	 	= htmlentities(strip_tags($this->input->post('nidk')));
							$perusahaan  = htmlentities(strip_tags($this->input->post('perusahaan')));
							$pendidikan_tertinggi  	= htmlentities(strip_tags($this->input->post('pendidikan_tertinggi')));
							$bidang_keahlian   	 	= htmlentities(strip_tags($this->input->post('bidang_keahlian')));
							$sertifikat  = htmlentities(strip_tags($this->input->post('sertifikat')));
							$mata_kuliah  	= htmlentities(strip_tags($this->input->post('mata_kuliah')));
							$bobot_kredit  	= htmlentities(strip_tags($this->input->post('bobot_kredit')));
							
								$data = array(
										'nama_dosen'				=> $nama_dosen,
										'nidk'						=> $nidk,
										'perusahaan'				=> $perusahaan,
										'pendidikan_tertinggi'		=> $pendidikan_tertinggi,
										'bidang_keahlian' 			=> $bidang_keahlian,
										'sertifikat'				=> $sertifikat,
										'mata_kuliah'				=> $mata_kuliah,
										'bobot_kredit'				=> $bobot_kredit,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_dosen_industri(array('id_dosen_industri' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/dosen_industri');
					}

		}
	}




	public function saran($aksi='', $id='') 
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('saran.id_saran', 'ASC');
			$data['saran'] 		  = $this->db->get("saran");

				if ($aksi == 't') {
					$p = "saran_tambah";

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('saran', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "saran_detail";

					$data['query'] = $this->db->get_where("saran", array('id_saran' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_saran(array('id_saran' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_saran(array('id_saran' => "$id"), $data2);

							redirect('users/saran');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_saran(array('id_saran' => "$id"), $data2);

							redirect('users/saran');
					}
				}elseif ($aksi == 'e') {
					$p = "saran_edit";
					

					$data['query'] = $this->db->get_where("saran", array('id_saran' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("saran", array('id_saran' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_saran(array('id_saran' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_saran_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_saran_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/saran');
				}else{
					$p = "saran";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$tanggal   	 	= htmlentities(strip_tags($this->input->post('tanggal')));
							$pengirim  = htmlentities(strip_tags($this->input->post('pengirim')));
							$perihal  	= htmlentities(strip_tags($this->input->post('perihal')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('saran', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'tanggal'				=> $tanggal,
										'pengirim'				=> $pengirim,
										'perihal'				=> $perihal,
										'id_user'				=> $id_user,
										'token_lampiran' 			=> $token,
										
									);
									$this->Mcrud->save_saran($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$tanggal   	 	= htmlentities(strip_tags($this->input->post('tanggal')));
							$pengirim  = htmlentities(strip_tags($this->input->post('pengirim')));
							$perihal  	= htmlentities(strip_tags($this->input->post('perihal')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('saran', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
								$data = array(
										'tanggal'				=> $tanggal,
										'pengirim'				=> $pengirim,
										'perihal'				=> $perihal,
										'id_user'				=> $id_user,
									
								);
								$this->Mcrud->update_saran(array('id_saran' => $id), $data);

								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/saran');
					}

		}
	}



	public function program($aksi='', $id='') 
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('program.id_program', 'ASC');
			$data['program'] 		  = $this->db->get("program");

				if ($aksi == 't') {
					$p = "program_tambah";

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('program', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "program_detail";

					$data['query'] = $this->db->get_where("program", array('id_program' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_program(array('id_program' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_program(array('id_program' => "$id"), $data2);

							redirect('users/program');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_program(array('id_program' => "$id"), $data2);

							redirect('users/program');
					}
				}elseif ($aksi == 'e') {
					$p = "program_edit";
					

					$data['query'] = $this->db->get_where("program", array('id_program' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("program", array('id_program' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_program(array('id_program' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_program_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_program_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/program');
				}else{
					$p = "program";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$nama_program    	= htmlentities(strip_tags($this->input->post('nama_program')));
							$jenis_program  = htmlentities(strip_tags($this->input->post('jenis_program')));
							$peringkat  	= htmlentities(strip_tags($this->input->post('peringkat')));
							$no_sk   	 	= htmlentities(strip_tags($this->input->post('no_sk')));
							$tgl_kadaluarsa  = htmlentities(strip_tags($this->input->post('tgl_kadaluarsa')));
							$nama_unit  	= htmlentities(strip_tags($this->input->post('nama_unit')));
							$nama_perguruan   	= htmlentities(strip_tags($this->input->post('nama_perguruan')));
							$alamat  = htmlentities(strip_tags($this->input->post('alamat')));
							$no_tlp  	= htmlentities(strip_tags($this->input->post('no_tlp')));
							$email   	 	= htmlentities(strip_tags($this->input->post('email')));
							$website  = htmlentities(strip_tags($this->input->post('website')));
							$ts  	= htmlentities(strip_tags($this->input->post('ts')));
							$nama_pengusul   	= htmlentities(strip_tags($this->input->post('nama_pengusul')));
							$tanggal  = htmlentities(strip_tags($this->input->post('tanggal')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('program', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'nama_program'				=> $nama_program,
										'jenis_program'				=> $jenis_program,
										'peringkat'					=> $peringkat,
										'no_sk'						=> $no_sk,
										'tgl_kadaluarsa'			=> $tgl_kadaluarsa,
										'nama_unit'					=> $nama_unit,
										'nama_perguruan'			=> $nama_perguruan,
										'alamat'					=> $alamat,
										'no_tlp'					=> $no_tlp,
										'email'						=> $email,
										'website'					=> $website,
										'ts'						=> $ts,
										'nama_pengusul'				=> $nama_pengusul,
										'tanggal'					=> $tanggal,
										'id_user'					=> $id_user,

										
										'token_lampiran' 			=> $token,
										
									);
									$this->Mcrud->save_program($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$nama_program    	= htmlentities(strip_tags($this->input->post('nama_program')));
							$jenis_program  = htmlentities(strip_tags($this->input->post('jenis_program')));
							$peringkat  	= htmlentities(strip_tags($this->input->post('peringkat')));
							$no_sk   	 	= htmlentities(strip_tags($this->input->post('no_sk')));
							$tgl_kadaluarsa  = htmlentities(strip_tags($this->input->post('tgl_kadaluarsa')));
							$nama_unit  	= htmlentities(strip_tags($this->input->post('nama_unit')));
							$nama_perguruan   	= htmlentities(strip_tags($this->input->post('nama_perguruan')));
							$alamat  = htmlentities(strip_tags($this->input->post('alamat')));
							$no_tlp  	= htmlentities(strip_tags($this->input->post('no_tlp')));
							$email   	 	= htmlentities(strip_tags($this->input->post('email')));
							$website  = htmlentities(strip_tags($this->input->post('website')));
							$ts  	= htmlentities(strip_tags($this->input->post('ts')));
							$nama_pengusul   	= htmlentities(strip_tags($this->input->post('nama_pengusul')));
							$tanggal  = htmlentities(strip_tags($this->input->post('tanggal')));
							
								$data = array(
										'nama_program'				=> $nama_program,
										'jenis_program'				=> $jenis_program,
										'peringkat'					=> $peringkat,
										'no_sk'						=> $no_sk,
										'tgl_kadaluarsa'			=> $tgl_kadaluarsa,
										'nama_unit'					=> $nama_unit,
										'nama_perguruan'			=> $nama_perguruan,
										'alamat'					=> $alamat,
										'no_tlp'					=> $no_tlp,
										'email'						=> $email,
										'website'					=> $website,
										'ts'						=> $ts,
										'nama_pengusul'				=> $nama_pengusul,
										'tanggal'					=> $tanggal,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_program(array('id_program' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/program');
					}

		}
	}

	public function upps($aksi='', $id='') 
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			
			$this->db->order_by('upps.id_upps', 'ASC');
			$data['upps'] 		  = $this->db->get("upps");

				if ($aksi == 't') {
					$p = "upps_tambah";

					$data['judul_web'] 	  = "Tambah Data Berkas | Aplikasi ";
					$data['data_ns']			= $this->Mcrud->data_ns('upps', "$id_user");
				}elseif ($aksi == 'd') {
					$p = "upps_detail";

					$data['query'] = $this->db->get_where("upps", array('id_upps' => "$id"))->row();
					$data['judul_web'] 	  = "Detail Berkas | Aplikasi";

					
					if ($data['user']->row()->level == 'user') {
							$data2 = array(
							);
							$this->Mcrud->update_upps(array('id_upps' => "$id"), $data2);
					}

					if (isset($_POST['btndisposisi'])) {
							$data2 = array(
							);
							$this->Mcrud->update_upps(array('id_upps' => "$id"), $data2);

							redirect('users/upps');
					}

					if (isset($_POST['btndisposisi0'])) {
							$data2 = array(
							);
							$this->Mcrud->update_upps(array('id_upps' => "$id"), $data2);

							redirect('users/upps');
					}
				}elseif ($aksi == 'e') {
					$p = "upps_edit";
					

					$data['query'] = $this->db->get_where("upps", array('id_upps' => "$id"))->row();
					$data['judul_web'] 	  = "Edit Data | Aplikasi ";

					
				}elseif ($aksi == 'h') {


					$data['query'] = $this->db->get_where("upps", array('id_upps' => "$id", 'id_user' => "$id_user"))->row();
					$data['judul_web'] 	  = "Hapus Data | Aplikasi";

					if ($data['query']->id_user != '') {

							$data2 = array(
								'id_user'		   	 => ''
							);
							$this->Mcrud->update_upps(array('id_upps' => "$id"), $data2);

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_upps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);

					}else {

							$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
							foreach ($query_h->result() as $baris) {
								unlink('lampiran/'.$baris->nama_berkas);
							}

							$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
							$this->Mcrud->delete_upps_by_id($id);
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
							);
					}

					redirect('users/upps');
				}else{
					$p = "upps";

					$data['judul_web'] 	  = " Data | Aplikasi ";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/$p", $data);
					$this->load->view('users/footer');


					if (isset($_POST['ns'])) {

						$this->upload->initialize(array(
							"upload_path"   => "./lampiran",
							"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
						));

						if($this->upload->do_upload('userfile')){
							$jenis    	= htmlentities(strip_tags($this->input->post('jenis')));
							$nama  = htmlentities(strip_tags($this->input->post('nama')));
							$status  	= htmlentities(strip_tags($this->input->post('status')));
							$no   	 	= htmlentities(strip_tags($this->input->post('no')));
							$tanggal  = htmlentities(strip_tags($this->input->post('tanggal')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
							date_default_timezone_set('Asia/Jakarta');
							$waktu = date('Y-m-d H:m:s');
							$tgl 	 = date('d-m-Y');
 
							$token = md5("$id_user-$ns-$waktu");

							$cek_status = $this->db->get_where('upps', "token_lampiran='$token'")->num_rows();
								if ($cek_status == 0) {
									$data = array(
										
										'jenis'						=> $jenis,
										'nama'						=> $nama,
										'status'					=> $status,
										'no'						=> $no,
										'tanggal'					=> $tanggal,
										'jumlah'					=> $jumlah,
										'id_user'					=> $id_user,	
										'token_lampiran' 			=> $token,
										
									);
									$this->Mcrud->save_upps($data);
									
								}

								$nama   = $this->upload->data('file_name');
								$ukuran = $this->upload->data('file_size');

								$this->db->insert('tbl_lampiran',array('nama_berkas'=>$nama,'ukuran'=>$ukuran,'token_lampiran'=>"$token"));

						}
							
					}

					if (isset($_POST['btnupdate'])) {
							$jenis    	= htmlentities(strip_tags($this->input->post('jenis')));
							$nama  = htmlentities(strip_tags($this->input->post('nama')));
							$status  	= htmlentities(strip_tags($this->input->post('status')));
							$no   	 	= htmlentities(strip_tags($this->input->post('no')));
							$tanggal  = htmlentities(strip_tags($this->input->post('tanggal')));
							$jumlah  	= htmlentities(strip_tags($this->input->post('jumlah')));
							
								$data = array(
										'jenis'						=> $jenis,
										'nama'						=> $nama,
										'status'					=> $status,
										'no'						=> $no,
										'tanggal'					=> $tanggal,
										'jumlah'					=> $jumlah,
										'id_user'					=> $id_user,
									
								);
								$this->Mcrud->update_upps(array('id_upps' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
									);
									redirect('users/upps');
					}

		}
	}

}
