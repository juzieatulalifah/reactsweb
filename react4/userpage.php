<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}

$sql_social = "SELECT facebook, instagram, twitter 
               FROM contact 
               WHERE username=?";
$stmt_social = $conn->prepare($sql_social);
$stmt_social->bind_param("s", $username);
$stmt_social->execute();
$result_social = $stmt_social->get_result();
$social = $result_social->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Proses data profile-form
    if (isset($_POST['update_profile'])) {
        $pekerjaan = $_POST['pekerjaan'] ?? '';
        $profileImage = $_FILES['profile'] ?? null;
        $profileImagePath = $user['profile'];

        if ($profileImage['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'profile/';
            $fileExtension = pathinfo($profileImage['name'], PATHINFO_EXTENSION);
            $fileName = "profilepic_" . $username . '.' . $fileExtension;
            $targetFile = $uploadDir . $fileName;

            if (!empty($user['profile']) && file_exists($user['profile'])) {
                unlink($user['profile']);
            }

            if (move_uploaded_file($profileImage['tmp_name'], $targetFile)) {
                $profileImagePath = $targetFile;
            } else {
                echo "Error uploading profile picture.";
                exit;
            }
            
        }

        $sql = "UPDATE users SET pekerjaan=?, profile=? WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $pekerjaan, $profileImagePath, $username);
        if (!$stmt->execute()) {
            echo "Error updating profile: " . $conn->error;
        }

    }

    if (isset($_POST['update_social'])) {
        // Ambil data dari form
        $twitter = $_POST['twitter'] ?? '';
        $instagram = $_POST['instagram'] ?? '';
        $facebook = $_POST['facebook'] ?? '';
        $username = $_SESSION['username'];  // Pastikan username sudah ada dari session

        // Cek apakah data sosial media sudah ada untuk username tersebut
        $sql_check = "SELECT * FROM contact WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            // Jika data sudah ada, lakukan UPDATE
            $sql_update = "UPDATE contact SET facebook=?, instagram=?, twitter=? WHERE username=?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssss", $facebook, $instagram, $twitter, $username);

            if (!$stmt_update->execute()) {
                echo "Error updating social profiles: " . $conn->error;
                exit;
            } else {
                echo "Social media profiles updated successfully.";
            }
        } else {
            // Jika data belum ada, lakukan INSERT
            $sql_insert = "INSERT INTO contact (username, facebook, instagram, twitter) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $username, $facebook, $instagram, $twitter);

            if (!$stmt_insert->execute()) {
                echo "Error inserting social profiles: " . $conn->error;
                exit;
            } else {
                echo "Social media profiles added successfully.";
            }
        }
    }
    header('Content-Type: application/json');
    exit;
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Userpage</title>
        <link rel="stylesheet"  href="stylepoints/userpage.css">
        <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
    </head>
<body>
    <div id="overlay"></div>
    <?php include 'navbar.php' ?>

    <section id="mainpage">
        <div class="container1">
            <div class="container1_1">
            <div class="profpic">
                <img id="profile-picture" src="<?php echo $user['profile'] ?: 'https://via.placeholder.com/150';?>" alt="profpic">
            </div>

                <h1><span><?php echo htmlspecialchars($user['username']); ?></span></h1>
                <!-- dibawah itu job name -->
                <p><?php echo htmlspecialchars($user['pekerjaan'] ?: ' '); ?></p>
                <div class="social-media">
                    <a href="https://facebook.com/<?php echo htmlspecialchars($social['facebook']); ?>" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://x.com/<?php echo htmlspecialchars($social['twitter']); ?>" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com/<?php echo htmlspecialchars($social['instagram']); ?>" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
        </div>
            <div class="container1_2">
    <div class="profile-content">
        <p>Username: <span><?php echo htmlspecialchars($user['username']); ?></span></p>
        <p>Email: <span><?php echo htmlspecialchars($user['email']); ?></span></p>
        <p>Pekerjaan: <span><?php echo htmlspecialchars($user['pekerjaan'] ?: 'Belum diatur'); ?></span></p>
        <p>Tanggal Akun Dibuat: <span><?php echo htmlspecialchars($user['tgl_buat']); ?></span></p>
    </div>

    <!-- Form untuk edit profile -->
    <form action="" method="POST" enctype="multipart/form-data" id="profile-form">
    <input type="hidden" name="update_profile">
    <div class="image-upload">
        <label for="gambar">Upload Foto Profil</label><br><br>
        <div class="upload-area" id="upload-area" onclick="document.getElementById('gambar').click();">
            <p id="drag-text">Drag and drop image here or click to select</p>
            <img class="preview-image" id="preview" src="" alt="Preview Gambar" style="display: none;" />
        </div>
        <input type="file" name="profile" id="gambar" accept="image/*" style="display:none;" onchange="previewImageFile(event)">
    </div><br>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="pekerjaan">Pekerjaan:</label>
        <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Belum diatur" value="<?php echo htmlspecialchars($user['pekerjaan']); ?>">
    </div>
    <div class="form-group">
        <label for="tgl_buat">Tanggal Akun Dibuat:</label>
        <input type="text" id="tgl_buat" value="<?php echo htmlspecialchars($user['tgl_buat']); ?>" readonly>
    </div>
