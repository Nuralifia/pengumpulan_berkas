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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Kepuasan Pengguna Lulusan</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/kepuasan_pengguna_lulusan/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Jenis Kemampuan</th>
              <th colspan="4"><center>Tingkat Kepuasan Pengguna (%)</th>
              <th rowspan="2"><center>Rencana Tindak Lanjut Oleh UPPS/PS</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>Sangat Baik</th>
              <th><center>Baik</th>
              <th><center>Cukup</th>
              <th><center>Kurang</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($kepuasan_pengguna_lulusan->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->jenis_kepuasan; ?></td>
                  <td><center><?php echo $baris->tingkat_kepuasan_sangat; ?></td>
                  <td><center><?php echo $baris->tingkat_kepuasan_baik; ?></td>
                  <td><center><?php echo $baris->tingkat_kepuasan_cukup; ?></td>
                  <td><center><?php echo $baris->tingkat_kepuasan_kurang; ?></td>
                  <td><center><?php echo $baris->rencana; ?></td>
                  
                  <td>
                    <a href="users/kepuasan_pengguna_lulusan/d/<?php echo $baris->id_kepuasan_pengguna_lulusan; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/kepuasan_pengguna_lulusan/e/<?php echo $baris->id_kepuasan_pengguna_lulusan; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/kepuasan_pengguna_lulusan/h/<?php echo $baris->id_kepuasan_pengguna_lulusan; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
