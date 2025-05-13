<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku=$id");
$data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Buku</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/stylesss.css">
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
      <div class="title">Detail Buku</div>
      <img src="img/<?php echo $data['image']; ?>" alt="Current Image" class="detail-image">
      <form method="post" enctype="multipart/form-data">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Nama</span>
            <input type="text" placeholder="nama" name="nama" value="<?php echo $data['nama']; ?>" readonly>
          </div>
          <div class="input-box">
            <span class="details">Pengarang</span>
            <input type="text" placeholder="pengarang" name="pengarang" value="<?php echo $data['pengarang']; ?>" readonly>
          </div>
          <div class="input-box">
            <span class="details">Penulis</span>
            <input type="text" placeholder="penulis" name="penulis" value="<?php echo $data['penulis']; ?>" readonly>
          </div>
          <div class="input-box">
            <span class="details">Tanggal Upload</span>
            <input type="date" placeholder="tanggal upload" name="tanggal_upload" value="<?php echo $data['tanggal_upload']; ?>" readonly>
          </div>
          <div class="input-box">
            <span class="details">Jumlah Halaman</span>
            <input type="number" placeholder="Halaman" name="jumlah_halaman" value="<?php echo $data['jumlah_halaman']; ?>" readonly>
          </div>
          <div class="input-box">
            <span class="details">Jenis</span>
            <select name="jenis_buku" id="" disabled>
            <option value="Fiksi" <?php if ($data['jenis_buku'] == "Fiksi") echo 'selected'; ?>>Fiksi</option>
            <option value="Non_Fiksi" <?php if ($data['jenis_buku'] == "Non_Fiksi") echo 'selected'; ?>>Non Fiksi</option>
          </select>
          </div>
          <div class="input-box">
            <span class="details">Stok Buku</span>
            <input type="number" placeholder="Halaman" name="stok" value="<?php echo $data['stok']; ?>" readonly>
          </div>
        </div>
        <div class="button">
          <a href="dashboard.php">Kembali</a>
        </div>
      </form>
    </div>
  </div>
  </div>
</body>
</html>