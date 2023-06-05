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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Kerjasama Tridharma Pengabdian Kepada Masyarakat</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/kerjasama_tridharma_pengabdian/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Lembaga Mitra</th>
              <th><center>Tingkat</th>
              <th><center>Judul Kegiatan Kerjasama</th>
              <th><center>Manfaat Bagi PS yang Diakreditasi</th>
              <th><center>Waktu dan Durasi</th>
              <th><center>Bukti Kerjasama</th>
              <th><center>Tahun Berakhirnya Kerjasama</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($kerjasama_tridharma_pengabdian->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->lembaga_mitra; ?></td>
                  <td><center><?php echo $baris->tingkat; ?></td>
                  <td><center><?php echo $baris->judul_kegiatan_kerjasama; ?></td>
                  <td><center><?php echo $baris->manfaat; ?></td>
                  <td><center><?php echo $baris->waktu_dan_durasi; ?></td>
                  <td><center><?php echo $baris->bukti_kerjasama; ?></td>
                  <td><center><?php echo $baris->tahun_berakhir; ?></td>
                  
                  <td>
                    <a href="users/kerjasama_tridharma_pengabdian/d/<?php echo $baris->id_kerjasama_tridharma_pengabdian; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/kerjasama_tridharma_pengabdian/e/<?php echo $baris->id_kerjasama_tridharma_pengabdian; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/kerjasama_tridharma_pengabdian/h/<?php echo $baris->id_kerjasama_tridharma_pengabdian; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
