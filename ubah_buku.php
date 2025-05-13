<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $pengarang = $_POST['pengarang'];
    $penulis = $_POST['penulis'];
    $tanggal_upload = $_POST['tanggal_upload'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $jenis_buku = $_POST['jenis_buku'];
    $stok = $_POST['stok'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target_dir = "img/";

    if (empty($image)) {
        $image = $_POST['old_image'];
    } else {
        move_uploaded_file($image_tmp, $target_dir . $image);
    }

    $query = mysqli_query($koneksi, "UPDATE buku SET pengarang='$pengarang', penulis='$penulis', tanggal_upload='$tanggal_upload', jumlah_halaman='$jumlah_halaman', jenis_buku='$jenis_buku', stok='$stok', image='$image' WHERE id_buku='$id'");
    if ($query) {
        echo '<script>alert("Data berhasil diubah"); window.location.href = "buku.php";</script>';
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
  <title>Ubah Buku</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/style_buku.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<style>
  .input-field {
    margin-bottom: 20px;
}

.input-field label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.input-field input[type="text"],
.input-field input[type="number"],
.input-field input[type="email"],
.input-field input[type="date"],
.input-field input[type="file"],
.input-field select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.input-field .custom-file-upload {
    display: inline-block;
    padding: 10px 65px;
    cursor: pointer;
    background: #4682b4;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    font-size: 16px;
    letter-spacing: 1px;
    transition: background 0.3s ease;
}

.input-field .custom-file-upload:hover {
    background: #315f86;
}

.file-upload-filename {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #333;
    word-wrap: break-word;
    max-width: 100%;
    white-space: pre-wrap;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    background: #f9f9f9;
}

.fileimg {
    display: none;
}
</style>
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
        <div class="title">Ubah Buku</div>
        <form method="post" enctype="multipart/form-data">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Nama</span>
              <input type="text" placeholder="nama" name="nama" value="<?php echo $data['nama']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Pengarang</span>
              <input type="text" placeholder="pengarang" name="pengarang" value="<?php echo $data['pengarang']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Penulis</span>
              <input type="text" placeholder="penulis" name="penulis" value="<?php echo $data['penulis']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Tanggal Upload</span>
              <input type="date" placeholder="tanggal upload" name="tanggal_upload" value="<?php echo $data['tanggal_upload']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Jumlah Halaman</span>
              <input type="number" placeholder="Halaman" name="jumlah_halaman" value="<?php echo $data['jumlah_halaman']; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Jenis</span>
              <select name="jenis_buku">
                <option value="">Pilih</option>
                <option value="Fiksi" <?php if ($data['jenis_buku'] == "Fiksi") echo 'selected'; ?>>Fiksi</option>
                <option value="Non_Fiksi" <?php if ($data['jenis_buku'] == "Non_Fiksi") echo 'selected'; ?>>Non Fiksi</option>
              </select>
            </div>
            <div class="input-box">
              <span class="details">Stok Buku</span>
              <input type="number" placeholder="Stok" name="stok" value="<?php echo $data['stok']; ?>" required>
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