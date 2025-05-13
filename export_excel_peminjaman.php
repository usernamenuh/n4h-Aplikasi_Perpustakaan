<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export Excel Pembelian</title>
  <link rel="icon" type="image/png" href="css/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
 <div class="main--content">
      <div class="tabular--wrapper">
        <h3 style="text-align: center; font-size: 20px;">Data Buku</h3>
        <div class="table-container">
        <?php
include "koneksi.php";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Data_peminjaman.xls");
$query = mysqli_query($koneksi, "SELECT pb.id_peminjaman, 
                                        b.nama AS nama_buku, 
                                        a.nama AS nama_anggota, 
                                        pb.tanggal_pinjam, 
                                        pb.tanggal_kembali, 
                                        pb.status 
                                 FROM peminjaman_buku pb 
                                 JOIN buku b ON pb.id_buku = b.id_buku 
                                 JOIN anggota a ON pb.id_anggota = a.id_anggota 
                                 ORDER BY pb.id_peminjaman ASC");

echo "<table border='1'>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Buku</th>
            <th>Nama Anggota</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>";

while ($data = mysqli_fetch_assoc($query)) {
    echo "<tr>
            <td>{$data['id_peminjaman']}</td>
            <td>{$data['nama_buku']}</td>
            <td>{$data['nama_anggota']}</td>
            <td>{$data['tanggal_pinjam']}</td>
            <td>{$data['tanggal_kembali']}</td>
            <td>{$data['status']}</td>
          </tr>";
}
echo "</tbody></table>";
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