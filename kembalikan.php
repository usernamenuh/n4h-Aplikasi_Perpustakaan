<?php
include 'koneksi.php';

if (isset($_GET['id_peminjaman'])) {
    $id_peminjaman = $koneksi->real_escape_string($_GET['id_peminjaman']);
    $tanggal_kembali = date("Y-m-d");

    $cek = $koneksi->query("SELECT status, id_buku FROM peminjaman_buku WHERE id_peminjaman = '$id_peminjaman'");
    $data = $cek->fetch_assoc();

    if ($data && $data['status'] === 'dikembalikan') {
        echo "<script>
                alert('Buku sudah dikembalikan sebelumnya!');
                window.history.back();
              </script>";
        exit();
    }

    $sql = "UPDATE peminjaman_buku 
            SET tanggal_kembali = '$tanggal_kembali', status = 'dikembalikan' 
            WHERE id_peminjaman = '$id_peminjaman'";

    if ($koneksi->query($sql)) {
        $id_buku = $data['id_buku'];
        $updateStok = "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$id_buku'";
        $koneksi->query($updateStok);

        echo "<script>
                alert('Buku berhasil dikembalikan dan stok bertambah!');
                window.location='tambah_peminjaman.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengembalikan buku!');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('ID peminjaman tidak ditemukan!');
            window.history.back();
          </script>";
}
?>