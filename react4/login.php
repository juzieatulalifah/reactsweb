<?php
session_start();
require "koneksi.php";

function validateInput($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = validateInput($_POST['signuser']);
    $email = validateInput($_POST['email']);
    $password = $_POST['password'];

    // Validasi password minimal 8 karakter
    if (strlen($password) < 8) {
        echo json_encode(["status" => "error", "message" => "Password minimal 8 karakter!"]);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Cek username atau email sudah digunakan
    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Username atau email sudah digunakan!"]);
        exit;
    }

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Simpan data ke tabel users
        $tanggal_buat = date('Y-m-d'); // Format tanggal standar
        $insertQuery = "INSERT INTO users (username, email, password, tgl_buat) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $tanggal_buat);
        $stmt->execute();
        $stmt->close();

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        // Redirect ke halaman login setelah berhasil
        echo "<script>window.location.href = 'login.php';</script>";

    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Terjadi kesalahan saat mendaftar!"]);
    }

    $conn->close();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = validateInput($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            echo "<script>window.location.href = 'index.php';</script>";
        }
    }
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="stylepoints/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
</head>
<body>

<div class="container">
    <div class="curved-shape"></div>
    <div class="curved-shape"></div>
    <div class="curved-shape2"></div>
    <div class="form-box login">
        <h2 class="animation" style="--D:0; --S:21">Log in</h2>
        <form action="" method="POST">
            <div class="input-box animation" style="--D:1; --S:22">
                <input type="text" name="username" required>
                <label for="">Nama Pengguna</label>
                <i class='bx bxs-user' style='color:#ffffff'></i>
            </div>
            <p id="message-luser"></p>
            <div class="input-box animation" style="--D:2; --S:23">
                <input type="password" name="password" required>
                <label for="">Kata Sandi</label>
                <i class='bx bxs-key' style='color:#ffffff'></i>
            </div>
            <div class="input-box animation" style="--D:3; --S:24">
                <button class="btn" type="submit" name="login">Masuk</button>
            </div>
            <div class="regis-link animation" style="--D:4; --S:25">
                <p>Belum memiliki akun? <a href="#" class="signuplink">Daftar</a></p>
            </div>
        </form>
    </div>

    <div class="info-content login">
        <h2 class="animation" style="--D:0; --S:20">Selamat Datang</h2>
        <p class="animation" style="--D:1; --S:21">Silahkan masuk ke akun anda!</p>
    </div>

    <div class="form-box register">
        <h2 class="animation" style="--li:17; --S:0">Daftar</h2>
        <form action="" method="POST">
            <div class="input-box animation" style="--li:18; --S:1">
                <input type="text" name="signuser" required>
                <label for="">Nama Pengguna</label>
                <i class='bx bxs-user' style='color:#ffffff'></i>
            </div>
            <p id="message-user"></p>
            <div class="input-box animation" style="--li:19; --S:2">
                <input type="email" name="email" required>
                <label for="">Surel</label>
                <i class='bx bx-envelope' style='color= #ffffff'></i>
            </div>
            <p id="message-email"></p>
            <div class="input-box animation" style="--li:20; --S:3">
                <input type="password" name="password" required pattern=".{8,}" title="Masukkan password minimal 8 karakter">
                <label for="">Kata Kunci</label>
                <i class='bx bxs-key' style='color:#ffffff'></i>
            </div>
            <div class="input-box animation" style="--li:21; --S:4">
                <button class="btn" type="submit" name="signup">Daftar</button>
            </div>
            <div class="regis-link animation" style="--li:22; --S:5">
                <p>Sudah punya akun? <a href="#" class="signinlink">Masuk</a></p>
            </div>
        </form>
    </div>

    <div class="info-content register">
        <h2 class="animation" style="--li:17; --S:0;">Pertama Kali Disini?</h2>
        <p class="animation" style="--li:18; --S:1;">Silahkan buat akun anda!</p>
    </div>
</div>

<script src="index.js"></script>
</body>
</html>
