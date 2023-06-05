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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Dosen Industri/Praktisi</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana Terapan.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/dosen_industri/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Nama Dosen Industri/Praktisi</th>
              <th><center>NIDK</th>
              <th><center>Perusahaan/Industri</th>
              <th><center>Pendidikan Tertinggi</th>
              <th><center>Bidang Keahlian</th>
              <th><center>Sertifikat Profesi/Kompetensi/Industri</th>
              <th><center>Mata Kuliah yang Diampu</th>
              <th><center>Bobot Kredit (sks)</th>
              
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($dosen_industri->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->nidk; ?></td>
                  <td><center><?php echo $baris->perusahaan; ?></td>
                  <td><center><?php echo $baris->pendidikan_tertinggi; ?></td>
                  <td><center><?php echo $baris->bidang_keahlian; ?></td>
                  <td><center><?php echo $baris->sertifikat; ?></td>
                  <td><center><?php echo $baris->mata_kuliah; ?></td>
                  <td><center><?php echo $baris->bobot_kredit; ?></td>
                  
                  <td>
                    <a href="users/dosen_industri/d/<?php echo $baris->id_dosen_industri; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/dosen_industri/e/<?php echo $baris->id_dosen_industri; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/dosen_industri/h/<?php echo $baris->id_dosen_industri; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
