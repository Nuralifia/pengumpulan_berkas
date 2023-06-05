<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <?php
    echo $this->session->flashdata('msg');
    ?>
    <!-- Dashboard content -->
    <div class="row">
      <!-- Basic datatable -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Dosen Tetap Perguruan Tinggi</h5>
          <h6 style="color:black">Gasal 2019/2020 1D3TI</i></h6>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/dosen_tetap/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Nama Dosen</th>
              <th rowspan="2"><center>NIDN/NIDK</th>
              <th colspan="2"><center>Pendidikan Pasca sarjana</center></th>
              <th rowspan="2"><center>Bidang Keahlian</th>
              <th rowspan="2"><center>Kesesuaian dengan Kompetensi inti IPS</th>
              <th rowspan="2"><center>Jabatan Akademik</th>
              <th rowspan="2"><center>Sertifikat Pendidik Profesional</th>
              <th rowspan="2"><center>Sertifikat Kompetensi/Profesi/industri</th>
              <th rowspan="2"><center>Mata Kuliah yang Diampu pada PS yang Diakreditasi</th>
              <th rowspan="2"><center>Kesesuaian Bidang Keahlian dengan Mata Kuliah yang Diampu</th>
              <th rowspan="2"><center>Mata Kuliah yang Diampu pada PS Lain</th>
              <th rowspan="2" class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>Magister/Magister Terapan/Spesialis</th>
              <th><center>Doktor/Doktor Terapan/Spesialis</th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($dosen_tetap->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->nidn_nidk; ?></td>
                  <td><center><?php echo $baris->pendidikan_magister; ?></td>
                  <td><center><?php echo $baris->pendidikan_doktor; ?></td>
                  <td><center><?php echo $baris->bidang_keahlian; ?></td>
                  <td><center><?php echo $baris->kesesuaian_kompetensi; ?></td>
                  <td><center><?php echo $baris->jabatan_akademik; ?></td>
                  <td><center><?php echo $baris->sertifikat_profesional; ?></td>
                  <td><center><?php echo $baris->sertifikat_kompetensi_profesi; ?></td>
                  <td><center><?php echo $baris->mata_kuliah_akreditasi; ?></td>
                  <td><center><?php echo $baris->kesesuaian_keahlian; ?></td>
                  <td><center><?php echo $baris->mata_kuliah_lain; ?></td>
                  
                  <td>
                    <a href="users/dosen_tetap/d/<?php echo $baris->id_dosen_tetap; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/dosen_tetap/e/<?php echo $baris->id_dosen_tetap; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/dosen_tetap/h/<?php echo $baris->id_dosen_tetap; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
                    <?php
                    } ?>
                  </td>
                </tr>
              <?php
              $no++;
              } ?>
          </tbody>
        </table>
      </div>
      <!-- /basic datatable -->
    </div>
    <!-- /dashboard content -->
