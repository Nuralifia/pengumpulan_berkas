<?php
  $cek    = $user->row();
  $id_user = $cek->id_user;
  $nama    = $cek->nama_lengkap;
  $level   = $cek->level;

  $tgl = date('m-Y');
?>

<center>
  <h6><b>Sistem Informasi Manajemen Berkas Data Dukung Akreditasi</b></h6>
  <h6><b>Prodi D3 Teknik Informatika PENS PSDKU Lamongan</b></h6>
</center>
      <div class="content">
        <div class="row">
          <div class="panel panel-flat">
            <div class="panel-heading">
              <h7 class="panel-title"><i class=" "></i><b> Daftar Progran Studi di Unit Pengelola Program Studi : </b></h7>
                <hr style="margin:0px;">
                  <div class="heading-elements">
                    <ul class="icons-list">
                  <li><a data-action="collapse"></a></li>
               </ul>
            </div>
        </div>
        <table class="table datatable-basic" width="100%">
          <thead>
            <tr>
              <th><b>No</b></th>
              <th><b>Kode</b></th>
              <th><b>Keterangan</b></th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>1.</th>
              <th>1-1</th>
              <th>Kerjasama Tridharma - Pendidikan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>2.</th>
              <th>1-2</th>
              <th>Kerjasama Tridharma - Penelitian</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>3.</th>
              <th>1-3</th>
              <th>Kerjasama Tridharma - Pengabdian Kepada Masyarakat</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>4.</th>
              <th>2a</th>
              <th>Seleksi Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>5.</th>
              <th>2b</th>
              <th>Mahasiswa Asing</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>6.</th>
              <th>3a1</th>
              <th>Dosen Tetap Perguruan Tinggi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>7.</th>
              <th>3a2</th>
              <th>Dosen Pembimbing Utama Tugas Akhir</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>8.</th>
              <th>3a3</th>
              <th>Ekuivalen Waktu Mengajar Penuh (EWMP) Dosen Tetap Perguruan Tinggi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>9.</th>
              <th>3a4</th>
              <th>Dosen Tidak Tetap</th>
              <th class="text-center" width="170"></th>
            </tr>
             <tr>
              <th>10.</th>
              <th>3a5</th>
              <th>Dosen Industri / Praktisi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>11.</th>
              <th>3b1</th>
              <th>Pengakuan / Rekogisi Dosen</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>12.</th>
              <th>3b2</th>
              <th>Penelitian DTPS</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>13.</th>
              <th>3b3</th>
              <th>PkM DTPS</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>14.</th>
              <th>3b4-1</th>
              <th>Publikasi Ilmiah DTPS</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>15.</th>
              <th>3b4-2</th>
              <th>Pengelaran/Pameran/Presentasi/Publikasi DTPS</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>16.</th>
              <th>3b5</th>
              <th>Karya Ilmiah DTPS yang Disitasi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>17.</th>
              <th>3b6</th>
              <th>Produk Jasa DTPS yang Diadopsi Oleh Industri / Masyarakat</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>18.</th>
              <th>3b7-1</th>
              <th>Luaran Penelitian PkM Lainnya - HKI (Paten, Paten Sederhana)</th>
              <th class="text-center" width="170"></th>
            </tr>
             <tr>
              <th>19.</th>
              <th>3b7-2</th>
              <th>Luaran Penelitian PkM Lainnya - HKI (Hak Cipta, Desain Produksi Industri, dll)</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>20.</th>
              <th>3b7-3</th>
              <th>Luaran Penelitian PkM Lainnya - Teknologi Tepat Guna, Produksi, Karya Seni, Rekayasa Sosial</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>21.</th>
              <th>3b7-4</th>
              <th>Luaran Penelitian PkM Lainnya - Buku ber-ISBN, Book Chapter</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>22.</th>
              <th>4</th>
              <th>Penggunaan Dana</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>23.</th>
              <th>5a</th>
              <th>Kilikurum, Capaian Pembelajaran, dan Rencana Pembelajaran</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>24.</th>
              <th>5b</th>
              <th>Integrasi Kegiatan Penelitian/PkM dalam Pembelajaran</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>25.</th>
              <th>5c</th>
              <th>Kepuasan Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>26.</th>
              <th>6a</th>
              <th>Penelitian DTPS yang Melibatkan Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>27.</th>
              <th>6b</th>
              <th>Penalitian DTPS yang Menjadi Rujukan Tema Tesis/Disitasi</th>
              <th class="text-center" width="170"></th>
            </tr>
             <tr>
              <th>28.</th>
              <th>7</th>
              <th>PKM DTPS yang Melibatkan Masyarakat</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>29.</th>
              <th>8a</th>
              <th>IPK Lulusan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>30.</th>
              <th>8b1</th>
              <th>Prestasi Akademik Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>31.</th>
              <th>8b2</th>
              <th>Prestasi Non-akademik Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>32.</th>
              <th>8c1</th>
              <th>Masa Studi Lulusan Dari Program Diploma Tiga</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>33.</th>
              <th>8c2</th>
              <th>Masa Studi Lulusan Dari Program Sarjana/Sarjana Terapan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>34.</th>
              <th>8c3</th>
              <th>Masa Studi Lulusan Dari Program Magister/Magister Terapan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>35.</th>
              <th>8c4</th>
              <th>Masa Studi Lulusan Dari Program Doktor/Doktor Terapan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>36.</th>
              <th>8d1-1</th>
              <th>Waktu Tunggu Lulusan Pada Program Diploma</th>
              <th class="text-center" width="170"></th>
            </tr>
             <tr>
              <th>37.</th>
              <th>8d1-2</th>
              <th>Waktu Tunggu Lulusan Pada Program Sarjana</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>38.</th>
              <th>8d1-3</th>
              <th>Waktu Tunggu Lulusan Pada Program sarjana Terapan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>39.</th>
              <th>8d2</th>
              <th>Kesesuaian Bidang Kerja Lulusan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>40.</th>
              <th>8e1</th>
              <th>Tempat Kerja Lulusan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>41.</th>
              <th>8e2</th>
              <th>Referensi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>42.</th>
              <th>8e3</th>
              <th>Kepuasan Pengguna Lulusan</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>43.</th>
              <th>8f1-1</th>
              <th>Publikasi Ilmiah Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>44.</th>
              <th>8f1-2</th>
              <th>Pengelaran/Pameran/Presentasi/Publikasi Ilmiah Mahasiswa</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>45.</th>
              <th>8f2</th>
              <th>Karya Ilmiah Mahasiswa yang Disitasi</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>46.</th>
              <th>8f3</th>
              <th>Produk/Jasa Mahasiswa yang Diapdopsi oleh Industri/Masyarakat</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>47.</th>
              <th>8f4-1</th>
              <th>Luaran Penelitian yang Dihasilkan Mahasiswa - HKI (paten, patenn sederhana)</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>48.</th>
              <th>8f4-2</th>
              <th>Luaran Penelitian yang Dihasilkan Mahasiswa - HKI (hak Cipta, Desain Produksi Industri, dll)</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>49.</th>
              <th>8f4-3</th>
              <th>Luaran Penelitian yang Dihasilkan Mahasiswa - Teknologi Tepat Guna, Produk, Karya Seni, rekayasa Sosial</th>
              <th class="text-center" width="170"></th>
            </tr>
            <tr>
              <th>50.</th>
              <th>8f4-4</th>
              <th>Luaran Penelitian yang Dihasilkan Mahasiswa - Buku ber_ISBN, Book Chpter</th>
              <th class="text-center" width="170"></th>
            </tr>

            <th> </th>
              <th> </th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            <th></th>
              <th></th>
              <th> </th>
              <th class="text-center" width="170"></th>
            </tr>
            
            
          </thead>
        </table>
      </div>
    </div>
  </div>  
