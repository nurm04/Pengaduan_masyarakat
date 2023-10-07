<?php 
  $nama_petugas = $_SESSION['user']['nama_petugas'];
  $username = $_SESSION['user']['username'];
  $telp = $_SESSION['user']['telp'];
  $passNew = $password = "";
  $errnik = $errnama_petugas = $errusername = $errpassword = $errpassNew = $errtelp = "";
  if(isset($_POST['UbahPetugas'])) {
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = cekInput($_POST['nama_petugas']);
    $username = cekInput($_POST['username']);
    $password = cekInput($_POST['password']);
    $passNew = cekInput($_POST['passNew']);
    $telp = cekInput($_POST['telp']);
    $cari = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$id_petugas'");
    $data_lama = mysqli_fetch_array($cari);
    if(!empty($password)) {
      if(md5($password) !== $data_lama['password']) {
        $errpassword = "Password Lama salah";
      }

      if(!empty($nama_petugas)) {
        if($nama_petugas !== $data_lama['nama_petugas']) {
          if(!preg_match("/^[a-zA-Z ]*$/",$nama_petugas)) {
            $errnama_petugas = "Inputan hanya boleh huruf";
          }
        }
      } else {
        $errnama_petugas = "Form Nama Petugas kosong";
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
        $ubah = mysqli_query($conn, "UPDATE petugas SET nama_petugas='$nama_petugas', username='$username', password='$pass', telp='$telp' WHERE id_petugas='$id_petugas'");
        if($ubah) {
          $_SESSION['user']['nama_petugas'] = $nama_petugas;
          $_SESSION['user']['username'] = $username;
          $_SESSION['user']['password'] = $pass;
          $_SESSION['user']['telp'] = $telp;
          setFlash('success', 'Data Berhasil Diubah');
          header('Location: index2.php?profil_petugas');
          exit;
        } else {
          setFlash('danger', 'Data Gagal Diubah');
          header('Location: index2.php?profil_petugas');
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
      <input type="hidden" name="id_petugas" value="<?= $_SESSION['user']['id_petugas']; ?>">
      <div class="form mb-3">
        <label for="nama_petugas">Nama Petugas :</label>
        <input value="<?= $nama_petugas; ?>" class="form-control <?= ($errnama_petugas !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="nama_petugas" id="nama_petugas" type="text" aria-label=".form-control-sm example">
        <span class="warning"><?= $errnama_petugas; ?></span>
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
      <button type="submit" class="btn btn-dark" name="UbahPetugas">Ubah</button>
    </form>
  </div>
</div>