<?php
  $_SESSION['hal'] = "index2.php?data_semua_laporan";
  if(isset($_POST['ubah'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $status = "selesai";
    $kirim = mysqli_query($conn, "UPDATE pengaduan SET 
    status = '$status' WHERE id_pengaduan = '$id_pengaduan'");
    if($kirim) {
      setFlash('success', 'Laporan Selesai');
    } else {
      setFlash('danger', 'Maaf ada kesalaha');
    }
  }
  $batas = 5;
  $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
  $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

  $previous = $halaman-1;
  $next = $halaman+1;
  
  $data = mysqli_query($conn,"SELECT * FROM pengaduan");
  $jumlah_data = mysqli_num_rows($data);
  $total_halaman = ceil($jumlah_data / $batas);

  $nomor = $halaman_awal+1;
  $cari = "";
  if(isset($_POST['cariin'])) {
    $cari = cekInput($_POST['cari']);
    $id_petugas = $_SESSION['user']['id_petugas'];
    $query = mysqli_query($conn, "SELECT * FROM pengaduan 
    INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik 
    LEFT JOIN tanggapan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan 
    LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas WHERE 
    pengaduan.isi_laporan LIKE '%".$cari."%' OR  
    pengaduan.tgl_pengaduan LIKE '%".$cari."%' OR
    pengaduan.tgl_kejadian LIKE '%".$cari."%' OR
    masyarakat.nama LIKE '%".$cari."%' OR
    petugas.nama_petugas LIKE '%".$cari."%' OR
    tanggapan.tanggapan LIKE '%".$cari."%'
    LIMIT $halaman_awal, $batas");
  } else {
    $id_petugas = $_SESSION['user']['id_petugas'];
    $query = mysqli_query($conn, "SELECT * FROM pengaduan
    INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik 
    ORDER BY pengaduan.id_pengaduan DESC LIMIT $halaman_awal, $batas");
  }
?>
<div class="data_laporan">
<h3>Semua Laporan</h3>

  <form class="d-flex" role="search" method="post" action="">
    <input value="<?= $cari; ?>" class="form-control me-2 input" type="search" placeholder="Search" name="cari" aria-label="Search">
    <button type="submit" name="cariin"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>

  <button type="button" class="btn btn-dark pdf" data-bs-toggle="modal" data-bs-target="#exampleModalPDF"><i class="fa-solid fa-file-pdf"></i> Cetak PDF</button>

  <?php flash(); ?>
  <br>
  <table class="table table-bordered border-dark">
    <thead>
      <tr class="table-dark table-bordered border-dark">
        <th scope="col">NIK</th>
        <th scope="col">Nama</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Jenis Laporan</th>
        <th scope="col">Isi Laporan</th>
        <th scope="col">Status</th>
        <th scope="col">...</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
      <?php
        if(mysqli_num_rows($query)) {
          foreach($query as $dt) {
            $status = $dt['verifikasi'] == "tidak" ? "ditolak" : $status = $dt['status'] == "0" ? "belum dibaca" : $dt['status'];
      ?>
      <tr>
        <th><?= $dt['nik']; ?></th>
        <td><?= $dt['nama']; ?></td>
        <td><?= date('d-m-Y', strtotime($dt['tgl_pengaduan'])) ?></td>
        <td><?= $dt['jenis_laporan']; ?></td>
        <td><?= textLimit($dt['isi_laporan']); ?></td>
        <td><?= $status; ?></td>
        <td>
          <a type="button" class="btn btn-dark" href="index2.php?detail_laporan_petugas&id_pengaduan=<?= $dt['id_pengaduan']; ?>&hal=data_semua_laporan">
            <i class="fa-solid fa-eye"></i>
          </a>
        </td>
      </tr>
      <?php } } else {?>
      <tr><td colspan="7"><center>Data Kosong</center></td></tr>
      <?php } ?>
    </tbody>
  </table>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index2.php?data_semua_laporan&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index2.php?data_semua_laporan&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index2.php?data_semua_laporan&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>

<!-- Modal PDF -->
  <div class="modal fade" id="exampleModalPDF" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak PDF</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="exportPdfTgl.php" method="post">
          <div class="modal-body">
            <div class="form mb-3">
              <label for="tgl_dari">Dari Tanggal:</label>
              <input class="form-control form-control-sm" autocomplete="off" name="tgl_dari" id="tgl_dari" type="date" aria-label=".form-control-sm example">
            </div>
            <div class="form mb-3">
              <label for="tgl_sampai">Sampai Tanggal:</label>
              <input class="form-control form-control-sm" autocomplete="off" name="tgl_sampai" id="tgl_sampai" type="date" aria-label=".form-control-sm example">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="cetakPdf" class="btn btn-dark">Cetak</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Modal PDF -->
</div>