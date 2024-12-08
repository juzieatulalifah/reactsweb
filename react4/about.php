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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us & Contact</title>
    <link rel="stylesheet" href="stylepoints/about_us.css">
    <!-- <link rel="stylesheet" href="stylepoints/index.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
    <style>
        /* About Us Section Styles */
        .member {
            position: relative;
            margin-bottom: 30px;
        }

        .member p {
            margin-left: 20px;
        }

        .social-media-popup {
            display: none;
            position: absolute;
            top: -30px;
            right: 10px;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .member:hover .social-media-popup {
            display: block;
            transform: translateY(10px);
        }

        .social-media-popup a {
            display: flex;
            margin-bottom: 5px;
            font-size: 25px;
            color: #333;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .social-media-popup a:hover {
            transform: scale(1.2);
        }

        .photo img {
            width: 150px;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
            position: relative;
        }

        /* Contact Section Styles */
        .contact-container {
            display: flex;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 1275px;
            margin: 50px auto; 
            height: 600px;
        }

        .map-section {
            flex: 1;
        }

        .map-section iframe {
            width: 100%; 
            height: 100%; 
            border: none;
        }

        .info-section {
            flex: 1;
            background-color: #8f0000;
            color: #ffffff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: 18px;
        }

        .info-section h2 {
            margin-bottom: 15px;
            color: #ffffff;
            font-size: 28px;
        }


        .info-section p {
            margin: 10px 0;
            font-size: 18px;
        }

        .info-section .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-section .contact-item i {
            margin-right: 15px;
            color: #758694;
            font-size: 24px;
        }

        .social-media {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
        }

        .social-media a {
            color: #ffffff;
            font-size: 30px;
            text-decoration: none;
            margin-right: 20px;
        }

        .social-media a:hover {
            color: #758694;
        }

        .social-media-text {
            color: #ffffff;
            font-size: 20px;
            margin-bottom: 5px;
            text-align: center;
            margin-top: 80px;
        }

        .social-media-popup {
                display: flex;
                flex-direction: column;
                position: absolute;
                bottom: -30px; 
                right: 0; 
                opacity: 0;
                visibility: hidden;
                transform: translateY(-20px);
                transition: 
                    opacity 0.4s ease-out, 
                    transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                    visibility 0.4s ease-out;
                z-index: 10;
            }

            /* Aktifkan popup ketika .member di-hover */
            .member:hover .social-media-popup {
                opacity: 1;
                visibility: visible;
                transform: translateY(10px); 
            }

            .social-media-popup a {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 8px;
                font-size: 25px;
                color: #333;
                text-decoration: none;
                transition: 
                    transform 0.3s ease-out,
                    color 0.3s ease;
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 50%;
                width: 45px;
                height: 45px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .social-media-popup a:hover {
                transform: scale(1.15) rotate(360deg);
                color: #007bff;
                background-color: rgba(255, 255, 255, 1);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            }

            .social-media-popup a:nth-child(1) {
                transition-delay: 0.1s;
            }

            .social-media-popup a:nth-child(2) {
                transition-delay: 0.2s;
            }

        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
                max-width: 100%;
                height: auto;
                margin: 0;
            }

            .map-section iframe {
                height: 300px;
            }
        }

        
    </style>
</head>
<body>
    <?php include 'navbar.php' ?>
    
    <main class="content">
        <!-- About Us Section -->
        <div class="about-us">
            <img src="stylepoints/aset/team.jpg" alt="Team Photo" class="team-photo">
            <div class="about-text">
                <h1>About Us</h1>
                <p>Team kami merupakan Team dari kelompok react yang dibimbing oleh pak Rajiansyah. Berikut adalah anggota-anggota kami.</p>
            </div>
        </div>
        <h2>Our Team</h2>
        <div class="team-members">
            <div class="member">
                <div class="photo">
                    <img src="stylepoints/aset/syukur.jpg" alt="Khairil Syukri">
                    <div class="social-media-popup">
                        <a href="https://instagram.com/rilll_27" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/khairil" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <p>Khairil Syukri</p>
            </div>
            <div class="member">
                <div class="photo">
                    <img src="stylepoints/aset/cancan.jpg" alt="Chandra Adha Rezki Pahlawan">
                    <div class="social-media-popup">
                        <a href="https://instagram.com/chandrarezki7" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/chandra" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <p>Chandra Adha R P</p>
            </div>
            <div class="member">
                <div class="photo">
                    <img src="stylepoints/aset/yunew.jpg" alt="Qurrata Ayuni">
                    <div class="social-media-popup">
                        <a href="https://instagram.com/qrrtayuni_" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/yunew" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <p>Qurrata Ayuni</p>
            </div>
            <div class="member">
                <div class="photo">
                    <img src="stylepoints/aset/fajar.jpg" alt="Adithya Fajar Al-huda">
                    <div class="social-media-popup">
                        <a href="https://instagram.com/eci_504210" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/fajar" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <p>Adithya Fajar Al-huda</p>
            </div>
            <div class="member">
                <div class="photo">
                    <img src="stylepoints/aset/elloy.jpg" alt="Nur Juzieatul Alifah">
                    <div class="social-media-popup">
                        <a href="https://instagram.com/yzj668969_" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/elly" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <p>Nur Juzieatul Alifah</p>
            </div>
            <div class="member">
                <div class="photo">
                    <img src="stylepoints/aset/dosen.jpg" alt="Rajiansyah">
                    <div class="social-media-popup">
                        <a href="https://instagram.com/rjiansyahh" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/raji" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <p>Rajiansyah</p>
            </div>
        </div>

        <!-- Contact Us Section -->
        <div class="contact-container" id="kontaksen">
            <div class="map-section">
                <iframe 
                    loading="lazy"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=universitas%20mulawarman&zoom=15&maptype=roadmap">
                </iframe>
            </div>
            <div class="info-section">
                <h2>Kontak Kami</h2>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <p>Jl. kuaro, Gn. kelua</p>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <p>reactforall@gmail.com</p>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <p>0812-3456-7643</p>
                </div>
                <div class="social-media-text">Social Media Kami</div>
                <div class="social-media">
                    <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>