<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Berkas Dari Mahasiswa</title>
    <base href="<?php echo base_url();?>"/>
  </head>
  <body onload="window.print()">

    <table border="0" width="100%">
      <tr>
        <td width="120">
          <img src="foto/logo1.png" alt="logo1" width="120">
        </td>
        <td align="center">
          <h1>Website Pengumpulan Berita</h1>
        </td>
        <td width="120">
          <img src="foto/logo2.png" alt="logo2" width="120">
        </td>
      </tr>
    </table>

    <hr>

    <h2 align="center">Berkas Pengumpulan Dari Mahasiswa</h2>
    <br>
    <table border="1"width="100%">
      <tr>
        <th width="1%">No</th>
        <th width="10%">Tanggal</th>
        <th width="10%">Kepada</th>
        <th width="20%">Judul</th>
      </tr>
      <?php
      $no=1;
      foreach ($sql->result() as $baris) {?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $baris->tgl_ns; ?></td>
          <td><?php echo $baris->penerima; ?></td>
          <td><?php echo $baris->perihal; ?></td>
        </tr>
      <?php
      $no++;
      } ?>
    </table>

  </body>
</html>