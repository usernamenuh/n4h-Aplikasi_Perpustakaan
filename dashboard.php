<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['role'] ?? '';
$id_admin = $_SESSION['id_admin'] ?? null;
$id_anggota = $_SESSION['id_anggota'] ?? null;
$nama = 'Guest';
$email = '';
$foto_user = 'default.png';

if ($role == 'admin' && $id_admin) {
    $admin_query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
    if ($admin_query && mysqli_num_rows($admin_query) > 0) {
        $admin = mysqli_fetch_assoc($admin_query);
        $nama = $admin['nama'];
        $email = $admin['email'];
        $foto_user = !empty($admin['image']) ? $admin['image'] : 'default_admin.png';
    }
}

if ($role == 'user' && $id_anggota) {
    $user_query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id_anggota'");
    if ($user_query && mysqli_num_rows($user_query) > 0) {
        $user = mysqli_fetch_assoc($user_query);
        $nama = $user['nama'];
        $email = $user['email'];
        $foto_user = !empty($user['image']) ? $user['image'] : 'default_user.png';
    }
}

$count1 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku"));
$count2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM anggota"));
$count3 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin"));
$count4 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peminjaman_buku"));

$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$query = "SELECT * FROM buku";
if ($search != '') {
    $query .= " WHERE nama LIKE '%$search%'";
}
$query .= " ORDER BY nama ASC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="css/logo.png" alt="logo">
    </div>
    <ul class="menu">
      <li class="active">
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
    <div class="header--wrapper">
      <div class="header--title">
        <span>Selamat Datang</span>
        <h1><?php echo  $_SESSION['username']; ?></h1>
      </div>
      <div class="user--info">
        <div class="search--box">
          <form method="GET" action="dashboard.php">
            <div class="searh--box">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" name="search" placeholder="Search Nama Buku..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" />
            </div>
          </form>
        </div>
        <img src="foto/<?= htmlspecialchars($foto_user); ?>" alt="Profile Picture" >
      </div>
    </div>

    <div class="card--container">
      <div class="card--wrapper">
        <div class="payment--card light-red">
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
        <?php if ($role === 'admin'): ?> 
        <div class="payment--card light-blue">
          <div class="card--header">
            <div class="amount">
              <span class="title">Jumlah Admin</span>
              <span class="amount--value"><?=$count3; ?></span>
            </div>
            <i class="fa-solid fa-user fa-chart-simple dark-blue"></i>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="tabular--wrapper">
  
    <?php if ($role === 'admin'): ?>   
      <h3 class="main--title">Tambah<a href="tambah_buku.php" class="tambah-data"> 
        <i class="fa-solid fa-upload"></i>
      </a></h3>
    <?php endif; ?>
      
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Pengarang</th>
              <th>Penulis</th>
              <th>Jenis</th>
              <th>Stok</th>
              <th>Gambar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $urut = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
            <tr>
              <td><?php echo $urut; ?></td>
              <td><?php echo $data['nama']; ?></td>
              <td><?php echo $data['pengarang']; ?></td>
              <td><?php echo $data['penulis']; ?></td>
              <td><?php echo $data['jenis_buku']; ?></td>
              <td><?php echo $data['stok']; ?></td>
              <td><img src="img/<?php echo $data['image']; ?>" title="<?php echo $data['image']; ?>" style="height: 70px; width: auto; border-radius: 10px;"></td>
              <td>
              <?php if ($role === 'admin'): ?> 
                <a style="color: rgba(70,130,180, 255);" href="ubah_buku.php?id=<?php echo $data['id_buku']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                <a style="color: rgba(70,130,180, 255);" onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="hapus_buku.php?id=<?php echo $data['id_buku']; ?>"><i class="fa-solid fa-trash"></i></a>
              <?php endif; ?>
                <a style="color: rgba(70,130,180, 255);" href="detail_buku.php?id=<?php echo $data['id_buku']; ?>"><i class="fa-solid fa-circle-info"></i></a>
              </td>
            </tr>
            <?php
            $urut++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>