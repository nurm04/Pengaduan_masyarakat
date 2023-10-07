<div class="laporan_data_petugas">
  <h3><a href="index2.php?data_petugas"><i class="fa-solid fa-left-long"></i>Laporan Yang Diterima</a></h3>
  <?php 
    $id_petugas = $_GET['id'];
    $batas = 5;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $previous = $halaman-1;
    $next = $halaman+1;
    
    $data = mysqli_query($conn,"SELECT * FROM pengaduan 
      INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik
      LEFT JOIN tanggapan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan 
      LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas
      WHERE tanggapan.id_petugas = '$id_petugas' ORDER BY tanggapan.id_petugas DESC
    ");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;
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
      LEFT JOIN tanggapan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan 
      LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas
      WHERE tanggapan.id_petugas = '$id_petugas' ORDER BY tanggapan.id_petugas DESC LIMIT $halaman_awal, $batas");
    }
  ?>
  <form class="d-flex" role="search" method="post" action="">
    <input value="<?= $cari; ?>" class="form-control me-2 input" type="search" placeholder="Search" name="cari" aria-label="Search">
    <button type="submit" name="cariin"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>
  <?php flash(); ?>
  <br>
  <table class="table table-bordered border-dark">
    <thead>
      <tr class="table-dark table-bordered border-dark">
        <th scope="col">NIK</th>
        <th scope="col">Nama</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Judul</th>
        <th scope="col">Jenis Laporan</th>
        <th scope="col">Tujuan</th>
        <th scope="col">Status</th>
        <th scope="col">...</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
      <?php
        if(mysqli_num_rows($query)) {
          foreach($query as $dt) {
            if($dt['id_petugas'] == $id_petugas) {
              $status = $dt['verifikasi'] == "tidak" ? "ditolak" : $status = $dt['status'] == "0" ? "belum dibaca" : $dt['status'];
      ?>
      <tr>
        <th><?= $dt['nik']; ?></th>
        <td><?= $dt['nama']; ?></td>
        <td><?= date('d-m-Y', strtotime($dt['tgl_pengaduan'])); ?></td>
        <td><?= $dt['judul_laporan']; ?></td>
        <td><?= $dt['jenis_laporan']; ?></td>
        <td><?= $dt['tujuan']; ?></td>
        <td><?= $status; ?></td>
        <td>
          <a type="button" class="btn btn-dark" href="index2.php?detail_laporan_petugas&id_pengaduan=<?= $dt['id_pengaduan']; ?>&hal=laporan_data_petugas&id=<?= $id_petugas;?>">
            <i class="fa-solid fa-eye"></i>
          </a>
        </td>
      </tr>
      <?php } } } else {?>
      <tr><td colspan="8"><center>Data Kosong</center></td></tr>
      <?php } ?>
    </tbody>
  </table>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index2.php?laporan_data_petugas&id=$id_petugas&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index2.php?laporan_data_petugas&id=<?= $id_petugas;?>&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index2.php?laporan_data_petugas&id=$id_petugas&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>