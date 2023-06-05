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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Luaran Penelitian/PkM Lainnya oleh DTPS Bagian-2 HKI (Hak Cipta, Desain Produk Industri, dll.)</h5>
          <h6 style="color:black">II HKI : a) Hak Cipta, b) Desain Produk Industri, c) Perlindungan Varientas Tanaman (Sertifikat Perlindungan Varientas Tanaman, Sertifikat Pelepasan Varientas, Sertifikat Pendaftaran Varientas), d) Desain Tata Letak Terpadu, e) dll.)</h6>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/luaran_pkm_lainnya_dtps/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Luaran Penelitian dan PkM</th>
              <th><center>Tahun</th>
              <th><center>Keterangan</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($luaran_pkm_lainnya_dtps->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->luaran_penelitian; ?></td>
                  <td><center><?php echo $baris->tahun; ?></td>
                  <td><center><?php echo $baris->keterangan; ?></td>
                  
                  <td>
                    <a href="users/luaran_pkm_lainnya_dtps/d/<?php echo $baris->id_luaran_pkm_lainnya_dtps; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/luaran_pkm_lainnya_dtps/e/<?php echo $baris->id_luaran_pkm_lainnya_dtps; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/luaran_pkm_lainnya_dtps/h/<?php echo $baris->id_luaran_pkm_lainnya_dtps; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
