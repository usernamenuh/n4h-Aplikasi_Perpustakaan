<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $cek_user = mysqli_query($koneksi, "SELECT * FROM login WHERE username='$username'");
    $cek_email = mysqli_query($koneksi, "SELECT * FROM admin WHERE email='$email'");

    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah digunakan, silakan gunakan username lain!'); window.location='register_admin.php';</script>";
    } elseif (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar, silakan gunakan email lain!'); window.location='register_admin.php';</script>";
    } else {
        $target_dir = "foto/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $query = "INSERT INTO admin (nama, email, image) VALUES ('$nama', '$email', '$image')";
        mysqli_query($koneksi, $query);

        $id_admin = mysqli_insert_id($koneksi);

        $query_login = "INSERT INTO login (username, password, role, id_admin) VALUES ('$username', '$password', 'admin', '$id_admin')";
        mysqli_query($koneksi, $query_login);

        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/register.css">
  <title>Website Perpustakaan</title>
</head>
<body>
<section class="hero">
  <div class="container">
    <div class="form-container">
      <h2>Registrasi Admin</h2>
      <form method="POST" enctype="multipart/form-data" class="register-form">
        <div class="form-group">
          <label>Nama:</label>
          <input type="text" name="nama" required placeholder="Masukkan nama">
        </div>
        <div class="form-group">
          <label>Email:</label>
          <input type="email" name="email" required placeholder="Masukkan email">
        </div>
        <div class="form-group">
          <label>Username:</label>
          <input type="text" name="username" required placeholder="Masukkan username">
        </div>
        <div class="form-group">
          <label>Password:</label>
          <input type="password" name="password" required placeholder="Masukkan password">
        </div>
        <div class="form-group">
          <label for="image" class="custom-file-label" id="file-label">Pilih Foto:</label>
          <input type="file" id="image" name="image" required class="custom-file-input">
        </div>
        <div class="button-container">
          <button type="submit" class="btn-submit">Daftar</button>
          <a href="login.php" class="btn-submit">Kembali</a>
        </div>
      </form>
    </div>
    <div class="image-container">
      <img src="css/logo.png" alt="buku">
    </div>
  </div>
</section>

<script>
const fileInput = document.getElementById("image");
const fileLabel = document.getElementById("file-label");

fileInput.addEventListener("change", function() {
  if (fileInput.files.length > 0) {
    fileLabel.classList.add("uploaded");
  } else {
    fileLabel.classList.remove("uploaded");
  }
});
</script>
</body>
</html>