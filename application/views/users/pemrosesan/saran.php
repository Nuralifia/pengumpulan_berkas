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
          <h5 class="panel-title"><i class="icon-folder-download2"></i> Saran</h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

                <?php
                if ($user->row()->level == 's_admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan' or $user->row()->level == 'asesorinternal') { ?>
                    <br>
                    <a href="users/saran/t" class="btn btn-primary">+ <i class="icon-folder-download2"></i> Tambah Saran</a>
                <?php
                } ?>
        </div>

        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th width="30px;">No.</th>
              <th><center>Tanggal</th>
              <th><center>Nama Pengirim</th>
              <th><center>Perihal</th>
              <th class="text-center" width="170"></th>
            </tr>
          </thead>
          <tbody>
              <?php
              $no = 1;
              foreach ($saran->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no.'.'; ?></td>
                  <td><center><?php echo $baris->tanggal; ?></td>
                  <td><center><?php echo $baris->pengirim; ?></td>
                  <td><center><?php echo $baris->perihal; ?></td>
                  
                  <td>
                    <a href="users/saran/d/<?php echo $baris->id_saran; ?>" class="btn btn-default btn-xs"><i class="icon-eye"></i></a>
                    
                    <?php
                    if ($user->row()->level == 's_admin' or $user->row()->level == 'timpjm' or $user->row()->level == 'pimpinan' or $user->row()->level == 'asesorinternal') { ?>
                    <a href="users/saran/e/<?php echo $baris->id_saran; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>

                    <a href="users/saran/h/<?php echo $baris->id_saran; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda Yakin Ingin Menghapusnya ?')"><i class="icon-trash"></i></a>
					 
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
