<?php
include "database/database.php";
session_start();

$login_massage = "";
$register_massage = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // cek username
    $check_sql = "SELECT * FROM akun WHERE username='$username'";
    $check_result = $db->query($check_sql);

    if ($check_result->num_rows > 0) {
        $register_massage = "Username sudah terdaftar!";
    } else {
        // simpan user baru
        $insert_sql = "INSERT INTO akun (id_user, username, password) VALUES ('','$username', '$password')";
        if ($db->query($insert_sql) === TRUE) {
            $register_massage = "Registrasi berhasil! Silakan login.";
        } else {
            $register_massage = "Terjadi kesalahan saat registrasi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <!-- Login -->
        <div class="login-box">
            <h2>REGISTER</h2>
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
                    <button type="submit" class="btn" name="register">Daftar</button>
                </div>
                <div class="message"><?= $login_massage ?></div>
                <div class="text-center small">
                    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>