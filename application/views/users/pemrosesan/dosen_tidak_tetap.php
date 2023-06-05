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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Dosen Tidak Tetap</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/dosen_tidak_tetap/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Nama Dosen</th>
              <th><center>NIDN/NIDK</th>
              <th><center>Pendidikan Pasca Sarjana</th>
              <th><center>Bidang Keahlian</th>
              <th><center>Jabatan Akademik</th>
              <th><center>Sertifikat Pendidik Profesional</th>
              <th><center>Sertifikat/Kompetensi/Profesi Industri</th>
              <th><center>Mata Kuliah yang Diampu pada PS yang Diakreditasi</th>
              <th><center>Kesesuaian Bidang Keahlian dengan Mata Kuliah yang Diampu</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($dosen_tidak_tetap->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->nidn_nidk; ?></td>
                  <td><center><?php echo $baris->pendidikan; ?></td>
                  <td><center><?php echo $baris->bidang_keahlian; ?></td>
                  <td><center><?php echo $baris->jabatan_akademik; ?></td>
                  <td><center><?php echo $baris->sertifikat_profesional; ?></td>
                  <td><center><?php echo $baris->sertifikat_kompetensi_profesi; ?></td>
                  <td><center><?php echo $baris->mata_kuliah_diampu; ?></td>
                  <td><center><?php echo $baris->kesesuaian_keahlian; ?></td>
                  
                  <td>
                    <a href="users/dosen_tidak_tetap/d/<?php echo $baris->id_dosen_tidak_tetap; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/dosen_tidak_tetap/e/<?php echo $baris->id_dosen_tidak_tetap; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/dosen_tidak_tetap/h/<?php echo $baris->id_dosen_tidak_tetap; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
