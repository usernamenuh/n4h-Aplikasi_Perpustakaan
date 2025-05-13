<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $target_dir = "foto/";
    $image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $cek_user = mysqli_query($koneksi, "SELECT * FROM login WHERE username='$username'");
    $cek_email = mysqli_query($koneksi, "SELECT * FROM anggota WHERE email='$email'");

    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah terdaftar! Gunakan username lain.'); window.history.back();</script>";
        exit();
    }

    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar! Gunakan email lain.'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO anggota (nama, nim, no_hp, email, tanggal_lahir, tempat_lahir, alamat, program_studi, agama, jenis_kelamin, image) 
              VALUES ('$nama', '$nim', '$no_hp', '$email', '$tanggal_lahir', '$tempat_lahir', '$alamat', '$program_studi', '$agama', '$jenis_kelamin', '$image')";
    mysqli_query($koneksi, $query);

    $id_anggota = mysqli_insert_id($koneksi);

    $query_login = "INSERT INTO login (username, password, role, id_anggota) VALUES ('$username', '$password', 'user', '$id_anggota')";
    mysqli_query($koneksi, $query_login);

    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi User</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap');
        body {
            font-family: "Montserrat", serif;
            background: url('css/bg.png') no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            letter-spacing: 1px;
            backdrop-filter: blur(20px);
            animation: fadeIn 1s ease-out;
        }
        h2 {
            text-align: center;
            color: black;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            height: 5vh;
            padding: 2px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        select {
            color: black;
            font-size: 15px;
        }
        .form-group.file {
            grid-column: span 3;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            grid-column: span 3;
        }
        button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 500px) {
            .form-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }
        .custom-file-input {
            display: none;
        }
        .custom-file-label {
            display: inline-block;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input:focus {
            border-color: rgba(70,130,180, 255);
            box-shadow: 0 0 8px rgba(70,130,180, 255);
            outline: none;
            background: rgba(255, 255, 255, 0.5);
            color: #000;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
        }
        .custom-file-label:hover {
            background-color: #45a049;
        }
        .custom-file-label.uploaded {
            background-color: #2196F3;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: left;
            margin-top: 30px;
            gap: 10px;
        }
        button, .form-actions a {
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            width: 100%;
            max-width: 200px;
            margin-top: 10px;
        }
        button {
            background-color: rgba(70,130,180, 255);
            border: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
            letter-spacing: 2px;
        }
        button:hover {
            background-color: #1e8449;
        }
        .form-actions a {
            text-decoration: none;
            font-weight: bold;
            background: rgba(70,130,180, 255);
            color: #fff;
            transition: 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-actions a:hover {
            background: #1e8449;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrasi User</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" placeholder="nama" required>
                </div>
                <div class="form-group">
                    <label>NIM</label>
                    <input type="number" name="nim" placeholder="nim" required>
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" placeholder="no hp" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" placeholder="tanggal lahir" required>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="tempat lahir" required>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <select name="program_studi" required>
                        <option value="">Pilih Program Studi</option>
                        <option value="Teknik-Informatika">Teknik Informatika</option>
                        <option value="Manajemen-Informatika">Manajemen Informatika</option>
                        <option value="Akuntansi">Akuntansi</option>
                        <option value="Teknik Sipil">Teknik Sipil</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Budha">Budha</option>
                        <option value="Katolik">Katolik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <select name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="password" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" placeholder="alamat" required>
                </div>
                <div class="form-group">
                    <label for="image" class="custom-file-label" id="file-label">Pilih Foto:</label>
                    <input type="file" id="image" name="image" required class="custom-file-input">
                </div>
                <div class="form-actions">
                    <button type="submit">Daftar</button>
                    <a href="login.php">Kembali</a>
                </div>
            </div>
        </form>
    </div>
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