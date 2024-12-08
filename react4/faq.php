<?php
session_start();
require "koneksi.php";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
if ($username){
    $query = "SELECT profile FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

$current_page = basename($_SERVER['PHP_SELF']); // Get the current page file name
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
  <link rel="stylesheet" href="stylepoints/faq.css">
  <!-- <link rel="stylesheet" href="stylepoints/index.css"> -->
</head>
<body>

<?php include 'navbar.php' ?>

<div class="faq-container">
    <h1>Frequently Asked Questions</h1>
  <!-- Header -->
  <div class="faq-search">
    <h3>Berikut adalah beberapa pertanyaan yang sering diajukan oleh pengguna kami. Semoga dapat membantu Anda!<br>
    Temukan jawaban atas berbagai pertanyaan mengenai layanan kami, mulai dari cara penggunaan, informasi terkini, hingga panduan lengkap untuk meningkatkan pengalaman Anda.</h3>
</div>
</header>

<!-- Konten FAQ -->
<main class="faq-content">
    <section class="faq-list">
        <article class="faq-item">
            <div class="faq-question">
                <h3>Berita terbaru?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Tetap up-to-date dengan berita terbaru dan eksplorasi topik yang sedang tren terkait layanan kami dan industri.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Bagaimana cara mendaftar?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Pelajari langkah-langkah mudah untuk mendaftar dan mulai menggunakan platform kami dengan cepat.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Informasi tentang perusahaan kami?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Temukan lebih banyak tentang misi, visi, dan tim yang mendukung kesuksesan perusahaan kami.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Apakah ada fitur baru?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Kami secara rutin menambahkan fitur baru. Jelajahi pembaruan terbaru yang dapat membantu Anda.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Bagaimana cara menghubungi tim kami?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Hubungi tim kami melalui email, telepon, atau formulir kontak untuk mendapatkan bantuan lebih lanjut.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Apa saja layanan yang kami tawarkan?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Kami menawarkan berbagai layanan yang dirancang untuk memenuhi kebutuhan Anda. Jelajahi layanan kami di sini.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Bagaimana cara mengatur profil?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Pelajari cara memperbarui informasi pribadi Anda dan mengelola pengaturan profil dengan mudah.
            </div>
        </article>
        <article class="faq-item">
            <div class="faq-question">
                <h3>Apakah ada panduan penggunaan?</h3>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Kami menyediakan panduan penggunaan yang dirancang untuk membantu Anda memahami fitur-fitur utama platform kami.
            </div>
        </article>
    </section>
    </section>
    <aside class="faq-image">
      <img src="stylepoints/aset/faq.png" alt="FAQ Illustration">
    </aside>
  </main>
</div>

<script>
  document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {
      item.classList.toggle('active');
    });
  });
</script>
</body>
</html>
