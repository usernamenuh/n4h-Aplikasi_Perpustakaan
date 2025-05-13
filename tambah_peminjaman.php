<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

$sql = "SELECT pb.id_peminjaman, 
               a.nama AS nama_anggota, 
               b.nama AS nama_buku, 
               pb.tanggal_pinjam, 
               COALESCE(pb.tanggal_kembali, '-') AS tanggal_kembali, 
               pb.status 
        FROM peminjaman_buku pb 
        JOIN anggota a ON pb.id_anggota = a.id_anggota 
        JOIN buku b ON pb.id_buku = b.id_buku";

$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Peminjaman</title>
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
      <li class="active">
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
    <div class="tabular--wrapper">
      <h3 class="main--title">Tambah<a href="tampil_peminjaman.php" class="tambah-data">
        <i class="fa-solid fa-upload"></i>
      </a></h3>
      
      <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Buku</th>
              <th>Anggota</th>
              <th>Pinjam</th>
              <th>Kembali</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <?php foreach (['id_peminjaman', 'nama_buku', 'nama_anggota', 'tanggal_pinjam', 'tanggal_kembali', 'status'] as $field): ?>
                <td><?= htmlspecialchars($row[$field]); ?></td>
              <?php endforeach; ?>
              <td>
                <a style="color: rgba(70,130,180, 255);" href="hapus_peminjaman.php?id_peminjaman=<?= $row['id_peminjaman']; ?>" onclick="return confirm('Hapus?');"><i class="fa-solid fa-trash"></i></a>
                <?php if ($row['status'] !== 'dikembalikan'): ?>
                  <a style="color: rgba(70,130,180, 255);" href="kembalikan.php?id_peminjaman=<?= $row['id_peminjaman']; ?>" onclick="return confirm('Kembalikan?');">Kembalikan</a>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="alert">Tidak ada data peminjaman!</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>

<?php
$koneksi->close();
?>