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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Kapuasan Mahasiswa </h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/kepuasan_mhs/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="2"><center>Aspek Yang Diukur</th>
              <th colspan="4"><center>Tingkat Kepuasan Mahasiswa (%)</th>
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
              foreach ($kepuasan_mhs->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->aspek; ?></td>
                  <td><center><?php echo $baris->tingkat_sangat; ?></td>
                  <td><center><?php echo $baris->tingkat_baik; ?></td>
                  <td><center><?php echo $baris->tingkat_cukup; ?></td>
                  <td><center><?php echo $baris->tingkat_kurang; ?></td>
                  <td><center><?php echo $baris->rencana; ?></td>
                  
                  <td>
                    <a href="users/kepuasan_mhs/d/<?php echo $baris->id_kepuasan_mhs; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/kepuasan_mhs/e/<?php echo $baris->id_kepuasan_mhs; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/kepuasan_mhs/h/<?php echo $baris->id_kepuasan_mhs; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
