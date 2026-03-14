<?php
// Scan the music folder for audio files
$musicDir = 'music/';
$allowedExtensions = ['mp3', 'wav', 'ogg', 'flac', 'm4a'];
$songs = [];

if (is_dir($musicDir)) {
    $files = scandir($musicDir);
    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $allowedExtensions)) {
            $songs[] = [
                'file'  => $musicDir . $file,
                'title' => pathinfo($file, PATHINFO_FILENAME),
                'ext'   => $ext,
            ];
        }
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music - Musically</title>
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
            background-attachment: fixed;
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Animated background blobs */
        body::before {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 0, 110, 0.1), transparent);
            border-radius: 50%;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            animation: pulse 8s ease-in-out infinite;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(131, 56, 236, 0.1), transparent);
            border-radius: 50%;
            bottom: -150px;
            right: -100px;
            animation: float 10s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulse {
            0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.3; }
            50%       { transform: translateX(-50%) scale(1.1); opacity: 0.5; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-40px); }
        }

        /* ── Nav ── */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
            background: rgba(10, 10, 26, 0.6);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo i {
            font-size: 28px;
            background: linear-gradient(135deg, #ff006e, #8338ec);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-logo span {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
        }

        .nav-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            margin-left: 24px;
            font-size: 15px;
            transition: color 0.3s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #ff006e;
        }

        /* ── Page header ── */
        .page-header {
            text-align: center;
            padding: 60px 20px 40px;
        }

        .page-header h1 {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #ff006e, #8338ec);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .page-header p {
            color: rgba(255,255,255,0.55);
            font-size: 16px;
        }

        /* ── Container ── */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 80px;
        }

        /* ── Song count badge ── */
        .song-count {
            display: inline-block;
            background: rgba(131,56,236,0.2);
            border: 1px solid rgba(131,56,236,0.4);
            color: #b79fff;
            font-size: 13px;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 32px;
        }

        /* ── Song cards ── */
        .song-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .song-card {
            background: rgba(10, 10, 26, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 24px 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: border-color 0.3s, transform 0.2s;
            animation: slideUp 0.4s ease both;
        }

        .song-card:hover {
            border-color: rgba(131,56,236,0.4);
            transform: translateY(-2px);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .song-card:nth-child(1)  { animation-delay: 0.05s; }
        .song-card:nth-child(2)  { animation-delay: 0.10s; }
        .song-card:nth-child(3)  { animation-delay: 0.15s; }
        .song-card:nth-child(4)  { animation-delay: 0.20s; }
        .song-card:nth-child(5)  { animation-delay: 0.25s; }
        .song-card:nth-child(6)  { animation-delay: 0.30s; }

        /* ── Song top row ── */
        .song-top {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .song-index {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            flex-shrink: 0;
        }

        .song-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255,0,110,0.25), rgba(131,56,236,0.25));
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .song-icon i {
            font-size: 18px;
            background: linear-gradient(135deg, #ff006e, #8338ec);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .song-info {
            flex: 1;
            min-width: 0;
        }

        .song-title {
            font-size: 17px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: capitalize;
            /* replace hyphens/underscores visually */
        }

        .song-meta {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Play button ── */
        .btn-play {
            background: linear-gradient(135deg, #ff006e, #8338ec);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(131,56,236,0.3);
        }

        .btn-play:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(131,56,236,0.45);
        }

        .btn-play.playing {
            background: linear-gradient(135deg, #8338ec, #ff006e);
        }

        /* ── Audio player ── */
        .song-player {
            display: none;
        }

        .song-player.visible {
            display: block;
        }

        audio {
            width: 100%;
            height: 40px;
            border-radius: 8px;
            accent-color: #8338ec;
        }

        /* Style the native audio element across browsers */
        audio::-webkit-media-controls-panel {
            background: rgba(255,255,255,0.05);
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: rgba(255,255,255,0.4);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            display: block;
            opacity: 0.3;
        }

        .empty-state h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: rgba(255,255,255,0.6);
        }

        .empty-state p {
            font-size: 14px;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            nav { padding: 16px 20px; }
            .page-header h1 { font-size: 30px; }
            .song-card { padding: 18px 16px; }
            .song-title { font-size: 15px; }
            .btn-play span { display: none; }
            .btn-play { padding: 10px 14px; }
            .song-index { display: none; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <a href="home.php" class="nav-logo">
            <i class="fas fa-music"></i>
            <span>Musically</span>
        </a>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="music.php" class="active">Music</a>
            <a href="login.html">Login</a>
            <a href="register.html">Sign Up</a>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-headphones-alt" style="font-size:36px;"></i> All Music</h1>
        <p>Browse and play all available tracks</p>
    </div>

    <!-- Main Content -->
    <div class="container">

        <?php if (empty($songs)): ?>

            <!-- Empty state -->
            <div class="empty-state">
                <i class="fas fa-compact-disc"></i>
                <h2>No songs found</h2>
                <p>Add audio files (mp3, wav, ogg, flac, m4a) to the <code>music/</code> folder.</p>
            </div>

        <?php else: ?>

            <div class="song-count">
                <?= count($songs) ?> track<?= count($songs) !== 1 ? 's' : '' ?> available
            </div>

            <!-- Song list -->
            <div class="song-list">
                <?php foreach ($songs as $index => $song): ?>

                    <div class="song-card" id="card-<?= $index ?>">

                        <!-- Top row: index, icon, title, play button -->
                        <div class="song-top">

                            <div class="song-index"><?= $index + 1 ?></div>

                            <div class="song-icon">
                                <i class="fas fa-music"></i>
                            </div>

                            <div class="song-info">
                                <div class="song-title">
                                    <?= htmlspecialchars(str_replace(['-', '_'], ' ', $song['title'])) ?>
                                </div>
                                <div class="song-meta"><?= strtoupper($song['ext']) ?></div>
                            </div>

                            <!-- Play button -->
                            <button 
                                class="btn-play" 
                                id="btn-<?= $index ?>"
                                onclick="togglePlay(<?= $index ?>)"
                            >
                                <i class="fas fa-play" id="icon-<?= $index ?>"></i>
                                <span>Play</span>
                            </button>

                        </div>

                        <!-- Audio player (shown on play) -->
                        <div class="song-player" id="player-<?= $index ?>">
                            <audio 
                                id="audio-<?= $index ?>" 
                                src="<?= htmlspecialchars($song['file']) ?>"
                                controls
                                onended="onSongEnd(<?= $index ?>)"
                            ></audio>
                        </div>

                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>

    <script>
        let currentPlaying = null;

        function togglePlay(index) {
            const audio  = document.getElementById('audio-'  + index);
            const player = document.getElementById('player-' + index);
            const btn    = document.getElementById('btn-'    + index);
            const icon   = document.getElementById('icon-'   + index);

            // If another song is playing, stop it first
            if (currentPlaying !== null && currentPlaying !== index) {
                stopSong(currentPlaying);
            }

            if (audio.paused) {
                // Show the player and start playing
                player.classList.add('visible');
                audio.play();
                btn.classList.add('playing');
                icon.classList.replace('fa-play', 'fa-pause');
                btn.querySelector('span').textContent = 'Pause';
                currentPlaying = index;
            } else {
                // Pause
                audio.pause();
                btn.classList.remove('playing');
                icon.classList.replace('fa-pause', 'fa-play');
                btn.querySelector('span').textContent = 'Play';
                currentPlaying = null;
            }
        }

        function stopSong(index) {
            const audio = document.getElementById('audio-'  + index);
            const btn   = document.getElementById('btn-'    + index);
            const icon  = document.getElementById('icon-'   + index);

            audio.pause();
            audio.currentTime = 0;
            btn.classList.remove('playing');
            icon.classList.replace('fa-pause', 'fa-play');
            btn.querySelector('span').textContent = 'Play';
        }

        function onSongEnd(index) {
            const btn  = document.getElementById('btn-'  + index);
            const icon = document.getElementById('icon-' + index);
            btn.classList.remove('playing');
            icon.classList.replace('fa-pause', 'fa-play');
            btn.querySelector('span').textContent = 'Play';
            currentPlaying = null;
        }
    </script>

</body>
</html>