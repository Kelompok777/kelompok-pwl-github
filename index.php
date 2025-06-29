<?php
include "database/database.php"; // koneksi ke database
session_start();

$login_massage = "";
$register_massage = "";

// PROSES LOGIN
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM akun WHERE username='$username' AND password='$password'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;
        header("Location: halamanUtama.php"); // halaman setelah login
        exit;
    } else {
        $login_massage = "Akun tidak ditemukan atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <!-- Login -->
        <div class="login-box">
            <h2>LOGIN</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <span class="icon">👤</span>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn" name="login">Login</button>
                </div>
                <div class="message"><?= $login_massage ?></div>
                <div class="text-center small">
                    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>