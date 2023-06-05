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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Penelitian DTPS yang Menjadi Rujukan Tema Tesis/Disertasi</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Magister/Magister Terapan/Doktor/Doktor Terapan.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/penelitian_dtps_tesis/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Nama Dosen</th>
              <th><center>Tema Penelitian Sesuai Readmap</th>
              <th><center>Nama Mahasiswa</th>
              <th><center>Judul Tesis/Disertasi</th>
              <th><center>Tahun</th>
              
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($penelitian_dtps_tesis->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->tema; ?></td>
                  <td><center><?php echo $baris->nama_mhs; ?></td>
                  <td><center><?php echo $baris->judul; ?></td>
                  <td><center><?php echo $baris->tahun; ?></td>
                  
                  <td>
                    <a href="users/penelitian_dtps_tesis/d/<?php echo $baris->id_penelitian_dtps_tesis; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/penelitian_dtps_tesis/e/<?php echo $baris->id_penelitian_dtps_tesis; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/penelitian_dtps_tesis/h/<?php echo $baris->id_penelitian_dtps_tesis; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
