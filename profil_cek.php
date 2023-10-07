<div class="profil">
  <?php flash(); ?>
  <div class="kotak">
    <form action="" method="post">
      <?php 
        $id = isset($_GET['id'])?'&id='.$_GET['id']:"";
        $hal = !empty($_GET['id'])?$_GET['hal'] . '&id=' . $_GET['id']:$_GET['hal'];
        if(isset($_GET['id_petugas'])) {
          $id_petugas = $_GET['id_petugas'];
          $query = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$id_petugas'");
          $dt = mysqli_fetch_array($query);
        } else {
          $nik = $_GET['nik'];
          $query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
          $dt = mysqli_fetch_array($query);
        }
      ?>
      <?php if(isset($_GET['id_petugas'])) {?>
      <div class="form mb-3">
        <label for="nama_petugas">Nama :</label>
        <input value="<?= $dt['nama_petugas']; ?>" class="form-control form-control-sm" autocomplete="off" name="nama_petugas" id="nama_petugas" type="text" aria-label=".form-control-sm example" disabled>
      </div>
      <?php } else { ?>
      <div class="form mb-3">
        <label for="nik">NIK :</label>
        <input value="<?= $dt['nik']; ?>" class="form-control form-control-sm" autocomplete="off" name="nik" id="nik" type="text" aria-label=".form-control-sm example" disabled>
      </div>
      <div class="form mb-3">
        <label for="nama">Nama :</label>
        <input value="<?= $dt['nama']; ?>" class="form-control form-control-sm" autocomplete="off" name="nama" id="nama" type="text" aria-label=".form-control-sm example" disabled>
      </div>
      <?php } ?>
      <div class="form mb-3">
        <label for="username">Username :</label>
        <input value="<?= $dt['username']; ?>" class="form-control form-control-sm" autocomplete="off" name="username" id="username" type="text" aria-label=".form-control-sm example" disabled>
      </div>
      <div class="form mb-3">
        <label for="telp">No Handphone :</label>
        <input value="0<?= $dt['telp']; ?>" class="form-control form-control-sm" autocomplete="off" name="telp" id="telp" type="text" aria-label=".form-control-sm example" disabled>
      </div>
      <button type="button" class="btn btn-secondary apa"><a href="<?= $_SESSION['user']['level']=='user'?'index1.php?':'index2.php?';?>detail_laporan_<?= $_SESSION['user']['level']=='user'?'masyarakat':'petugas';?>&id_pengaduan=<?= $_GET['a']; ?>&hal=<?= $hal; ?>">Kembali</a></button>
    </form>
  </div>
</div>