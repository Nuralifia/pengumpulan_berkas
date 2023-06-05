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
$this->db->order_by('id_program', 'ASC');
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
                <form class="form-horizontal" action="users/program"  enctype="multipart/form-data" method="post">
                    
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Program Studi</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama_program" id="nama_program" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Jenis Program</label>
                      <div class="col-lg-9">
                            <input type="text" name="jenis_program" id="jenis_program" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Peringkat Akreditasi PS</label>
                      <div class="col-lg-9">
                            <input type="text" name="peringkat" id="peringkat" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nomor SK BAN-PT</label>
                      <div class="col-lg-9">
                            <input type="text" name="no_sk" id="no_sk" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Tanggal Kadaluarsa</label>
                      <div class="col-lg-9">
                            <input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Unit Pengelola</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama_unit" id="nama_unit" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Perguruan Tinggi</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama_perguruan" id="nama_perguruan" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Alamat</label>
                      <div class="col-lg-9">
                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nomor Telepon</label>
                      <div class="col-lg-9">
                            <input type="text" name="no_tlp" id="no_tlp" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">E-mail</label>
                      <div class="col-lg-9">
                            <input type="text" name="email" id="email" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Website</label>
                      <div class="col-lg-9">
                            <input type="text" name="website" id="website" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">TS *)</label>
                      <div class="col-lg-9">
                            <input type="text" name="ts" id="ts" class="form-control" placeholder="">
                            <i style="color:red">*) TS = Tahun Akademik penuh terakhir saat pengujian usulan akreditasi</i>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Pengusul</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama_pengusul" id="nama_pengusul" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Tanggal</label>
                      <div class="col-lg-9">
                            <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="">
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
                    <a href="users/program" class="btn btn-default"><< Kembali</a>
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
  url: "<?php echo base_url('users/program') ?>",
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
            formData.append("nama_program", jQuery("#nama_program").val());
            formData.append("jenis_program", jQuery("#jenis_program").val());
            formData.append("peringkat", jQuery("#peringkat").val());
            formData.append("no_sk", jQuery("#no_sk").val());
            formData.append("tgl_kadaluarsa", jQuery("#tgl_kadaluarsa").val());
            formData.append("nama_unit", jQuery("#nama_unit").val());
            formData.append("nama_perguruan", jQuery("#nama_perguruan").val());
            formData.append("alamat", jQuery("#alamat").val());
            formData.append("no_tlp", jQuery("#no_tlp").val());
            formData.append("email", jQuery("#email").val());
            formData.append("website", jQuery("#website").val());
            formData.append("ts", jQuery("#ts").val());
            formData.append("nama_pengusul", jQuery("#nama_pengusul").val());
            formData.append("tanggal", jQuery("#tanggal").val());
            
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
                            window.location="<?php echo base_url(); ?>users/program/t";
                //     }
                // });

      myDropzone.removeFile(file);
    });

  }
};

</script>
