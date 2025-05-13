<?php 
include "koneksi.php";
$id = $_GET['id'];
 $query = mysqli_query($koneksi, "DELETE FROM buku where id_buku=$id");
 header('location:dashboard.php');
?>