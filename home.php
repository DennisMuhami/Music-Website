<?php
session_start();

// Include music functions
require_once 'auth/music_functions.php';

// Check if there's a search query
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$show_results = !empty($search_query); // Only show results if there's a search term

// Only search if there's a query
if ($show_results) {
    $music_files = searchMusic($search_query);
}

$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Musically - Live your day with Music</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="stylesheet" href="home.css" />
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar">
      <div class="nav-container">
        <div class="logo">
          <i class="fas fa-music"></i>
          <span>Musically</span>
        </div>

        <ul class="nav-menu">
          <li><a href="#" class="active">Home</a></li>
          <li><a href="music.php">Music</a></li>
          <li><a href="#">New Arrival</a></li>
          <li><a href="#">Download</a></li>
          <li><a href="#">Pricing</a></li>
        </ul>

        <div class="nav-buttons">
          <?php if ($logged_in): ?>
          <!-- Show this when user is logged in -->
          <span style="color: white; margin-right: 15px">
            Welcome,
            <span style="color: #ff006e"><?php echo $username; ?></span>!
          </span>
          <a
            href="auth/logout.php"
            class="btn-logout"
            style="
              background: linear-gradient(135deg, #ff006e, #8338ec);
              color: white;
              padding: 8px 20px;
              border-radius: 50px;
              text-decoration: none;
              font-weight: 600;
            "
            >Log Out</a
          >
          <?php else: ?>
          <!-- Show this when user is not logged in -->
          <a href="login.php" class="btn-login">Log In</a>
          <a href="register.php" class="btn-signup">Sign Up</a>
          <?php endif; ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </nav>

    <!-- Welcome Section -->
    <div style="text-align: center; margin-top: 100px; padding: 40px">
      <?php if ($logged_in): ?>
      <h1 style="color: white; font-size: 48px; margin-bottom: 20px">
        Welcome back, <?php echo htmlspecialchars($username); ?>! 🎵
      </h1>
      <p style="color: rgba(255, 255, 255, 0.8); font-size: 18px">
        Ready to discover some amazing music?
      </p>
      <?php else: ?>
      <h1 style="color: white; font-size: 48px; margin-bottom: 20px">
        Welcome to Musically 🎵
      </h1>
      <p style="color: rgba(255, 255, 255, 0.8); font-size: 18px">
        Please <a href="login.php" style="color: #ff006e">login</a> or
        <a href="register.html" style="color: #ff006e">sign up</a> to get
        started.
      </p>
      <?php endif; ?>
    </div>

    <!-- Search Section -->
    <div
      class="search-container"
      style="max-width: 600px; margin: 40px auto; padding: 0 20px"
    >
      <form action="home.php" method="GET" style="display: flex; gap: 10px">
        <input
          type="text"
          name="search"
          placeholder="Search for songs..."
          value="<?php echo htmlspecialchars($search_query); ?>"
          style="
            flex: 1;
            padding: 15px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 16px;
          "
        />
        <button
          type="submit"
          style="
            padding: 15px 30px;
            background: linear-gradient(135deg, #ff006e, #8338ec);
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            cursor: pointer;
          "
        >
          <i class="fas fa-search"></i> Search
        </button>
      </form>
    </div>

    <!-- Music Results - Only shown when there's a search -->
    <?php if ($show_results): ?>
    <div
      class="music-container"
      style="max-width: 800px; margin: 0 auto; padding: 20px"
    >
      <h2 style="color: white; margin-bottom: 20px">
        Search Results for "<?php echo htmlspecialchars($search_query); ?>"
        (<?php echo count($music_files); ?> found)
      </h2>

      <?php if (empty($music_files)): ?>
      <div
        style="
          text-align: center;
          padding: 50px;
          background: rgba(255, 255, 255, 0.05);
          border-radius: 20px;
          color: rgba(255, 255, 255, 0.6);
        "
      >
        <i
          class="fas fa-music"
          style="font-size: 48px; margin-bottom: 20px"
        ></i>
        <p>No songs found. Try a different search term.</p>
      </div>
      <?php else: ?>
      <div class="music-list">
        <?php foreach ($music_files as $index => $song): ?>
        <div
          class="music-item"
          style="
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
          "
          onmouseover="this.style.background = 'rgba(255,255,255,0.1)'"
          onmouseout="this.style.background = 'rgba(255,255,255,0.05)'"
        >
          <div style="display: flex; align-items: center; gap: 15px">
            <div
              style="
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, #ff006e, #8338ec);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
              "
            >
              <i class="fas fa-music"></i>
            </div>
            <div>
              <h3 style="color: white; margin: 0; font-size: 16px">
                <?php echo htmlspecialchars($song['title']); ?>
              </h3>
              <p
                style="
                  color: rgba(255, 255, 255, 0.5);
                  margin: 5px 0 0 0;
                  font-size: 12px;
                "
              >
                <?php echo $song['size']; ?>
              </p>
            </div>
          </div>

          <a
            href="player.php?file=<?php echo urlencode($song['path']); ?>"
            style="
              background: transparent;
              border: 2px solid #ff006e;
              color: white;
              padding: 8px 20px;
              border-radius: 50px;
              text-decoration: none;
              font-weight: 600;
              transition: all 0.3s ease;
            "
            onmouseover="this.style.background = '#ff006e'"
            onmouseout="this.style.background = 'transparent'"
          >
            <i class="fas fa-play"></i> Play
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Optional: Add a welcome message or featured content when no search -->
    <?php if (!$show_results): ?>
    <div
      style="
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.7);
      "
    >
      <i
        class="fas fa-music"
        style="font-size: 80px; color: #ff006e; margin-bottom: 20px"
      ></i>
      <h2 style="color: white; font-size: 32px; margin-bottom: 15px">
        Discover Music
      </h2>
      <p style="font-size: 18px; max-width: 600px; margin: 0 auto">
        Use the search bar above to find songs in our collection. Just type a
        song name and hit search!
      </p>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-container">
        <div class="hero-content">
          <h1 class="hero-title">
            Live your day<br />
            with <span class="italic-text">Music</span>
          </h1>
          <p class="hero-description">
            Say goodbye to interruptions and enjoy uninterrupted music
            streaming. With our add-free platform, you'll have access to
            millions of songs.
          </p>
          <button
            class="btn-get-started"
            onclick="window.location.href = 'index.html'"
          >
            Get Started
            <i class="fas fa-arrow-right"></i>
          </button>
        </div>

        <div class="hero-image">
          <div class="hero-gradient-circle"></div>
          <div class="floating-image">
            <i class="fas fa-headphones"></i>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Albums Section -->
    <section class="featured-albums">
      <div class="albums-container">
        <!-- Album Card 1 -->
        <div class="album-card card-pink">
          <div class="album-overlay">
            <div class="album-year">2021</div>
          </div>
          <div class="album-content">
            <div class="album-image-placeholder">
              <i class="fas fa-compact-disc"></i>
            </div>
          </div>
          <button class="album-play-btn">
            <i class="fas fa-play"></i>
          </button>
        </div>

        <!-- Album Card 2 -->
        <div class="album-card card-dark">
          <div class="album-image-container">
            <div class="album-title-overlay">
              <h3>DARK<br />MOON</h3>
              <div class="album-subtitle">Original Soundtrack</div>
            </div>
            <div class="album-image-placeholder dark">
              <i class="fas fa-moon"></i>
            </div>
          </div>
          <button class="album-play-btn">
            <i class="fas fa-play"></i>
          </button>
        </div>

        <!-- Album Card 3 -->
        <div class="album-card card-coral">
          <div class="album-overlay">
            <div class="album-discount-tag">DON'T COUNT<br />MAKE IT COUNT</div>
          </div>
          <div class="album-content">
            <div class="album-image-placeholder coral">
              <i class="fas fa-fire"></i>
            </div>
          </div>
          <button class="album-play-btn">
            <i class="fas fa-play"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features">
      <div class="features-container">
        <h2 class="section-title">Why Choose Musically?</h2>

        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-ad"></i>
            </div>
            <h3>Ad-Free Experience</h3>
            <p>
              Enjoy uninterrupted music streaming without any advertisements
            </p>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-infinity"></i>
            </div>
            <h3>Unlimited Songs</h3>
            <p>Access millions of songs from artists around the world</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-download"></i>
            </div>
            <h3>Offline Mode</h3>
            <p>Download your favorite tracks and listen anywhere</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-heart"></i>
            </div>
            <h3>Personalized Playlists</h3>
            <p>Get custom playlists based on your music taste</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="cta-container">
        <h2>Ready to start your musical journey?</h2>
        <p>Join millions of music lovers worldwide</p>
        <div class="cta-buttons">
          <button
            class="btn-get-started"
            onclick="window.location.href = 'register.html'"
          >
            Sign Up Now
            <i class="fas fa-arrow-right"></i>
          </button>
          <button
            class="btn-secondary"
            onclick="window.location.href = 'index.html'"
          >
            Explore Music
          </button>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-left">
          <div class="logo">
            <i class="fas fa-music"></i>
            <span>Musically</span>
          </div>
          <p>Your ultimate music streaming platform</p>
        </div>

        <div class="footer-links">
          <div class="footer-column">
            <h4>Company</h4>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Press</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Support</h4>
            <ul>
              <li><a href="#">Help Center</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Social</h4>
            <div class="social-icons">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; 2024 Musically. All rights reserved.</p>
      </div>
    </footer>

    <script src="home.js"></script>
  </body>
</html>
