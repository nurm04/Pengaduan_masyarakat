<?php 
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    require "koneksi.php";
    if(isset($_SESSION['user'])) {
      header('Location: logout.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"content="Source code generated using layoutit.com"/>
    <meta name="author" content="LayoutIt!" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="css/sweetalert2.min.css" />
    <title>E-Complain</title>
  </head>
  <body class="hal1">
    <div class="nav">
      <nav class="navbar ct1">
        <div class="container-fluid">
          <a class="navbar-brand" href="index2.php?beranda">E-Complain</a>
          <div class="settings apa">
            <a href="index.php?login">Masuk</a>
          </div>
        </div>  
      </nav>
    </div>

    <div class="atas" id="home">
      <h1>Website Pengaduan Masyarakat</h1>
      <h5>Sampaikan Aspirasi dan Laporan Anda, Untuk Membangun Negeri Ini!!</h5>
      <img src="gambar/IMG_20230207_191013.png" alt="IMG_20230207_191013.png"/>
    </div>

    <nav class="navbar ct2">
      <div class="container-fluid">
        <ul class="">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#tentang">Tentang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#cara_penggunaan">Cara Penggunaan</a>
          </li>
        </ul>
      </div>
    </nav>
      
    <div class="conten">
      <div class="tentang" id="tentang">
        <h3>Tentang</h3>
        <div class="text">
          <h4>Layanan Pengaduan Masyarakat</h4>
          <p>Pengaduan masyarakat adalah penyampaian keluhan oleh masyarakat kepada pemerintah atas pelayanan yang tidak sesuai dengan standar pelayanan, atau pengabaian kewajiban dan/atau pelanggaran larangan</p>
        </div>
        <img src="gambar/20230128_210047.png" alt="20230128_210047.png"/>
      </div>

      <div class="tutor" id="cara_penggunaan">
      <h3>Tata Cara Penggunaan</h3>
      <div class="kotak">
        <i class="fa-solid fa-right-to-bracket"></i>
        <h6>Masuk</h6>
        <p>Masuk dengan akun Anda yang sudah terdaftar, jika belum registrasi, klik Registrasi</p>
      </div>
      <i class="fa-solid fa-caret-right"></i>
      <div class="kotak">
        <i class="fa-solid fa-exclamation"></i>
        <h6>Pengaduan</h6>
        <p>Pada Bagian navbar klik menu Lapor untuk membuat laporan pengaduan</p>
      </div>
      <i class="fa-solid fa-caret-right"></i>
      <div class="kotak">
        <i class="fa-solid fa-reply"></i>
        <h6>Tanggapan</h6>
        <p>Pada bagian navbar klik menu Lihat Laporan untuk melihat seluruh pengaduan yang telah Anda buat untuk melihat tanggapan petugas, klik tombol Detail</p>
      </div>
      </div>
    </div>

    <div class="footer">
      <p>nurm892709@gmail.com</p>
    </div>

    <?php
      if(isset($_GET['login'])) {
        $Lerrusername = $Lerrpassword = "";
        $Lusername = $Lpassword = "";
        if(isset($_POST['masuk'])) {
          $Lusername = cekInput($_POST['Lusername']);
          $Lpassword = cekInput($_POST['Lpassword']);

          if(empty($Lusername)) {
            $Lerrusername = "Form username kosong";
          }

          if(empty($Lpassword)) {
            $Lerrpassword = "Form password kosong";
          }

          if(empty($Lerrusername) && empty($Lerrpassword)) {
            $cariM = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username = '$Lusername'");
            $cariP = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$Lusername'");
            $Lpass = md5($Lpassword);
            if(mysqli_num_rows($cariM) > 0 ){
              $rCariM = mysqli_fetch_array($cariM);
              if($Lpass == $rCariM['password']) {
                $_SESSION['user'] = $rCariM;
                $_SESSION['user']['level'] = "user";
                header('Location: index1.php?lapor');
                exit;
              } else {
                $Lerrpassword = "Password salah";
              }
            } else if(mysqli_num_rows($cariP) > 0 ) {
              $rCariP = mysqli_fetch_array($cariP);
              if($Lpass == $rCariP['password']) {
                $_SESSION['user'] = $rCariP;
                header('Location: index2.php');
                exit;
              } else {
                $Lerrpassword = "Password salah";
              }
            } else {
              $Lerrusername = "Username tidak ada";
            }
          }
        }
    ?>
    <div class="login">
      <div class="kotak ct2">
        <a href="index.php" class="kembali">Kembali</a>
        <center>
        <h2>Masuk</h2>
        <?php flash(); ?>
        <form action="" method="post">
          <div class="form mb-3">
            <label for="Lusername">Username :</label>
            <input value="<?= $Lusername; ?>" class="form-control <?= ($Lerrusername !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="Lusername" id="Lusername" type="text" aria-label=".form-control-sm example">
            <span class="warning"><?= $Lerrusername; ?></span>
          </div>
          <div class="form mb-3">
            <label for="Lpassword">Password :</label>
            <input value="<?= $Lpassword; ?>" class="form-control <?= ($Lerrpassword !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="Lpassword" id="Lpassword" type="password" aria-label=".form-control-sm example">
            <span class="warning"><?= $Lerrpassword; ?></span>
          </div>
          <button type="submit" name="masuk" id="masuk" class="btn btn-dark">Masuk !</button>
        </form>
        </center>
        <p>Belum Punya Akun ? <a href="index.php?register">Register</a></p>
      </div>
      <a href="index.php"></a>
    </div>
      
    <?php
      }
      if(isset($_GET['register'])) {
        $nik = $nama = $username = $password = $telp = "";
        $errnik = $errnama = $errusername = $errpassword = $errtelp = "";
        if(isset($_POST['register'])) {
          $nik = cekInput($_POST['nik']);
          $nama = cekInput($_POST['nama']);
          $username = cekInput($_POST['username']);
          $password = cekInput($_POST['password']);
          $telp = $_POST['telp'];

          if(!empty($nik)) {
            if(preg_match("/^[0-9]*$/",$nik)) {
              if(strlen($nik) == 16 ) {
                $errnik = "";
              } else {
                $errnik = "Jumlah input harus 16";
              }
            } else {
              $errnik = "Inputan hanya boleh angka";
            }
          } else {
            $errnik = "Form NIK kosong";
          }

          if(!empty($nama)) {
            if(!preg_match("/^[a-zA-Z ]*$/",$nama)) {
              $errnama = "Inputan hanya boleh huruf";
            }
          } else {
            $errnama = "Form Nama kosong";
          }

          if(empty($username)) {
            $errusername = "Form username kosong";
          }

          if(empty($password)) {
            $errpassword = "Form password kosong";
          }

          if(!empty($telp)) {
            if(preg_match("/^[0-9]*$/",$telp)) {
              if(strlen($telp) <= 13 && strlen($telp) >= 11 ) {
                $errtelp = "";
              } else {
                $errtelp = "Jumlah input tidak sesuai";
              }
            } else {
              $errtelp = "Inputan hanya boleh angka";
            }
          } else {
            $errtelp = "Form No Handphone kosong";
          }

          if(empty($errnik) && empty($errnama) && empty($errusername) && empty($errpassword) && empty($errtelp)) {
            $cari = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
            if(!mysqli_num_rows($cari)) {
              if(cekUsername($username) == 0) {
                $pass = md5($password);
                $kirim = mysqli_query($conn, "INSERT INTO masyarakat
                VALUES ('$nik', '$nama', '$username', '$pass', '$telp')");
                if($kirim) {
                  setFlash('success', 'Registrasi Berhasil');
                  header('Location: index.php?login');
                  exit;
                } else {
                  setFlash('danger', 'Maaf Ada Kesalahan');
                } 
              } else {
                $errusername = "Username sudah ada";
              }
            } else {
              $errnik = "NIK sudah terdaftar";
            }
          }
        }
    ?>
    <div class="register">
      <div class="kotak ct2">
        <center>
        <h2>Registrasi</h2>
        <?php flash(); ?>
        <form action="" method="post">
          <div class="form mb-3">
            <label for="nik">NIK :</label>
            <input value="<?= $nik; ?>" class="form-control <?= ($errnik !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="nik" id="nik" type="text" aria-label=".form-control-sm example">
            <span class="warning"><?= $errnik; ?></span>
          </div>
          <div class="form mb-3">
            <label for="nama">Nama :</label>
            <input value="<?= $nama; ?>" class="form-control <?= ($errnama !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="nama" id="nama" type="text" aria-label=".form-control-sm example">
            <span class="warning"><?= $errnama; ?></span>
          </div>
          <div class="form mb-3">
            <label for="username">Username :</label>
            <input value="<?= $username; ?>" class="form-control <?= ($errusername !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="username" id="username" type="text" aria-label=".form-control-sm example">
            <span class="warning"><?= $errusername; ?></span>
          </div>
          <div class="form mb-3">
            <label for="password">Password :</label>
            <input value="<?= $password; ?>" class="form-control <?= ($errpassword !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="password" id="password" type="password" aria-label=".form-control-sm example">
            <span class="warning"><?= $errpassword; ?></span>
          </div>
          <div class="form mb-3">
            <label for="telp">No Handphone :</label>
            <input value="<?= $telp; ?>" class="form-control <?= ($errtelp !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="telp" id="telp" type="text" aria-label=".form-control-sm example">
            <span class="warning"><?= $errtelp; ?></span>
          </div>
          <button type="submit" name="register" id="register" class="btn btn-dark">Register !</button>
        </form>
        </center>
        <p>Sudah Punya Akun ? <a href="index.php?login">Login</a></p>
      </div>
      <a href="index.php"></a>
    </div>
    <?php } ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="login.php"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/jquery.min(1).js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
