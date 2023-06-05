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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Publikasi Ilmiah Mahasiswa</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Sarjana/Magister/Doktor.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/publikasi_ilmiah_mhs/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Jenis Publikasi</th>
              <th colspan="3"><center>Jumlah Judul</th>
              <th rowspan="2"><center>Jumlah</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>TS-2</th>
              <th><center>TS-1</th>
              <th><center>TS</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($publikasi_ilmiah_mhs->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->jenis_publikasi; ?></td>
                  <td><center><?php echo $baris->jumlah_judul_ts2; ?></td>
                  <td><center><?php echo $baris->jumlah_judul_ts1; ?></td>
                  <td><center><?php echo $baris->jumlah_judul_ts; ?></td>
                  <td><center><?php echo $baris->jumlah; ?></td>
                  
                  <td>
                    <a href="users/publikasi_ilmiah_mhs/d/<?php echo $baris->id_publikasi_ilmiah_mhs; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/publikasi_ilmiah_mhs/e/<?php echo $baris->id_publikasi_ilmiah_mhs; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/publikasi_ilmiah_mhs/h/<?php echo $baris->id_publikasi_ilmiah_mhs; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
