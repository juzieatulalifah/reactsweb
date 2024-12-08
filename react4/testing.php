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
  <title>CV Publik & Template</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="stylepoints/tes.css">
  <link rel="stylesheet" href="stylepoints/index.css">
  <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
</head>
<body>
  <?php include 'navbar.php' ?>

  <div class="content">
    <div class="tutorial-title"><strong>TUTORIAL MENGGUNAKAN TEMPLATE</strong></div>
    <div class="tutorial-section">
      <div class="tutorial-text">
        Jika Anda ingin membuat CV, Anda diharuskan untuk membuat akun terlebih dahulu, apabila akun anda selesai, Anda bisa melakukannya melalui Buat CV setelah log masuk atau opsi kedua bisa dilakukan melalui CV publik dengan menekan buat CV Anda sendiri, lalu mengisi data diri anda di dalam forum. Pembuatan CV pun selesai, and dapat mengunduh CV yang telah anda buat dalam bentuk image, ataupun mengedit CV anda dengan menekan tombol edit.
      </div>
      <div class="video-container">
        <object width="640" height="360" data="https://www.youtube.com/v/AORnkBzE0i4" type="application/x-shockwave-flash">
          <param name="movie" value="https://www.youtube.com/v/AORnkBzE0i4" />
          <param name="allowFullScreen" value="true" />
          <param name="allowScriptAccess" value="always" />
        </object>
      </div>
    </div>
    <div class="tutorial-section">
      <div class="video-container">
        <object width="640" height="360" data="https://www.youtube.com/v/AORnkBzE0i4" type="application/x-shockwave-flash">
          <param name="movie" value="https://www.youtube.com/v/AORnkBzE0i4" />
          <param name="allowFullScreen" value="true" />
          <param name="allowScriptAccess" value="always" />
        </object>
      </div>
      <div class="tutorial-text">
        Pada halaman userpage, anda dapat mengedit foto profil, biodata, pekerjaan, beserta sosial media anda. Namun, untuk dapat mengakses userpage ini, tentunya anda harus memiliki akun terlebih dahulu, apabila anda belum memiliki akun, klik menu log in pada sidebar, lalu akan diminta untuk meregistrasi dengan menggunakan email, username, dan password(minimal 8). Jika sudah, anda akan dapat mengakses userpage anda.
      </div>
    </div>

  <main id="content">
    <!-- Show CV Section -->
    <section id="show-cv">
      <h1>CV Publik</h1>
      <div class="cv-grid">
        <div class="cv-card">
          <img src="stylepoints\aset\temp2.png" alt="CV 1">
        </div>
        <div class="cv-card">
          <img src="stylepoints\aset\mek.png" alt="CV 2">
        </div>
        <div class="cv-card">
          <img src="stylepoints\aset\temp2.png" alt="CV 3">
        </div>
        <div class="cv-card">
          <img src="stylepoints\aset\mek.png" alt="CV 4">
        </div>
        <div class="cv-card">
          <img src="stylepoints\aset\temp2.png" alt="CV 5">
        </div>
        <div class="cv-card">
          <img src="stylepoints\aset\mek.png" alt="CV 6">
        </div>
    </div>
    <button class="btn-create"> <a href="#create-cv" class="btn-kirit">Bikin CV Anda</a></button>
</section>

    <!-- Create CV Section -->
    <section id="create-cv">
      <h1>Template CV</h1>
      <div class="templates">
      <div class="template">
        <img src="stylepoints/aset/temp2.png" alt="Template 1">
        <button><a href="form.php?template_id=1" class="btn-kirit">Gunakan template ini</a></button> <!-- Template 1 -->
      </div>
      <div class="template">
        <img src="stylepoints/aset/mek.png" alt="Template 2">
        <button><a href="form.php?template_id=2" class="btn-kirit">Gunakan template ini</a></button> <!-- Template 2 -->
      </div>
      </div>
    </section>

  </main>
</body>
</html>
