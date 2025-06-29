<?php
include("database/database.php");
session_start();

$sukses = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul     = $_POST['kategori'] ?? '';
    $username  = $_POST['nama'] ?? '';
    $isi       = $_POST['isi_laporan'] ?? '';
    $email     = $_POST['email'] ?? '';
    $nomerhp   = $_POST['hp'] ?? '';
    $jenis     = $_POST['jenis'] ?? '';
    $wilayah   = $_POST['wilayah'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';

    $upload_dir = "upload/";
    $file_name  = $_FILES['fupload']['name'] ?? '';
    $tmp_name   = $_FILES['fupload']['tmp_name'] ?? '';
    $file_ext   = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_path  = $upload_dir . $file_name;
    $allowed_ext = ["jpg", "jpeg", "png", "pdf"];

    if (!empty($file_name) && in_array($file_ext, $allowed_ext)) {
        if (move_uploaded_file($tmp_name, $file_path)) {
            $sql = "INSERT INTO laporan 
                    (judul, username, isi, email, nomerhp, jenis, wilayah, bukti, deskripsiBukti)
                    VALUES
                    ('$judul', '$username', '$isi', '$email', '$nomerhp', '$jenis', '$wilayah', '$file_name', '$deskripsi')";

            if ($db->query($sql)) {
                $sukses = "Laporan berhasil dikirim!";
            } else {
                $error = "Gagal menyimpan ke database.";
            }
        } else {
            $error = "Upload file gagal.";
        }
    } else {
        $error = "File tidak valid. Hanya JPG, PNG, PDF.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Form Pengaduan</title>
    <link rel="stylesheet" href="css/isiPengaduan.css" />
    <link rel="stylesheet" href="css/layout.css" />
</head>

    <header>
        <div class="logo-container">
            <img src="image/logo.png" class="logo" alt="Logo" />
            <span class="title">Pengaduan Masyarakat</span>
        </div>
        <div class="menu-icon" onclick="toggleSidebar()">☰</div>
    </header>

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
    <main class="form-wrapper">
        <div class="form-container">
            <?php if ($sukses): ?>
                <div class="alert success"><?= $sukses ?></div>
            <?php elseif ($error): ?>
                <div class="alert error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <label for="kategori">Kategori (Judul):</label>
                    <input type="text" name="kategori" required />
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis:</label>
                    <input type="text" name="jenis" required />
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" required />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required />
                </div>
                <div class="form-group">
                    <label for="hp">No. HP:</label>
                    <input type="tel" name="hp" required />
                </div>
                <div class="form-group">
                    <label for="wilayah">Wilayah:</label>
                    <input type="text" name="wilayah" required />
                </div>
                <div class="form-group">
                    <label for="isi_laporan">Isi Laporan:</label>
                    <textarea name="isi_laporan" required></textarea>
                </div>
                <div class="form-group">
                    <label for="fupload">Upload Bukti:</label>
                    <input type="file" name="fupload" required />
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi File:</label>
                    <textarea name="deskripsi" rows="4" required></textarea>
                </div>
                <button type="submit">Kirim Laporan</button>
            </form>
        </div>
    </main>
    <script src="js/isiPengaduan.js"></script>

</body>

</html>