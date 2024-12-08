<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];

$template_id = $_GET['template_id'] ?? null; 

if ($template_id === null) {
  // Jika template_id tidak ada, arahkan ke halaman pemilihan template
  header("Location: testing.php"); // Ganti dengan halaman pilih template
  exit;
}

$cekemail = "SELECT email FROM users WHERE username = ?";
$stmt = $conn->prepare($cekemail);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah query berhasil dan mengambil email
$email = '';
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email']; // Menyimpan email ke variabel
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Collect form data
  $nama = $_POST['name'];
  $prof_tujuan = $_POST['profession'];
  $desk_diri = $_POST['description'];
  $email = $_POST['email'] ?? '';

  // Collect skills
  $skills = [];
  if (!empty($_POST['skill1'])) $skills[] = $_POST['skill1'];
  if (!empty($_POST['skill2'])) $skills[] = $_POST['skill2'];
  if (!empty($_POST['skill3'])) $skills[] = $_POST['skill3'];

  // Collect experiences
  $experiences = [];
  if (!empty($_POST['position1']) && !empty($_POST['perusahaan1'])) {
    $experiences[] = [
      'position' => $_POST['position1'],
      'company' => $_POST['perusahaan1'],
      'start_year' => $_POST['start1'],
      'end_year' => $_POST['end1']
    ];
  }
  if (!empty($_POST['position2']) && !empty($_POST['perusahaan2'])) {
    $experiences[] = [
      'position' => $_POST['position2'],
      'company' => $_POST['perusahaan2'],
      'start_year' => $_POST['start2'],
      'end_year' => $_POST['end2']
    ];
  }
  if (!empty($_POST['position3']) && !empty($_POST['perusahaan3'])) {
    $experiences[] = [
      'position' => $_POST['position3'],
      'company' => $_POST['perusahaan3'],
      'start_year' => $_POST['start3'],
      'end_year' => $_POST['end3']
    ];
  }

  // Collect social media links
  $linkedin = $_POST['linkedin'] ?? '';
  $twitter = $_POST['twitter'] ?? '';
  $instagram = $_POST['instagram'] ?? '';
  $facebook = $_POST['facebook'] ?? '';
  $phone = $_POST['phone'] ?? '';

  // Collect education data
  $education = [];
  if (!empty($_POST['degree1']) && !empty($_POST['institute1'])) {
    $education[] = [
      'degree' => $_POST['degree1'],
      'institution' => $_POST['institute1'],
      'start_year' => $_POST['startsc1'],
      'end_year' => $_POST['endsc1']
    ];
  }
  if (!empty($_POST['degree2']) && !empty($_POST['institute2'])) {
    $education[] = [
      'degree' => $_POST['degree2'],
      'institution' => $_POST['institute2'],
      'start_year' => $_POST['startsc2'],
      'end_year' => $_POST['endsc2']
    ];
  }
  if (!empty($_POST['degree3']) && !empty($_POST['institue3'])) {
    $education[] = [
      'degree' => $_POST['degree3'],
      'institution' => $_POST['institue3'],
      'start_year' => $_POST['startsc3'],
      'end_year' => $_POST['endsc3']
    ];
  }


  $sql_check = "SELECT * FROM personal WHERE username = ?";
  $stmt_check = $conn->prepare($sql_check);
  $stmt_check->bind_param('s', $username);
  $stmt_check->execute();
  $result = $stmt_check->get_result();

  if ($result->num_rows > 0) {
      // Jika sudah ada, lakukan UPDATE
      $sql_user = "UPDATE personal SET 
                      nama = ?, 
                      tujuan_kerja = ?, 
                      deskripsi = ? 
                    WHERE username = ?";
      $stmt_user = $conn->prepare($sql_user);
      $stmt_user->bind_param('ssss', $nama, $prof_tujuan, $desk_diri, $username);
      if (!$stmt_user->execute()) {
          echo "Error updating user information: " . $conn->error;
      }
  } else {
      // Jika belum ada, lakukan INSERT
      $sql_user = "INSERT INTO personal (username, nama, tujuan_kerja, deskripsi) 
                  VALUES (?, ?, ?, ?)";
      $stmt_user = $conn->prepare($sql_user);
      $stmt_user->bind_param('ssss', $username, $nama, $prof_tujuan, $desk_diri);
      if (!$stmt_user->execute()) {
          echo "Error inserting user information: " . $conn->error;
      }
  }


  // Update skills in the skills table
  $sql_delete_skills = "DELETE FROM skill WHERE username = ?";
  $stmt_delete_skills = $conn->prepare($sql_delete_skills);
  $stmt_delete_skills->bind_param('s', $username);
  $stmt_delete_skills->execute();

  foreach ($skills as $skill) {
      $sql_skill = "INSERT INTO skill (username, skill) VALUES (?, ?)";
      $stmt_skill = $conn->prepare($sql_skill);
      $stmt_skill->bind_param('ss', $username, $skill);
      if (!$stmt_skill->execute()) {
          echo "Error updating skills: " . $conn->error;
      }
  }

  // Update experiences in the experiences table
  $sql_delete_experiences = "DELETE FROM experience WHERE username = ?";
  $stmt_delete_experiences = $conn->prepare($sql_delete_experiences);
  $stmt_delete_experiences->bind_param('s', $username);
  $stmt_delete_experiences->execute();

  foreach ($experiences as $exp) {
      $sql_experience = "INSERT INTO experience (username, posisi, perusahaan, mulai, selesai) 
                         VALUES (?, ?, ?, ?, ?)";
      $stmt_experience = $conn->prepare($sql_experience);
      $stmt_experience->bind_param('sssss', $username, $exp['position'], $exp['company'], $exp['start_year'], $exp['end_year']);
      if (!$stmt_experience->execute()) {
          echo "Error updating experiences: " . $conn->error;
      }
  }

  // Update education in the education table
  $sql_delete_education = "DELETE FROM education WHERE username = ?";
  $stmt_delete_education = $conn->prepare($sql_delete_education);
  $stmt_delete_education->bind_param('s', $username);
  $stmt_delete_education->execute();

  foreach ($education as $edu) {
      $sql_education = "INSERT INTO education (username, gelar, institusi, mulai, selesai) 
                        VALUES (?, ?, ?, ?, ?)";
      $stmt_education = $conn->prepare($sql_education);
      $stmt_education->bind_param('sssss', $username, $edu['degree'], $edu['institution'], $edu['start_year'], $edu['end_year']);
      if (!$stmt_education->execute()) {
          echo "Error updating education: " . $conn->error;
      }
  }

  // Update social media in the social_media table
  // Mengambil data dari form
  $linkedin = $_POST['linkedin'] ?? '';
  $twitter = $_POST['twitter'] ?? '';
  $instagram = $_POST['instagram'] ?? '';
  $facebook = $_POST['facebook'] ?? '';
  $username = $_SESSION['username'];  // Username sudah ada dari session

  // Cek apakah data sosial media sudah ada di database
  $sql_check = "SELECT * FROM contact WHERE username = ?";
  $stmt_check = $conn->prepare($sql_check);
  $stmt_check->bind_param('s', $username);
  $stmt_check->execute();
  $result = $stmt_check->get_result();

  if ($result->num_rows > 0) {
      // Jika sudah ada, lakukan UPDATE
      $sql_social = "UPDATE contact SET 
                    hp = ?,
                    linkedin = ?, 
                    twitter = ?, 
                    instagram = ?, 
                    facebook = ? 
                    WHERE username = ?";
      $stmt_social = $conn->prepare($sql_social);
      $stmt_social->bind_param('ssssss',$phone, $linkedin, $twitter, $instagram, $facebook, $username);
      if (!$stmt_social->execute()) {
          echo "Error updating social media: " . $conn->error;
      }
  } else {
      // Jika belum ada, lakukan INSERT
      $sql_insert = "INSERT INTO contact (username, hp, linkedin, twitter, instagram, facebook) 
                    VALUES (?, ?, ?, ?, ?, ?)";
      $stmt_insert = $conn->prepare($sql_insert);
      $stmt_insert->bind_param('ssssss', $username, $phone, $linkedin, $twitter, $instagram, $facebook);
      if (!$stmt_insert->execute()) {
          echo "Error inserting social media: " . $conn->error;
      }
  }
  if ($template_id == 1) {
    header("Location: template1.php");
  } else if ($template_id == 2) {
      header("Location: template2.php");
  } else {
      // Jika template_id tidak valid, arahkan ke halaman pemilihan template
      header("Location: testing.php");
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Form</title>
    <link rel="stylesheet" href="stylepoints/form.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
</head>
<body>
    <form id="msform" method="POST">
        <ul id="progressbar">
          <li class="active">Profile</li>
          <li>Skills</li>
          <li>Experience</li>
          <li>Education</li>
          <li>Contact</li>
        </ul>

        <!-- Section 1: Profile -->
        <fieldset>
          <h2 class="fs-title">Profile</h2>
          <input type="text" name="name" placeholder="Nama Lengkap" required/>
          <small class="error-message"></small>
          <input type="text" name="profession" placeholder="Profesi yang ingin di apply" required/>
          <small class="error-message"></small>
          <textarea 
            name="description" 
            placeholder="Deskripsi diri (maks 400 karakter)" 
            maxlength="400" 
            oninput="updateWordCount(this)"
            required
          ></textarea>
          <small class="error-message"></small>
          <small id="wordCount" style="display: block; text-align: right; color: #666;">
            0/400 characters
          </small>
          <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>

        <!-- Section 2: Skills & Experience -->
        <fieldset>
          <h2 class="fs-title">Skills</h2>
          <div class="skills-section">
              <input type="text" name="skill1" placeholder="keterampilan" required/>
              <small class="error-message"></small>
              <input type="text" name="skill2" placeholder="keterampilan" required/>
              <small class="error-message"></small>
              <input type="text" name="skill3" placeholder="keterampilan" />
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Next" />
          </div>
          </fieldset>

          <fieldset>
          <h3>Experience</h3>
          <div class="experience-section">
              <input type="text" name="position1" placeholder="Posisi" required/>
              <small class="error-message"></small>
              <input type="text" name="perusahaan1" placeholder="Perusahaan" required/>
              <small class="error-message"></small>
              <input type="number" name="start1" placeholder="Tahun mulai" min="1901" max="2099" step="1" required/>
              <small class="error-message"></small>
              <input type="number" name="end1" placeholder="Tahun selesai" min="1901" max="2099" step="1" required/>
              <small class="error-message"></small>
              <input type="text" name="position2" placeholder="Posisi"/>
              <input type="text" name="perusahaan2" placeholder="Perusahaan"/>
              <input type="number" name="start2" placeholder="Tahun mulai" min="1901" max="2099" step="1" />
              <input type="number" name="end2" placeholder="Tahun selesai" min="1901" max="2099" step="1"/>
              <input type="text" name="position3" placeholder="Posisi" />
              <input type="text" name="perusahaan3" placeholder="Perusahaan" />
              <input type="number" name="start3" placeholder="Tahun mulai" min="1901" max="2099" step="1" />
              <input type="number" name="end3" placeholder="Tahun selesai" min="1901" max="2099" step="1" />
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Next" />
          </div>
          </fieldset>

          <fieldset>
          <h3>Education</h3>
          <div class="education-section">
              <input type="text" name="degree1" placeholder="Gelar" required/>
              <small class="error-message"></small>
              <input type="text" name="institute1" placeholder="Institusi" required/>
              <small class="error-message"></small>
              <input type="number" name="startsc1" placeholder="Tahun mulai" min="1901" max="2099" step="1" required/>
              <small class="error-message"></small>
              <input type="number" name="endsc1" placeholder="Tahun selesai" min="1901" max="2099" step="1" required/>
              <small class="error-message"></small>
              <input type="text" name="degree2" placeholder="Gelar"/>
              <input type="text" name="institute2" placeholder="Institusi" />
              <input type="number" name="startsc2" placeholder="Tahun mulai" min="1901" max="2099" step="1"/>
              <input type="number" name="endsc2" placeholder="Tahun selesai" min="1901" max="2099" step="1"/>
              <input type="text" name="degree3" placeholder="Gelar" />
              <input type="text" name="institute3" placeholder="Institusi" />
              <input type="number" name="startsc3" placeholder="Tahun mulai" min="1901" max="2099" step="1" />
              <input type="number" name="endsc3" placeholder="Tahun selesai" min="1901" max="2099" step="1" />
          </div>
          <input type="button" name="previous" class="previous action-button" value="Previous" />
          <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>

        <!-- Section 3: Contact -->
        <fieldset>
          <h2 class="fs-title">Contact & Social Media</h2>
          <input type="tel" name="phone" placeholder="Telepon (0812679352142)" pattern="[0-9]{10,15}" required/>
          <small class="error-message"></small>
          <input type="email" name="email" placeholder="Email" value="<?php echo $email ?? '' ?>" readonly />
          <input type="text" name="linkedin" placeholder="LinkedIn Profile" required/>
          <small class="error-message"></small>
          <input type="text" name="twitter" placeholder="Twitter Profile (username)" value="<?php echo $twitter ?? '' ?>"required />
          <small class="error-message"></small>
          <input type="text" name="instagram" placeholder="Instagram Profile (username)" value="<?php echo $instagram ?? '' ?>" required/>
          <small class="error-message"></small>
          <input type="text" name="facebook" placeholder="Facebook Profile (username)" value="<?php echo $facebook ?? '' ?>" required/>
          <small class="error-message"></small>
          <input type="button" name="previous" class="previous action-button" value="Previous" />
          <input type="submit" name="submit" class="submit action-button" value="Submit" />
        </fieldset>
    </form>

    <script src="script/form.js"></script>
</body>
</html>
