<?php 
  if(!isset($_SESSION)) { 
    session_start(); 
  }
  require "koneksi.php";
  if(!isset($_SESSION['user'])){
    header('Location: index.php?login');
  }
  if($_SESSION['user']['level'] == "user"){
    header('Location: index.php?login');
  }
  $_SESSION['hal'] = "index2.php";
  $notif = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status != 'selesai' AND status != 'proses' AND pengaduan.verifikasi != 'tidak' ORDER BY id_pengaduan DESC");
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

    <div class="nav">
      <nav class="navbar ct2 position-fixed top-0">
        <div class="container-fluid">
          <a class="navbar-brand" href="index2.php?dashboard">E-Complain</a>
          <div class="btn-group">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="index2.php?profil_petugas">Profil</a></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <div class="sidebar bg-dark position-fixed">
      <ul>
        <a class="list" href="index2.php?dashboard">
          <i class="fa-solid fa-house"></i>
          <li>Dashboard</li>
        </a>
        <?php if($_SESSION['user']['level'] == "admin") {?>
          <p>
            <a class="list" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              <i class="apa fa-solid fa-file"></i>Data User
            </a>
          </p>
          <div class="collapse" id="collapseExample">
            <div class="card card-body">
              <ul>
                <li><a href="index2.php?data_masyarakat">Data Masyarakat</a></li>
                <li><a href="index2.php?data_petugas">Data Petugas</a></li>
              </ul>
            </div>
          </div>
          <a href="index2.php?laporan_masuk" class="list position-relative">
            <i class="fa-solid fa-file-lines"></i>
            <li>Laporan Masuk
              <?php if(mysqli_num_rows($notif) > 0 ){ ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= mysqli_num_rows($notif); ?>
              <span class="visually-hidden">unread messages</span>
              <?php } ?>
            </li>
          </a>
          <a href="index2.php?data_laporan_petugas" class="list">
            <i class="fa-solid fa-file-lines"></i>
            <li>Data Laporan</li>
          </a>
          <a href="index2.php?data_semua_laporan" class="list">
            <i class="fa-solid fa-file-lines"></i>
            <li>Data Semua Laporan</li>
          </a>
        <?php } else {?>
          <a href="index2.php?laporan_masuk" class="list position-relative">
            <i class="fa-solid fa-file-lines"></i>
            <li>Laporan Masuk
              <?php if(mysqli_num_rows($notif) > 0 ){ ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= mysqli_num_rows($notif); ?>
              <span class="visually-hidden">unread messages</span>
              <?php } ?>
            </li>
          </a>
          <a href="index2.php?data_laporan_petugas" class="list">
            <i class="fa-solid fa-file-lines"></i>
            <li>Data Laporan</li>
          </a>
        <?php } ?>
      </ul>
    </div>

    <div class="conten2">
      <?php
        if($_SESSION['user']['level'] == "petugas") {
          if(isset($_GET['dashboard'])){
            include 'dashboard.php';
          } else if(isset($_GET['laporan_masuk'])) {
          include 'laporan_masuk.php';
          } else if(isset($_GET['data_laporan_petugas'])) {
          include 'data_laporan_petugas.php';
          } else if(isset($_GET['detail_laporan_petugas'])) {
          include 'detail_laporan_petugas.php';
          } else if(isset($_GET['profil_petugas'])) {
          include 'profil_petugas.php';
          } else if(isset($_GET['profil_cek'])) {
          include 'profil_cek.php';
          } else {
            include 'dashboard.php';
          }
        } else {
          if(isset($_GET['dashboard'])){
            include 'dashboard.php';
          } else if(isset($_GET['data_masyarakat'])) {
          include 'data_masyarakat.php';
          } else if(isset($_GET['data_petugas'])) {
          include 'data_petugas.php';
          } else if(isset($_GET['laporan_masuk'])) {
          include 'laporan_masuk.php';
          } else if(isset($_GET['data_laporan_petugas'])) {
          include 'data_laporan_petugas.php';
          } else if(isset($_GET['data_semua_laporan'])) {
          include 'data_semua_laporan.php';
          } else if(isset($_GET['detail_laporan_petugas'])) {
          include 'detail_laporan_petugas.php';
          } else if(isset($_GET['laporan_data_masyarakat'])) {
          include 'laporan_data_masyarakat.php';
          } else if(isset($_GET['laporan_data_petugas'])) {
          include 'laporan_data_petugas.php';
          } else if(isset($_GET['profil_petugas'])) {
          include 'profil_petugas.php';
          } else if(isset($_GET['profil_cek'])) {
          include 'profil_cek.php';
          } else {
            include 'dashboard.php';
          }
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