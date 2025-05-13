<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_peminjaman = $_POST['id_peminjaman'];
    $cek_status = $koneksi->query("SELECT status FROM peminjaman_buku WHERE id_peminjaman = '$id_peminjaman'");
    $data = $cek_status->fetch_assoc();
    if ($data['status'] == 'dikembalikan') {
        echo "Buku ini sudah dikembalikan sebelumnya!";
    } else {
        $query = "UPDATE buku b 
                  JOIN peminjaman_buku pb ON b.id_buku = pb.id_buku 
                  SET pb.status = 'dikembalikan', pb.tanggal_kembali = NOW(), b.stok = b.stok + 1 
                  WHERE pb.id_peminjaman = '$id_peminjaman'";
        echo $koneksi->query($query) ? "Buku berhasil dikembalikan dan stok bertambah." : "Gagal mengupdate status peminjaman.";
    }
}
?>