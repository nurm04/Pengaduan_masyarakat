<?php 
  require "koneksi.php";
  if(!isset($_SESSION)) { 
    session_start(); 
  }
  require_once __DIR__ . '/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf();
  ob_start(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Source code generated using layoutit.com"/>
    <meta name="author" content="LayoutIt!" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <title>E-Complain</title>
  </head>
  <body>
    <?php
      if(isset($_POST['cetakPdf'])) {
        $dari = $_POST['tgl_dari'];
        $sampai = $_POST['tgl_sampai'];
        if(!empty($dari) && !empty($sampai)) {
          $query1 = mysqli_query($conn, "SELECT * FROM pengaduan 
            INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik 
            LEFT JOIN tanggapan ON pengaduan.id_pengaduan = tanggapan.id_pengaduan
            LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas
            WHERE tgl_pengaduan BETWEEN '$dari' AND '$sampai' AND pengaduan.verifikasi != 'tidak' ORDER BY pengaduan.id_pengaduan ASC
          ");
        } else {
          $query1 = mysqli_query($conn, "SELECT * FROM pengaduan 
            INNER JOIN masyarakat ON masyarakat.nik = pengaduan.nik 
            LEFT JOIN tanggapan ON pengaduan.id_pengaduan = tanggapan.id_pengaduan
            LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas
            WHERE pengaduan.verifikasi != 'tidak' ORDER BY pengaduan.id_pengaduan ASC
          ");
        }
      }
    ?>
    <div class="pdfLaporUser">
      <h1>Laporan<br>Pengaduan Masyarakat</h1>
      <?php if(!empty($dari) && !empty($sampai)) { ?>
      <p>Dari Tanggal <?= date('d F Y', strtotime($dari)); ?> Sampai <?= date('d F Y', strtotime($sampai)); ?></p>
      <?php } else { ?>
        <p>Semua Data Laporan</p>
      <?php } ?>
      <div class="isi">
        <table>
          <thead>
            <tr>
              <th scope="col">NO</th>
              <th scope="col">Judul</th>
              <th scope="col">Tanggal Laporan</th>
              <th scope="col">Judul Laporan</th>
              <th scope="col">Jenis Laporan</th>
              <th scope="col">Tujuan</th>
              <th scope="col">Tanggal Kejadian</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 1;
              if(mysqli_num_rows($query1)) {
                foreach($query1 as $dt) {
            ?>
            <tr>
              <th rowspan="5"><p><?= $no++; ?></p></th>
              <td><p><?= $dt['judul_laporan']; ?></p></td>
              <td><p><?= date('d-m-Y', strtotime($dt['tgl_pengaduan'])); ?></p></td>
              <td><p><?= $dt['judul_laporan']; ?></p></td>
              <td><p><?= $dt['jenis_laporan']; ?></p></td>
              <td><p><?= $dt['tujuan']; ?></p></td>
              <td><p><?= date('d-m-Y', strtotime($dt['tgl_kejadian'])); ?></p></td>
            </tr>
            <tr>
              <th colspan="6">Isi Laporan</th>
            </tr>
            <tr>
              <td colspan="6"><p><?= $dt['isi_laporan']; ?></p></td>
            </tr>
            <tr>
              <th colspan="6">gambar</th>
            </tr>
            <tr>
              <?php if(!empty($dt['foto'])) {?>
                <td colspan="6"><img class="foto" src="upload/<?= $dt['foto']; ?>" alt="<?= $dt['foto']; ?>"></td>
              <?php } else { ?>
                <td colspan="6">tidak gambar</td>
              <?php } ?>
            </tr>
            <?php } } else {?>
            <tr><td colspan="6"><center>Data Kosong</center></td></tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.min(1).js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  $html = ob_get_contents(); 
  ob_end_clean();
  $mpdf->WriteHTML(utf8_encode($html));
  $mpdf->Output("datapajak.pdf" ,'I');
?>