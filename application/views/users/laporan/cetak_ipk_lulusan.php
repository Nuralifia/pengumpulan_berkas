<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak IPK Lulusan</title>
    <base href="<?php echo base_url();?>"/>
  </head>
  <body onload="window.print()">

    <table border="0" width="100%">
      <tr>
        <td width="120">
          <img src="foto/logo1.png" alt="logo1" width="120">
        </td>
        <td align="center">
          <h1>Data</h1>
        </td>
        <td width="120">
          <img src="foto/logo2.png" alt="logo2" width="120">
        </td>
      </tr>
    </table>

    <hr>

    <h2 align="center">Berkas Akreditasi</h2>
    <br>
    <table border="1"width="100%">
      <tr>
        <th width="1%">No</th>
        <th width="10%">Tahun Lulus</th>
        <th width="10%">Jumlah Lulusan</th>
        <th width="20%">Indeks</th>
      </tr>
      <?php
      $no=1;
      foreach ($sql->result() as $baris) {?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $baris->Tahun_lulus; ?></td>
          <td><?php echo $baris->jumlah_lulusan; ?></td>
          <td><?php echo $baris->indeks; ?></td>
        </tr>
      <?php
      $no++;
      } ?>
    </table>

  </body>
</html>
