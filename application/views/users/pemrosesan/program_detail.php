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
                <legend class="text-bold"><i class="icon-folder-download2"></i> DETAIL AKREDITASI PROGRAM STUDI BADAN AKREDITASI NASIONAL PERGURUAN - TINGGI</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action=""  enctype="multipart/form-data" method="post">


                  <table width="100%" border=0>
                    <tr>
                      <td><b>Nama Program Studi :</b></td>
                    </tr>
                      <tr>
                      <td> <?php echo $query->nama_program; ?></td>
                    </tr>
                       
                    <tr>
                      <td><b>Jenis Program :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->jenis_program; ?></td>
                    </tr>

                    <tr>
                      <td><b>Peringkat Akreditasi PS :</b></td>
                    </tr>
                    <tr>
                      <td> <?php echo $query->peringkat; ?></td>
                    </tr>

                    <tr>
                      <td><b>Nomor SK BAN-PT :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->no_sk; ?></td>
                    </tr>

                    <tr>
                      <td><b>Tanggal Kadaluarsa :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->tgl_kadaluarsa; ?></td>
                    </tr>

                    <tr>
                      <td><b>Nama Unit Pengelola :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->nama_unit; ?></td>
                    </tr>

                    <tr>
                      <td><b>Nama Perguruan Tinggi :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->nama_perguruan; ?></td>
                    </tr>

                    <tr>
                      <td><b>Alamat :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->alamat; ?></td>
                    </tr>
                    <tr>
                      <td><b>Nomor Telepon :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->no_tlp; ?></td>
                    </tr>

                    <tr>
                      <td><b>E-mail :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->email; ?></td>
                    </tr>

                    <tr>
                      <td><b>Website :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->website; ?></td>
                    </tr>

                    <tr>
                      <td><b>TS *) :</b></td>
                      </tr>
                      <tr>
                      <td> <?php echo $query->ts; ?></td>
                    </tr>

                    <tr>
                      <td><b>Nama Pengusul :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->nama_pengusul; ?></td>
                    </tr>

                    <tr>
                      <td><b>Tanggal :</b></td>
                     </tr>
                     <tr>
                      <td> <?php echo $query->tanggal; ?></td>
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
                    <a href="users/program" class="btn btn-default"><< Kembali</a>
                    
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
