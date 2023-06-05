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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Ekuivalen Waktu Mengajar Penuh (EWMP) Dosen Tetap Perguruan Tinggi </h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/ewmp_dosen_tetap/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="3" width="30px;">No.</th>
              <th rowspan="3"><center>Nama Dosen (DT)</th>
              <th rowspan="3"><center>DTPS</th>
              <th colspan="6"><center>Ekuivalen Waktu Mengajar Penuh (EWMP) pada saat TS dalam satuan kredit semester (sks)</center></th>
              <th rowspan="3"><center>Jumlah (sks)</th>
              <th rowspan="3"><center>Rata-Rata Per Semester (sks)</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th colspan="3"><center>Pendidikan : Pembelajaran dan Pembimbingan PS yang Diakreditasi</center></th>
              <th rowspan="2"><center>Penelitian</th>
              <th rowspan="2"><center>PkM</th>
              <th rowspan="2"><center>Tugas Tambahan dan/atau Penunjang</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>PS yang Diakreditasi</th>
              <th><center>PS lain di dalam PT</th>
              <th><center>PS lain di luar PT</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($ewmp_dosen_tetap->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->dtps; ?></td>
                  <td><center><?php echo $baris->ekuivalen_pendidikan_akreditasi; ?></td>
                  <td><center><?php echo $baris->ekuivalen_pendidikan_dalampt; ?></td>
                  <td><center><?php echo $baris->ekuivalen_pendidikan_luarpt; ?></td>
                  <td><center><?php echo $baris->penelitian; ?></td>
                  <td><center><?php echo $baris->pkm; ?></td>
                  <td><center><?php echo $baris->tugas; ?></td>
                  <td><center><?php echo $baris->jumlah_sks; ?></td>
                  <td><center><?php echo $baris->rata_persemester; ?></td>
                  
                  <td>
                    <a href="users/ewmp_dosen_tetap/d/<?php echo $baris->id_ewmp_dosen_tetap; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/ewmp_dosen_tetap/e/<?php echo $baris->id_ewmp_dosen_tetap; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/ewmp_dosen_tetap/h/<?php echo $baris->id_ewmp_dosen_tetap; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
