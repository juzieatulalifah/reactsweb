<?php
session_start();
require "koneksi.php";

// Periksa apakah user sudah login dengan memeriksa session 'username'
if (isset($_SESSION['username'])) {
    // Jika sudah login, ambil username dari sesi
    $username = $_SESSION['username'];
    $query = "SELECT profile FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Lakukan sesuatu dengan data user, seperti menampilkan profil
        $profile = $user['profile'];
    } else {
        // Jika user tidak ditemukan dalam database
        $profile = "User tidak ditemukan.";
    }
} else {
    // Jika session 'username' tidak ada, berarti user belum login
    $profile = "Anda belum login.";
    $_SESSION['login'] = false; // Set session login = false
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV Publik</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="stylepoints/show.css">
  <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
</head>
<body>
    <?php include 'navbar.php' ?>
    
    <main id="content">
      <h1>CV Publik</h1>
      <div class="cv-grid">
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 1">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 2">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 3">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 4">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 5">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 6">
        </div>
      </div>
      <button class="btn-create">Bikin CV Anda</button>
      <p><?php echo $profile; ?></p>
    </main>
  </div>
</body>
</html><?php
session_start();
require "koneksi.php";

// Periksa apakah user sudah login dengan memeriksa session 'username'
if (isset($_SESSION['username'])) {
    // Jika sudah login, ambil username dari sesi
    $username = $_SESSION['username'];
    $query = "SELECT profile FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Lakukan sesuatu dengan data user, seperti menampilkan profil
    } else {
        // Jika user tidak ditemukan dalam database
        echo "User tidak ditemukan.";
    }
} else {
    // Jika session 'username' tidak ada, berarti user belum login
    $_SESSION['login'] = false; // Set session login = false
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV Publik</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="stylepoints/show.css">
</head>
<body>
    <?php include 'navbar.php' ?>

   
    
    <main id="content">
      <h1>CV Publik</h1>
      <div class="cv-grid">
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 1">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 2">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 3">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 4">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 5">
        </div>
        <div class="cv-card">
          <img src="https://via.placeholder.com/200" alt="CV 6">
        </div>
      </div>
      <button class="btn-create">Bikin CV Anda</button>
    </main>
  </div>
</body>
</html>
