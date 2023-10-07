<?php
  if(isset($_POST['hapusL'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $kirim = mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'");
    if($kirim) {
      setFlash('success', 'Laporan Berhasil Dihapus');
      echo "<script> window.location.href='index1.php?data_laporan_masyarakat';</script>";
    } else {
      setFlash('danger', 'Laporan Gagal Dihapus');
    }
  }
  $id_pengaduan = $_GET['id_pengaduan'];
  $query1 = mysqli_query($conn, "SELECT * FROM pengaduan 
    INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
    LEFT JOIN tanggapan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
    LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas
    WHERE pengaduan.id_pengaduan = '$id_pengaduan' ORDER BY pengaduan.id_pengaduan DESC
  ");
  $dt = mysqli_fetch_array($query1);
  $status = $dt['verifikasi'] == "tidak" ? "ditolak" : $status = $dt['status'] == "0" ? "belum dibaca" : $dt['status'];
  flash();
?>
<div class="detail_laporan">
  <br>
  <div class="card">
    <div class="card-body">
      <h6>Laporan</h6>
      <div class="atass">
        <div class="lebel"><?= $status;?></div>
      </div>
      <table>
        <tr>
          <td>NIK<p>:</p></td>
          <td><?= $dt['nik']; ?></td>
        </tr>
        <tr>
          <td>Nama<p>:</p></td>
          <td><?= $dt['nama']; ?></td>
        </tr>
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
          <td><?= $dt['isi_laporan']; ?></td>
        </tr>
        <?php if(!empty($dt['foto'])) { ?>
        <tr>
          <td>Lampiran Foto<p>:</p></td>
          <td><img class="foto" src="upload/<?= $dt['foto']; ?>" alt="<?= $dt['foto']; ?>"></td>
        </tr>
        <?php } ?>
      </table>
      <h6 class="card-subtitle mb-2 text-muted"><?= date('d F Y', strtotime($dt['tgl_pengaduan'])); ?></h6>
      <?php if(!empty($dt['id_tanggapan'])) {?>
        <?php if($dt['verifikasi'] == "tidak") {?>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label"><h6>Laporan Ditolak<br>Oleh : <a href="index1.php?profil_cek&id_petugas=<?= $dt['id_petugas']; ?>&a=<?= $id_pengaduan; ?>"><?= $dt['nama_petugas']; ?></a></h6></label>
          </div>
          <div class="aksi">
            <a class="btn btn-secondary apa" href="index1.php?data_laporan_masyarakat">Kembali</a>
          </div>
        <?php } else {?>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label"><h6>Tanggapan : <a href="index1.php?profil_cek&id_petugas=<?= $dt['id_petugas']; ?>&a=<?= $id_pengaduan; ?>"><?= $dt['nama_petugas']; ?></a></h6></label>
            <p><?= $dt['tanggapan']; ?></p>
          </div>
          <div class="aksi">
            <a class="btn btn-secondary apa" href="index1.php?data_laporan_masyarakat">Kembali</a>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"><h6>Tanggapan </h6></label>
          <p>Belum Ada Tanggapan</p>
        </div>
        <div class="aksi">
          <a class="btn btn-secondary apa" href="index1.php?data_laporan_masyarakat">Kembali</a>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusL<?= $id_pengaduan; ?>">Hapus</button>
          <a class="btn btn-warning" href="index1.php?lapor_ubah&id_pengaduan=<?= $id_pengaduan; ?>">Ubah</a>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- Model Hapus -->
    <div class="modal fade" id="hapusL<?= $id_pengaduan; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="post">
            <div class="modal-body">
              Anda Yakin Ingin Hapus Laporan Ini ?
              <input type="hidden" name="id_pengaduan" value="<?=$id_pengaduan;?>">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
              <button type="submit" class="btn btn-dark" name="hapusL">Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <!-- Model Hapus -->
</div>