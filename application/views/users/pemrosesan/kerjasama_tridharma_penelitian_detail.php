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
                <legend class="text-bold"><i class="icon-folder-download2"></i> Detail Kerjasama Tridharma Penelitian</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action=""  enctype="multipart/form-data" method="post">

                  <table width="100%" border=0>
                    <tr>
                      <td><b>Lembaga Mitra :</b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->lembaga_mitra; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Tingkat :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->tingkat; ?></td>
                    </tr>

                    <tr>
                      <td><b>Judul Kegiatan Kerjasama :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->judul_kegiatan_kerjasama; ?></td>
                    </tr>

                    <tr>
                      <td><b>Manfaat Bagi PS yang Diakreditasi :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->manfaat; ?></td>
                    </tr>

                    <tr>
                      <td><b>Waktu dan Durasi :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->waktu_dan_durasi; ?></td>
                    </tr>

                    <tr>
                      <td><b>Bukti Kerjasama :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->bukti_kerjasama; ?></td>
                    </tr>

                    <tr>
                      <td><b>Tahun Berakhirnya Kerjasama :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->tahun_berakhir; ?></td>
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
                    <a href="users/kerjasama_tridharma_penelitian" class="btn btn-default"><< Kembali</a>
                    
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
