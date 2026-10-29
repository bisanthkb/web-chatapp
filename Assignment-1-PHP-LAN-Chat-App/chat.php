<?php
session_start();

// Only people who have joined can see the chat
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$me = $_SESSION['user'];
$chatFile = 'messages.txt';

// Save a new message: one line per message, in the form  name|text
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = trim($_POST['text']);
    $text = str_replace(array("\r", "\n"), ' ', $text);

    if ($text != '') {
        file_put_contents($chatFile, $me . '|' . $text . "\n", FILE_APPEND | LOCK_EX);
    }

    // Redirect so pressing refresh does not post the same message twice
    header('Location: chat.php');
    exit;
}

// Load every saved message
$lines = array();
if (file_exists($chatFile)) {
    $lines = file($chatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LAN Talk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat-window">

        <div class="top-bar">
            <div>
                <div class="title">LAN Talk</div>
                <div class="who">You are <?php echo htmlspecialchars($me); ?></div>
            </div>
            <div class="top-buttons">
                <form method="get" action="chat.php">
                    <button type="submit" class="btn-light">Refresh</button>
                </form>
                <form method="post" action="logout.php">
                    <button type="submit" class="btn-light">Logout</button>
                </form>
            </div>
        </div>

        <div class="chat-area">
            <?php if (count($lines) == 0) { ?>
                <p class="empty">No messages yet. Say hello!</p>
            <?php } ?>

            <?php foreach ($lines as $line) {
                $piece = explode('|', $line, 2);
                if (count($piece) < 2) {
                    continue;
                }
                $sender = $piece[0];
                $body = $piece[1];
                $side = ($sender == $me) ? 'mine' : 'theirs';
            ?>
                <div class="bubble <?php echo $side; ?>">
                    <span class="sender"><?php echo htmlspecialchars($sender); ?></span>
                    <?php echo htmlspecialchars($body); ?>
                </div>
            <?php } ?>
        </div>

        <form method="post" action="chat.php" class="send-bar">
            <input type="text" name="text" placeholder="Write a message..." required>
            <button type="submit" class="btn-primary">Send</button>
        </form>

    </div>
</body>
</html>
