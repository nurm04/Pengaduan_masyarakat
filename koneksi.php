<?php 
 $conn = mysqli_connect('localhost', 'root', '', 'pengaduan_masyarakat');
 if(!$conn) {
  echo "<h1>Koneksi Gagal</h1>";
 }

  function id($tabel, $id, $kode)
  {
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM $tabel ORDER BY $id DESC LIMIT 1");
    $result = mysqli_fetch_array($query);
    $key = $result[$id];
    if($key != "1" && $key != "") {
      $urut = substr($key, 4);
      $urut++;
      $jadi = $kode.date('m').date('y').sprintf('%04s', $urut);

      $urut = substr($key, 6, 4);
      $tambah = (int) $urut + 1 ;
      $bln = date("m");
      $thn = date("y");

      if(strlen($tambah) == 1) {
        $jadi = $kode.$bln.$thn."000".$tambah;
      } else if(strlen($tambah) == 2) {
        $jadi = $kode.$bln.$thn."00".$tambah;
      } else if(strlen($tambah) == 3) {
        $jadi = $kode.$bln.$thn."0".$tambah;
      } else {
        $jadi = $kode.$bln.$thn.$tambah;
      }
    } else {
      $urut = 0000;
      $tambah = (int) $urut + 1 ;
      $bln = date("m");
      $thn = date("y");

      if(strlen($tambah) == 1) {
        $jadi = $kode.$bln.$thn."000".$tambah;
      } else if(strlen($tambah) == 2) {
        $jadi = $kode.$bln.$thn."00".$tambah;
      } else if(strlen($tambah) == 3) {
        $jadi = $kode.$bln.$thn."0".$tambah;
      } else {
        $jadi = $kode.$bln.$thn.$tambah;
      }
    }
    return $jadi;
  }

  function cekUsername($username)
  {
    global $conn;
    $cariM = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username = '$username'");
    $cariP = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$username'");
    if(mysqli_num_rows($cariM) > 0 || mysqli_num_rows($cariP) > 0) {
      $ada = true;
    } else {
      $ada = false;
    }
    return $ada;
  }

  function textLimit($text, $limit = 150)
  {
    if(strlen($text) > $limit) {
      $jadi = substr($text, 0, $limit)."...";
    } else {
      $jadi = $text;
    }
    return $jadi;
  }

  function setFlash($tipe, $pesan)
  {
    $_SESSION['flash'] = [
      'tipe' => $tipe,
      'pesan' => $pesan
    ];
  }
  function flash()
  {
    if(isset($_SESSION['flash'])) {
      echo '
        <div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
          ' . $_SESSION['flash']['pesan'] . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      ';
      unset($_SESSION['flash']);
    }
  }

  function cekInput($data) 
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
