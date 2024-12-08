<link rel="stylesheet"  href="stylepoints/navbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="icon" type="image/jpeg" href="stylepoints/aset/logo.ico">
 
 <nav id="navigation">
        <button id="hamburgerMenu" aria-label="Toggle Menu">
            <i class="fa fa-bars"></i> <!-- Font Awesome icon for the hamburger -->
        </button>

        <div id="sidebar">
            <button id="toggleSidebar">
                <i class="fa fa-street-view"></i>
                <i class="fa fa-home"></i>
                <i class="fa fa-puzzle-piece"></i>
                <i class="fa fa-question"></i>
                <i class="fa fa-id-badge"></i>
                <i class="fa fa-info"></i>
                <i class="fa fa-angle-left"></i>
            </button>

            <div class="loginbar">
                <div class="profilecircle">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                    <!-- Tampilkan gambar profil -->
                    <img src="<?php echo htmlspecialchars($user['profile'] ?? 'https://via.placeholder.com/100'); ?>" alt="Profile Picture">
                <?php endif; ?>
                </div>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                    <a href="userpage.php" class="loginbutton"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <?php else: ?>
                    <a href="login.php" class="loginbutton">Log in</a>
                <?php endif; ?>
            </div>

            <menu id="navbar-list">
                <li class="navbar-item">
                    <a href="index.php" id="navbar-text">
                        Beranda
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="testing.php" id="navbar-text">
                        Tutorial
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="faq.php" id="navbar-text">
                        FAQ
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="testing.php#create-cv" id="navbar-text">
                        Bikin CV
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="about.php" id="navbar-text">
                        Tentang
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="about.php#kontaksen" id="navbar-text">
                        Kontak
                    </a>
                </li>

                <div id="copyright">
                        <a href="#" id="navbar-text">
                            © 2024 - 2024 React.Ltd - All Rights Reserved.
                        </a>
                    </li>
                </div>
            </menu>
        </div>
    </nav>
    <script src="script/scriptberanda.js">
</script>