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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Prestasi Non-akademik Mahasiswa</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/prestasi_nonakademik/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Nama Kegiatan</th>
              <th><center>Waktu Perolehan</th>
              <th><center>Tingkat</th>
              <th><center>Prestasi Yang Dicapai</th>
              <th><center>Nama Mahasiswa</th>
              <th><center>NRP</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($prestasi_nonakademik->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_kegiatan; ?></td>
                  <td><center><?php echo $baris->waktu_perolehan; ?></td>
                  <td><center><?php echo $baris->tingkat; ?></td>
                  <td><center><?php echo $baris->prestasi; ?></td>
                  <td><center><?php echo $baris->nama_mhs; ?></td>
                  <td><center><?php echo $baris->nrp; ?></td>
                  
                  <td>
                    <a href="users/prestasi_nonakademik/d/<?php echo $baris->id_prestasi_nonakademik; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/prestasi_nonakademik/e/<?php echo $baris->id_prestasi_nonakademik; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/prestasi_nonakademik/h/<?php echo $baris->id_prestasi_nonakademik; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