</form>

</div>

<!-- Section Social Media -->
<div class="container1_3">
    <h2>Social Media:</h2>
    <div class="innercontainer1_3">
        <span>X.com/<span id="twitter-link"><?php echo htmlspecialchars($social['twitter'] ?? ''); ?></span></span>
        <span>facebook.com/<span id="instagram-link"><?php echo htmlspecialchars($social['facebook'] ?? ''); ?></span></span>
        <span>Instagram.com/<span id="facebook-link"><?php echo htmlspecialchars($social['instagram'] ?? ''); ?></span></span>
    </div>
    <form action="" method="POST" id="social-media-form">
    <input type="hidden" name="update_social">
    <div class="form-group">
        <label for="twitter">Twitter:</label>
        <input type="text" name="twitter" id="twitter" placeholder="Your profile" value="<?php echo htmlspecialchars($social['twitter'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="facebook">Facebook:</label>
        <input type="text" name="facebook" id="facebook" placeholder="Your profile" value="<?php echo htmlspecialchars($social['facebook'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="instagram">Instagram:</label>
        <input type="text" name="instagram" id="instagram" placeholder="Your profile" value="<?php echo htmlspecialchars($social['instagram'] ?? ''); ?>">
    </div>
</form>

</div>

            <a href="logout.php">
                <button class="logout">
                <p>Logout</p>
                </button>
            </a>
            <a href="javascript:void(0)">
                <button class="edit" id="edit-btn">
                    <p>Edit</p>
                </button>
            </a>
            <button class="edit" type="submit" id="save-btn" style="display: none;">
                <p>Save</p>
            </button>
        </div>
    </section>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    const editButton = document.getElementById("edit-btn");
    const saveButton = document.getElementById("save-btn");
    const profileForm = document.getElementById("profile-form");
    const socialForm = document.getElementById("social-media-form");
    const profileContent = document.querySelector(".profile-content");
    const socialMediaContainer = document.querySelector(".innercontainer1_3");
    const uploadArea = document.querySelector(".upload-area");
    const fileInput = document.getElementById("gambar");
    const previewImage = document.getElementById("preview");
    const dragText = document.getElementById("drag-text");

    // Fungsi untuk preview gambar
    const previewImageFile = (file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
            dragText.style.display = "none";
        };
        reader.readAsDataURL(file);
    };

    // Event untuk drag-and-drop
    uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadArea.classList.add("dragging");
        dragText.textContent = "Drop the file here!";
    });

    uploadArea.addEventListener("dragleave", () => {
        uploadArea.classList.remove("dragging");
        dragText.textContent = "Drag and drop image here or click to select";
    });

    uploadArea.addEventListener("drop", (e) => {
        e.preventDefault();
        uploadArea.classList.remove("dragging");

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith("image/")) {
                fileInput.files = e.dataTransfer.files;
                previewImageFile(file);
            } else {
                alert("Please upload a valid image file.");
            }
        }
    });

    fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            previewImageFile(file);
        }
    });

    editButton.addEventListener("click", () => {
        editButton.style.display = "none";
        saveButton.style.display = "block";

        profileForm.style.display = "block";
        socialForm.style.display = "block";
        profileContent.style.display = "none";
        socialMediaContainer.style.display = "none";
        uploadArea.style.display = "block";
    });

    saveButton.addEventListener("click", (e) => {

        e.preventDefault();

        profileFormSave = new FormData(profileForm);
        socialFormSave = new FormData(socialForm);

        // Gabungkan kedua FormData
        for (const [key, value] of socialFormSave.entries()) {
            profileFormSave.append(key, value);
        }

        // Kirim data menggunakan fetch
        fetch('', {
            method: 'POST',
            body: profileFormSave,
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            })
            
            .catch(error => {
                console.error('Error:', error);
            });

        saveButton.style.display = "none";
        editButton.style.display = "block";

        profileForm.style.display = "none";
        socialForm.style.display = "none";
        profileContent.style.display = "block";
        socialMediaContainer.style.display = "block";
        uploadArea.style.display = "none";
    });

    profileForm.style.display = "none";
    socialForm.style.display = "none";
    uploadArea.style.display = "none";
});
</script>
</body>
</html>