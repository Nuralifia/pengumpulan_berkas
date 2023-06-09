<?php
$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
$bulan = $array_bulan[date('n')];?>

<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-flat">

            <div class="panel-body">

              <fieldset class="content-group">
                <legend class="text-bold"><i class="icon-cube"></i> Edit Berkas Surat</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <form class="form-horizontal" action="" method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Separator</b></label>
                      <div class="col-lg-2">
                        <input type="text" name="separator" class="form-control" value="<?php echo $query->separator; ?>" style="text-align:center;" autofocus>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Nomor</b></label>
                      <div class="col-lg-2">
                        <select class="form-control" name="no_posisi">
                          <option value=""></option>
                          <?php
                          for ($i=1; $i <=6; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $query->no_posisi){echo "selected";} ?>><?php echo $i; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                      <div class="col-lg-7">
                        <input type="text" name="no" class="form-control" value="<?php echo $query->no; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Organisasi</b></label>
                      <div class="col-lg-2">
                        <select class="form-control" name="org_posisi">
                          <option value=""></option>
                          <?php
                          for ($i=1; $i <=6; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $query->org_posisi){echo "selected";} ?>><?php echo $i; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                      <div class="col-lg-7">
                        <input type="text" name="org" class="form-control" value="<?php echo $query->org; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Bagian</b></label>
                      <div class="col-lg-2">
                        <select class="form-control" name="bag_posisi">
                          <option value=""></option>
                          <?php
                          for ($i=1; $i <=6; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $query->bag_posisi){echo "selected";} ?>><?php echo $i; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                      <div class="col-lg-7">
                        <select class="form-control" name="bag">
                          <option value="">- Pilih Bagian -</option>
                          <?php
                          foreach ($bagian as $baris) {?>
                            <option value="<?php echo $baris->nama_bagian; ?>" <?php if($baris->nama_bagian == $query->bag){echo "selected";} ?>><?php echo $baris->nama_bagian; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Sub Bagian</b></label>
                      <div class="col-lg-2">
                        <select class="form-control" name="subbag_posisi">
                          <option value=""></option>
                          <?php
                          for ($i=1; $i <=6; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $query->subbag_posisi){echo "selected";} ?>><?php echo $i; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                      <div class="col-lg-7">
                        <input type="text" name="subbag" class="form-control" value="<?php echo $query->subbag; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Bulan</b></label>
                      <div class="col-lg-2">
                        <select class="form-control" name="bln_posisi">
                          <option value=""></option>
                          <?php
                          for ($i=1; $i <=6; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $query->bln_posisi){echo "selected";} ?>><?php echo $i; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                      <div class="col-lg-7">
                        <input type="text" name="bln" class="form-control" value="<?php echo $query->bln; ?>" id="bln">
                        <label><input type="checkbox" name="type_bulan" value="huruf" onclick="bln_system()" id="check_bln" <?php if($bulan == $query->bln){echo "checked";} ?>> Gunakan bulan system</label>
                      </div>
                    </div>
                  </div>

                  <script type="text/javascript">
                  function bln_system() {
                      if ($('#check_bln').is(':checked')) {
                        $('#bln').val('<?php echo $bulan ?>');
                      } else {
                        $('#bln').val('');
                      }
                  }

                  function thn_system() {
                      if ($('#check_thn').is(':checked')) {
                        $('#thn').val('<?php echo date('Y'); ?>');
                      } else {
                        $('#thn').val('');
                      }
                  }
                  </script>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Tahun</b></label>
                      <div class="col-lg-2">
                        <select class="form-control" name="thn_posisi">
                          <option value=""></option>
                          <?php
                          for ($i=1; $i <=6; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $query->thn_posisi){echo "selected";} ?>><?php echo $i; ?></option>
                          <?php
                          } ?>
                        </select>
                      </div>
                      <div class="col-lg-7">
                        <input type="number" name="thn" class="form-control" value="<?php echo $query->thn; ?>" id="thn">
                        <label><input type="checkbox" name="type_thn" value="huruf" onclick="thn_system()" id="check_thn" <?php if(date('Y') == $query->thn){echo "checked";} ?>> Gunakan tahun system</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Reset Nomor</b></label>
                      <div class="col-lg-9">
                        <label>
    											<input type="radio" name="reset_no" class="styled" value="bln" <?php if($query->reset_no == "bln"){echo "checked";} ?>> Bulan
    										</label>
                        <br>
    										<label>
    											<input type="radio" name="reset_no" class="styled" value="thn" <?php if($query->reset_no == "thn"){echo "checked";} ?>> Tahun
    										</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Prefix</b></label>
                      <div class="col-lg-9">
                        <input type="text" name="prefix" class="form-control" value="<?php echo $query->prefix; ?>">
                        <div class="col-lg-6">
                          <label>
      											<input type="radio" name="prefix_posisi" class="styled" value="kiri" <?php if($query->reset_no == "kiri"){echo "checked";} ?>> Kiri
      										</label>
                        </div>
                        <div class="col-lg-6">
                          <label>
      											<input type="radio" name="prefix_posisi" class="styled" value="kanan" <?php if($query->reset_no == "kanan"){echo "checked";} ?>> Kanan
      										</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Jenis Nomor</b></label>
                      <div class="col-lg-4">
                        <select class="form-control" name="jenis_ns">
                          <option value="semua" <?php if($query->jenis_ns == "semua"){echo "selected";} ?>>Semua Modul</option>
                          <option value="sm" <?php if($query->jenis_ns == "sm"){echo "selected";} ?>>Surat Masuk</option>
                          <option value="sk" <?php if($query->jenis_ns == "sk"){echo "selected";} ?>>Surat Keluar</option>
                          <option value="disposisi" <?php if($query->jenis_ns == "disposisi"){echo "selected";} ?>>Disposisi</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Keterangan</b></label>
                      <div class="col-lg-9">
                        <textarea name="ket" rows="2" cols="80" class="form-control"><?php echo $query->ket; ?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <hr>
                    <a href="users/ns" class="btn btn-default"><< Kembali</a>
                    <button type="submit" name="btnupdate" class="btn btn-primary" style="float:right;">Update</button>
                  </div>
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
