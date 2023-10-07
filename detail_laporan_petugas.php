<?php
  $id = isset($_GET['id'])? "&id=" . $_GET['id']:"";
  $hal = !empty($_GET['id'])?$_GET['hal'] . $id:$_GET['hal'];
  if(isset($_POST['ubah'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $id_tanggapan = $_POST['id_tanggapan'];
    $tanggapan = cekInput($_POST['tanggapan']);
    $status = "selesai";
    if(!empty($tanggapan)) {
      $kirim = mysqli_query($conn, "UPDATE tanggapan SET tanggapan = '$tanggapan' WHERE id_tanggapan = '$id_tanggapan'");
      $kirim .= mysqli_query($conn, "UPDATE pengaduan SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'");
    } else {
      $kirim = mysqli_query($conn, "UPDATE pengaduan SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'");
    }
    if($kirim) {
      setFlash('success', 'Laporan Selesai');
    } else {
      setFlash('danger', 'Maaf Ada kesalahan');
    }
  }
  if(isset($_POST['hapus'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $kirim = mysqli_query($conn, "DELETE FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'");
    $kirim .= mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'");
    if($kirim) {
      setFlash('success', 'Laporan Berhasil Dihapus');
      header("Location: index2.php?$hal");
      exit;
    } else {
      setFlash('danger', 'Laporan Gagal Dihapus');
    }
  }
  if(isset($_POST['balas'])) {
    $id_tanggapan = id('tanggapan', 'id_tanggapan', 'TG');
    $id_pengaduan = $_POST['id_pengaduan'];
    $tgl_tanggapan = date('Y-m-d');
    $tanggapan = cekInput($_POST['tanggapan']);
    $id_petugas = $_SESSION['user']['id_petugas'];
    $status = $_POST['status'];

    if(!empty($tanggapan) && !empty($status)) {
      $kirim = mysqli_query($conn, "UPDATE pengaduan SET 
      status = '$status' WHERE id_pengaduan = '$id_pengaduan'");
      $kirim .= mysqli_query($conn, "INSERT INTO tanggapan 
      VALUES ('$id_tanggapan', '$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')");
      if($kirim) {
        setFlash('success', 'Tanggapan Terkirim');
      } else {
        setFlash('danger', 'Maaf Ada Kesalahan');
      }
    } else {
      setFlash('danger', 'Isi Form dengan lengkap');
    }
  }
  if(isset($_POST['verifikasiL'])) {
    $ver = $_POST['verifikasiL'];
    $id_pengaduan = $_POST['id_pengaduan'];
    $id_tanggapan = id('tanggapan', 'id_tanggapan', 'TG');
    $tgl_tanggapan = date('Y-m-d');
    $id_petugas = $_SESSION['user']['id_petugas'];
    if($ver == "tidak") {
      $verL = mysqli_query($conn, "UPDATE pengaduan SET verifikasi = '$ver' WHERE id_pengaduan = '$id_pengaduan'");
      $verL .= mysqli_query($conn, "INSERT INTO tanggapan
      VALUES ('$id_tanggapan', '$id_pengaduan', '$tgl_tanggapan', '', '$id_petugas')");
    } else {
      $verL = mysqli_query($conn, "UPDATE pengaduan SET verifikasi = '$ver' WHERE id_pengaduan = '$id_pengaduan'");
    }
    if($verL) {
      setFlash('success', 'Laporan Ditolak');
    } else {
      setFlash('danger', 'Laporan Diterima');
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
      <h6>Laporan: <a href="index2.php?profil_cek&nik=<?= $dt['nik']; ?>&a=<?= $id_pengaduan; ?>&hal=<?= $hal; ?>" class="profil_cek"><?= $dt['nama']; ?></a></h6>
      <div class="atass">
        <?php if($_SESSION['user']['level'] == "admin") {?>
          <a class="btn btn-dark pdf" href="exportPdf.php?id_pengaduan=<?= $id_pengaduan; ?>"><i class="fa-solid fa-file-pdf"></i></a>
        <?php } ?>
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
      <?php if($dt['verifikasi'] !== "tidak") { ?>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"><h6>Tanggapan : <a href="index2.php?profil_cek&id_petugas=<?= $dt['id_petugas']; ?>&a=<?= $id_pengaduan; ?>&hal=<?= $hal; ?>"><?= $dt['nama_petugas']; ?></a></h6></label>
          <p><?= $dt['tanggapan']; ?></p>
        </div>
      <?php 
        if($dt['status'] == "proses") {
          if($_SESSION['user']['id_petugas'] == $dt['id_petugas']) {
      ?>
        <form action="" method="post">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label"><h6>Tanggapan : <a href="index2.php?profil_cek&id_petugas=<?= $dt['id_petugas']; ?>&a=<?= $id_pengaduan; ?>&hal=<?= $hal; ?>"><?= $dt['nama_petugas']; ?></a></h6></label>
            <textarea name="tanggapan" class="form-control" id="exampleFormControlTextarea1"></textarea>
            <input type="hidden" name="id_tanggapan" value="<?= $dt['id_tanggapan']; ?>">
            <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan; ?>">
          </div>
          <div class="aksi">
            <button type="submit" class="btn btn-dark" name="ubah">Selesai</button>
            <a class="btn btn-secondary apa" href="index2.php?<?= $hal; ?>">Kembali</a>
            <?php if($_SESSION['user']['level'] == "admin") {?>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $id_pengaduan; ?>">Hapus</button>
            <?php } ?>
          </div>
        </form>
      <?php } } ?>
        <div class="aksi">
          <a class="btn btn-secondary apa" href="index2.php?<?= $hal; ?>">Kembali</a>
          <?php if($_SESSION['user']['level'] == "admin") {?>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $id_pengaduan; ?>">Hapus</button>
          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">
            <h6> 
              Laporan Ditolak<br>Oleh: 
              <a href="index2.php?profil_cek&id_petugas=<?= $dt['id_petugas']; ?>&a=<?= $id_pengaduan; ?>&hal=<?= $hal; ?>"><?= $dt['nama_petugas']; ?></a>
            </h6>
          </label>
        </div>
        <div class="aksi">
          <a class="btn btn-secondary apa" href="index2.php?<?= $hal; ?>">Kembali</a>
          <?php if($_SESSION['user']['level'] == "admin") {?>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $id_pengaduan; ?>">Hapus</button>
          <?php } ?>
        </div>
      <?php } ?>
      <?php } else { ?>
      <?php if($dt['verifikasi'] == "ya") {?>
        <div class="tanggapan">
          <form action="" method="post">
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label"><h6>Tanggapan : <a href="index2.php?profil_cek&id_petugas=<?= $dt['id_petugas']; ?>&a=<?= $id_pengaduan; ?>&hal=<?= $hal; ?>"><?= $dt['nama_petugas']; ?></a></h6></label>
              <textarea name="tanggapan" class="form-control" id="exampleFormControlTextarea1"></textarea>
              <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan; ?>">
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="proses" name="status" id="status1">
              <label class="form-check-label" for="status1">Proses</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="selesai" name="status" id="status2">
              <label class="form-check-label" for="status2">Selesai</label>
            </div>
            <div class="aksi">
              <button type="submit" class="btn btn-dark" name="balas">Kirim</button>
              <a class="btn btn-secondary apa" href="index2.php?<?= $hal; ?>">Kembali</a>
              <?php if($_SESSION['user']['level'] == "admin") {?>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $id_pengaduan; ?>">Hapus</button>
              <?php } ?>
            </div>
          </form>
        </div>
      <?php } else { ?>
        <form action="" method="post">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label"><h6>Verifikasi Laporan:</h6></label>
            <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan; ?>">
          </div>
          <div class="aksi1">
            <button type="submit" name="verifikasiL" class="btn btn-dark apa" value="tidak">Tidak</button>
            <button type="submit" name="verifikasiL" class="btn btn-dark apa" value="ya">Ya</button>
          </div>
        </form>
        <div class="aksi">
          <a class="btn btn-secondary apa" href="index2.php?<?= $hal; ?>">Kembali</a>
          <?php if($_SESSION['user']['level'] == "admin") {?>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $id_pengaduan; ?>">Hapus</button>
          <?php } ?>
        </div>
      <?php } } ?>
    </div>
  </div>
  <!-- Model Hapus -->
    <div class="modal fade" id="hapus<?= $id_pengaduan; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <button type="submit" class="btn btn-dark" name="hapus">Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <!-- Model Hapus -->
</div>