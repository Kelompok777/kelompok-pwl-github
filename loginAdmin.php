<?php
include "database/database.php"; // koneksi ke database
session_start();

$login_massage = "";
$register_massage = "";

// PROSES LOGIN
if (isset($_POST['login'])) {
    $usernameAdmin = $_POST['usernameAdmin'];
    $passwordAdmin = $_POST['passwordAdmin'];

    $sql = "SELECT * FROM akunAdmin WHERE usernameAdmin='$usernameAdmin' AND passwordAdmin='$passwordAdmin'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["usernameAdmin"] = $data["usernameAdmin"];
        $_SESSION["is_login"] = true;
        header("Location: halamanAdmin.php"); // halaman setelah login
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
                    <input type="text" name="usernameAdmin" placeholder="Username Admin" required>
                </div>
                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="passwordAdmin" placeholder="PasswordAdmin" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn" name="login">Login</button>
                </div>
                <div class="message"><?= $login_massage ?></div>
            </form>
        </div>
    </div>

</body>

</html>