<?php
include 'koneksi.php';

if (isset($_GET['id_peminjaman'])) {
    $id_peminjaman = $_GET['id_peminjaman'];

    $cekStatus = $koneksi->prepare("SELECT status FROM peminjaman_buku WHERE id_peminjaman = ?");
    $cekStatus->bind_param("s", $id_peminjaman);
    $cekStatus->execute();
    $result = $cekStatus->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($row['status'] == 'dipinjam') {
            echo "<script>
                    alert('Buku masih dipinjam, tidak bisa dihapus!');
                    window.history.back();
                  </script>";
            exit();
        }
        
        $deleteQuery = $koneksi->prepare("DELETE FROM peminjaman_buku WHERE id_peminjaman = ?");
        $deleteQuery->bind_param("s", $id_peminjaman);
        if ($deleteQuery->execute()) {
            echo "<script>
                    alert('Data peminjaman berhasil dihapus!');
                    window.location = 'tambah_peminjaman.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus data!');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('ID peminjaman tidak ditemukan!');
                window.history.back();
              </script>";
    }
}
?>