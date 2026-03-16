# 🎵 Musically - Music Streaming Web Application

A modern, Spotify-inspired music streaming platform built with HTML, CSS, JavaScript, PHP, and MySQL. Musically offers users a seamless experience to browse, play, and enjoy music with a beautiful, responsive interface.

![Musically](https://img.shields.io/badge/Status-Active-success)
![Version](https://img.shields.io/badge/Version-1.0.0-blue)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Table of Contents

- [Features](#-features)
- [Demo](#-demo)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Installation](#-installation)
- [Usage](#-usage)
- [Screenshots](#-screenshots)
- [Team](#-team)
- [Contributing](#-contributing)
- [License](#-license)

---

## ✨ Features

### 🎨 Frontend Features
- **Modern Landing Page**
  - Animated hero section with gradient backgrounds
  - Featured album cards with hover effects
  - Smooth scroll animations
  - Parallax effects for depth
  - Fully responsive design

- **Interactive Music Player**
  - Play, pause, next, and previous controls
  - Real-time progress bar with seek functionality
  - Volume control with visual feedback
  - Song queue display
  - Keyboard shortcuts (Space, Arrow keys)
  - Fixed bottom player bar

- **User Authentication UI**
  - Modern login and registration forms
  - Client-side validation
  - Password strength indicator
  - Real-time error messages
  - Glassmorphic design elements

### 🔐 Backend Features
- **User Authentication**
  - Secure user registration with password hashing (`password_hash()`)
  - Login system with session management
  - Email validation
  - Duplicate user prevention

- **Music Management**
  - Dynamic song loading from MySQL database
  - Song metadata storage (title, artist, duration, file path)
  - Efficient database queries

- **Security**
  - SQL injection prevention
  - Password encryption
  - Session-based authentication
  - Form validation (client and server-side)

---

## 🎬 Demo

### Live Pages
- **Landing Page:** `home.html` or `home.php`
- **Music Player:** `player.php`
- **Login:** `login.php`
- **Register:** `register.php`

### Quick Start
1. Visit the landing page
2. Click "Get Started" to explore the music player
3. Sign up for an account to access full features
4. Log in and start streaming music!

---

## 🛠️ Tech Stack

### Frontend
- **HTML5** - Structure and semantic markup
- **CSS3** - Styling, animations, and responsive design
  - Flexbox & Grid layouts
  - CSS Variables for theming
  - Keyframe animations
  - Media queries for responsiveness
- **JavaScript (ES6)** - Interactivity and functionality
  - HTML5 Audio API
  - Intersection Observer API
  - DOM Manipulation
  - Event Handling

### Backend
- **PHP 7.4+** - Server-side logic
- **MySQL** - Database management
- **Apache/XAMPP** - Local development server

### Libraries & Tools
- **Font Awesome 6.4.0** - Icons
- **Git** - Version control
- **GitHub** - Code repository

---

## 📁 Project Structure

```
musically/
│
├── auth/                          # Authentication pages
│   ├── login.php                  # User login with session management
│   └── register.php               # User registration with password hashing
│
├── music/                         # Music files directory
│   └── [songs uploaded by users]
│
├── home.css                       # Landing page styles
├── home.js                        # Landing page interactions
├── home.php                       # Landing page (PHP version)
│
├── login.php                      # Login backend logic
├── register.php                   # Registration backend logic
│
├── player.php                     # Music player page
├── music.php                      # Music management backend
│
├── config.php                     # Database configuration (not in repo)
├── .gitignore                     # Git ignore file
└── README.md                      # Project documentation
```

---

## 🚀 Installation

### Prerequisites
- **XAMPP** or **WAMP** (Apache + MySQL + PHP)
- **Modern Web Browser** (Chrome, Firefox, Edge)
- **Git** (optional, for cloning)

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/musically.git
cd musically
```

### Step 2: Set Up Database

1. **Start XAMPP/WAMP** and launch Apache and MySQL

2. **Open phpMyAdmin** (http://localhost/phpmyadmin)

3. **Create Database:**
```sql
CREATE DATABASE musically;
USE musically;
```

4. **Create Tables:**

**Users Table:**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Songs Table:**
```sql
CREATE TABLE songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    duration VARCHAR(10) NOT NULL,
    uploaded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
);
```

5. **Insert Sample Data:**
```sql
INSERT INTO songs (title, artist, file_path, duration) VALUES
('Blinding Lights', 'The Weeknd', 'music/song1.mp3', '3:20'),
('Shape of You', 'Ed Sheeran', 'music/song2.mp3', '3:54'),
('Levitating', 'Dua Lipa', 'music/song3.mp3', '3:23'),
('Save Your Tears', 'The Weeknd', 'music/song4.mp3', '3:36'),
('Peaches', 'Justin Bieber', 'music/song5.mp3', '3:18');
```

### Step 3: Configure Database Connection

Create `config.php` in the root directory:
```php
<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'musically');

// Create connection
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### Step 4: Add Music Files

1. Create a `music/` folder in the project root
2. Add your MP3 files (name them `song1.mp3`, `song2.mp3`, etc.)
3. Ensure file paths in the database match your file names

### Step 5: Run the Application

1. Move project folder to `htdocs/` (XAMPP) or `www/` (WAMP)
2. Open browser and navigate to:
   ```
   http://localhost/musically/home.php
   ```

---

## 💻 Usage

### For Users

**1. Browse Music (No Login Required)**
- Visit the landing page
- Click "Get Started" or "Explore Music"
- View available songs

**2. Create an Account**
- Click "Sign Up" on the landing page
- Fill in username, email, and password
- Submit the form
- Redirected to login page

**3. Log In**
- Click "Log In"
- Enter email and password
- Access full player features

**4. Play Music**
- Click any song to play
- Use controls:
  - **Spacebar:** Play/Pause
  - **Left Arrow:** Previous song
  - **Right Arrow:** Next song
- Drag progress bar to seek
- Adjust volume with slider

### For Developers

**Frontend Customization:**
- Modify colors in CSS variables (`home.css` and `styles.css`)
- Edit HTML structure in respective files
- Add animations in JavaScript files

**Backend Customization:**
- Modify database queries in PHP files
- Add new features (playlists, favorites, etc.)
- Enhance security measures

**Adding New Songs:**
1. Upload MP3 to `music/` folder
2. Insert record in database:
```sql
INSERT INTO songs (title, artist, file_path, duration) 
VALUES ('Song Title', 'Artist Name', 'music/newsong.mp3', '3:45');
```

---

## 📸 Screenshots

### Landing Page
- Modern hero section with animated gradients
- Featured album cards
- Features showcase

### Music Player
- Sidebar with navigation
- Song list with play indicators
- Bottom player bar with controls

### Authentication
- Login form with validation
- Registration with password strength
- Error handling

---

## 👥 Team

| Role | Responsibilities | Files |
|------|-----------------|-------|
| **Frontend Developer** | Landing page, Music player UI, Auth pages | `home.html`, `home.css`, `home.js`, `player.html`, `styles.css`, `script.js` |
| **Backend Developer (Auth)** | User authentication, Session management | `login.php`, `register.php`, `config.php` |
| **Backend Developer (Music)** | Music data management, Database queries | `music.php`, `player.php` |
| **Database Designer** | Database schema, Sample data | MySQL tables and relationships |

---

## 🔧 Configuration

### Color Theme
Edit CSS variables in `home.css`:
```css
:root {
    --primary-gradient: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    --accent-pink: #ff006e;
    --accent-purple: #8338ec;
    --accent-coral: #ff5a5f;
    --text-light: #ffffff;
    --text-gray: #b8b8b8;
}
```

### Database Settings
Edit `config.php`:
```php
define('DB_HOST', 'localhost');     // Database host
define('DB_USER', 'root');          // Database username
define('DB_PASS', '');              // Database password
define('DB_NAME', 'musically');     // Database name
```

---

## 🐛 Known Issues

- [ ] Mobile menu animation needs improvement
- [ ] Add playlist functionality
- [ ] Implement search feature
- [ ] Add user profile page
- [ ] Support for more audio formats (FLAC, OGG)

---

## 🚧 Roadmap

### Version 1.1 (Planned)
- [ ] User playlists
- [ ] Favorite songs feature
- [ ] Search functionality
- [ ] User profile management
- [ ] Admin dashboard

### Version 2.0 (Future)
- [ ] Social features (follow users, share songs)
- [ ] Lyrics display
- [ ] Music recommendations
- [ ] API for mobile app
- [ ] Cloud storage integration

---

## 🤝 Contributing

We welcome contributions! Here's how you can help:

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Commit your changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push to the branch**
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Open a Pull Request**

### Coding Standards
- Use meaningful variable names
- Comment complex logic
- Follow existing code style
- Test before submitting

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- **Font Awesome** for beautiful icons
- **Spotify** for design inspiration
- **MDN Web Docs** for excellent documentation
- **Stack Overflow** community for problem-solving help

---

## 📞 Contact

**Project Link:** [https://github.com/DennisMuhami/Music-Website](https://github.com/DennisMuhami/Music-Website)

**Team Email:**
- atiengivylisa@gmail.com

---

## ⚠️ Security Note

**For Production Deployment:**
1. Change database credentials
2. Use prepared statements (PDO) instead of mysqli
3. Implement CSRF protection
4. Add rate limiting for login attempts
5. Use HTTPS
6. Sanitize all user inputs
7. Keep `config.php` out of version control
8. Enable error logging (disable display_errors)

---

## 📚 Documentation

### API Endpoints (Backend)

**Authentication:**
- `POST /login.php` - User login
- `POST /register.php` - User registration
- `GET /logout.php` - User logout

**Music:**
- `GET /music.php` - Fetch all songs
- `POST /music.php` - Upload new song (admin)

### JavaScript Functions

**Player Controls (`script.js`):**
- `playSongAtIndex(index)` - Play song at specific position
- `togglePlayPause()` - Toggle play/pause state
- `updateProgress()` - Update progress bar
- `seekAudio()` - Jump to position in song
- `adjustVolume()` - Change volume level

**Animations (`home.js`):**
- `fadeInObserver` - Intersection Observer for scroll animations
- `parallax effect` - Background parallax on scroll

---

## 🎓 Learning Resources

If you want to understand the technologies used:

- **HTML/CSS:** [MDN Web Docs](https://developer.mozilla.org/)
- **JavaScript:** [JavaScript.info](https://javascript.info/)
- **PHP:** [PHP.net](https://www.php.net/docs.php)
- **MySQL:** [MySQL Documentation](https://dev.mysql.com/doc/)

---

**Made with ❤️ by the Musically Team**

**Star ⭐ this repo if you find it helpful!**
