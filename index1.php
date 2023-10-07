<?php 
  if(!isset($_SESSION)) { 
    session_start(); 
  }
  require "koneksi.php";
  if(!isset($_SESSION['user'])){
    header('Location: index.php?login');
  }
  if($_SESSION['user']['level'] != "user"){
    header('Location: index.php?login');
  }
  $notif = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status != 'selesai' AND status != 'proses' ORDER BY id_pengaduan DESC");
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
  <body class="hal1">
    <div class="nav">
      <nav class="navbar ct1">
        <div class="container-fluid">
          <a class="navbar-brand" href="index2.php?beranda">E-Complain</a>
          <div class="btn-group">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="index1.php?profil">Profil</a></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </div>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" href="index1.php?beranda">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index1.php?beranda#tentang">Tentang</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index1.php?beranda#cara_penggunaan">Cara Penggunaan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index1.php?lapor">Lapor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index1.php?data_laporan_masyarakat">Lihat Laporan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index1.php?profil">Profil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <?php if(isset($_GET['beranda'] )) {?>
    <div class="atas">
      <h1>Website Pengaduan Masyarakat</h1>
      <h5>Sampaikan Aspirasi dan Laporan Anda, Untuk Membangun Negeri Ini!!</h5>
      <img src="gambar/IMG_20230207_191013.png" alt="IMG_20230207_191013.png" />
    </div>
    <?php } ?>
    <nav class="navbar ct2 index1">
      <div class="container-fluid">
        <ul class="">
          <li class="nav-item">
            <a class="nav-link" href="index1.php?beranda">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index1.php?beranda#tentang">Tentang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index1.php?beranda#cara_penggunaan">Cara Penggunaan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index1.php?lapor">Lapor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index1.php?data_laporan_masyarakat">Lihat Laporan</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="conten1">
      <?php
        if(isset($_GET['beranda'])){
          include 'beranda.php';
        } else if(isset($_GET['lapor'])) {
          include 'lapor.php';
        } else if(isset($_GET['lapor_ubah'])) {
          include 'lapor_ubah.php';
        } else if(isset($_GET['data_laporan_masyarakat'])) {
        include 'data_laporan_masyarakat.php';
        } else if(isset($_GET['detail_laporan_masyarakat'])) {
        include 'detail_laporan_masyarakat.php';
        } else if(isset($_GET['profil'])) {
        include 'profil.php';
        } else if(isset($_GET['profil_cek'])) {
        include 'profil_cek.php';
        } else {
          include 'beranda.php';
        }
      ?>
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