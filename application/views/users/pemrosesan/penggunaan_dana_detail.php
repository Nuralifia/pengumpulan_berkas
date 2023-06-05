<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>


<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-flat">

            <div class="panel-body">

              <fieldset class="content-group">
                <legend class="text-bold"><i class="icon-folder-download2"></i> Detail Penggunaan Dana</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action=""  enctype="multipart/form-data" method="post">


                  <table width="100%" border=0>
                    <tr>
                      <td><b>Jenis Penggunaan :</b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->jenis_pengguna; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Unit Pengelola Program Studi (Rupiah) :</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"><b>TS-2</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->unit_pengelola_ts2; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>TS-1</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->unit_pengelola_ts1; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>TS </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->unit_pengelola_ts; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Rata-rata :</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->unit_pengelola_rata; ?></td>
                    </tr>

                    <tr>
                      <td><b>Program Studi (Rupiah) :</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"><b>TS-2</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->program_studi_ts2; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>TS-1</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->program_studi_ts1; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>TS</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->program_studi_ts; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Rata-rata</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->program_studi_rata; ?></td>
                    </tr>
                  </table>
                    
                        
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Lampiran</b></label>
                      <div class="col-lg-12">
                        <table class="table table-bordered" width="100%">
                          <tr style="background:#222;color:#f1f1f1;">
                            <th width='10%'><b>NO.</b></th>
                            <th><b>Berkas</b></th>
                            <th width='10%'><b>Aksi</b></th>
                          </tr>
                          <?php
                          $lampiran = $this->db->get_where('tbl_lampiran', "token_lampiran='$query->token_lampiran'");
                          $no = 1;
                          foreach ($lampiran->result() as $baris) {?>
                            <tr>
                              <td><?php echo $no; ?></td>
                              <td><a href="lampiran/<?php echo $baris->nama_berkas; ?>" target="_blank" title="<?php echo substr($baris->ukuran / 1024, 0, 5); ?> MB"><?php echo $baris->nama_berkas; ?></a></td>
                              <td><a href="lampiran/<?php echo $baris->nama_berkas; ?>" target="_blank" title="<?php echo substr($baris->ukuran / 1024, 0, 5); ?> MB" class="btn btn-default xs"><i class="icon-download"></i></a></td>
                            </tr>
                          <?php
                            $no++;
                          }?>
                        </table>
    									</div>
                    </div>

                    <hr>
                    <a href="users/penggunaan_dana" class="btn btn-default"><< Kembali</a>
                    
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
