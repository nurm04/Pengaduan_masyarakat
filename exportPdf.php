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
      $id_pengaduan = $_GET['id_pengaduan'];
      $query1 = mysqli_query($conn, "SELECT * FROM pengaduan 
        INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik
        LEFT JOIN tanggapan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
        LEFT JOIN petugas ON petugas.id_petugas = tanggapan.id_petugas
        WHERE pengaduan.id_pengaduan = '$id_pengaduan' ORDER BY pengaduan.id_pengaduan DESC
      ");
      $dt = mysqli_fetch_array($query1);
    ?>
    <div class="pdfLapor">
      <h1>Laporan<br>Pengaduan Masyarakat</h1>
      <div class="atas">
        <table>
          <tr>
            <td>NIK</td>
            <td>: <?= $dt['nik']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>: <?= $dt['nama']; ?></td>
          </tr>
          <tr>
            <td>Judul</td>
            <td>: <?= $dt['judul_laporan']; ?></td>
          </tr>
          <tr>
            <td>Jenis Laporan</td>
            <td>: <?= $dt['jenis_laporan']; ?></td>
          </tr>
          <tr>
            <td>Tujuan</td>
            <td>: <?= $dt['tujuan']; ?></td>
          </tr>
          <tr>
            <td>Tanggal Kejadian</td>
            <td>: <?= date('d F Y', strtotime($dt['tgl_kejadian'])); ?></td>
          </tr>
        </table>
      </div>
      <div class="isi">
        <?= $dt['isi_laporan']; ?>
        <?php if(!empty($dt['foto'])) {?>
          <img class="foto" src="upload/<?= $dt['foto']; ?>" alt="<?= $dt['foto']; ?>">
        <?php } ?>
      </div>
      <br><br>
      <?php if(isset($dt['id_tanggapan'])) {?>
        <div class="tanggapan">
          <p>Tanggapan: <?= $dt['id_petugas']; ?></p>
          <?= $dt['tanggapan']; ?>
        </div>
      <?php } else { ?>
        <div class="tanggapan">
          <p>Tanggapan:</p>
          <p>Tidak Ada Tanggapan</p>
        </div>
      <?php } ?>
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