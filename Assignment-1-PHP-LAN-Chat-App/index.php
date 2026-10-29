<?php
session_start();

// Already have a name? Skip straight to the chat room
if (!empty($_SESSION['user'])) {
    header('Location: chat.php');
    exit;
}

// When the join form is submitted, remember the name in the session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $name = str_replace('|', '', $name); // "|" is our separator in messages.txt

    if ($name != '') {
        $_SESSION['user'] = $name;
        header('Location: chat.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LAN Talk - Join</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="join-page">
    <div class="join-card">
        <div class="logo">LAN Talk</div>
        <p class="tagline">Chat with someone on the same Wi-Fi</p>

        <form method="post" action="index.php">
            <label for="name">Your name</label>
            <input type="text" id="name" name="name" placeholder="e.g. Rahul" required>
            <button type="submit" class="btn-primary">Join Chat</button>
        </form>
    </div>
</body>
</html>
