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
$this->db->order_by('id_upps', 'ASC');
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
                      <label class="control-label col-lg-3">Jenis Program</label>
                      <div class="col-lg-9">
                            <input type="text" name="jenis" id="jenis" class="form-control" value="<?php echo $query->jenis; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Nama Program Studi</label>
                      <div class="col-lg-9">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $query->nama; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-12">Akreditasi Program Studi</label>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>Status/Peringkat</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="status" id="status" class="form-control" value="<?php echo $query->status; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>No. dan Tgl.SK</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="no" id="no" class="form-control" value="<?php echo $query->no; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label class="control-label col-lg-3"><blockquote>Tgl. Kadaluarsa</blockquote></label>
                      <div class="col-lg-9">
                            <input type="text" name="tanggal" id="tanggal" class="form-control" value="<?php echo $query->tanggal; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-lg-3">Jumlah Mahasiswa Saat TS</label>
                      <div class="col-lg-9">
                            <input type="text" name="jumlah" id="jumlah" class="form-control" value="<?php echo $query->jumlah; ?>" placeholder="">
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
                    <a href="users/upps" class="btn btn-default"><< Kembali</a>
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
  url: "<?php echo base_url('users/upps') ?>",
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
            formData.append("jenis", jQuery("#jenis").val());
            formData.append("nama", jQuery("#nama").val());            
            formData.append("status", jQuery("#status").val());
            formData.append("no", jQuery("#no").val());
            formData.append("tanggal", jQuery("#tanggal").val());
            formData.append("jumlah", jQuery("#jumlah").val());
            
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
                            window.location="<?php echo base_url(); ?>users/upps";
                //     }
                // });

      myDropzone.removeFile(file);
    });

  }
};

</script>
