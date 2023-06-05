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
          <h5 class="panel-title"><i class="icon-folder-download2"></i><b> Daftar Program studi di Unit Pengelola Program Studi (UPPS)</b></h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/upps/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Jenis Program</th>
              <th rowspan="2"><center>Nama Program Studi</th>
              <th colspan="3"><center>Akreditasi Program Studi</center></th>
              <th rowspan="2"><center>Jumlah Mahasiswa Saat TS</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>Status/Peringkat</th>
              <th><center>No. dan Tgl.SK</th>
              <th><center>Tgl. Kadaluarsa</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($upps->result() as $baris) {
              ?>
                <tr>
                  <td><center><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->jenis; ?></td>
                  <td><center><?php echo $baris->nama; ?></td>
                  <td><center><?php echo $baris->status; ?></td>
                  <td><center><?php echo $baris->no; ?></td>
                  <td><center><?php echo $baris->tanggal; ?></td>
                  <td><center><?php echo $baris->jumlah; ?></td>
                  
                  <td>
                    <a href="users/upps/d/<?php echo $baris->id_upps; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/upps/e/<?php echo $baris->id_upps; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/upps/h/<?php echo $baris->id_upps; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
