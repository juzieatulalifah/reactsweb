<?php
session_start();
require 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];


// Query user data
$userQuery = "SELECT * FROM users u
              LEFT JOIN personal p ON u.username = p.username
              LEFT JOIN contact c ON u.username = c.username
              WHERE u.username = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

// Query skill data
$skillQuery = "SELECT * FROM skill WHERE username = ?";
$stmt = $conn->prepare($skillQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$skills = $stmt->get_result();

// Query experience data
$experienceQuery = "SELECT * FROM experience WHERE username = ?";
$stmt = $conn->prepare($experienceQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$experiences = $stmt->get_result();

// Query education data
$educationQuery = "SELECT * FROM education WHERE username = ?";
$stmt = $conn->prepare($educationQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$educations = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume</title>
    <link rel="stylesheet" href="stylepoints/temp2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
</head>
<body>
    <div class="button-wrapper2">
    <button id="backtohome"><i class="fa-solid fa-arrow-left"></i></button>
    </div>

    <div class="resume-container">
        <!-- Header -->
        <div class="header">
            <h1><?php echo htmlspecialchars($userData['nama'] ?? 'Your Name'); ?></h1>
            <p><?php echo htmlspecialchars($userData['tujuan_kerja'] ?? 'Your Career Objective'); ?></p>
        </div>

        <div class="main-content">
            <!-- Left Column -->
            <div class="left-column">
                <div class="profile-image">
                    <img src="<?php 
                        echo htmlspecialchars(
                            $userData['profile'] && file_exists($userData['profile']) 
                            ? $userData['profile'] 
                            : 'https://via.placeholder.com/150'
                        ); 
                    ?>" alt="Profile">
                </div>

                <!-- Education -->
                <div class="education">
                    <h3>Education</h3>
                    <?php while ($education = $educations->fetch_assoc()): ?>
                        <p>
                            <strong><?php echo htmlspecialchars($education['mulai']) . ' - ' . htmlspecialchars($education['selesai']); ?></strong><br>
                            <?php echo htmlspecialchars($education['gelar']); ?><br>
                            <?php echo htmlspecialchars($education['institusi']); ?>
                        </p>
                    <?php endwhile; ?>
                </div>

                <!-- Skills -->
                <div class="skills">
                    <h3>Skills</h3>
                    <ul>
                        <?php while ($skill = $skills->fetch_assoc()): ?>
                            <li><?php echo htmlspecialchars($skill['skill']); ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <!-- About Me -->
                <div class="about">
                    <h3>About Me</h3>
                    <p><?php echo htmlspecialchars($userData['deskripsi'] ?? 'Describe yourself here.'); ?></p>
                </div>

                <!-- Work Experience -->
                <div class="work-experience">
                    <h3>Work Experience</h3>
                    <?php while ($experience = $experiences->fetch_assoc()): ?>
                        <p>
                            <strong><?php echo htmlspecialchars($experience['mulai']) . ' - ' . htmlspecialchars($experience['selesai']); ?></strong><br>
                            <?php echo htmlspecialchars($experience['posisi']); ?><br>
                            <?php echo htmlspecialchars($experience['perusahaan']); ?>
                        </p>
                    <?php endwhile; ?>
                </div>

                <!-- Contact -->
                <div class="contact">
                    <h3>Contact</h3>
                    <p><?php echo htmlspecialchars($userData['hp'] ?? 'Phone Number'); ?></p>
                    <p><?php echo htmlspecialchars($userData['email'] ?? 'Email Address'); ?></p>
                    <p>x.com/<strong><?php echo htmlspecialchars($userData['twitter']); ?></strong></p>
                    <p>instagram.com/<strong><?php echo htmlspecialchars($userData['instagram']); ?></strong></p>
                    <p>linkedin.com/<strong><?php echo htmlspecialchars($userData['linkedin']); ?></strong></p>
                    <p>facebook.com/<strong><?php echo htmlspecialchars($userData['facebook']); ?></strong></p>
            </div>
        </div>
    </div>
  </div>  
    
    <!-- <div class="button-wrapper">
    <button id="editbaten">Edit CV</button>
    <button id="saveAsImage">Save as Image</button>
    </div> -->
    <!-- <button id="saveAsImage">Save as Image</button> -->
    <div class="button-wrapper">
    <a href="form.php?template_id=2"><button id="editbaten">Edit CV</button></a>
    <button id="saveAsImage">Save as Image</button>
    </div>

    <!-- Tambahkan Script html2canvas -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        // document.getElementById('editbaten').addEventListener('click', function() {
        //     window.location.href = 'form.php';
        // });

        document.getElementById('backtohome').addEventListener('click', function() {
        window.location.href = 'testing.php#create-cv';
        });

        document.getElementById('saveAsImage').addEventListener('click', function() {
            const container = document.querySelector('.resume-container'); // Pilih elemen
            html2canvas(container, {
                scale: 2, // Tingkatkan resolusi hasil tangkapan layar
                useCORS: true // Pastikan gaya dari file eksternal dimuat
            }).then(function(canvas) {
                // Buat elemen link untuk mengunduh gambar
                let link = document.createElement('a');
                link.download = 'resume<?php echo $userData['username']?>.jpg';
                link.href = canvas.toDataURL('image/jpeg', 1.0); // Format JPG dengan kualitas penuh
                link.click();
            });
        });
    </script>
</body>
</html>
