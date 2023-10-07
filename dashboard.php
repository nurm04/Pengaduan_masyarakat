<?php 
  $lp = mysqli_query($conn, "SELECT * FROM pengaduan");
  $lp1 = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = '0'");
  $lp2 = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status != '0'");
  $pt = mysqli_query($conn, "SELECT * FROM petugas WHERE level = 'petugas'");
  $ms = mysqli_query($conn, "SELECT * FROM masyarakat");
?>
<div class="dashboard">
  <div class="data">
    <div class="kotak lp bg-danger">
      <i class="fa-regular fa-file-lines"></i>
      <p><?= mysqli_num_rows($lp); ?> Laporan Masuk</p>
    </div>
    <div class="kotak lp1 bg-danger">
      <i class="fa-regular fa-file-lines"></i>
      <p><?= mysqli_num_rows($lp1); ?> Laporan belum ditanggapi</p>
    </div>
    <div class="kotak lp2 bg-danger">
      <i class="fa-regular fa-file-lines"></i>
      <p><?= mysqli_num_rows($lp2); ?> Laporan sudah ditanggapi</p>
    </div>
    <?php if($_SESSION['user']['level'] == 'admin') {?>
    <div class="kotak pt bg-success">
      <i class="fa-solid fa-user"></i> 
      <p><?= mysqli_num_rows($pt); ?> Petugas</p>
    </div>
    <div class="kotak ms bg-primary">
      <i class="fa-solid fa-users"></i>
      <p><?= mysqli_num_rows($ms); ?> Masyarakat</p>
    </div>
    <?php } ?>
  </div>
</div>
<div class="laporan data">
  <h3>Data Semua Laporan</h3>
  <br>
  <?php 
    $batas = 5;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $previous = $halaman-1;
    $next = $halaman+1;
    
    $data = mysqli_query($conn,"SELECT * FROM pengaduan");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;
    $_SESSION['hal'] = "index2.php?data_semua_laporan";
    $cari = "";
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
      pengaduan.tgl_kejadian LIKE '%".$cari."%' OR 
      pengaduan.tgl_pengaduan LIKE '%".$cari."%' OR 
      pengaduan.tujuan LIKE '%".$cari."%' OR 
      tanggapan.tanggapan LIKE '%".$cari."%'
      LIMIT $halaman_awal, $batas");
    } else {
      $query = mysqli_query($conn, "SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik 
      WHERE pengaduan.status = 'selesai'
      ORDER BY pengaduan.id_pengaduan DESC LIMIT $halaman_awal, $batas");
    }
  ?>

  <form class="d-flex" role="search" method="post" action="">
    <input value="<?= $cari; ?>" class="form-control me-2 input" type="search" placeholder="Search" name="cari" aria-label="Search">
    <button type="submit" name="cariin"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>

  <?php 
    flash();
    if(mysqli_num_rows($query)) {
      foreach($query as $pd) {
        if($pd['status'] == 'selesai') {
  ?>
  <div class="card">
    <div class="card-body">
      <h6><?= $pd['nama']; ?></h6>
      <div class="atas">
        <div class="lebel"><?= $pd['status'] != 'selesai' && $pd['status'] != 'proses' ? "belum dibaca" : $pd['status'];?></div>
      </div>
      <table>
        <tr>
          <td>Judul<p>:</p></td>
          <td><?= $pd['judul_laporan']; ?></td>
        </tr>
        <tr>
          <td>Jenis Laporan<p>:</p></td>
          <td><?= $pd['jenis_laporan']; ?></td>
        </tr>
        <tr>
          <td>Tujuan<p>:</p></td>
          <td><?= $pd['tujuan']; ?></td>
        </tr>
        <tr>
          <td>Tanggal Kejadian<p>:</p></td>
          <td><?= $pd['tgl_kejadian']; ?></td>
        </tr>
        <tr>
          <td>Isi<p>:</p></td>
          <td><?= textlimit($pd['isi_laporan']); ?></td>
        </tr>
      </table>
      <h6 class="card-subtitle mb-2 text-muted"><?= $pd['tgl_pengaduan']; ?></h6>
      <div class="aksi">
        <button type="button" class="btn btn-dark apa"><a href="index2.php?detail_laporan_petugas&id_pengaduan=<?= $pd['id_pengaduan']; ?>&hal=dashboard">Detail</a></button>
      </div>
    </div>
  </div>
  <?php } } } else { ?>
  <div class="kosong">Data Kosong</div>
  <?php } ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index2.php?dashboard&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index2.php?dashboard&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index2.php?dashboard&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
  <br><br>
</div>