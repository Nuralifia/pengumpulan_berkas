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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Integrasi Kegiatan Penelitian/PkM dalam Pembelajaran</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/integrasi_penelitian_pembelajaran/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Judul Penelitian/PkM</th>
              <th><center>Nama Dosen</th>
              <th><center>Mata Kuliah</th>
              <th><center>Bentuk Integrasi</th>
              <th><center>Tahun</th>
              <th><center>Berelasi dgn Sup-Menu 7</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($integrasi_penelitian_pembelajaran->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->judul; ?></td>
                  <td><center><?php echo $baris->nama_dosen; ?></td>
                  <td><center><?php echo $baris->matkul; ?></td>
                  <td><center><?php echo $baris->bentuk; ?></td>
                  <td><center><?php echo $baris->tahun; ?></td>
                  <td><center><?php
                        if ($baris->relasi == 1) {?>
                            <button type="button" class="btn btn-success"><i class="icon-checkmark4"></i></button>
                      <?php
                        }?>
                  </td>
                  
                  <td>
                    <a href="users/integrasi_penelitian_pembelajaran/d/<?php echo $baris->id_integrasi_penelitian_pembelajaran; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/integrasi_penelitian_pembelajaran/e/<?php echo $baris->id_integrasi_penelitian_pembelajaran; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/integrasi_penelitian_pembelajaran/h/<?php echo $baris->id_integrasi_penelitian_pembelajaran; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
