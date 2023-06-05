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
$this->db->order_by('id_kurikulum', 'ASC');
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
                      <label class="control-label col-lg-3">Semester</label>
                      <div class="col-lg-9">
                            <input type="text" name="semester" id="semester" class="form-control" value="<?php echo $query->semester; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Kode Mata Kuliah</label>
                      <div class="col-lg-9">
                            <input type="text" name="kode_matkul" id="kode_matkul" class="form-control" value="<?php echo $query->kode_matkul; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Mata Kuliah</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama_matkul" id="nama_matkul" class="form-control" value="<?php echo $query->nama_matkul; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Mata Kuliah Kom-petensi</label>
                      <div class="col-lg-9">
                            <input type="text" name="matkul_kom" id="matkul_kom" class="form-control" value="<?php echo $query->matkul_kom; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Bobot Kredit (sks)</label>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Kuliah/Responsi/Tutorial</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="bobot_kuliah" id="bobot_kuliah" class="form-control" value="<?php echo $query->bobot_kuliah; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Seminar</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="bobot_seminar" id="bobot_seminar" class="form-control" value="<?php echo $query->bobot_seminar; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Praktikum/ Praktik/Praktik Lapangan</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="bobot_praktikum" id="bobot_praktikum" class="form-control" value="<?php echo $query->bobot_praktikum; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Konversi Kredit ke jam</label>
                      <div class="col-lg-9">
                            <input type="text" name="konversi" id="konversi" class="form-control" value="<?php echo $query->konversi; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Capaian Pembelajaran</label>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote> Sikap</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="capaian_sikap" id="capaian_sikap" class="form-control" value="<?php echo $query->capaian_sikap; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>  Pengetahuan</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="capaian_pengetahuan" id="capaian_pengetahuan" class="form-control" value="<?php echo $query->capaian_pengetahuan; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>  Keteretampilan Umum</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="capaian_umum" id="capaian_umum" class="form-control" value="<?php echo $query->capaian_umum; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>  Keteretampilan Khusus</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="capaian_khusus" id="capaian_khusus" class="form-control" value="<?php echo $query->capaian_khusus; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Dokumen Rencana Pembela-jaran</label>
                      <div class="col-lg-9">
                            <input type="text" name="dokumen" id="dokumen" class="form-control" value="<?php echo $query->dokumen; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Unit Penyeleng-gara</label>
                      <div class="col-lg-9">
                            <input type="text" name="unit" id="unit" class="form-control" value="<?php echo $query->unit; ?>" placeholder="">
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
                    <a href="users/kurikulum" class="btn btn-default"><< Kembali</a>
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
  url: "<?php echo base_url('users/kurikulum') ?>",
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
            formData.append("semester", jQuery("#semester").val());
            formData.append("kode_matkul", jQuery("#kode_matkul").val());
            formData.append("nama_matkul", jQuery("#nama_matkul").val());
            formData.append("matkul_kom", jQuery("#matkul_kom").val());
            formData.append("bobot_kuliah", jQuery("#bobot_kuliah").val());
            formData.append("bobot_seminar", jQuery("#bobot_seminar").val());
            formData.append("bobot_praktikum", jQuery("#bobot_praktikum").val());
            formData.append("konversi", jQuery("#konversi").val());
            formData.append("capaian_sikap", jQuery("#capaian_sikap").val());
            formData.append("capaian_pengetahuan", jQuery("#capaian_pengetahuan").val());
            formData.append("capaian_umum", jQuery("#capaian_umum").val());
            formData.append("capaian_khusus", jQuery("#capaian_khusus").val());
            formData.append("dokumen", jQuery("#dokumen").val());
            formData.append("unit", jQuery("#unit").val());
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
                            window.location="<?php echo base_url(); ?>users/kurikulum";
                //     }
                // });

      myDropzone.removeFile(file);
    });

  }
};

</script>
