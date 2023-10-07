<?php
  $id_pengaduan = $_GET['id_pengaduan'];
  $errjudul_laporan = $errjenis_laporan = $errisi_laporan = $errtgl_kejadian = $errtujuan = "";
  if(isset($_POST['laporU'])) {
    $tujuan = "---";
    $jenis_laporan = "---";
    $judul_laporan =  $isi_laporan = "";
    $rand = rand();
    $filename = $_FILES['foto']['name'];
    if(!empty($_FILES['foto']['name'])) {
      $foto = $rand.'_'.$filename;
      move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/'.$foto);
    } else {
      $foto = "";
    }
    $id_pengaduan = $_POST['id_pengaduan'];
    $judul_laporan = cekInput($_POST['judul_laporan']);
    $jenis_laporan = cekInput($_POST['jenis_laporan']);
    $tgl_kejadian = $_POST['tgl_kejadian'];
    $tujuan = $_POST['tujuan'];
    $isi_laporan = cekInput($_POST['isi_laporan']);
    $status = "0";

    if(empty($judul_laporan)) {
      $errjudul_laporan = "Form Judul Laporan tidak boleh kosong";
    }
    if(empty($jenis_laporan)) {
      $errjenis_laporan = "Form Jenis Laporan tidak boleh kosong";
    }
    if($tujuan == "---") {
      $errtujuan = "Pilih Tujuan Laporan Anda";
    }
    if(empty($tgl_kejadian)) {
      $errtgl_kejadian = "Form Tanggal Kejadian Laporan tidak boleh kosong";
    }
    if(empty($isi_laporan)) {
      $errisi_laporan = "Form Isi Laporan tidak boleh kosong";
    }

    if(empty($errjudul_laporan) && empty($errjenis_laporan) && empty($errtujuan) && empty($errtgl_kejadian) && empty($errisi_laporan)) {
      $ubah = mysqli_query($conn, "UPDATE pengaduan SET judul_laporan='$judul_laporan',jenis_laporan='$jenis_laporan',tgl_kejadian='$tgl_kejadian',tujuan='$tujuan',isi_laporan='$isi_laporan',foto='$foto' WHERE id_pengaduan = '$id_pengaduan'");
      if($ubah) {
        setFlash('success', 'Laporan Berhasil Diubah');
      } else {
        setFlash('danger', 'Maaf Ada Kesalahan');
      }
    }
  }
  $query = mysqli_query($conn, "SELECT * FROM pengaduan 
    INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
    WHERE pengaduan.id_pengaduan = '$id_pengaduan'
  ");
  $dt = mysqli_fetch_array($query);
?>
<div class="lapor">
  <h3>Buat Laporan</h3>
  <?php flash(); ?>
  <br>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan; ?>">
    <input type="hidden" name="tgl_pengaduan" value="<?= $dt['tgl_pengaduan']; ?>">
    <div class="form mb-3">
      <label for="judul_laporan">Judul Laporan :</label>
      <input value="<?= isset($judul_laporan)?$judul_laporan:$dt['judul_laporan']; ?>" class="form-control <?= ($errjudul_laporan !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="judul_laporan" id="judul_laporan" type="text" aria-label=".form-control-sm example">
      <span class="warning"><?= $errjudul_laporan; ?></span>
    </div>
    <div class="form mb-3">
      <label for="jenis_laporan">Jenis Laporan :</label>
      <select class="form-select <?= ($errjenis_laporan !="" ? "is-invalid" : ""); ?>" aria-label="Default select example" name="jenis_laporan" id="jenis_laporan"  required>
        <option><?= isset($jenis_laporan)?$jenis_laporan:$dt['jenis_laporan']; ?></option>
        <option value="KDRT">KDRT</option>
        <option value="Kriminal">Kriminal</option>
        <option value="Bencana Alam">Bencana Alam</option>
        <option value="Keluhan Masyarakat">Keluhan Masyarakat</option>
      </select>
      <span class="warning"><?= $errjenis_laporan; ?></span>
    </div>
    <div class="form mb-3">
      <label for="tujuan">Tujuan :</label>
      <select class="form-select <?= ($errtujuan !="" ? "is-invalid" : ""); ?>" aria-label="Default select example" name="tujuan" id="tujuan"  required>
        <option><?= isset($tujuan)?$tujuan:$dt['tujuan']; ?></option>
        <option value="Kepolisian Republik Indonesia">Kepolisian Republik Indonesia</option>
        <option value="Badan Meteorologi, Klimatologi, dan Geofisika">Badan Meteorologi, Klimatologi, dan Geofisika</option>
        <option value="Komisi Yudisial">Komisi Yudisial</option>
        <option value="Kejaksaan Agung">Kejaksaan Agung</option>
        <option value="Badan Pemeriksaan Keuangan">Badan Pemeriksaan Keuangan</option>
        <option value="Kesekretariatan Lembaga Negara">Kesekretariatan Lembaga Negara</option>
        <option value="Kementrian PUPR">Kementrian PUPR</option>
      </select>
      <span class="warning"><?= $errtujuan; ?></span>
    </div>
    <div class="form mb-3">
      <label for="tgl_kejadian">Tanggal Kejadian :</label>
      <input value="<?= isset($tgl_kejadian)?$tgl_kejadian:$dt['tgl_kejadian']; ?>" class="form-control <?= ($errtgl_kejadian !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="tgl_kejadian" id="tgl_kejadian" type="date" aria-label=".form-control-sm example">
      <span class="warning"><?= $errtgl_kejadian; ?></span>
    </div>
    <div class="form mb-3">
      <label for="isi_laporan">isi_laporan :</label>
      <textarea name="isi_laporan" class="form-control <?= ($errisi_laporan !="" ? "is-invalid" : ""); ?>" id="exampleFormControlTextarea1"><?= isset($isi_laporan)?$isi_laporan:$dt['isi_laporan']; ?></textarea>
      <span class="warning"><?= $errisi_laporan; ?></span>
    </div>
    <div class="form mb-3">
      <label for="foto">Gambar :</label>
      <input class="form-control form-control-sm" name="foto" id="foto" type="file" aria-label=".form-control-sm example">
      <!-- <span class="warning">upload Gambar ulang</span> -->
    </div>
    <button type="submit" name="laporU" id="laporU" class="btn btn-dark">Ubah</button>
    <a href="index1.php?detail_laporan_masyarakat&id_pengaduan=<?= $id_pengaduan; ?>" class="btn btn-secondary">Kembali</a>
  </form>
</div>