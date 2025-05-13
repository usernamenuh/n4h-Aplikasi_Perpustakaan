<?php 
include "koneksi.php";
$id = $_GET['id'];
$query = mysqli_query($koneksi, "DELETE FROM jadwal where id=$id");
 header('location:anggota.php');
?>