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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Penggunaan Dana</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/penggunaan_dana/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Jenis Penggunaan</center></th>
              <th colspan="4"><center>Unit Pengelola Program Studi (Rupiah)</center></th>
              <th colspan="4"><center>Program Studi (Rupiah)</center></th>          
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center>TS-2</center></th>
              <th><center>TS-1</center></th>
              <th><center>TS</center></th>
              <th><center>Rata-rata</center></th>
              <th><center>TS-2</center></th>
              <th><center>TS-1</center></th>
              <th><center>TS</center></th>
              <th><center>Rata-rata</th>
              <th class="text-center" width="170"></th>
            </tr>

          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($penggunaan_dana->result() as $baris) {
              ?>
                <tr>
                  <td><center><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->jenis_pengguna; ?></center></td>
                  <td><center><?php echo $baris->unit_pengelola_ts2; ?></center></td>
                  <td><center><?php echo $baris->unit_pengelola_ts1; ?></center></td>
                  <td><center><?php echo $baris->unit_pengelola_ts; ?></center></td>
                  <td><center><?php echo $baris->unit_pengelola_rata; ?></center></td>
                  <td><center><?php echo $baris->program_studi_ts2; ?></center></td>
                  <td><center><?php echo $baris->program_studi_ts1; ?></center></td>
                  <td><center><?php echo $baris->program_studi_ts; ?></center></td>
                  <td><center><?php echo $baris->program_studi_rata; ?></center></td>
                  
                  <td>
                    <a href="users/penggunaan_dana/d/<?php echo $baris->id_penggunaan_dana; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/penggunaan_dana/e/<?php echo $baris->id_penggunaan_dana; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/penggunaan_dana/h/<?php echo $baris->id_penggunaan_dana; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
