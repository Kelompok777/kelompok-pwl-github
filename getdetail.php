<?php
include("database/database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($db, "SELECT isi, bukti, deskripsiBukti, username FROM laporan WHERE id_laporan = '$id'");
    if ($row = mysqli_fetch_assoc($query)) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
}

?>