<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

$bukuQuery = "SELECT id_buku, nama FROM buku WHERE stok > 0";
$anggotaQuery = "SELECT id_anggota, nama FROM anggota";
$anggotaResult = $koneksi->query($anggotaQuery);

$bukuQuery = "SELECT id_buku, nama FROM buku";
$bukuResult = $koneksi->query($bukuQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Peminjaman</title>
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
        <div class="title">Tambah Peminjaman Buku</div>
        <form method="post" enctype="multipart/form-data" action="proses_peminjaman.php">
          <div class="user-details">
            <div class="input-box">
              <label for="id_buku">Pilih Buku:</label>
              <select name="id_buku" id="id_buku" required>
                <option><-----Pilih Buku-----></option>
                <?php while ($row = $bukuResult->fetch_assoc()) { ?>
                  <option value="<?= $row['id_buku']; ?>"><?= $row['nama']; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="input-box">
              <label for="id_anggota">Pilih Anggota:</label>
              <select name="id_anggota" id="id_anggota" required>
                <option value=""><-----Pilih Anggota-----></option>
                <?php 
                mysqli_data_seek($anggotaResult, 0);
                while ($row = $anggotaResult->fetch_assoc()) { ?>
                  <option value="<?= $row['id_anggota']; ?>"><?= $row['nama']; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="input-box">
              <label for="tanggal_pinjam">Tanggal Pinjam:</label>
              <input type="date" name="tanggal_pinjam" required>
            </div>
          </div>
          <div class="button">
            <input type="submit" value="Tambah">
            <a href="tambah_peminjaman.php">Kembali</a>
            <input type="reset" value="Reset">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>