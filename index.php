<?php
// Read the output playlist
$outputFile = "out.m3u";
$channels = [];

if (file_exists($outputFile)) {
    $lines = file($outputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $channel = [];
    
    foreach ($lines as $line) {
        if (strpos($line, "EXTINF") !== false) {
            if ($channel) {
                $channels[] = $channel;
            }
            preg_match('/tvg-name="([^"]+)" .*?tvg-logo="([^"]+)"/', $line, $matches);
            $channel = [
                'name' => $matches[1] ?? 'Unknown Channel',
                'logo' => $matches[2] ?? '',
                'm3u8' => next($lines),
            ];
        }
    }
    if ($channel) {
        $channels[] = $channel;
}

} else {
    echo "Error: Output playlist file not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Channel Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .channel-list {
            display: flex;
            flex-wrap: wrap;
        }
        .channel-item {
            width: 150px;
            margin: 10px;
            text-align: center;
        }
        .channel-item img {
            width: 100%;
            height: auto;
        }
        .channel-item button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .channel-item button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Channel Preview</h1>
    <div class="channel-list">
        <?php foreach ($channels as $channel): ?>
            <div class="channel-item">
                <img src="<?= $channel['logo'] ?>" alt="<?= $channel['name'] ?> Logo">
                <h4><?= $channel['name'] ?></h4>
                <button onclick="playChannel('<?= $channel['m3u8'] ?>')">Play</button>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function playChannel(m3u8Link) {
            window.location.href = m3u8Link;  // Redirect to M3U8 link
        }
    </script>
</body>
</html>
