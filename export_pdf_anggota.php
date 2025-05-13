<?php
include "koneksi.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export PDF Anggota</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
 <div class="main--content">
      <div class="tabular--wrapper">
        <h3 style="text-align: center; font-size: 20px;">Data Anggota</h3>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIM/NISN</th>
                <th>NO HP</th>
                <th>Email</th>
                <th>Tanggal Lahir</th>
                <th>Tempat Lahir</th>
                <th>Alamat</th>
                <th>Program Studi</th>
                <th>Agama</th>
                <th>Foto</th>
              </tr>
            </thead>
            <?php 
            $urut = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY nama ASC" );
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <tbody>
              <tr>
                <td><?php echo $urut; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['nim']; ?></td>
                <td><?php echo $data['no_hp']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['tanggal_lahir']; ?></td>
                <td><?php echo $data['tempat_lahir']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['program_studi']; ?></td>
                <td><?php echo $data['agama']; ?></td>
                <td><img src="foto/<?php echo $data['image']; ?>" title="<?php echo $data['image']; ?>" style="height: 70px; width: auto; border-radius: 10px;"></td>
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
<script>
  window.print();
</script>
</body>
</html>