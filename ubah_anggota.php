<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $alamat = $_POST['alamat'];
    $program_studi = $_POST['program_studi'];
    $agama = $_POST['agama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target_dir = "foto/";

    if (empty($image)) {
        $image = $_POST['old_image'];
    } else {
        move_uploaded_file($image_tmp, $target_dir . $image);
    }

    $query = mysqli_query($koneksi, "UPDATE anggota SET nama='$nama', nim='$nim', no_hp='$no_hp', email='$email', tanggal_lahir='$tanggal_lahir', tempat_lahir='$tempat_lahir', alamat='$alamat', program_studi='$program_studi', agama='$agama', jenis_kelamin='$jenis_kelamin', image='$image' WHERE id_anggota='$id'");
    if ($query) {
        echo '<script>alert("Data berhasil diubah"); window.location.href = "anggota.php";</script>';
    } else {
        echo '<script>alert("Data gagal diubah")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Anggota</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/style_buku.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="css/logo.png" alt="logo">
    </div>
    <ul class="menu">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="buku.php">
          <i class="fa-solid fa-book"></i>
          <span>Buku</span>
        </a>
      </li>
      <li>
        <a href="anggota.php">
          <i class="fa-solid fa-users"></i>
          <span>Anggota</span>
        </a>
      </li>
      <li>
        <a href="tambah_peminjaman.php">
          <i class="fa-solid fa-folder-open"></i>
          <span>Pinjam Buku</span>
        </a>
      </li>
      <?php if ($role === 'admin'): ?> 
      <li>
        <a href="export.php">
          <i class="fa-solid fa-file-export"></i>
          <span>Export</span>
        </a>
      </li>
      <?php endif; ?>
      <li class="logout" style="margin-top: 80px;">
        <a href="logout.php">
          <i class="fas fa-sign-out"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="main--content">
    <div class="parent-container">
      <div class="container">
        <div class="title">Ubah Anggota</div>
        <form method="post" enctype="multipart/form-data">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Nama</span>
              <input type="text" placeholder="nama" name="nama" value="<?php echo $data['nama']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">NIM</span>
              <input type="text" placeholder="nim" name="nim" value="<?php echo $data['nim']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">No HP</span>
              <input type="text" placeholder="no_hp" name="no_hp" value="<?php echo $data['no_hp']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Email</span>
              <input type="email" placeholder="email" name="email" value="<?php echo $data['email']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Tanggal Lahir</span>
              <input type="date" placeholder="tanggal lahir" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Tempat Lahir</span>
              <input type="text" placeholder="tempat lahir" name="tempat_lahir" value="<?php echo $data['tempat_lahir']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Alamat</span>
              <input type="text" placeholder="alamat" name="alamat" value="<?php echo $data['alamat']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Program Studi</span>
              <input type="text" placeholder="program studi" name="program_studi" value="<?php echo $data['program_studi']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Agama</span>
              <input type="text" placeholder="agama" name="agama" value="<?php echo $data['agama']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Jenis Kelamin</span>
              <select name="jenis_kelamin">
                <option value="">Pilih</option>
                <option value="Laki-Laki" <?php if ($data['jenis_kelamin'] == "Laki-Laki") echo 'selected'; ?>>Laki-laki</option>
                <option value="Perempuan" <?php if ($data['jenis_kelamin'] == "Perempuan") echo 'selected'; ?>>Perempuan</option>
              </select>
            </div>
            <div class="input-field">
              <label>Foto</label>
              <input type="hidden" name="old_image" value="<?php echo $data['image']; ?>">
              <input type="file" name="image" id="file-upload" class="fileimg">
              <label for="file-upload" class="custom-file-upload">Upload Ulang Foto</label>
              <span id="file-upload-filename" class="file-upload-filename"><?php echo $data['image']; ?></span>
            </div>
          </div>
          <div class="button">
            <input type="submit" value="Simpan">
            <a href="dashboard.php">Kembali</a>
            <input type="reset" value="Reset">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>