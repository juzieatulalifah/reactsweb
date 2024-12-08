<?php
session_start();
require "koneksi.php";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$isLoggedIn = false;
if ($username){
    $isLoggedIn = true; 
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
<html lang="en">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Homepage</title>
    <link rel="stylesheet"  href="stylepoints/index.css">
    <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
</head>
<body>
    <div id="overlay"></div>
    <?php include 'navbar.php' ?>
    

    <section id="mainpage1">
        <div class="containervideo1">
            <video autoplay loop muted>
                <source src="stylepoints/aset/reactlogo.mp4" type="video/mp4" />
              </video>
        </div>
        <div class="container1">
            <h1>Buat CV anda, untuk masa depan anda</h1>
            <p>Walaupun website ini simple,
                anda dapat membuat CV anda sendiri hanya dengan beberapa klik</p>
        </div>
    </section>

    <section id="mainpage2">
        <div class="container2_1">
            <h2>Mudah Dipakai</h2>
            <span></span>
            <p>Cukup dengan memasukkan biodata dan beberapa info lainnya, <br>anda bisa membuat CV anda sendiri.</p>
        </div>

        <div class="container2_2">
            <h2>Unjuk Gigi Anda!</h2>
            <span></span>
            <p>Dengan CV, anda dapat menunjukkan keahlian Anda dalam format nyata dan praktis.</p>
        </div>

        <div class="container2_3">
            <h2>Tidak Perlu Biaya</h2>
            <span></span>
            <p>Kami tidak mengambil biaya dari tiap CV yang anda buat, buat CV sebanyak yang anda butuhkan!</p>
        </div>
    </section>

    <section id="mainpage3">
        <div class="container3">
            <div class="container2video">
                <video autoplay loop muted>
                    <source src="stylepoints/aset/cv-unscreen.mp4" type="video/mp4" />
                </video>
            </div>
            <h3>Siap Membantu Anda</h3>
            <p>Layanan di situs pembuat CV Anda bekerja lebih 
                baik dan membantu Anda melakukan lebih banyak hal saat Anda masuk. 
                Akun Anda memberi akses ke fitur-fitur berguna seperti pengisian otomatis, 
                rekomendasi yang dipersonalisasi, dan lainnya—kapan saja dan di perangkat apa saja.</p>
                <div class="container3_1">
    <div class="buttons">
        <button class="tablinks" onclick="openAbout(event, 'Mudah')">Mudah</button>
        <button class="tablinks" onclick="openAbout(event, 'Personal')">Personal</button>
        <button class="tablinks" onclick="openAbout(event, 'Perhatian')">Perhatian</button>
    </div>

    <div id="Mudah" class="tabcontent">
        <p>Buat CV yang mengesankan secara visual dengan platform kami yang mudah digunakan, 
            bahkan tanpa pengalaman desain sebelumnya. 
            Buat resume yang tampak hebat dan mengomunikasikan keterampilan Anda secara efektif.
            <br><br>
            <strong><?php echo $isLoggedIn ? 'Buat CV Anda Sekarang!' : 'Login Untuk Membuat CV Anda Sekarang!'; ?></strong>
            <br>
            <a href="<?php echo $isLoggedIn ? 'testing.php' : 'login.php'; ?>" id="button">
                <?php echo $isLoggedIn ? 'Create CV' : 'Log in'; ?>
            </a>
        </p>
        <div class="container3video">
            <video autoplay loop muted>
                <source src="stylepoints/aset/ngetik-unscreen.mp4" type="video/mp4" />
            </video>
        </div>
    </div>

    <div id="Personal" class="tabcontent">
        <p>Personalisasikan CV Anda secara mudah dengan berbagai template, tata letak, dan opsi desain yang membantu 
            Anda menonjol dari yang lain dan memberikan kesan mengesankan pada manajer perekrutan.
            <br><br>
            <strong><?php echo $isLoggedIn ? 'Buat CV Sekarang Untuk Mempersonalisasikan CV Anda! ' : 'Login Untuk Mempersonalisasikan CV Anda Sekarang!'; ?></strong>
            <br>
            <a href="<?php echo $isLoggedIn ? 'testing.php' : 'login.php'; ?>" id="button">
                <?php echo $isLoggedIn ? 'Create CV' : 'Log in'; ?>
            </a>
        </p>
        <div class="container3video">
            <video autoplay loop muted>
                <source src="stylepoints/aset/1S3nC005NpQMqCy42O-unscreen.mp4" type="video/mp4" />
            </video>
        </div>
    </div>

    <div id="Perhatian" class="tabcontent">
        <p>Dengan template yang dapat disesuaikan dan fitur yang mudah digunakan, 
            Anda dapat membuat CV yang menyoroti kekuatan, pengalaman, dan keterampilan Anda, 
            membantu Anda diperhatikan oleh pemberi kerja lebih cepat dan mendapatkan peluang berikutnya.
            <br><br>
            <strong><?php echo $isLoggedIn ? 'Buat CV Sekarang Mempromosikan Personal Branding Anda!' : 'Login Untuk Mempromosikan Personal Branding Anda!'; ?></strong>
            <br>
            <a href="<?php echo $isLoggedIn ? 'testing.php' : 'login.php'; ?>" id="button">
                <?php echo $isLoggedIn ? 'Create CV' : 'Log in'; ?>
            </a>
        </p>
        <div class="container3video">
            <video autoplay loop muted>
                <source src="stylepoints/aset/man-unscreen.mp4" type="video/mp4" />
            </video>
        </div>
    </div>
</div>

    </section>


    <footer>
        <div class="react">
            <img src="stylepoints/aset/react.png" alt="ini_file" height="200">
        </div>
        <div class="social-media">
            <a href="https://facebook.com" target="_blank">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://twitter.com" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://instagram.com" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </footer>
    <script src="index.js"></script>
</body>
</html>