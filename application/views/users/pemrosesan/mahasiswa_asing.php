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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Mahasiswa Asing</h5>
          <h10 style="color:red">Diisi oleh pengusul dari Program Studi pada program Sarjana/Sarjana Terapan/Magister/Magister Terapan/Doktor/Doktor Terapan.</h10>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/mahasiswa_asing/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th rowspan="2" width="30px;">No.</th>
              <th rowspan="3"><center>Program Studi</th>
              <th colspan="3"><center>Jumlah Mahasiswa Aktif</center></th>
              <th colspan="3"><center>Jumlah Mahasiswa Asing Penuh Waktu (Full-time)</th>
              <th colspan="3"><center>Jumlah Mahasiswa Asing Paruh Waktu (Part-time)</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th><center> TS-2</th>
              <th><center> TS-1</th>
              <th><center> TS</th>
              <th><center> TS-2</th>
              <th><center> TS-1</th>
              <th><center> TS</th>
              <th><center> TS-2</th>
              <th><center> TS-1</th>
              <th><center> TS</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($mahasiswa_asing->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->program_studi; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_aktif_ts2; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_aktif_ts1; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_aktif_ts; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_fulltime_ts2; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_fulltime_ts1; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_fulltime_ts; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_parttime_ts2; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_parttime_ts1; ?></td>
                  <td><center><?php echo $baris->jumlah_mhs_parttime_ts; ?></td>
                  
                  <td>
                    <a href="users/mahasiswa_asing/d/<?php echo $baris->id_mahasiswa_asing; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/mahasiswa_asing/e/<?php echo $baris->id_mahasiswa_asing; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/mahasiswa_asing/h/<?php echo $baris->id_mahasiswa_asing; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
