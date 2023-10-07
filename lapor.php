<?php
  $errjudul_laporan = $errjenis_laporan = $errisi_laporan = $errtgl_kejadian = $errtujuan = $errfoto = "";
  $tujuan = "---";
  $jenis_laporan = "---";
  $judul_laporan =  $isi_laporan = "";
  if(isset($_POST['lapor'])) {
    if(!empty($_FILES['foto']['name'])) {
      if($_FILES['foto']['size'] < 500000 ) {
      $rand = rand();
      $filename = $_FILES['foto']['name'];
      $foto = $rand.'_'.$filename;
      } else {
        $errfoto = "Ukuran file melebihi ketentuan";
      }
    } else {
      $foto = "";
    }
    $id_pengaduan = id('pengaduan', 'id_pengaduan', 'PD');
    $tgl_pengaduan = date('Y-m-d');
    $judul_laporan = cekInput($_POST['judul_laporan']);
    $jenis_laporan = cekInput($_POST['jenis_laporan']);
    $tgl_kejadian = $_POST['tgl_kejadian'];
    $tujuan = $_POST['tujuan'];
    $nik = $_SESSION['user']['nik'];
    $isi_laporan = cekInput($_POST['isi_laporan']);

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

    if(empty($errjudul_laporan) && empty($errfoto) && empty($errjenis_laporan) && empty($errtujuan) && empty($errtgl_kejadian) && empty($errisi_laporan)) {
      move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/'.$foto);
      $kirim = mysqli_query($conn, "INSERT INTO pengaduan 
      VALUES ('$id_pengaduan', '$tgl_pengaduan', '$nik', '$judul_laporan', '$jenis_laporan', '$tgl_kejadian', '$tujuan', '$isi_laporan', '$foto', '0','0')");
      if($kirim) {
        setFlash('success', 'Laporan Terkirim');
        //header('Location: index1.php?data_laporan_masyarakat');
        echo "<script> window.location.href='index1.php?data_laporan_masyarakat';</script>";
        exit;
      } else {
        setFlash('danger', 'Maaf Ada Kesalahan');
      }
    }
  }
?>
<div class="lapor">
  <h3>Buat Laporan</h3>
  <?php flash(); ?>
  <br>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form mb-3">
      <label for="judul_laporan">Judul Laporan :</label>
      <input value="<?= $judul_laporan; ?>" class="form-control <?= ($errjudul_laporan !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="judul_laporan" id="judul_laporan" type="text" aria-label=".form-control-sm example">
      <span class="warning"><?= $errjudul_laporan; ?></span>
    </div>
    <div class="form mb-3">
      <label for="jenis_laporan">Jenis Laporan :</label>
      <select class="form-select <?= ($errjenis_laporan !="" ? "is-invalid" : ""); ?>" aria-label="Default select example" name="jenis_laporan" id="jenis_laporan"  required>
        <option><?= $jenis_laporan; ?></option>
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
        <option><?= $tujuan; ?></option>
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
      <input value="<?= $tgl_kejadian; ?>" class="form-control <?= ($errtgl_kejadian !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="tgl_kejadian" id="tgl_kejadian" type="date" aria-label=".form-control-sm example">
      <span class="warning"><?= $errtgl_kejadian; ?></span>
    </div>
    <div class="form mb-3">
      <label for="isi_laporan">isi_laporan :</label>
      <textarea name="isi_laporan" class="form-control <?= ($errisi_laporan !="" ? "is-invalid" : ""); ?>" id="exampleFormControlTextarea1"><?= $isi_laporan; ?></textarea>
      <span class="warning"><?= $errisi_laporan; ?></span>
    </div>
    <div class="form mb-3">
      <label for="foto">Gambar :</label>
      <input class="form-control form-control-sm" name="foto" id="foto" type="file" aria-label=".form-control-sm example">
      <span class="">Ukuran file dibawah 500kb</span>
      <span class="warning"><?= $errfoto; ?></span>
    </div>
    <button type="submit" name="lapor" id="lapor" class="btn btn-dark">Kirim</button>
  </form>
</div>