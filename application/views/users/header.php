<?php
$cek    = $user->row();
$nama   = $cek->nama_lengkap;

$level  = $cek->level;
if ($level == "s_admin") {
		$level = "Super Admin";
}

$menu 		= strtolower($this->uri->segment(1));
$sub_menu = strtolower($this->uri->segment(2));
$sub_menu3 = strtolower($this->uri->segment(3));
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.interface.club/limitless/layout_2/LTR/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Apr 2017 11:59:08 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<base href="<?php echo base_url();?>"/>

	<title><?php echo $judul_web; ?></title>
 <style type="text/css">

  th{
    background-color:#32B7D4;
   
  }
  th, td{
    padding: 5px;
  }
  
  tr:nth-child(odd){
    background-color:#BAE7E7;
  }
  tr:nth-child(even){
    background-color:#ecf9fe; 
  }
  tr:hover{
    background-color:#ffffff;
    cursor: pointer; 
  }
  </style>
	<!-- Global stylesheets -->
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<?php
	if ($sub_menu == "" or $sub_menu == "profile" or $sub_menu == "lap_ipk_lulusan" or $sub_menu == "dosen_industri" or $sub_menu == "kepuasan_mhs" or $sub_menu == "karya_mhs_disitasi" or $sub_menu == "karya_dtps_disitasi" or $sub_menu == "integrasi_penelitian_pembelajaran" or $sub_menu == "kepuasan_pengguna_lulusan" or $sub_menu == "ewmp_dosen_tetap" or $sub_menu == "dosen_pembimbing_utama_pa" or $sub_menu == "kesesuaian_bidang_kerja" or $sub_menu == "mahasiswa_asing" or $sub_menu == "penelitian_dtps" or $sub_menu == "penelitian_dtps_mhs" or $sub_menu == "prestasi_akademik" or $sub_menu == "prestasi_nonakademik" or $sub_menu == "produk_jasa_dtps" or $sub_menu == "produk_jasa_mhs_diapdosi" or $sub_menu == "publikasi_ilmiah_dtps" or $sub_menu == "publikasi_ilmiah_mhs" or $sub_menu == "refrensi" or $sub_menu == "seleksi_mahasiswa" or $sub_menu == "tempat_kerja_lulusan" or $sub_menu == "waktu_tunggu_d3" or $sub_menu == "waktu_tunggu_s" or $sub_menu == "waktu_tunggu_st" or $sub_menu == "dosen_tetap" or $sub_menu == "dosen_tidak_tetap" or $sub_menu == "kerjasama_tridharma_pendidikan" or $sub_menu == "kerjasama_tridharma_penelitian" or $sub_menu == "kerjasama_tridharma_pengabdian" or $sub_menu == "kurikulum" or $sub_menu == "luaran_penelitianlainnya_dtps" or $sub_menu == "luaran_pkm_lainnya_dtps" or $sub_menu == "luaran_penelitian_mhs_1" or $sub_menu == "luaran_penelitian_mhs_2" or $sub_menu == "luaran_penelitian_mhs_3" or $sub_menu == "luaran_penelitian_mhs_4" or $sub_menu == "masa_studi_d" or $sub_menu == "masa_studi_do" or $sub_menu == "masa_studi_m" or $sub_menu == "masa_studi_s" or $sub_menu == "pagelaran_ilmiah_dtps" or $sub_menu == "pagelaran_ilmiah_mhs" or $sub_menu == "penelitian_dtps_tesis" or $sub_menu == "pengakuan_rekognisi_dtps" or $sub_menu == "penggunaan_dana" or $sub_menu == "pkm_dtps" or $sub_menu == "pkm_dtps_mhs" or $sub_menu == "luaran_penelitianlainnya_dtps_3" or $sub_menu == "luaran_penelitianlainnya_dtps_4") {?>
	<!-- Theme JS files -->

		<link rel="stylesheet" href="assets/calender/css/style.css">
		<link rel="stylesheet" href="assets/calender/css/pignose.calendar.css">



	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<!-- <script type="text/javascript" src="assets/js/pages/dashboard.js"></script> -->
	<script src="assets/calender/js/pignose.calendar.js"></script>
	<!-- /theme JS files -->


	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> -->
	<?php
	} ?>

		<?php
	if ($sub_menu == "pengguna" or $sub_menu == "program" or $sub_menu == "upps" or $sub_menu == "saran" or $sub_menu == "data_saran") {?>

	<!-- Theme JS files -->
			<?php if ($sub_menu == 'saran' and $sub_menu3 != ''){}elseif ($sub_menu == 'saran' and $sub_menu3 != ''){}else{ ?>
				
			<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>

			<script type="text/javascript" src="assets/js/core/app.js"></script>
			<script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
			<?php } ?>

	<!-- /theme JS files -->
	<?php
	} ?>


