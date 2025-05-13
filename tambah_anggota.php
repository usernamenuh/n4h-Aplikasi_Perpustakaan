<?php
session_start();
include "koneksi.php";
$role = $_SESSION['role'] ?? '';

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

    if ($nama == "" || $nim == "" || $no_hp == "" || $email == "" || $tanggal_lahir == "" || $tempat_lahir == "" || $alamat == "" || $program_studi == "" || $agama == "" || $jenis_kelamin == "" || $image == "") {
        echo '<script>alert("Semua data harus di isi.")</script>';
    } else {
        if (move_uploaded_file($image_tmp, $target_dir . $image)) {
            $query = mysqli_query($koneksi, "INSERT INTO anggota (nama, nim, no_hp, email, tanggal_lahir, tempat_lahir, alamat, program_studi, agama, jenis_kelamin, image) VALUES ('$nama', '$nim', '$no_hp', '$email', '$tanggal_lahir', '$tempat_lahir', '$alamat', '$program_studi', '$agama', '$jenis_kelamin', '$image')");
            if ($query) {
                echo '<script>alert("Tambah Data berhasil")</script>';
                header('Location: anggota.php');
                exit();
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
  <title>Tambah Anggota</title>
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
                <input type="text" name="nama" placeholder="Masukan nama anda" required>
              </div>
              <div class="input-field">
                <label>NIM/NISN</label>
                <input type="number" name="nim" placeholder="Masukan nim/nisn anda" required>
              </div>
              <div class="input-field">
                <label>No Hp</label>
                <input type="number" name="no_hp" placeholder="Masukan no hp anda" required>
              </div>
              <div class="input-field">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukan email anda" required>
              </div>
              <div class="input-field">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" placeholder="Masukan tanggal lahir anda" required>
              </div>
              <div class="input-field">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" placeholder="Masukan tempat lahir anda" required>
              </div>
              <div class="input-field">
                <label>Alamat</label>
                <input type="text" name="alamat" placeholder="Masukan alamat anda" required>
              </div>
              <div class="input-field">
                <label>Program Studi</label>
                <select name="program_studi" id="" required>
                  <option value="">Pilih</option>
                  <option value="Teknik-Informatika">Teknik Informatika</option>
                  <option value="Manajemen-Informatika">Manajemen Informatika</option>
                  <option value="Akuntansi">Akuntansi</option>
                  <option value="Teknik Sipil">Teknik Sipil</option>
                </select>
              </div>
              <div class="input-field">
                <label>Agama</label>
                <select name="agama" id="">
                  <option>Pilih</option>
                  <option>Islam</option>
                  <option>Kristen</option>
                  <option>Budha</option>
                  <option>Katolik</option>
                </select>
              </div>
              <div class="input-field">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" id="">
                  <option>Pilih</option>
                  <option>Laki-Laki</option>
                  <option>Perempuan</option>
                </select>
              </div>
              <div class="input-field">
                <label>Foto</label>
                <input type="file" name="image" id="file-upload" class="fileimg" required>
                <label for="file-upload" class="custom-file-upload">Upload Foto</label>
                <span id="file-upload-filename" class="file-upload-filename"></span>
              </div>
            </div>

            <div class="buttons">
              <a href="anggota.php" class="button">
                <span class="btnText">Kembali</span>
                <i class="fa-solid fa-caret-left"></i>
              </a>
              <button class="nexBtn">
                <span class="btnText">Tambah</span>
                <i class="fa-solid fa-caret-right"></i>
              </button>
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