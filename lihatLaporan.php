<?php
include "database/database.php";
session_start();

// Redirect jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$katakunci = $_GET["katakunci"] ?? "";
$op = $_GET['op'] ?? "";
$id = $_GET['id'] ?? "";

$sukses = "";
$error = "";

// Proses hapus
if ($op === 'delete' && !empty($id)) {
    $sql = "DELETE FROM laporan WHERE id_laporan = ? AND username = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $id, $username);
    if (mysqli_stmt_execute($stmt)) {
        $sukses = "Data berhasil dihapus.";
    } else {
        $error = "Gagal menghapus data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lihat Laporan Anda</title>
    <link rel="stylesheet" href="css/lihatLaporan.css">
    <link rel="stylesheet" href="css/layout.css" />
    
</head>

    <!-- HEADER -->
    <header>
        <div class="logo-container">
            <img src="image/logo.png" class="logo" alt="Logo">
            <span class="title">Pengaduan Masyarakat</span>
        </div>
        <div class="menu-icon" onclick="toggleSidebar()">☰</div>
    </header>

<div id="detailModal" style="display:none; position:fixed; top:20%; left:30%; width:40%; background:#fff; padding:20px; box-shadow:0 0 10px #000;">
    <h3>Detail Laporan</h3>
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
                });
        });
    });
});
</script>

<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-content">
                <ul>
                    <li><a href="halamanUtama.php"><img src="image/home (1).png"> <span>Home</span></a></li>
                    <li><a href="isiPengaduan.php"><img src="image/fill.png"> <span>Isi Pengaduan</span></a></li>
                    <li><a href="lihatLaporan.php"><img src="image/form.png"> <span>Lihat Laporan Anda</span></a></li>
                </ul>
                <div class="logout-container">
                    <a href="halamanUtama.php?logout=true" onclick="return confirm('Yakin ingin logout?')">
                    <button type="submit" name="logout" class="logout"><img class="logout-icon" src="image/logout (1).png" alt="User">Logout</button>
                    </a>
                </div>
            </div>
        </div>
    </aside>
    <!-- KONTEN UTAMA -->
    <main class="content">
        <?php if ($sukses) echo "<p class='alert success'>$sukses</p>"; ?>
        <?php if ($error) echo "<p class='alert error'>$error</p>"; ?>

        <table id="laporanTable">
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
                $sql = "SELECT * FROM laporan 
                    WHERE username = ? AND (
                        judul LIKE ? OR jenis LIKE ? OR email LIKE ? OR nomerhp LIKE ? 
                        OR wilayah LIKE ? OR isi LIKE ?
                    )
                    ORDER BY tgl_isi DESC";
                $stmt = mysqli_prepare($db, $sql);
                $like = "%$katakunci%";
                mysqli_stmt_bind_param($stmt, "sssssss", $username, $like, $like, $like, $like, $like, $like);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['tgl_isi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nomerhp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['wilayah']) . "</td>";
                    echo "<td><button class='btn-detail' data-id='{$row['id_laporan']}'>Lihat</button></td>";
                    // Aksi Edit dan Hapus
                    echo "<td>
                        <a href='editLaporan.php?id=" . $row['id_laporan'] . "'><button class='btn-edit'>Edit</button></a>
                        <a href='lihatLaporan.php?op=delete&id=" . $row['id_laporan'] . "' onclick=\"return confirm('Hapus Laporan Ini?')\">
                            <button class='btn-delete'>Hapus</button>
                        </a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <script src="js/lihatLaporan.js"></script>
</body>

</html>