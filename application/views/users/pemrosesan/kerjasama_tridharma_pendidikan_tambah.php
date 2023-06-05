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
$this->db->order_by('id_kerjasama_tridharma_pendidikan', 'ASC');
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
                <legend class="text-bold"><i class="icon-folder-download2"></i> Tambah Data</legend>
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="msg"></div>
                <form class="form-horizontal" action="users/kerjasama_tridharma_pendidikan"  enctype="multipart/form-data" method="post">
                    
                    <div class="form-group">
                      <label class="control-label col-lg-3">Lembaga Mitra</label>
                      <div class="col-lg-9">
                            <input type="text" name="lembaga_mitra" id="lembaga_mitra" class="form-control" placeholder="">
                      </div>
                    </div>

                   
                    
                    <div class="form-group">
                      <label class="control-label col-lg-3">Tingkat</label>
                      <div class="col-lg-9">
                        <select class="form-control" name="tingkat" id="tingkat" required>
                        <option value="">- Pilih Tingkat -</option>
                        <option value="Internasional">Internasional</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Wilayah/Lokal">Wilayah/Lokal</option>
                      </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-lg-3">judul Kegiatan Kerjasama</label>
                      <div class="col-lg-9">
                            <input type="text" name="judul_kegiatan_kerjasama" id="judul_kegiatan_kerjasama" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Manfaat Bagi PS yang Diakreditasi</label>
                      <div class="col-lg-9">
                            <input type="text" name="manfaat" id="manfaat" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Waktu dan Durasi</label>
                      <div class="col-lg-9">
                            <input type="text" name="waktu_dan_durasi" id="waktu_dan_durasi" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Bukti Kerjasama</label>
                      <div class="col-lg-9">
                            <input type="text" name="bukti_kerjasama" id="bukti_kerjasama" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Tahun Berakhirnya Kerjasama</label>
                      <div class="col-lg-9">
                            <input type="text" name="tahun_berakhir" id="tahun_berakhir" class="form-control" placeholder="">
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
                    <a href="users/kerjasama_tridharma_pendidikan" class="btn btn-default"><< Kembali</a>
                    <button type="submit" id="submit-all" class="btn btn-primary" style="float:right;">Kirim</button>
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
  url: "<?php echo base_url('users/kerjasama_tridharma_pendidikan') ?>",
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
            formData.append("lembaga_mitra", jQuery("#lembaga_mitra").val());
            formData.append("tingkat", jQuery("#tingkat").val());
            formData.append("judul_kegiatan_kerjasama", jQuery("#judul_kegiatan_kerjasama").val());
            formData.append("manfaat", jQuery("#manfaat").val());
            formData.append("waktu_dan_durasi", jQuery("#waktu_dan_durasi").val());
            formData.append("bukti_kerjasama", jQuery("#bukti_kerjasama").val());
            formData.append("tahun_berakhir", jQuery("#tahun_berakhir").val());
            
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
                            window.location="<?php echo base_url(); ?>users/kerjasama_tridharma_pendidikan/t";
                //     }
                // });

      myDropzone.removeFile(file);
    });

  }
};

</script>
