<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tanggal_pinjam = date("Y-m-d");

    $cek_stok = $koneksi->query("SELECT stok FROM buku WHERE id_buku = '$id_buku'")->fetch_assoc();
    if ($cek_stok['stok'] <= 0) {
        echo "<script>alert('Stok buku habis!'); window.location.href = 'tambah_peminjaman.php';</script>";
        exit();
    }

    $last_id = $koneksi->query("SELECT id_peminjaman FROM peminjaman_buku ORDER BY id_peminjaman DESC LIMIT 1")->fetch_assoc();
    $new_number = $last_id ? (int)substr($last_id['id_peminjaman'], 5) + 1 : 1;
    $id_peminjaman = "PINJ-" . str_pad($new_number, 4, "0", STR_PAD_LEFT);

    $query = "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_buku';
              INSERT INTO peminjaman_buku (id_peminjaman, id_buku, id_anggota, tanggal_pinjam, status) 
              VALUES ('$id_peminjaman', '$id_buku', '$id_anggota', '$tanggal_pinjam', 'dipinjam')";

    if ($koneksi->multi_query($query)) {
        echo "<script>alert('Berhasil meminjam buku!'); window.location.href = 'tambah_peminjaman.php';</script>";
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>