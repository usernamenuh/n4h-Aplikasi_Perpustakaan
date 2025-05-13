<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Buku</title>
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
      <li class="active">
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
      <div class="tabular--wrapper">
      <?php if ($role === 'admin'): ?> 
        <h3 class="main--title">Tambah<a href="tambah_buku1.php"  class="tambah-data">
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
            <?php 
            $urut = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY nama ASC" );
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <tbody>
              <tr>
                <td><?php echo $urut; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['pengarang']; ?></td>
                <td><?php echo $data['penulis']; ?></td>
                <td><?php echo $data['jenis_buku']; ?></td>
                <td><?php echo $data['stok']; ?></td>
                <td><img src="img/<?php echo $data['image']; ?>" title="<?php echo $data['image']; ?>" style="height: 70px; width: auto; border-radius: 10px;"></td>
                <Td>
                <?php if ($role === 'admin'): ?> 
                  <a style="color: rgba(70,130,180, 255);" href="ubah_buku.php?id=<?php echo $data['id_buku']; ?>" ><i class="fa-solid fa-pen-to-square"></i></a>
                  <a style="color: rgba(70,130,180, 255);" onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="hapus_buku.php?id=<?php echo $data['id_buku']; ?>"><i class="fa-solid fa-trash"></i></a>
                  <?php endif; ?>
                  <a style="color: rgba(70,130,180, 255);" href="detail_buku.php?id=<?php echo $data['id_buku']; ?>" ><i class="fa-solid fa-circle-info"></i></a>
                </Td>
              </tr>
            </tbody>
            <?php
            $urut++;
            }
            ?>
          </table>
        </div>
    </div>
</div>
</body>
</html>