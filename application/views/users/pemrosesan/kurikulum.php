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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Kurikulum, Capaian Pembelajaran, Dan Rencana Pembelajaran</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/kurikulum/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.MK</th>
              <th rowspan="2"><center>Semester</th>
              <th rowspan="2"><center>Kode Mata Kuliah</th>
              <th rowspan="2"><center>Nama Mata Kuliah</th>
              <th rowspan="2"><center>Mata Kuliah Kom-petensi</th>
              <th colspan="3"><center>Bobot Kredit (sks)</th>
              <th rowspan="2"><center>Konversi Kredit ke jam</th>
              <th colspan="4"><center>Capaian Pembelajaran</th>
              <th rowspan="2"><center>Dokumen Rencana Pembela-jaran</th>
              <th rowspan="2"><center>Unit Penyeleng-gara</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>Kuliah/Responsi/Tutorial</th>
              <th><center>Seminar</th>
              <th><center>Praktikum/ Praktik/Praktik Lapangan</th>
              <th><center>Sikap</th>
              <th><center> Pengetahuan</th>
              <th><center> Keteretampilan Umum</th>
              <th><center> Keteretampilan Khusus</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($kurikulum->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->semester; ?></td>
                  <td><center><?php echo $baris->kode_matkul; ?></td>
                  <td><center><?php echo $baris->nama_matkul; ?></td>
                  <td><center><?php echo $baris->matkul_kom; ?></td>
                  <td><center><?php echo $baris->bobot_kuliah; ?></td>
                  <td><center><?php echo $baris->bobot_seminar; ?></td>
                  <td><center><?php echo $baris->bobot_praktikum; ?></td>
                  <td><center><?php echo $baris->konversi; ?></td>
                  <td><center><?php echo $baris->capaian_sikap; ?></td>
                  <td><center><?php echo $baris->capaian_pengetahuan; ?></td>
                  <td><center><?php echo $baris->capaian_umum; ?></td>
                  <td><center><?php echo $baris->capaian_khusus; ?></td>
                  <td><center><?php echo $baris->dokumen; ?></td>
                  <td><center><?php echo $baris->unit; ?></td>
                  
                  <td>
                    <a href="users/kurikulum/d/<?php echo $baris->id_kurikulum; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/kurikulum/e/<?php echo $baris->id_kurikulum; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/kurikulum/h/<?php echo $baris->id_kurikulum; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
