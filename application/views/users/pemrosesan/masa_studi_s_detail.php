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
                <legend class="text-bold"><i class="icon-folder-download2"></i> Detail Masa Studi Lulusan Pada Program Sarjana/Sarjana Terapan</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action=""  enctype="multipart/form-data" method="post">


                  <table width="100%" border=0>
                    <tr>
                      <td><b>Tahun Masuk :</b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->tahun_masuk; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Jumlah Mahasiswa Diterima :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->jumlah_mhs_diterima; ?></td>
                    </tr>

                    <tr>
                      <td><b>Jumlah Mahasiswa Lulus Pada :</b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"><b>Akhir TS-6 </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts6; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Akhir TS-5 </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts5; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Akhir TS-4 </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts4; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Akhir TS-3 </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts3; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Akhir TS-2 </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts2; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Akhir TS-1 </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts1; ?></td>
                    </tr>

                    <tr>
                      <td class="col-lg-12"><b>Akhir TS </b></td>
                    </tr>
                    <tr>
                      <td class="col-lg-12"> <?php echo $query->jumlah_mhs_lulus_ts; ?></td>
                    </tr>

                    <tr>
                      <td><b>Jumlah Lulusan s.d. Akhir TS </b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->jumlah_lulusan; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Rata-Rata Masa Studi :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->rata_studi; ?></td>
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
                    <a href="users/masa_studi_s" class="btn btn-default"><< Kembali</a>
                    
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
