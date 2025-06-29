<?php
session_start();

// Jika belum login, arahkan ke login
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Proses logout jika ada parameter ?logout=true
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset();
    session_destroy();
    header("Location: index.php"); // Atau login.php sesuai aplikasi kamu
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="css/halamanUtama.css">
    <link rel="stylesheet" href="css/layout.css" />
</head>

    <!-- HEADER -->
    <header>
        <div class="logo-container">
            <img src="image/logo.png" alt="Logo" class="logo">
            <span class="title">Pengaduan Masyarakat</span>
        </div>
        <div class="menu-icon" onclick="toggleSidebar()">☰</div>
    </header>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
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
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="overlay">
            <div class="row">
                <h1 class="selamat-datang">Selamat datang, <?= htmlspecialchars($_SESSION["username"]) ?></h1>
            </div>
        </div>
    </main>

<script src="js/halamanUtama.js"></script>
</body>
</html>
