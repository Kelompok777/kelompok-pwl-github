<?php
include("database/database.php");
session_start();

$sukses = "";
$error = "";

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
$editData = null;

// Ambil data lama jika ada
if ($id) {
    $result = $db->query("SELECT * FROM laporan WHERE id_laporan = '$id'");
    if ($result && $result->num_rows > 0) {
        $editData = $result->fetch_assoc();
    } else {
        $error = "Data tidak ditemukan.";
    }
}

// Proses saat form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_post   = $_POST['id_laporan'] ?? '';
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

    $file_uploaded = false;

    if (!empty($file_name)) {
        if (in_array($file_ext, $allowed_ext)) {
            if (move_uploaded_file($tmp_name, $file_path)) {
                $file_uploaded = true;
            } else {
                $error = "Upload file gagal.";
            }
        } else {
            $error = "Ekstensi file tidak valid.";
        }
    }

    if (empty($error)) {
        // UPDATE data
        $sql = "UPDATE laporan SET 
                    judul='$judul',
                    username='$username',
                    isi='$isi',
                    email='$email',
                    nomerhp='$nomerhp',
                    jenis='$jenis',
                    wilayah='$wilayah',
                    deskripsiBukti='$deskripsi'";

        if ($file_uploaded) {
            $sql .= ", bukti='$file_name'";
        }

        $sql .= " WHERE id_laporan='$id_post'";

        if ($db->query($sql)) {
            // Redirect ke halaman lihatLaporan.php setelah update berhasil
            header("Location: lihatLaporan.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Laporan</title>
    <link rel="stylesheet" href="css/isiPengaduan.css">
</head>

<body>

    <header class="header">
        <div class="logo-container">
            <img src="img/logo.png" class="logo" alt="Logo" />
            <span class="title">Pengaduan Masyarakat</span>
        </div>
        <div class="menu-icon" onclick="toggleSidebar()">☰</div>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-content">
                <ul>
                    <li><a href="halamanUtama.php"><img src="icon/icon-laporan.png"> <span>Home</span></a></li>
                    <li><a href="isiPengaduan.php"><img src="icon/icon-pengaduan.png"> <span>Isi Pengaduan</span></a></li>
                    <li><a href="lihatLaporan.php"><img src="icon/icon-laporan.png"> <span>Lihat Laporan Anda</span></a></li>
                </ul>
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

            <?php if ($editData): ?>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_laporan" value="<?= $editData['id_laporan'] ?>">

                    <div class="form-group">
                        <label>Kategori (Judul):</label>
                        <input type="text" name="kategori" required value="<?= $editData['judul'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Jenis:</label>
                        <input type="text" name="jenis" required value="<?= $editData['jenis'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama:</label>
                        <input type="text" name="nama" required value="<?= $editData['username'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" required value="<?= $editData['email'] ?>">
                    </div>

                    <div class="form-group">
                        <label>No. HP:</label>
                        <input type="tel" name="hp" required value="<?= $editData['nomerhp'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Wilayah:</label>
                        <input type="text" name="wilayah" required value="<?= $editData['wilayah'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Isi Laporan:</label>
                        <textarea name="isi_laporan" required><?= $editData['isi'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Bukti:</label>
                        <input type="file" name="fupload">
                        <?php if (!empty($editData['bukti'])): ?>
                            <p>File sebelumnya: <strong><?= $editData['bukti'] ?></strong></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi File:</label>
                        <textarea name="deskripsi" rows="4" required><?= $editData['deskripsiBukti'] ?></textarea>
                    </div>

                    <button type="submit">Update Laporan</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
    <script src="js/isiPengaduan.js"></script>
</body>

</html>