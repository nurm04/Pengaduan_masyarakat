<?php 
  $nama_petugas = $username = $password = $telp = "";
  $errnama_petugas = $errusername = $errpassword = $errtelp = "";
  if(isset($_POST['tambahP'])) {
    $id_petugas = id('petugas', 'id_petugas', 'PT');
    $nama_petugas = cekInput($_POST['nama_petugas']);
    $username = cekInput($_POST['username']);
    $password = cekInput($_POST['password']);
    $telp = $_POST['telp'];

    if(empty($nama_petugas)) {
      $errnama_petugas = "Form Nama kosong";
      setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
    }

    if(empty($username)) {
      $errusername = "Form username kosong";
      setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
    }

    if(empty($password)) {
      $errpassword = "Form password kosong";
      setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
    }

    if(!empty($telp)) {
      if(preg_match("/^[0-9]*$/",$telp)) {
        if(strlen($telp) <= 13 && strlen($telp) >= 11 ) {
          $errtelp = "";
        } else {
          $errtelp = "Jumlah input tidak sesuai";
          setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
        }
      } else {
        $errtelp = "Inputan hanya boleh angka";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }
    } else {
      $errtelp = "Form No Handphone kosong";
      setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
    }

    if(empty($errnama_petugas) && empty($errusername) && empty($errpassword) && empty($errtelp)) {
      if(cekUsername($username) == 0) {
        $pass = md5($password);
        $kirim = mysqli_query($conn, "INSERT INTO petugas
        VALUES ('$id_petugas', '$nama_petugas', '$username', '$pass', '$telp', 'petugas')");
        if($kirim) {
          setFlash('success', 'Petugas Berhasil Terdaftar');
          $nama_petugas = $username = $password = $telp = "";
          $errnama_petugas = $errusername = $errpassword = $errtelp = "";
        } else {
          setFlash('danger', 'Maaf Ada Kesalahan');
        } 
      } else {
        $errusername = "Username sudah ada";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }
    }
  }

  $uerrnama_petugas = $uerrusername = $uerrpassword = $uerrpassNew = $uerrtelp = "";
  if(isset($_POST['petugasU'])) {
    $uid_petugas = $_POST['uid_petugas'];
    $unama_petugas = cekInput($_POST['unama_petugas']);
    $uusername = cekInput($_POST['uusername']);
    $upassword = cekInput($_POST['upassword']);
    $upassNew = cekInput($_POST['upassNew']);
    $utelp = cekInput($_POST['utelp']);
    $cari = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$uid_petugas'");
    $data_lama = mysqli_fetch_array($cari);
    if(!empty($upassword)) {
      if(md5($upassword) !== $data_lama['password']) {
        $uerrpassword = "Password Lama salah";
      }

      if(!empty($unama_petugas)) {
        if($unama_petugas !== $data_lama['nama']) {
          if(!preg_match("/^[a-zA-Z ]*$/",$unama_petugas)) {
            $uerrnama = "Inputan hanya boleh huruf";
            setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
          }
        }
      } else {
        $uerrnama = "Form Nama kosong";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }

      if(!empty($utelp)) {
        if($utelp !== $data_lama['telp']) {
          if(!preg_match("/^[0-9]*$/",$utelp)) {
            $uerrtelp = "Inputan hanya boleh angka";
            setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
          }
        }
      } else {
        $uerrtelp = "Form No Handphone kosong";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }

      if(!empty($uusername)) {
        if($uusername !== $data_lama['username']) {
          if(cekUsername($uusername) > 0) {
            $uerrusername = "Username sudah ada";
            setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
          }
        }
      } else {
        $uerrusername = "Username kosong";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }
      

      if(!empty($upassNew)) {
        $upass = md5($upassNew);
      } else {
        $upass = md5($upassword);
      }
      if(empty($uerrnama_petugas) && empty($uerrusername) && empty($uerrpassword) && empty($uerrpassNew) && empty($uerrtelp)) {
        $ubah = mysqli_query($conn, "UPDATE petugas SET nama='$unama_petugas', username='$uusername', password='$upass', telp='$utelp' WHERE id_petugas='$uid_petugas'");
        if($ubah) {
          setFlash('success', 'Data Berhasil Diubah');
        } else {
          setFlash('danger', 'Data Gagal Diubah');
        }
      }
    } else {
      $uerrpassword = "Password Lama tidak boleh kosong";
      setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
    }
  }

  if(isset($_POST['hapusP'])) {
    $id_petugas = $_POST['id_petugas'];
    $hapus = mysqli_query($conn, "DELETE FROM tanggapan WHERE id_petugas = '$id_petugas'");
    $hapus .= mysqli_query($conn, "DELETE FROM petugas WHERE id_petugas = '$id_petugas'");
    if($hapus) {
      setFlash('success', 'Berhasil Dihapus');
    } else {
      setFlash('danger', 'Gagal Dihapus');
    }
  }
?>
<div class="data_petugas">
  <h3>Data Petugas</h3>
  <br>
  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newPet">
    User Baru
  </button>
  <br>
  <?php 
    $batas = 5;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $previous = $halaman-1;
    $next = $halaman+1;
    
    $data = mysqli_query($conn,"SELECT * FROM petugas ORDER BY id_petugas ASC");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;
    $cari = "";
    if(isset($_POST['cariin'])) {
      $cari = cekInput($_POST['cari']);
      $query1 = mysqli_query($conn, "SELECT * FROM petugas 
      WHERE nama_petugas LIKE '%".$cari."%' OR
      username LIKE '%".$cari."%' OR
      id_petugas LIKE '%".$cari."%' OR
      telp LIKE '%".$cari."%'
      ORDER BY id_petugas ASC LIMIT $halaman_awal, $batas");
    } else {
    $query1 = mysqli_query($conn, "SELECT * FROM petugas ORDER BY id_petugas ASC LIMIT $halaman_awal, $batas");
    }
    $query2 = mysqli_query($conn, "SELECT petugas.*, count(tanggapan.id_tanggapan) as jml 
      FROM petugas LEFT JOIN tanggapan ON petugas.id_petugas = tanggapan.id_petugas
      GROUP BY petugas.id_petugas ORDER BY petugas.id_petugas DESC
    ");
  ?>
  <form class="d-flex" role="search" method="post" action="">
    <input value="<?= $cari; ?>" class="form-control me-2 input" type="search" placeholder="Search" name="cari" aria-label="Search">
    <button type="submit" name="cariin"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>
  <br>
  <?php flash(); ?>
  <br>
  <table class="table table-light table-hover table-bordered">
    <thead>
      <tr class="table-dark">
        <th scope="col">Id Petugas</th>
        <th scope="col">Nama</th>
        <th scope="col">username</th>
        <th scope="col">No HP</th>
        <th scope="col">Laporan<br>Yang Diterima</th>
        <th scope="col">...</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
      <?php 
        if(mysqli_num_rows($query1)) {
          foreach($query1 as $pt) {
            foreach($query2 as $jml) {
              if($jml['id_petugas'] == $pt['id_petugas']) {

      ?>
      <tr>
        <th scope="row"><?= $pt['id_petugas']; ?></th>
        <td><?= $pt['nama_petugas']; ?></td>
        <td><?= $pt['username']; ?></td>
        <td>0<?= $pt['telp']; ?></td>
        <td><a href="index2.php?laporan_data_petugas&id=<?= $pt['id_petugas']; ?>">(<?= $jml['jml']; ?>) Laporan</a></td>
        <td>
          <?php if($pt['level'] != "admin") {?>
          <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delPet<?= $pt['id_petugas']; ?>"><i class="fa-solid fa-trash"></i></a>
          <a type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#upPet<?= $pt['id_petugas']; ?>"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
          <?php } ?>
        </td>
      </tr>
      <!-- Model Hapus -->
        <div class="modal fade" id="delPet<?= $pt['id_petugas']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body">
                  Anda Yakin Ingin hapus ?
                  <input type="hidden" name="id_petugas" value="<?= $pt['id_petugas']; ?>">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" class="btn btn-dark" name="hapusP">Hapus</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <!-- Model Hapus -->

      <!-- Model Ubah -->
        <div class="modal fade" id="upPet<?= $pt['id_petugas']; ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body">
                  <input type="hidden" name="uid_petugas" value="<?= $pt['id_petugas']; ?>">
                  <div class="form mb-3">
                    <label for="unama_petugas">Nama :</label>
                    <input value="<?= isset($unama_petugas)?$unama_petugas:$pt['nama_petugas']; ?>" class="form-control <?= ($uerrnama !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="unama_petugas" id="unama_petugas" type="text" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrnama_petugas; ?></span>
                  </div>
                  <div class="form mb-3">
                    <label for="uusername">Username :</label>
                    <input value="<?= isset($uusername)?$uusername:$pt['username']; ?>" class="form-control <?= ($uerrusername !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="uusername" id="uusername" type="text" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrusername; ?></span>
                  </div>
                  <div class="form mb-3">
                    <label for="upassword">Password Lama :</label>
                    <input value="" class="form-control <?= ($uerrpassword !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="upassword" id="upassword" type="password" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrpassword; ?></span>
                  </div>
                  <div class="form mb-3">
                    <label for="upassNew">Password Baru :</label>
                    <input value="" class="form-control <?= ($uerrpassNew !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="upassNew" id="upassNew" type="password" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrpassNew; ?></span>
                  </div>
                  <div class="form mb-3">
                    <label for="utelp">No Handphone :</label>
                    <input value="<?= isset($utelp)?$utelp:$pt['telp']; ?>" class="form-control <?= ($uerrtelp !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="utelp" id="utelp" type="text" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrtelp; ?></span>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" class="btn btn-dark" name="petugasU">Ubah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <!-- Model Ubah -->
      <?php }} } } else {?>
        <tr>
          <th colspan="6">Data Kosong</th>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index2.php?data_petugas&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index2.php?data_petugas&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index2.php?data_petugas&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>

<!-- Model Tambah -->
  <div class="modal fade" id="newPet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">User Baru</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form mb-3">
              <label for="nama_petugas">Nama :</label>
              <input value="<?= $nama_petugas; ?>" class="form-control <?= ($errnama_petugas !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="nama_petugas" id="nama_petugas" type="text" aria-label=".form-control-sm example">
              <span class="warning"><?= $errnama_petugas; ?></span>
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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-dark" name="tambahP">Daftar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Model Tambah -->