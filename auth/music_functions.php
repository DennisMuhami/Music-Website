<?php
// Function to get all music files from the music folder
function getMusicFiles() {
    $music_dir = __DIR__ . '/../music/';
    $allowed_extensions = ['mp3', 'wav', 'ogg', 'm4a'];
    $music_files = [];
    
    // Check if directory exists
    if (is_dir($music_dir)) {
        // Scan the directory
        $files = scandir($music_dir);
        
        foreach ($files as $file) {
            // Skip . and .. directories
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            // Get file extension
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            // Check if it's an audio file
            if (in_array($extension, $allowed_extensions)) {
                // Get file information
                $file_path = $music_dir . $file;
                $file_size = filesize($file_path);
                $file_modified = filemtime($file_path);
                
                // Extract song title (remove extension)
                $title = pathinfo($file, PATHINFO_FILENAME);
                
                $music_files[] = [
                    'filename' => $file,
                    'title' => $title,
                    'path' => 'music/' . $file,
                    'size' => formatFileSize($file_size),
                    'modified' => date('Y-m-d H:i:s', $file_modified)
                ];
            }
        }
    }
    
    return $music_files;
}

// Helper function to format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Function to search music files
function searchMusic($search_term) {
    $all_music = getMusicFiles();
    $results = [];
    
    if (empty($search_term)) {
        return $all_music; // Return all if no search term
    }
    
    $search_term = strtolower($search_term);
    
    foreach ($all_music as $song) {
        // Search in filename and title
        if (strpos(strtolower($song['filename']), $search_term) !== false || 
            strpos(strtolower($song['title']), $search_term) !== false) {
            $results[] = $song;
        }
    }
    
    return $results;
}
?>