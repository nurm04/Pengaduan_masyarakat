<?php 
  $nik = $_SESSION['user']['nik'];
  $nama = $_SESSION['user']['nama'];
  $username = $_SESSION['user']['username'];
  $telp = $_SESSION['user']['telp'];
  $passNew = $password = "";
  $errnik = $errnama = $errusername = $errpassword = $errpassNew = $errtelp = "";
  if(isset($_POST['UbahUser'])) {
    $nik_lama = $_POST['nik_lama'];
    $nik = cekInput($_POST['nik']);
    $nama = cekInput($_POST['nama']);
    $username = cekInput($_POST['username']);
    $password = cekInput($_POST['password']);
    $passNew = cekInput($_POST['passNew']);
    $telp = cekInput($_POST['telp']);
    $cari = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik_lama'");
    $data_lama = mysqli_fetch_array($cari);
    if(!empty($password)) {
      if(md5($password) !== $data_lama['password']) {
        $errpassword = "Password Lama salah";
      }

      if(!empty($nik)) {
        if($nik !== $data_lama['nik']) {
          if(preg_match("/^[0-9]*$/",$nik)) {
            if(strlen($nik) == 16 ) {
              $cekNik = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
              if(mysqli_num_rows($cekNik) > 0) {
                $errnik = "NIK sudah ada";
              }
            } else {
              $errnik = "Jumlah input harus 16";
            }
          } else {
            $errnik = "Inputan hanya boleh angka";
          }
        }
      } else {
        $errnik = "Form NIK kosong";
      }

      if(!empty($nama)) {
        if($nama !== $data_lama['nama']) {
          if(!preg_match("/^[a-zA-Z ]*$/",$nama)) {
            $errnama = "Inputan hanya boleh huruf";
          }
        }
      } else {
        $errnama = "Form Nama kosong";
      }

      if(!empty($telp)) {
        if($telp !== $data_lama['telp']) {
          if(!preg_match("/^[0-9]*$/",$telp)) {
            $errtelp = "Inputan hanya boleh angka";
          }
        }
      } else {
        $errtelp = "Form No Handphone kosong";
      }

      if(!empty($username)) {
        if($username !== $data_lama['username']) {
          if(cekUsername($username) > 0) {
            $errusername = "Username sudah ada";
          }
        }
      } else {
        $errusername = "Username kosong";
      }
      

      if(!empty($passNew)) {
        $pass = md5($passNew);
      } else {
        $pass = md5($password);
      }
      if(empty($errnik) && empty($errnama) && empty($errusername) && empty($errpassword) && empty($errpassNew) && empty($errtelp)) {
        $ubah = mysqli_query($conn, "UPDATE masyarakat SET nik='$nik', nama='$nama', username='$username', password='$pass', telp='$telp' WHERE nik='$nik_lama'");
        $ubah .= mysqli_query($conn, "UPDATE pengaduan SET nik='$nik' WHERE nik='$nik_lama'");
        if($ubah) {
          $_SESSION['user']['nik'] = $nik;
          $_SESSION['user']['nama'] = $nama;
          $_SESSION['user']['username'] = $username;
          $_SESSION['user']['password'] = $pass;
          $_SESSION['user']['telp'] = $telp;
          setFlash('success', 'Data Berhasil Diubah');
          header('Location: index1.php?profil');
          exit;
        } else {
          setFlash('danger', 'Data Gagal Diubah');
          header('Location: index1.php?profil');
          exit;
        }
      }
    } else {
      $errpassword = "Password Lama tidak boleh kosong";
    }
  }
?>
<div class="profil">
  <?php flash(); ?>
  <div class="kotak">
    <form action="" method="post">
      <input type="hidden" name="nik_lama" value="<?= $_SESSION['user']['nik']; ?>">
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
        <label for="telp">No Handphone :</label>
        <input value="<?= $telp; ?>" class="form-control <?= ($errtelp !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="telp" id="telp" type="text" aria-label=".form-control-sm example">
        <span class="warning"><?= $errtelp; ?></span>
      </div>
      <div class="form mb-3">
        <label for="password">Password Lama :</label>
        <input value="<?= $password; ?>" class="form-control <?= ($errpassword !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="password" id="password" type="password" aria-label=".form-control-sm example">
        <span class="warning"><?= $errpassword; ?></span>
      </div>
      <div class="form mb-3">
        <label for="passNew">Password Baru :</label>
        <input value="<?= $passNew; ?>" class="form-control <?= ($errpassNew !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="passNew" id="passNew" type="passNew" aria-label=".form-control-sm example">
        <span class="warning"><?= $errpassNew; ?></span>
      </div>
      <button type="submit" class="btn btn-dark" name="UbahUser">Ubah</button>
    </form>
  </div>
</div>