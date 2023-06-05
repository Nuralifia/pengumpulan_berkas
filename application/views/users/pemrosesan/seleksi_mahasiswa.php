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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Seleksi Mahasiswa Baru</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/seleksi_mahasiswa/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>
        <table class="table datatable-basic" width="100%">
          <thead>           
            <tr>
              <th width="30px;" rowspan="2">No.</th>
              <th rowspan="2"><center>Tahun Akademik</th>
              <th rowspan="2"><center>Daya Tampung</th>
              <th colspan="2"><center>Jumlah Calon</center></th>
              <th colspan="2"><center>Jumlah Mahasiswa Baru</center></th>
              <th colspan="2"><center>Jumlah Mahasiswa Aktif</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>Pendaftar</th>
              <th><center>Lulus Seleksi</th>
              <th><center>Reguler</th>
              <th><center>Transfer</th>
              <th><center>Reguler</th>
              <th><center>Transfer</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($seleksi_mahasiswa->result() as $baris) {
              ?>
              <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->tahun_akademik; ?></center></td>
                  <td><center><?php echo $baris->daya_tampung; ?></td>
                  <td><center><?php echo $baris->jumlah_calon_pendaftar; ?></td>
                  <td><center><?php echo $baris->jumlah_calon_lulus; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_baru_reg; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_baru_tra; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_aktif_reg; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_aktif_tra; ?></td> 
                  
                  <td>
                    <a href="users/seleksi_mahasiswa/d/<?php echo $baris->id_seleksi_mahasiswa; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/seleksi_mahasiswa/e/<?php echo $baris->id_seleksi_mahasiswa; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/seleksi_mahasiswa/h/<?php echo $baris->id_seleksi_mahasiswa; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
