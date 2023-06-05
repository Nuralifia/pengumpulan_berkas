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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Dosen Pembimbing Utama Tugas Akhir </h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/dosen_pembimbing_utama_pa/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="3" width="30px;">No.</th>
              <th rowspan="3"><center>Nama Dosen</th>
              <th colspan="8"><center>Jumlah Mahasiswa yang Dibimbing </center></th>
              <th rowspan="3"><center>Rata-Rata Jumlah Bimbingan di Semua Program/Semester</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
            <th colspan="4"><center>Pada PS yang Diakreditasi</center></th>
            <th colspan="4"><center>Pada PS Lain di PT</center></th>  
            <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center> TS-2</th>
              <th><center> TS-1</th>
              <th><center> TS</th>
              <th><center> Rata-rata</th>
              <th><center> TS-2</th>
              <th><center> TS-1</th>
              <th><center> TS</th>
              <th><center> Rata-rata</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($dosen_pembimbing_utama_pa->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->dibimbing_diakreditasi_ts2; ?></td>
                  <td><center><?php echo $baris->dibimbing_diakreditasi_ts1; ?></td>
                  <td><center><?php echo $baris->dibimbing_diakreditasi_ts; ?></td>
                  <td><center><?php echo $baris->dibimbing_diakreditasi_rata; ?></td>
                  <td><center><?php echo $baris->dibimbing_pt_ts2; ?></td>
                  <td><center><?php echo $baris->dibimbing_pt_ts1; ?></td>
                  <td><center><?php echo $baris->dibimbing_pt_ts; ?></td>
                  <td><center><?php echo $baris->dibimbing_pt_rata; ?></td>
                  <td><center><?php echo $baris->ratarata_jumlah_bimbingan; ?></center></td>
                  
                  <td>
                    <a href="users/dosen_pembimbing_utama_pa/d/<?php echo $baris->id_dosen_pembimbing_utama_pa; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/dosen_pembimbing_utama_pa/e/<?php echo $baris->id_dosen_pembimbing_utama_pa; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/dosen_pembimbing_utama_pa/h/<?php echo $baris->id_dosen_pembimbing_utama_pa; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
