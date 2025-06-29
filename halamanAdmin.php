<?php
include("database/database.php");
session_start();

$katakunci = isset($_GET["katakunci"]) ? $_GET["katakunci"] : "";
$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM laporan WHERE id_laporan = '$id'";
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

$sql_count = "SELECT COUNT(*) AS total_laporan FROM laporan";
$result_count = mysqli_query($db, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_laporan = $row_count['total_laporan'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="css/admin.css" />
</head>

<div id="detailModal" style="display:none; position:fixed; top:20%; left:30%; width:40%; background:#fff; padding:20px; box-shadow:0 0 10px #000;">
    <h3>Detail Laporan (<a id="username"></a>)</h3>
    <p><strong>Isi Laporan:</strong> <span id="isi"></span></p>
    <p><strong>Bukti:</strong> <span id="bukti"></span></p>
    <p><strong>Deskripsi:</strong> <span id="deskripsiBukti"></span></p>
    <button class='btn-delete' onclick="document.getElementById('detailModal').style.display='none'">Tutup</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            const laporanId = this.dataset.id;
            fetch('getdetail.php?id=' + laporanId)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('isi').textContent = data.isi;
                    document.getElementById('bukti').innerHTML = `<a href='upload/${data.bukti}' target='_blank'>Lihat Bukti</a>`;
                    document.getElementById('deskripsiBukti').textContent = data.deskripsiBukti;
                    document.getElementById('detailModal').style.display = 'block';
                    document.getElementById('username').textContent = data.username;
                });
        });
    });
});
</script>

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
                    <p><?= $total_laporan ?></p>
                </div>
            </div>

            <div class="content">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Wilayah</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM laporan ORDER BY tgl_isi DESC";
                        $result = mysqli_query($db, $sql);
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$row['tgl_isi']}</td>";
                            echo "<td>{$row['judul']}</td>";
                            echo "<td>{$row['jenis']}</td>";
                            echo "<td>{$row['username']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['nomerhp']}</td>";
                            echo "<td>{$row['wilayah']}</td>";
                            echo "<td><button class='btn-detail' data-id='{$row['id_laporan']}'>Lihat</button></td>";
                            echo "<td>
                                <div class='aksi-container'>
                                    <a href='editLaporan.php?id={$row['id_laporan']}'><button class='btn-edit'>Edit</button></a>
                                    <a href='halamanAdmin.php?op=delete&id={$row['id_laporan']}' onclick=\"return confirm('Hapus laporan ini?')\">
                                        <button class='btn-delete'>Hapus</button>
                                    </a>
                                </div>
                            </td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>