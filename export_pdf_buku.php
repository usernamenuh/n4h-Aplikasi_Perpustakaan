<?php
include "koneksi.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export PDF Buku</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

 <div class="main--content">

      <div class="tabular--wrapper">
        <h3 style="text-align: center; font-size: 20px;">Data Buku</h3>
        
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pengarang</th>
                <th>Penulis</th>
                <th>Jumlah Halaman</th>
                <th>Tanggal Upload</th>
                <th>Jenis</th>
                <th>Stok</th>
                <th>Gambar</th>
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
                <td><?php echo $data['jumlah_halaman']; ?></td>
                <td><?php echo $data['tanggal_upload']; ?></td>
                <td><?php echo $data['jenis_buku']; ?></td>
                <td><?php echo $data['stok']; ?></td>
                <td><img src="img/<?php echo $data['image']; ?>" title="<?php echo $data['image']; ?>" style="height: 70px; width: auto; border-radius: 10px;"></td>
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