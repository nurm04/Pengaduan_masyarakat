<?php 
  $nik = $nama = $username = $password = $telp = "";
  $errnik = $errnama = $errusername = $errpassword = $errtelp = "";
  if(isset($_POST['tambahM'])) {
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
          setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
        }
      } else {
        $errnik = "Inputan hanya boleh angka";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }
    } else {
      $errnik = "Form NIK kosong";
      setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
    }

    if(!empty($nama)) {
      if(!preg_match("/^[a-zA-Z ]*$/",$nama)) {
        $errnama = "Inputan hanya boleh huruf";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }
    } else {
      $errnama = "Form Nama kosong";
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

    if(empty($errnik) && empty($errnama) && empty($errusername) && empty($errpassword) && empty($errtelp)) {
      $cari = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
      if(!mysqli_num_rows($cari)) {
        if(cekUsername($username) == 0) {
          $pass = md5($password);
          $kirim = mysqli_query($conn, "INSERT INTO masyarakat
          VALUES ('$nik', '$nama', '$username', '$pass', '$telp')");
          if($kirim) {
            setFlash('success', 'User Berhasil Terdaftar');
            $nik = $nama = $username = $password = $telp = "";
            $errnik = $errnama = $errusername = $errpassword = $errtelp = "";            
          } else {
            setFlash('danger', 'User Gagal Terdaftar');
          } 
        } else {
          $errusername = "Username sudah ada";
          setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
        }
      } else {
        $errnik = "NIK sudah terdaftar";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }
    }
  }
  
  $uerrnik = $uerrnama = $uerrusername = $uerrpassword = $uerrpassNew = $uerrtelp = "";
  if(isset($_POST['masyarakatU'])) {
    $unik_lama = $_POST['unik_lama'];
    $unik = cekInput($_POST['unik']);
    $unama = cekInput($_POST['unama']);
    $uusername = cekInput($_POST['uusername']);
    $upassword = cekInput($_POST['upassword']);
    $upassNew = cekInput($_POST['upassNew']);
    $utelp = cekInput($_POST['utelp']);
    $cari = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$unik_lama'");
    $data_lama = mysqli_fetch_array($cari);
    if(!empty($upassword)) {
      if(md5($upassword) !== $data_lama['password']) {
        $uerrpassword = "Password Lama salah";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }

      if(!empty($unik)) {
        if($unik !== $data_lama['nik']) {
          if(preg_match("/^[0-9]*$/",$unik)) {
            if(strlen($unik) == 16 ) {
              $cekuNik = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
              if(mysqli_num_rows($cekuNik) > 0) {
                $uerrnik = "NIK sudah ada";
                setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
              }
            } else {
              $uerrnik = "Jumlah input harus 16";
              setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
            }
          } else {
            $uerrnik = "Inputan hanya boleh angka";
            setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
          }
        }
      } else {
        $uerrnik = "Form NIK kosong";
        setFlash('danger', 'Ada Kesalahan, Coba Periksa Kembali');
      }

      if(!empty($unama)) {
        if($unama !== $data_lama['nama']) {
          if(!preg_match("/^[a-zA-Z ]*$/",$unama)) {
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
      if(empty($uerrnik) && empty($uerrnama) && empty($uerrusername) && empty($uerrpassword) && empty($uerrpassNew) && empty($uerrtelp)) {
        $ubah = mysqli_query($conn, "UPDATE masyarakat SET nik='$unik', nama='$unama', username='$uusername', password='$upass', telp='$utelp' WHERE nik='$unik_lama'");
        $ubah .= mysqli_query($conn, "UPDATE pengaduan SET nik='$unik' WHERE nik='$unik_lama'");
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
  
  if(isset($_POST['hapusM'])) {
    $nikh = $_POST['nik'];
    $cari = mysqli_query($conn, "SELECT * FROM pengaduan WHERE nik = '$nikh'");
    if(mysqli_num_rows($cari) > 0) {
      foreach($cari as $i) {
        $a = $i['id_pengaduan'];
        $hapus = mysqli_query($conn, "DELETE FROM tanggapan WHERE id_pengaduan = '$a'");
      }
      $hapus .= mysqli_query($conn, "DELETE FROM pengaduan WHERE nik = '$nikh'");
      $hapus .= mysqli_query($conn, "DELETE FROM masyarakat WHERE nik = '$nikh'");
    } else {
      $hapus = mysqli_query($conn, "DELETE FROM pengaduan WHERE nik = '$nikh'");
      $hapus .= mysqli_query($conn, "DELETE FROM masyarakat WHERE nik = '$nikh'");
    }
    if($hapus) {
      setFlash('success', 'User Berhasil Dihapus');
    } else {
      setFlash('danger', 'User Gagal Dihapus');
    }
  }
?>
<div class="data_masyarakat">
  <h3>Data Masyarakat</h3>
  <br>
  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newMasy">
    User Baru
  </button>
  <br>
  <?php 
    $batas = 5;
    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

    $previous = $halaman-1;
    $next = $halaman+1;
    
    $data = mysqli_query($conn,"SELECT * FROM masyarakat ORDER BY nik DESC");
    $jumlah_data = mysqli_num_rows($data);
    $total_halaman = ceil($jumlah_data / $batas);

    $nomor = $halaman_awal+1;
    $cari = "";
    if(isset($_POST['cariin'])) {
      $cari = cekInput($_POST['cari']);
      $query1 = mysqli_query($conn, "SELECT * FROM masyarakat 
      WHERE nama LIKE '%".$cari."%' OR
      username LIKE '%".$cari."%' OR
      nik LIKE '%".$cari."%' OR
      telp LIKE '%".$cari."%'
      ORDER BY nik DESC LIMIT $halaman_awal, $batas");
    } else {
      $query1 = mysqli_query($conn, "SELECT * FROM masyarakat ORDER BY nik DESC LIMIT $halaman_awal, $batas");
    }
    $query2 = mysqli_query($conn, "SELECT masyarakat.*, count(pengaduan.id_pengaduan) as jml 
    FROM masyarakat LEFT JOIN pengaduan ON masyarakat.nik = pengaduan.nik
    GROUP BY masyarakat.nik ORDER BY masyarakat.nik DESC");
  ?>
  <form class="d-flex" role="search" method="post" action="">
    <input value="<?= $cari; ?>" class="form-control me-2 input" type="search" placeholder="Search" name="cari" aria-label="Search">
    <button type="submit" name="cariin"><i class="fa-solid fa-magnifying-glass"></i></button>
  </form>
  <br>
  <?php 
    flash();
  ?>
  <br>
  <table class="table table-light table-hover table-bordered">
    <thead>
      <tr class="table-dark">
        <th scope="col">NIK</th>
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
          foreach($query1 as $ms) {
            foreach($query2 as $jml) {
              if($jml['nik'] == $ms['nik']) {
      ?>
      <tr>
        <th scope="row"><?= $ms['nik']; ?></th>
        <td><?= $ms['nama']; ?></td>
        <td><?= $ms['username']; ?></td>
        <td>0<?= $ms['telp']; ?></td>
        <td><a href="index2.php?laporan_data_masyarakat&id=<?= $ms['nik']; ?>">(<?= $jml['jml']; ?>) Laporan</a></td>
        <td>
          <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delMasy<?= $ms['nik']; ?>"><i class="fa-solid fa-trash"></i></a>
          <a type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#upMasy<?= $ms['nik']; ?>"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
        </td>
      </tr>
      <!-- Model Hapus -->
        <div class="modal fade" id="delMasy<?= $ms['nik']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body">
                  <input type="hidden" name="nik" value="<?= $ms['nik']; ?>">
                  Anda Yakin Ingin hapus ?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" class="btn btn-dark" name="hapusM">Hapus</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <!-- Model Hapus -->

      <!-- Model Ubah -->
        <div class="modal fade" id="upMasy<?= $ms['nik']; ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body">
                  <div class="form mb-3">
                    <input type="hidden" name="unik_lama" value="<?= $ms['nik']; ?>">
                    <label for="unik">NIK :</label>
                    <input value="<?= isset($unik)?$unik:$ms['nik']; ?>" class="form-control <?= ($uerrnik !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="unik" id="unik" type="text" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrnik; ?></span>
                  </div>
                  <div class="form mb-3">
                    <label for="unama">Nama :</label>
                    <input value="<?= isset($unama)?$unama:$ms['nama']; ?>" class="form-control <?= ($uerrnama !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="unama" id="unama" type="text" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrnama; ?></span>
                  </div>
                  <div class="form mb-3">
                    <label for="uusername">Username :</label>
                    <input value="<?= isset($uusername)?$uusername:$ms['username']; ?>" class="form-control <?= ($uerrusername !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="uusername" id="uusername" type="text" aria-label=".form-control-sm example">
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
                    <input value="<?= isset($utelp)?$utelp:$ms['telp']; ?>" class="form-control <?= ($uerrtelp !="" ? "is-invalid" : ""); ?> form-control-sm" autocomplete="off" name="utelp" id="utelp" type="text" aria-label=".form-control-sm example">
                    <span class="warning"><?= $uerrtelp; ?></span>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" class="btn btn-dark" name="masyarakatU">Ubah</button>
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
        <a class="page-link text-dark" <?php if($halaman > 1){ echo "href='index2.php?data_masyarakat&halaman=$previous'"; } ?> aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link text-dark" href="index2.php?data_masyarakat&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>	
      <li class="page-item">
        <a class="page-link text-dark" <?php if($halaman < $total_halaman) { echo "href='index2.php?data_masyarakat&halaman=$next'"; } ?> aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>

<!-- Model Tambah -->
  <div class="modal fade" id="newMasy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">User Baru</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-dark" name="tambahM">Daftar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Model Tambah -->