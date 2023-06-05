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
$this->db->order_by('id_masa_studi_do', 'ASC');
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
                      <label class="control-label col-lg-3">Tahun Masuk</label>
                      <div class="col-lg-9">
                            <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control" value="<?php echo $query->tahun_masuk; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Jumlah Mahasiswa Diterima</label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_diterima" id="jumlah_mhs_diterima" class="form-control" value="<?php echo $query->jumlah_mhs_diterima; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Jumlah Mahasiswa Lulus Pada</label>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS-6</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts6" id="jumlah_mhs_lulus_ts6" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts6; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS-5</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts5" id="jumlah_mhs_lulus_ts5" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts5; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS-4</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts4" id="jumlah_mhs_lulus_ts4" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts4; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS-3</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts3" id="jumlah_mhs_lulus_ts3" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts3; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS-2</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts2" id="jumlah_mhs_lulus_ts2" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts2; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS-1</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts1" id="jumlah_mhs_lulus_ts1" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts1; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3"><blockquote>Akhir TS</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_mhs_lulus_ts" id="jumlah_mhs_lulus_ts" class="form-control" value="<?php echo $query->jumlah_mhs_lulus_ts; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Jumlah Lulusan s.d. Akhir TS</label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah_lulusan" id="jumlah_lulusan" class="form-control" value="<?php echo $query->jumlah_lulusan; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Rata-Rata Masa Studi</label>
                      <div class="col-lg-9">
                            <input type="text" name="rata_studi" id="rata_studi" class="form-control" value="<?php echo $query->rata_studi; ?>" placeholder="">
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
                    <a href="users/masa_studi_do" class="btn btn-default"><< Kembali</a>
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
  url: "<?php echo base_url('users/masa_studi_do') ?>",
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
            formData.append("tahun_masuk", jQuery("#tahun_masuk").val());
            formData.append("jumlah_mhs_diterima", jQuery("#jumlah_mhs_diterima").val());
            formData.append("jumlah_mhs_lulus_ts", jQuery("#jumlah_mhs_lulus_ts").val());
            formData.append("jumlah_mhs_lulus_ts1", jQuery("#jumlah_mhs_lulus_ts1").val());
            formData.append("jumlah_mhs_lulus_ts2", jQuery("#jumlah_mhs_lulus_ts2").val());
            formData.append("jumlah_mhs_lulus_ts3", jQuery("#jumlah_mhs_lulus_ts3").val());
            formData.append("jumlah_mhs_lulus_ts4", jQuery("#jumlah_mhs_lulus_ts4").val());
            formData.append("jumlah_mhs_lulus_ts5", jQuery("#jumlah_mhs_lulus_ts5").val());
            formData.append("jumlah_mhs_lulus_ts6", jQuery("#jumlah_mhs_lulus_ts6").val());
            formData.append("jumlah_lulusan", jQuery("#jumlah_lulusan").val());
            formData.append("rata_studi", jQuery("#rata_studi").val());
            
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
                            window.location="<?php echo base_url(); ?>users/masa_studi_do";
                //     }
                // });

      myDropzone.removeFile(file);
    });

  }
};

</script>
