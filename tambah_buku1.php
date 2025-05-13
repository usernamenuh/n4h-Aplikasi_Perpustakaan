<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $pengarang = $_POST['pengarang'];
    $penulis = $_POST['penulis'];
    $jenis_buku = $_POST['jenis_buku'];
    $stok = $_POST['stok'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $tanggal_upload = $_POST['tanggal_upload'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target_dir = "img/";

    if ($nama == "" || $pengarang == "" || $penulis == "" || $jumlah_halaman == "" || $tanggal_upload == "" || $jenis_buku == "" || $image == "") {
        echo '<script>alert("Semua data harus di isi.")</script>';
    } else {
        if (move_uploaded_file($image_tmp, $target_dir . $image)) {
            $query = mysqli_query($koneksi, "INSERT INTO buku (nama, pengarang, penulis, jumlah_halaman, tanggal_upload, jenis_buku, image) VALUES ('$nama', '$pengarang', '$penulis', '$jumlah_halaman', '$tanggal_upload', '$jenis_buku', '$image')");
            if ($query) {
                echo '<script>alert("Tambah Data berhasil")</script>';
                header('Location: buku.php');
            } else {
                echo '<script>alert("Tambah Data Gagal")</script>';
            }
        } else {
            echo '<script>alert("Gagal mengunggah gambar.")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Buku</title>
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
        <div class="title">Tambah Buku</div>
        <form method="post" enctype="multipart/form-data">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Nama</span>
              <input type="text" placeholder="nama" name="nama" required>
            </div>
            <div class="input-box">
              <span class="details">Pengarang</span>
              <input type="text" placeholder="pengarang" name="pengarang" required>
            </div>
            <div class="input-box">
              <span class="details">Penulis</span>
              <input type="text" placeholder="penulis" name="penulis" required>
            </div>
            <div class="input-box">
              <span class="details">Tanggal Upload</span>
              <input type="date" placeholder="tanggal upload" name="tanggal_upload" required>
            </div>
            <div class="input-box">
              <span class="details">Jumlah Halaman</span>
              <input type="number" placeholder="Halaman" name="jumlah_halaman" required>
            </div>
            <div class="input-box">
              <span class="details">Image</span>
              <input type="file" class="fileimg" placeholder="Upload" name="image" required>
            </div>
            <div class="input-box">
              <span class="details">Jenis</span>
              <select name="jenis_buku" id="">
                <option>Pilih</option>
                <option name="jenis_buku" value="Fiksi">Fiksi</option>
                <option name="jenis_buku" value="Non_Fiksi">Non_Fiksi</option>
              </select>
            </div>
            <div class="input-box">
              <span class="details">Stok</span>
              <input type="number" placeholder="Stok" name="stok" required>
            </div>
          </div>
          <div class="button">
            <input type="submit" value="Tambah">
            <a href="buku.php">Kembali</a>
            <input type="reset" value="Reset">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>