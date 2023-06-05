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
          <h5 class="panel-title"><i class="icon-folder-download2"></i><b> AKREDITASI PROGRAM STUDI BADAN AKREDITASI NASIONAL PERGURUAN - TINGGI</b></h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 'admin' or $user->row()->level == 's_admin') { ?>
                    <br>
                    <a href="users/program/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Data</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th>Nama Program Studi</th>
              <th>Jenis Program</th>
              <th>Peringkat Akreditasi PS</th>
              <th>Nomor SK BAN-PT</th>
              <th>Tanggal Kadaluarsa</th>
              <th>Nama Unit Pengelola</th>
              <th>Nama Perguruan Tinggi</th>
              <th>Alamat</th>
              <th>Nomor Telepon</th>
              <th>E-mail</th>
              <th>Website</th>
              <th>TS *)</th>
              <th>Nama Pengusul</th>
              <th>Tanggal</th>
              
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($program->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><?php echo $baris->nama_program; ?></td>
                  <td><?php echo $baris->jenis_program; ?></td>
                  <td><?php echo $baris->peringkat; ?></td>
                  <td><?php echo $baris->no_sk; ?></td>
                  <td><?php echo $baris->tgl_kadaluarsa; ?></td>
                  <td><?php echo $baris->nama_unit; ?></td>
                  <td><?php echo $baris->nama_perguruan; ?></td>
                  <td><?php echo $baris->alamat; ?></td>
                  <td><?php echo $baris->no_tlp; ?></td>
                  <td><?php echo $baris->email; ?></td>
                  <td><?php echo $baris->website; ?></td>
                  <td><?php echo $baris->ts; ?></td>
                  <td><?php echo $baris->nama_pengusul; ?></td>
                  <td><?php echo $baris->tanggal; ?></td>
                  
                  <td>
                    <a href="users/program/d/<?php echo $baris->id_program; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan') { ?>
                    <a href="users/program/e/<?php echo $baris->id_program; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/program/h/<?php echo $baris->id_program; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
