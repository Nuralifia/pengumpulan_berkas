<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<style>
.dropzone {
  margin-top: 10px;
  border: 2px dashed #0087F7;
}
</style>

<?php
$this->db->order_by('id_ewmp_dosen_tetap', 'ASC');
$this->db->limit(1);

?>

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
                <legend class="text-bold"><i class="icon-folder-download2"></i> Edit Data</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action="" method="post">
                    

                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Dosen (DT)</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama_dosen" id="nama_dosen" class="form-control" value="<?php echo $query->nama_dosen; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">DTPS</label>
                      <div class="col-lg-9">
                            <input type="text" name="dtps" id="dtps" class="form-control" value="<?php echo $query->dtps; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-12">Ekuivalen Waktu Mengajar Penuh (EWMP) pada saat TS dalam satuan kredit semester (sks)</label>
                    </div>
                    <div class="form-group col-lg-12">
                      <label class="control-label col-lg-12">Pendidikan : Pembelajaran dan Pembimbingan</label>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote> PS yang Diakreditasi</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="ekuivalen_pendidikan_akreditasi" id="ekuivalen_pendidikan_akreditasi" class="form-control" value="<?php echo $query->ekuivalen_pendidikan_akreditasi; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote> PS lain di dalam PT</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="ekuivalen_pendidikan_dalampt" id="ekuivalen_pendidikan_dalampt" class="form-control" value="<?php echo $query->ekuivalen_pendidikan_dalampt; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"> <blockquote>PS lain di luar PT</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="ekuivalen_pendidikan_luarpt" id="ekuivalen_pendidikan_luarpt" class="form-control" value="<?php echo $query->ekuivalen_pendidikan_luarpt; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-12">Ekuivalen Waktu Mengajar Penuh (EWMP) pada saat TS dalam satuan kredit semester (sks)</label>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote> Penelitian</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="penelitian" id="penelitian" class="form-control" value="<?php echo $query->penelitian; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>PkM</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="pkm" id="pkm" class="form-control" value="<?php echo $query->pkm; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Tugas Tambahan dan/atau Penunjang</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="tugas" id="tugas" class="form-control" value="<?php echo $query->tugas; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Jumlah (sks)</label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_sks" id="jumlah_sks" class="form-control" value="<?php echo $query->jumlah_sks; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Rata-Rata Per Semester (sks)</label>
                      <div class="col-lg-9">
                            <input type="text" name="rata_persemester" id="rata_persemester" class="form-control" value="<?php echo $query->rata_persemester; ?>" placeholder="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-lg-3"><b>Lampiran</b></label>
                      <div class="col-lg-12">
                          <div class="dropzone" id="myDropzone">
                            <div class="dz-message">
                             <h3> Klik atau Drop Lampiran disini</h3>
                            </div>
                          </div>
                          <i style="color:red"><h10>*Lampiran Wajib Di Isi Rekomendasi Dalam bentuk PDF Max 10 MB</h10></i>
                      </div>
                    </div>

                    <hr>
                    <a href="users/ewmp_dosen_tetap" class="btn btn-default"><< Kembali</a>
                    <button type="submit" name="btnupdate" id="submit-all" class="btn btn-primary" style="float:right;">Update</button>
                </form>

              </fieldset>


            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
<script type="text/javascript">

$('.msg').html('');

Dropzone.options.myDropzone = {

  // Prevents Dropzone from uploading dropped files immediately
  url: "<?php echo base_url('users/ewmp_dosen_tetap') ?>",
  paramName:"userfile",
  // acceptedFiles:"'file/doc','file/xls','file/xlsx','file/docx','file/pdf','file/txt',image/jpg,image/jpeg,image/png,image/bmp",
  autoProcessQueue: false,
  maxFilesize: 10, //MB
  parallelUploads: 10,
  maxFiles: 10,
  addRemoveLinks:true,
  dictCancelUploadConfirmation: "Yakin ingin membatalkan upload ini?",
  dictInvalidFileType: "Type file ini tidak dizinkan",
  dictFileTooBig: "File yang Anda Upload terlalu besar {{filesize}} MB. Maksimal Upload {{maxFilesize}} MB",
  dictRemoveFile: "Hapus",

  init: function() {
    var submitButton = document.querySelector("#submit-all")
        myDropzone = this; // closure

    submitButton.addEventListener("click", function(e) {
      // if ($("#ns").val() == '' || $("#tgl_ns").val() == '' || $("#no_asal").val() == '' || ("#tgl_no_asal").val() == '') {
      //     alert('Nomor dan No. Surat wajib diisi!');
      // }
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue(); // Tell Dropzone to process all queued files.
    });

    // You might want to show the submit button only when

    this.on("error", function(file, message) {
                alert(message);
                this.removeFile(file);
                errors = true;
    });

    // files are dropped here:
    this.on("addedfile", function(file) {
      // Show submit button here and/or inform user to click it.
      //  alert("Apakah anda yakin");
    });

    this.on("sending", function(data, xhr, formData) {
            formData.append("ns", jQuery("#ns").val());
            formData.append("nama_dosen", jQuery("#nama_dosen").val());
            formData.append("dtps", jQuery("#dtps").val());
            formData.append("ekuivalen_pendidikan_akreditasi", jQuery("#ekuivalen_pendidikan_akreditasi").val());
            formData.append("ekuivalen_pendidikan_dalampt", jQuery("#ekuivalen_pendidikan_dalampt").val());
            formData.append("ekuivalen_pendidikan_luarpt", jQuery("#ekuivalen_pendidikan_luarpt").val());
            formData.append("penelitian", jQuery("#penelitian").val());
            formData.append("pkm", jQuery("#pkm").val());
            formData.append("tugas", jQuery("#tugas").val());
            formData.append("jumlah_sks", jQuery("#jumlah_sks").val());
            formData.append("rata_persemester", jQuery("#rata_persemester").val());
    });

    this.on("complete", function(file) {
      //Event ketika Memulai mengupload
      myDropzone.removeFile(file);
    });

    this.on("success", function (file, response) {
      //Event ketika Memulai mengupload
      // console.log(response);
      //           $(response).each(function (index, element) {
      //               if (element.status) {
      //               }
      //               else {

      
      $(".cari_ns").val('').trigger('change');
                            $('.form-horizontal')[0].reset();
                            $('.msg').html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                          '     <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                          '       <span aria-hidden="true">&times;&nbsp; &nbsp;</span>'+
                                          '     </button>'+
                                          '     <strong>Sukses!</strong> Data berhasil dikirim.'+
                                          '  </div>');
                            $("#no_asal").focus();

                            alert('Sukses, Data berhasil dikirim');
                            window.location="<?php echo base_url(); ?>users/ewmp_dosen_tetap";
                //     }
                // });

      myDropzone.removeFile(file);
    });

  }
};

</script>
