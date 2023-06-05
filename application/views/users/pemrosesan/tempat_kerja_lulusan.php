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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Tempat Kerja Lulusan</h5>
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
                    <a href="users/tempat_kerja_lulusan/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Tahun Lulusan</th>
              <th rowspan="2"><center>Jumlah Lulusan</th>
              <th rowspan="2"><center>Jumlah Yang Lulusan Terlacak</th>
              <th colspan="3"><center>Jumlah Lulusan Terlacak Yang Berkerja Berdasarkan Tingkat/Ukuran Tempat Kerja/Berwirausaha</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center> Local/Wilayah/Berwirausaha Tidak Berbadan Hukum</th>
              <th><center> Nasional/Berwirausaha Berbadan Hukum </th>
              <th><center> Multinasional/Internasional</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($tempat_kerja_lulusan->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->tahun_lulusan; ?></td>
                  <td><center><?php echo $baris->jumlah_lulusan; ?></td>
                  <td><center><?php echo $baris->jumlah_lulusan_terlacak; ?></td>
                  <td><center><?php echo $baris->bekerja_lokal; ?></td>
                  <td><center><?php echo $baris->bekerja_nasional; ?></td>
                  <td><center><?php echo $baris->bekerja_multi; ?></td>
                  
                  <td>
                    <a href="users/tempat_kerja_lulusan/d/<?php echo $baris->id_tempat_kerja_lulusan; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/tempat_kerja_lulusan/e/<?php echo $baris->id_tempat_kerja_lulusan; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/tempat_kerja_lulusan/h/<?php echo $baris->id_tempat_kerja_lulusan; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
