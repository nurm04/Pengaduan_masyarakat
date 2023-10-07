<div class="laporan_masuk">
  <h3>Data Laporan Masuk</h3>
  <br>
  <?php 
    $cari = "";
    $batas = 5;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $previous = $halaman-1;
    $next = $halaman+1;
    
    $data = mysqli_query($conn,"SELECT * FROM pengaduan WHERE pengaduan.status = '0' ORDER BY pengaduan.id_pengaduan ASC");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;
    $_SESSION['hal'] = "index2.php?laporan_masuk";
    if(isset($_POST['cariin'])) {
      $cari = cekInput($_POST['cari']);
      $query = mysqli_query($conn, "SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik 
      LEFT JOIN tanggapan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan 
      LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas WHERE 
      pengaduan.isi_laporan LIKE '%".$cari."%' OR 
      masyarakat.nama LIKE '%".$cari."%' OR
      petugas.nama_petugas LIKE '%".$cari."%' OR
      pengaduan.judul_laporan LIKE '%".$cari."%' OR 
      pengaduan.jenis_laporan LIKE '%".$cari."%' OR 
      pengaduan.tujuan LIKE '%".$cari."%' OR 
      pengaduan.tgl_kejadian LIKE '%".$cari."%' OR 
      pengaduan.tgl_pengaduan LIKE '%".$cari."%' OR 
      tanggapan.tanggapan LIKE '%".$cari."%'
      LIMIT $halaman_awal, $batas");
    } else {
      $query = mysqli_query($conn, "SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
      WHERE pengaduan.status = '0' AND pengaduan.verifikasi != 'tidak'
      ORDER BY pengaduan.id_pengaduan ASC LIMIT $halaman_awal, $batas");
    }
  ?>
  <form class="d-flex" role="search" method="post" action="">
    <input value="<?= $cari; ?>" class="form-control me-2 input" type="search" placeholder="Search" name="cari" aria-label="Search">
    <button type="submit" name="cariin"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>

  <?php 
    flash();
    if(mysqli_num_rows($query) > 0 ) {
      while($dt = mysqli_fetch_array($query)) {
        if($dt['status'] == "0") {
          if($dt['verifikasi'] == "tidak") {
            $status = "ditolak";
          } else {
            $status = $dt['status'] == "0" ? "belum dibaca" : $dt['status'];
          }
  ?>
  <div class="card">
    <div class="card-body">
      <h6><?= $dt['nama']; ?></h6>
      <div class="atas">
        <div class="lebel"><?= $status;?></div>
      </div>
      <table>
        <tr>
          <td>Judul<p>:</p></td>
          <td><?= $dt['judul_laporan']; ?></td>
        </tr>
        <tr>
          <td>Jenis Laporan<p>:</p></td>
          <td><?= $dt['jenis_laporan']; ?></td>
        </tr>
        <tr>
          <td>Tujuan<p>:</p></td>
          <td><?= $dt['tujuan']; ?></td>
        </tr>
        <tr>
          <td>Tanggal Kejadian<p>:</p></td>
          <td><?= date('d F Y', strtotime($dt['tgl_kejadian'])); ?></td>
        </tr>
        <tr>
          <td>Isi<p>:</p></td>
          <td><?= textlimit($dt['isi_laporan']); ?></td>
        </tr>
      </table>
      <h6 class="card-subtitle mb-2 text-muted"><?= date('d F Y', strtotime($dt['tgl_pengaduan'])); ?></h6>
      <div class="aksi">
        <button type="button" class="btn btn-dark apa"><a href="index2.php?detail_laporan_petugas&id_pengaduan=<?= $dt['id_pengaduan']; ?>&hal=laporan_masuk">Detail</a></button>
      </div>
    </div>
  </div>
  <?php } } } else { ?>
  <div class="kosong">Data Kosong</div>
  <?php } ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index2.php?laporan_masuk&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index2.php?laporan_masuk&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index2.php?laporan_masuk&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav><br><br>
</div>