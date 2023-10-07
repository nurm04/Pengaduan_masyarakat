<div class="data_laporan_masyarakat">
  <h3>Data Laporan Anda</h3>
  <br>
  <?php 
    $cari = "";
    $nik = $_SESSION['user']['nik'];
    if($_SESSION['user']['level'] == "user") {
      $_SESSION['hal'] = "index1.php?data_laporan_masyarakat";
    } else {
      $_SESSION['hal'] = "index2.php?data_laporan_masyarakat";
    }
    $batas = 5;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $previous = $halaman-1;
    $next = $halaman+1;
    
    $data = mysqli_query($conn,"SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
      WHERE pengaduan.nik = '$nik' ORDER BY pengaduan.id_pengaduan DESC");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;
    if(isset($_POST['cariin'])) {
      $cari = cekInput($_POST['cari']);
      $query = mysqli_query($conn, "SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
      WHERE pengaduan.isi_laporan LIKE '%".$cari."%' OR
      pengaduan.status LIKE '%".$cari."%' OR
      pengaduan.judul_laporan LIKE '%".$cari."%' OR
      pengaduan.jenis_laporan LIKE '%".$cari."%' OR
      pengaduan.tgl_kejadian LIKE '%".$cari."%' OR 
      pengaduan.tgl_pengaduan LIKE '%".$cari."%' OR 
      pengaduan.tujuan LIKE '%".$cari."%'
      LIMIT $halaman_awal, $batas");
    } else {
      $query = mysqli_query($conn, "SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
      WHERE pengaduan.nik = '$nik' ORDER BY pengaduan.id_pengaduan DESC LIMIT $halaman_awal, $batas
      ");
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
        if($dt['nik'] == $_SESSION['user']['nik']) {
          $status = $dt['verifikasi'] == "tidak" ? "ditolak" : $status = $dt['status'] == "0" ? "belum dibaca" : $dt['status'];
  ?>
  <div class="card">
    <div class="card-body">
      <h6>Laporan</h6>
      <div class="atass">
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
        <?php if($dt['verifikasi'] == "tidak") {?>
        <tr>
          <td><span class="warning">Laporan Ditolak</span></td>
        </tr>
        <?php } ?>
      </table>
      <div class="aksi">
        <a type="button" class="btn btn-dark" href="index1.php?detail_laporan_masyarakat&id_pengaduan=<?= $dt['id_pengaduan']; ?>">Detail</a>
      </div>
    </div>
  </div>
  <?php } } } else { ?>
  <div class="kosong">Data Kosong</div>
  <?php } ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index1.php?data_laporan_masyarakat&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index1.php?data_laporan_masyarakat&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index1.php?data_laporan_masyarakat&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav><br><br>
</div>