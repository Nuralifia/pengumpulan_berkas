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
                <legend class="text-bold"><i class="icon-folder-download2"></i> Detail Tempat Kerja Lulusan</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action=""  enctype="multipart/form-data" method="post">


                  <table width="100%" border=0>
                    <tr>
                      <td><b>Tahun Lulusan :</b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->tahun_lulusan; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Jumlah Lulusan :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->jumlah_lulusan; ?></td>
                    </tr>

                    <tr>
                      <td><b>Jumlah Lulusan Yang Terlacak :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->jumlah_lulusan_terlacak; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Jumlah Lulusan Terlacak Yang Berkerja Berdasarkan Tingkat/Ukuran Tempat Kerja/Berwirausaha :</b></td>
                    </tr>
                    <tr>
                      <td class=" col-lg-12"><b>Local/Wilayah/Berwirausaha Tidak Berbadan Hukum </b></td>
                    </tr>
                    <tr>
                      <td class=" col-lg-12"> <?php echo $query->bekerja_lokal; ?></td>
                    </tr>

                    <tr>
                      <td class=" col-lg-12"><b>Nasional/Berwirausaha Berbadan Hukum </b></td>
                    </tr>
                    <tr>
                      <td class=" col-lg-12"> <?php echo $query->bekerja_nasional; ?></td>
                    </tr>

                    <tr>
                      <td class=" col-lg-12"><b>Multinasional/Internasional </b></td>
                    </tr>
                    <tr>
                      <td class=" col-lg-12"> <?php echo $query->bekerja_multi; ?></td>
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
                    <a href="users/tempat_kerja_lulusan" class="btn btn-default"><< Kembali</a>
                    
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
