<?php
include("database/database.php");
session_start();

$katakunci = isset($_GET["katakunci"]) ? $_GET["katakunci"] : "";
$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM akun WHERE id_user = '$id'";
    $q1 = mysqli_query($db, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    }
}

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header('Location: loginAdmin.php');
    exit;
}

$sql_count = "SELECT COUNT(*) AS total_akun FROM akun";
$result_count = mysqli_query($db, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_akun = $row_count['total_akun'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="css/halamanAdmin.css">
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">
                <img src="image/logo.png" alt="Logo" class="logo">
                <ul class="menu">
                    <li>
                        <a href="halamanAdmin.php">
                            <img src="image/home (1).png" alt="Home">
                            <span>Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="halamanAdminUser.php">
                            <img src="image/fill.png" alt="User">
                            <span>User</span>
                        </a>
                    </li>
                </ul>
            </div>
            <form method="post" class="logout-container">
                <button type="submit" name="logout" class="logout"><img class="logout-icon" src="image/logout (1).png" alt="User">Logout</button>
                </form>
        </div>

        <!-- Main Content -->
        <div class="main">
            <div class="header">Pengaduan Masyarakat</div>
            <div class="analyse">
                <div class="card">
                    <h3>Jumlah Laporan</h3>
                    <p><?= $total_akun ?></p>
                </div>
            </div>

            <div class="content">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM akun ORDER BY id_user ASC";
                        $result = mysqli_query($db, $sql);
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$row['username']}</td>";
                            echo "<td>{$row['password']}</td>";
                            echo "<td>
                                <a href='editLaporan.php?id={$row['id_user']}'><button class='btn-edit'>Edit</button></a>
                                <a href='halamanAdminUser.php?op=delete&id={$row['id_user']}' onclick=\"return confirm('Hapus laporan ini?')\">
                                    <button class='btn-delete'>Hapus</button>
                                </a>
                            </td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>