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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Masa Studi Lulusan Pada Program Magister/Magister Terapan</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Magister/Magister Terapan.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/masa_studi_m/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
            
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Tahun Masuk</th>
              <th rowspan="2"><center>Jumlah Mahasiswa Diterima</th>
              <th colspan="4"><center>Jumlah Mahasiswa yang Lulus Pada</th>
              <th rowspan="2"><center>jumlah Lulusan s.d. Akhir TS</th>
              <th rowspan="2"><center>Rata-Rata Masa Studi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>Akhir TS-3</th>
              <th><center>Akhir TS-2</th>
              <th><center>Akhir TS-1</th>
              <th><center>Akhir TS</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($masa_studi_m->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->tahun_masuk; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_diterima; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_lulus_ts3; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_lulus_ts2; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_lulus_ts1; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_lulus_ts; ?></td>
                  <td><center><?php echo $baris->jumlah_lulusan; ?></td>
                  <td><center><?php echo $baris->rata_studi; ?></td>
                  
                  <td>
                    <a href="users/masa_studi_m/d/<?php echo $baris->id_masa_studi_m; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/masa_studi_m/e/<?php echo $baris->id_masa_studi_m; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/masa_studi_m/h/<?php echo $baris->id_masa_studi_m; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
