<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

$count1 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku"));
$count2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM anggota"));
$count3 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin"));
$count4 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peminjaman_buku"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
.export-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #222;
  padding: 20px;
  border-radius: 10px;
  border: 1px solid #333;
  color: #fff;
  gap: 20px;
  max-width: 600px;
  margin: 20px auto;
}
.export-container span {
  margin-top: 18px;
  font-weight: 700;
}
.export-box {
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 5px;
  color: #fff;
}
.pdf {
  background-color: #e74c3c;
  color: white;
  border: 2px solid #c0392b;
}
.excel {
  background-color: #2ecc71;
  color: white;
  border: 2px solid #27ae60;
}
.export-box:hover {
  opacity: 0.8;
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
    <div class="card--container">
      <div class="card--wrapper">
        <div class="payment--card">
          <div class="card--header">
            <div class="amount">
              <span class="title">Buku</span>
              <span class="amount--value"> <?=$count1;?> </span>
            </div>
            <i class="fa-solid fa-layer-group"></i>
          </div>
        </div>
        <div class="payment--card light-purple">
          <div class="card--header">
            <div class="amount">
              <span class="title">Anggota</span>
              <span class="amount--value"> <?=$count2;?> </span>
            </div>
            <i class="fa-solid fa-chart-line fa-layer-group dark-purple"></i>
          </div>
        </div>
        <div class="payment--card light-green">
          <div class="card--header">
            <div class="amount">
              <span class="title">Buku Yang Di Pinjam</span>
              <span class="amount--value"><?=$count4; ?></span>
            </div>
            <i class="fa-solid fa-chart-simple dark-green"></i>
          </div>
        </div>
        <div class="payment--card light-blue">
          <div class="card--header">
            <div class="amount">
              <span class="title">Jumlah Admin</span>
              <span class="amount--value"><?=$count3; ?></span>
            </div>
            <i class="fa-solid fa-user fa-chart-simple dark-blue"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="tabular--wrapper">
      <div class="export-container light-red">
        <span>Data Buku</span>
        <a style="margin-left: 58px;" href="export_pdf_buku.php" class="export-box pdf">Export PDF</a>
        <a href="export_excel_buku.php" class="export-box excel">Export Excel</a>
      </div>
      <div class="export-container light-red">
        <span>Data Anggota</span>
        <a style="margin-left: 31px;" href="export_pdf_anggota.php" class="export-box pdf">Export PDF</a>
        <a href="export_excel_anggota.php" class="export-box excel">Export Excel</a>
      </div>
      <div class="export-container light-red">
        <span>Data Peminjaman</span>
        <a href="export_pdf_peminjaman.php" class="export-box pdf">Export PDF</a>
        <a href="export_excel_peminjaman.php" class="export-box excel">Export Excel</a>
      </div>
    </div>
  </div>
</body>
</html>