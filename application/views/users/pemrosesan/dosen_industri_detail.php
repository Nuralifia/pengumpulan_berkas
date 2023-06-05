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
                <legend class="text-bold"><i class="icon-folder-download2"></i> Detail dosen industri/Praktisi</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action=""  enctype="multipart/form-data" method="post">


                  <table width="100%" border=0>
                    <tr>
                      <td><b>Nama Dosen Industri :</b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->nama_dosen; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>NIDK :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->nidk; ?></td>
                    </tr>

                    <tr>
                      <td><b>Perusahaan/Industri :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->perusahaan; ?></td>
                    </tr>

                    <tr>
                      <td><b>Pendidikan Tertinggi :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->pendidikan_tertinggi; ?></td>
                    </tr>

                    <tr>
                      <td><b>Bidang Keahlian :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->bidang_keahlian; ?></td>
                    </tr>

                    <tr>
                      <td><b>Sertifikat Profesi/Kompetensi/Industri :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->sertifikat; ?></td>
                    </tr>

                    <tr>
                      <td><b>Mata Kuliah yang Diampu :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->mata_kuliah; ?></td>
                    </tr>

                    <tr>
                      <td><b>Bobot Kredit (sks) :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->bobot_kredit; ?></td>
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
                    <a href="users/dosen_industri" class="btn btn-default"><< Kembali</a>
                    
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
