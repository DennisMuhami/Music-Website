<?php
session_start();
require_once 'auth/music_functions.php';

// Get the file from URL
$file_path = isset($_GET['file']) ? $_GET['file'] : '';

// Security check - make sure file is in music directory
if (empty($file_path) || strpos($file_path, 'music/') !== 0) {
    header('Location: home.php');
    exit;
}

// Get absolute path
$absolute_path = __DIR__ . '/' . $file_path;

// Check if file exists
if (!file_exists($absolute_path)) {
    header('Location: home.php');
    exit;
}

// Get file info
$file_name = basename($absolute_path);
$file_title = pathinfo($file_name, PATHINFO_FILENAME);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Now Playing - <?php echo htmlspecialchars($file_title); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .player-container {
            background: rgba(10, 10, 26, 0.9);
            backdrop-filter: blur(20px);
            padding: 48px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .back-btn {
            text-align: left;
            margin-bottom: 30px;
        }

        .back-btn a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .back-btn a:hover {
            color: #ffffff;
        }

        .music-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #ff006e, #8338ec);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 48px;
            color: white;
            box-shadow: 0 10px 30px rgba(131, 56, 236, 0.5);
        }

        .song-title {
            color: white;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .song-name {
            color: #ff006e;
            font-size: 18px;
            margin-bottom: 30px;
            word-break: break-word;
        }

        audio {
            width: 100%;
            margin: 30px 0;
        }

        audio::-webkit-media-controls-panel {
            background: linear-gradient(135deg, #ff006e, #8338ec);
        }

        audio::-webkit-media-controls-play-button {
            background-color: white;
            border-radius: 50%;
        }

        .download-btn {
            display: inline-block;
            background: transparent;
            border: 2px solid #ff006e;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .download-btn:hover {
            background: #ff006e;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 0, 110, 0.3);
        }
    </style>
</head>
<body>
    <div class="player-container">
        <div class="back-btn">
            <a href="home.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>">
                <i class="fas fa-arrow-left"></i>
                Back to Music
            </a>
        </div>

        <div class="music-icon">
            <i class="fas fa-headphones-alt"></i>
        </div>

        <h1 class="song-title">Now Playing</h1>
        <h2 class="song-name"><?php echo htmlspecialchars($file_title); ?></h2>

        <audio controls autoplay>
            <source src="<?php echo htmlspecialchars($file_path); ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>

        <a href="<?php echo htmlspecialchars($file_path); ?>" download class="download-btn">
            <i class="fas fa-download"></i> Download Song
        </a>
    </div>
</body>
</html>