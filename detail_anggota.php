<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Anggota</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/anggota.css">
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
    <div class="container">
      <header>Anggota</header>
      <form method="post" enctype="multipart/form-data">
        <div class="form first">
        <div class="details-personal">
          <span class="title">Data Diri</span>
          <div class="fields">
          <div class="input-field">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukan nama anda" value="<?php echo $data['nama']; ?>" readonly>
          </div>
          <div class="input-field">
            <label>NIM/NISN</label>
            <input type="number" name="nim" placeholder="Masukan nim/nisn anda" value="<?php echo $data['nim']; ?>" readonly>
          </div>
          <div class="input-field">
            <label>No Hp</label>
            <input type="number" name="no_hp" placeholder="Masukan no hp anda" value="<?php echo $data['no_hp']; ?>" readonly>
          </div>
        <div class="input-field">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukan email anda" value="<?php echo $data['email']; ?>" readonly>
          </div>
          <div class="input-field">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" placeholder="Masukan tanggal lahir anda" value="<?php echo $data['tanggal_lahir']; ?>" readonly>
          </div>
          <div class="input-field">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" placeholder="Masukan tempat lahir anda" value="<?php echo $data['tempat_lahir']; ?>" readonly>
          </div>
          <div class="input-field">
            <label>alamat</label>
            <input type="text" name="alamat" placeholder="Masukan nama anda" value="<?php echo $data['alamat']; ?>" readonly>
          </div>
          <div class="input-field">
            <label>Program Studi</label>
            <select name="program_studi" id="" disabled>
            <option value="">Pilih</option>
            <option value="Teknik-Informatika" <?php if (trim($data['program_studi']) == "Teknik-Informatika") echo 'selected'; ?>>Teknik Informatika</option>
            <option value="Manajemen-Informatika" <?php if (trim($data['program_studi']) == "Manajemen-Informatika") echo 'selected'; ?>>Manajemen Informatika</option>
            <option value="Akuntansi" <?php if (trim($data['program_studi']) == "Akuntansi") echo 'selected'; ?>>Akuntansi</option>
            <option value="Teknik Sipil" <?php if (trim($data['program_studi']) == "Teknik Sipil") echo 'selected'; ?>>Teknik Sipil</option>
          </select>
          </div>
          <div class="input-field">
            <label>Agama</label>
            <select name="agama" id="" disabled>
              <option value="">Pilih</option>
              <option value="Islam" <?php if (trim($data['agama']) == "Islam") echo 'selected'; ?>>Islam</option>
              <option value="Kristen" <?php if (trim($data['agama']) == "Kristen") echo 'selected'; ?>>Kristen</option>
              <option value="Budha" <?php if (trim($data['agama']) == "Budha") echo 'selected'; ?>>Budha</option>
              <option value="Katolik" <?php if (trim($data['agama']) == "Katolik") echo 'selected'; ?>>Katolik</option>
            </select>
          </div>
          <div class="input-field">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" id="" disabled>
              <option value="">Pilih</option>
              <option value="Laki-Laki" <?php if ($data ['jenis_kelamin'] == "Laki-Laki") echo 'selected'; ?>>Laki-Laki</option>
              <option value="Perempuan" <?php if ($data ['jenis_kelamin'] == "Perempuan") echo 'selected'; ?>>Perempuan</option>
            </select>
            </div>
            <div class="input-field">
            <label>Foto</label>
            <img src="img/<?php echo $data['image']; ?>" alt="Current Image" class="detail-image" width="50%" height="auto">
          </div>
            </div>
        <div class="buttons">
          <a href="anggota.php" class="button">
        <span class="btnText">Kembali</span>
        <i class="fa-solid fa-caret-left"></i>
        </a>
        </div>
        </div>
        </div>
      </form>
    </div>
  </div>
  <script>
document.getElementById('file-upload').addEventListener('change', function() {
  var fileName = this.files[0].name;
  document.getElementById('file-upload-filename').textContent = fileName;
});
</script>
</body>
</html>