</head>
<body>

	<!-- Main navbar -->
	<div class="navbar navbar-default header-highlight">
		<div class="navbar-header">
			<a class="navbar-brand" href=""><img src="assets/images/Logo25.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="foto/default.png" alt="">
						<span><?php echo ucwords($nama); ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="users/profile"><i class="icon-user"></i> Profile</a></li>
						<li class="divider"></li>
						<li><a href="welcome/index"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="users/profile" class="media-left"><img src="foto/default.png" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold"><?php echo ucwords($nama); ?></span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> &nbsp;<?php echo ucwords($level); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li class="<?php if ($sub_menu == "users") { echo 'active';}?>"><a href="users"><i class="icon-home4"></i> <span>BERANDA</span></a></li>

								<?php
								//if ($user->row()->level == 's_admin') 
								{?>
								<li class="<?php if ($sub_menu == "pengguna" or $sub_menu == "program") { echo 'active';}?>">
									<a href="#"><i class="icon-gear"></i> <span>MASTER DATA</span></a>
									<ul>
										<?php
		                if ($user->row()->level == 's_admin') { ?>
										<li class="<?php if ($sub_menu == "pengguna") { echo 'active';}?>"><a href="users/pengguna"><i class="icon-users"></i> USER</a></li>
										<?php
										}?>

										<li class="<?php if ($sub_menu == "program") { echo 'active';}?>"><a href="users/program"><i class="icon-printer4"></i> PROGRAM STUDI</a></li>

										<li class="<?php if ($sub_menu == "upps") { echo 'active';}?>"><a href="users/upps"><i class="icon-printer4"></i>UPPS</a></li>
									</ul>
								</li>
								
								<?php
								} ?>

								<li class="<?php if ($sub_menu == "saran") { echo 'active';}?>"><a href="#"><i class="icon-file-empty2"></i> <span>SARAN</span></a>
									<ul>
										<li class="<?php if ($sub_menu == "saran") { echo 'active';}?>"><a href="users/saran"><i class="icon-file-empty2"></i> Saran</a></li>
									</ul>
								</li>

								<li class="<?php if ($sub_menu == "kerjasama_tridharma_pendidikan") { echo 'active';}?>">
									<a href="#"><i class="icon-file-spreadsheet"></i> <span>BERKAS AKREDITASI</span></a>
									<ul>
										<style type="text/css">

										.wrapper .icon{
										  margin: 0 0px;
										  text-align: center;
										  cursor: pointer;
										  display: flex;
										  align-items: center;
										  justify-content: center;
										  flex-direction: column;
										  position: relative;
										  z-index: 2;
										  transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
										}
										.wrapper .icon span{
										  height: 10px;
										  width: 10px;
										  position: relative;
										  z-index: 2;
										}
										.wrapper .icon span i{
										  line-height: 60px;
										  font-size: 15px;
										}
										.wrapper .icon .tooltip{
										  position: absolute;
										  top: 0;
										  z-index: 1;
										  background: #b0c4de;
										  color: #000;
										  padding: 10px 18px;
										  font-size: 15px;
										  font-weight: 500;
										  border-radius: 25px;
										  opacity: 0;
										  pointer-events: none;
										  box-shadow: 0px 10px 10px rgba(0,0,0,0.1);
										  transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
										}
										.wrapper .icon:hover .tooltip{
										  top: -70px;
										  opacity: 1;
										  pointer-events: auto;
										}
										.icon .tooltip:before{
										  position: absolute;
										  content: "";
										  height: 15px;
										  width: 15px;
										  background: #b0c4de;
										  left: 50%;
										  bottom: -6px;
										  transform: translateX(-50%) rotate(45deg);
										  transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
										}
										.wrapper .icon:hover span{
										  color: #fff;
										}
										.wrapper .icon:hover span,
										.wrapper .icon:hover .tooltip{
										  text-shadow: 0px -1px 0px rgba(0,0,0,0.4);
										}
										
										  </style>
																				
										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kerjasama Tridharma - Pendidikan
								            </div>
										<li class="<?php if ($sub_menu == "kerjasama_tridharma_pendidikan") { echo 'active';}?>"><a href="users/kerjasama_tridharma_pendidikan"><i class="icon-folder-download2"><span></i>1-1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kerjasama Tridharma - Penelitian
								            </div>
										<li class="<?php if ($sub_menu == "kerjasama_tridharma_penelitian") { echo 'active';}?>"><a href="users/kerjasama_tridharma_penelitian"><i class="icon-folder-download2"><span></i>1-2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kerjasama Tridharma - Pengabdian Kepada Masyarakat
								            </div>
										<li class="<?php if ($sub_menu == "kerjasama_tridharma_pengabdian") { echo 'active';}?>"><a href="users/kerjasama_tridharma_pengabdian"><i class="icon-folder-download2"><span></i>1-3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Seleksi Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "seleksi_mahasiswa") { echo 'active';}?>"><a href="users/seleksi_mahasiswa"><i class="icon-folder-download2"><span></i>2a</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Mahasiswa Asing
								            </div>
										<li class="<?php if ($sub_menu == "mahasiswa_asing") { echo 'active';}?>"><a href="users/mahasiswa_asing"><i class="icon-folder-download2"><span></i>2b</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Dosen Tetap Perguruan Tinggi
								            </div>
										<li class="<?php if ($sub_menu == "dosen_tetap") { echo 'active';}?>"><a href="users/dosen_tetap"><i class="icon-folder-download2"><span></i>3a1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Dosen Pembimbing Utama Tugas Akhir
								            </div>
										<li class="<?php if ($sub_menu == "dosen_pembimbing_utama_pa") { echo 'active';}?>"><a href="users/dosen_pembimbing_utama_pa"><i class="icon-folder-download2"><span></i> 3a2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Ekuivalen Waktu Mengajar Penuh (EWMP) Dosen Tetap Perguruan Tinggi
								            </div>
										<li class="<?php if ($sub_menu == "ewmp_dosen_tetap") { echo 'active';}?>"><a href="users/ewmp_dosen_tetap"><i class="icon-folder-download2"><span></i>3a3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Dosen Tidak Tetap
								            </div>
										<li class="<?php if ($sub_menu == "dosen_tidak_tetap") { echo 'active';}?>"><a href="users/dosen_tidak_tetap"><i class="icon-folder-download2"><span></i>3a4</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Dosen Industri / Praktisi
								            </div>
										<li class="<?php if ($sub_menu == "dosen_industri") { echo 'active';}?>"><a href="users/dosen_industri"><i class="icon-folder-download2"><span></i>3a5</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Pengakuan / Rekogisi Dosen
								            </div>
										<li class="<?php if ($sub_menu == "pengakuan_rekognisi_dtps") { echo 'active';}?>"><a href="users/pengakuan_rekognisi_dtps"><i class="icon-folder-download2"><span></i>3b1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Penelitian DTPS
								            </div>
										<li class="<?php if ($sub_menu == "penelitian_dtps") { echo 'active';}?>"><a href="users/penelitian_dtps"><i class="icon-folder-download2"><span></i>3b2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               PkM DTPS
								            </div>
										<li class="<?php if ($sub_menu == "pkm_dtps") { echo 'active';}?>"><a href="users/pkm_dtps"><i class="icon-folder-download2"><span></i>3b3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Publikasi Ilmiah DTPS
								            </div>
										<li class="<?php if ($sub_menu == "publikasi_ilmiah_dtps") { echo 'active';}?>"><a href="users/publikasi_ilmiah_dtps"><i class="icon-folder-download2"><span></i>3b4-1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Pengelaran/Pameran/Presentasi/ Publikasi DTPS
								            </div>
										<li class="<?php if ($sub_menu == "pagelaran_ilmiah_dtps") { echo 'active';}?>"><a href="users/pagelaran_ilmiah_dtps"><i class="icon-folder-download2"><span></i>3b4-2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Karya Ilmiah DTPS yang Disitasi
								            </div>
										<li class="<?php if ($sub_menu == "karya_dtps_disitasi") { echo 'active';}?>"><a href="users/karya_dtps_disitasi"><i class="icon-folder-download2"><span></i>3b5</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Produk Jasa DTPS yang Diadopsi Oleh Industri / Masyarakat
								            </div>
										<li class="<?php if ($sub_menu == "produk_jasa_dtps") { echo 'active';}?>"><a href="users/produk_jasa_dtps"><i class="icon-folder-download2"><span></i>3b6</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Luaran Penelitian PkM Lainnya - HKI (Paten, Paten Sederhana)
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitianlainnya_dtps") { echo 'active';}?>"><a href="users/luaran_penelitianlainnya_dtps"><i class="icon-folder-download2"><span></i>3b7-1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Luaran Penelitian PkM Lainnya - HKI (Hak Cipta, Desain Produksi Industri, dll)
								            </div>
										<li class="<?php if ($sub_menu == "luaran_pkm_lainnya_dtps") { echo 'active';}?>"><a href="users/luaran_pkm_lainnya_dtps"><i class="icon-folder-download2"><span></i>3b7-2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Luaran Penelitian PkM Lainnya - Teknologi Tepat Guna, Produksi, Karya Seni, Rekayasa Sosial
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitianlainnya_dtps_3") { echo 'active';}?>"><a href="users/luaran_penelitianlainnya_dtps_3"><i class="icon-folder-download2"><span></i>3b7-3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Luaran Penelitian PkM Lainnya - Buku ber-ISBN, Book Chapter
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitianlainnya_dtps_4") { echo 'active';}?>"><a href="users/luaran_penelitianlainnya_dtps_4"><i class="icon-folder-download2"><span></i>3b7-4</a></li></span>	
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Penggunaan Dana
								            </div>
										<li class="<?php if ($sub_menu == "penggunaan_dana") { echo 'active';}?>"><a href="users/penggunaan_dana"><i class="icon-folder-download2"><span></i>4</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kilikurum, Capaian Pembelajaran, dan Rencana Pembelajaran
								            </div>
										<li class="<?php if ($sub_menu == "kurikulum") { echo 'active';}?>"><a href="users/kurikulum"><i class="icon-folder-download2"><span></i>5a</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Integrasi Kegiatan Penelitian/PkM dalam Pembelajaran
								            </div>
										<li class="<?php if ($sub_menu == "integrasi_penelitian_pembelajaran") { echo 'active';}?>"><a href="users/integrasi_penelitian_pembelajaran"><i class="icon-folder-download2"><span></i>5b</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kepuasan Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "kepuasan_mhs") { echo 'active';}?>"><a href="users/kepuasan_mhs"><i class="icon-folder-download2"><span></i>5c</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Penelitian DTPS yang Melibatkan Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "penelitian_dtps_mhs") { echo 'active';}?>"><a href="users/penelitian_dtps_mhs"><i class="icon-folder-download2"><span></i>6a</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Penalitian DTPS yang Menjadi Rujukan Tema Tesis/Disitasi
								            </div>
										<li class="<?php if ($sub_menu == "penelitian_dtps_tesis") { echo 'active';}?>"><a href="users/penelitian_dtps_tesis"><i class="icon-folder-download2"><span></i>6b</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               PKM DTPS yang Melibatkan Masyarakat
								            </div>
										<li class="<?php if ($sub_menu == "pkm_dtps_mhs") { echo 'active';}?>"><a href="users/pkm_dtps_mhs"><i class="icon-folder-download2"><span></i>7</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               IPK Lulusan
								            </div>
										<li class="<?php if ($sub_menu == "ipk_lulusan") { echo 'active';}?>"><a href="users/ipk_lulusan"><i class="icon-folder-download2"><span></i> 8a</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Prestasi Akademik Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "prestasi_akademik") { echo 'active';}?>"><a href="users/prestasi_akademik"><i class="icon-folder-download2"><span></i>8b1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Prestasi Non-akademik Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "prestasi_nonakademik") { echo 'active';}?>"><a href="users/prestasi_nonakademik"><i class="icon-folder-download2"><span></i>8b2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Masa Studi Lulusan Dari Program Diploma Tiga
								            </div>
										<li class="<?php if ($sub_menu == "masa_studi_d") { echo 'active';}?>"><a href="users/masa_studi_d"><i class="icon-folder-download2"><span></i>8c1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Masa Studi Lulusan Dari Program Sarjana/Sarjana Terapan
								            </div>
										<li class="<?php if ($sub_menu == "masa_studi_s") { echo 'active';}?>"><a href="users/masa_studi_s"><i class="icon-folder-download2"><span></i>8c2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Masa Studi Lulusan Dari Program Magister/Magister Terapan
								            </div>
										<li class="<?php if ($sub_menu == "masa_studi_m") { echo 'active';}?>"><a href="users/masa_studi_m"><i class="icon-folder-download2"><span></i>8c3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Masa Studi Lulusan Dari Program Doktor/Doktor Terapan
								            </div>
										<li class="<?php if ($sub_menu == "masa_studi_do") { echo 'active';}?>"><a href="users/masa_studi_do"><i class="icon-folder-download2"><span></i>8c4</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Waktu Tunggu Lulusan Pada Program Diploma
								            </div>
										<li class="<?php if ($sub_menu == "waktu_tunggu_d3") { echo 'active';}?>"><a href="users/waktu_tunggu_d3"><i class="icon-folder-download2"><span></i>8d1-1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Waktu Tunggu Lulusan Pada Program Sarjana
								            </div>
										<li class="<?php if ($sub_menu == "waktu_tunggu_s") { echo 'active';}?>"><a href="users/waktu_tunggu_s"><i class="icon-folder-download2"><span></i>8d1-2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Waktu Tunggu Lulusan Pada Program sarjana Terapan
								            </div>
										<li class="<?php if ($sub_menu == "waktu_tunggu_st") { echo 'active';}?>"><a href="users/waktu_tunggu_st"><i class="icon-folder-download2"><span></i>8d1-3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kesesuaian Bidang Kerja Lulusan
								            </div>
										<li class="<?php if ($sub_menu == "kesesuaian_bidang_kerja") { echo 'active';}?>"><a href="users/kesesuaian_bidang_kerja"><i class="icon-folder-download2"><span></i>8d2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Tempat Kerja Lulusan
								            </div>
										<li class="<?php if ($sub_menu == "tempat_kerja_lulusan") { echo 'active';}?>"><a href="users/tempat_kerja_lulusan"><i class="icon-folder-download2"><span></i>8e1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Referensi
								            </div>
										<li class="<?php if ($sub_menu == "refrensi") { echo 'active';}?>"><a href="users/refrensi"><i class="icon-folder-download2"><span></i>8e2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Kepuasan Pengguna Lulusan
								            </div>
										<li class="<?php if ($sub_menu == "kepuasan_pengguna_lulusan") { echo 'active';}?>"><a href="users/kepuasan_pengguna_lulusan"><i class="icon-folder-download2"><span></i>8e3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Publikasi Ilmiah Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "publikasi_ilmiah_mhs") { echo 'active';}?>"><a href="users/publikasi_ilmiah_mhs"><i class="icon-folder-download2"><span></i>8f1-1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Pengelaran/Pameran/Presentasi/ Publikasi Ilmiah Mahasiswa
								            </div>
										<li class="<?php if ($sub_menu == "pagelaran_ilmiah_mhs") { echo 'active';}?>"><a href="users/pagelaran_ilmiah_mhs"><i class="icon-folder-download2"><span></i>8f1-2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Karya Ilmiah Mahasiswa yang Disitasi
								            </div>
										<li class="<?php if ($sub_menu == "karya_mhs_disitasi") { echo 'active';}?>"><a href="users/karya_mhs_disitasi"><i class="icon-folder-download2"><span></i> 8f2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Produk/Jasa Mahasiswa yang Diapdopsi oleh Industri/Masyarakat
								            </div>
										<li class="<?php if ($sub_menu == "produk_jasa_mhs_diapdosi") { echo 'active';}?>"><a href="users/produk_jasa_mhs_diapdosi"><i class="icon-folder-download2"><span></i>8f3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Luaran Penelitian yang Dihasilkan Mahasiswa - HKI (paten, patenn sederhana)
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitian_mhs_1") { echo 'active';}?>"><a href="users/luaran_penelitian_mhs_1"><i class="icon-folder-download2"><span></i>8f4-1</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               HKI (hak Cipta, Desain Produksi Industri, dll)
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitian_mhs_2") { echo 'active';}?>"><a href="users/luaran_penelitian_mhs_2"><i class="icon-folder-download2"><span></i>8f4-2</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Teknologi Tepat Guna, Produk, Karya Seni, rekayasa Sosial
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitian_mhs_3") { echo 'active';}?>"><a href="users/luaran_penelitian_mhs_3"><i class="icon-folder-download2"><span></i>8f4-3</a></li></span>
										</div>

										<div class="wrapper">
								         <div class="icon"><div class="tooltip">
								               Luaran Penelitian yang Dihasilkan Mahasiswa - Buku ber_ISBN, Book Chpter
								            </div>
										<li class="<?php if ($sub_menu == "luaran_penelitian_mhs_4") { echo 'active';}?>"><a href="users/luaran_penelitian_mhs_4"><i class="icon-folder-download2"><span></i>8f4-4</a></li></span>
										</div>

										
									</ul>
								</li>

								<!-- Logout -->
								<li class="navigation-header"><span>KELUAR</span> <i class="icon-menu" title="Forms"></i></li>
								<li><a href="welcome/index"><i class="icon-switch2"></i> <span>Logout </span></a></li>

								<!-- /logout -->

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->
