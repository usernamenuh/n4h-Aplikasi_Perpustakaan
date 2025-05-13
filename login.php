<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM login WHERE username = '$username' AND password = '$password' LIMIT 1");

    if (!$query) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'admin') {
            $_SESSION['id_admin'] = $data['id_admin'];

            $admin_query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '{$data['id_admin']}'");
            $admin = mysqli_fetch_assoc($admin_query);

            $_SESSION['nama'] = $admin['nama'];
            $_SESSION['email'] = $admin['email'];
            $_SESSION['image'] = !empty($admin['image']) ? $admin['image'] : 'default_admin.png';

            header("Location: dashboard.php");
            exit();
        } elseif ($data['role'] == 'user') {
            $_SESSION['id_anggota'] = $data['id_anggota'];

            $user_query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '{$data['id_anggota']}'");
            $user = mysqli_fetch_assoc($user_query);

            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['image'] = !empty($user['image']) ? $user['image'] : 'default_user.png';

            header("Location: user_dashboard.php");
            exit();
        }
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.'); window.location='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Form Login</h2>
            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" required>
                <label>Password</label>
                <input type="password" name="password" required>
                <button class="btn-login" type="submit">Login</button>
            </form>
            <div class="register-links">
                <p>Belum punya akun? Daftar sekarang!</p>
                <div class="register-buttons">
                    <a href="register_user.php" class="btn btn-user">Daftar sebagai User</a>
                    <a href="register_admin.php" class="btn btn-admin">Daftar sebagai Admin</a>
                    <a href="index.php" class="btn btn-admin">Kembali</a>
                </div>
            </div>
        </div>
        <div class="image-container">
            <img src="css/logo.png" alt="buku">
        </div>
    </div>
</body>
</html>