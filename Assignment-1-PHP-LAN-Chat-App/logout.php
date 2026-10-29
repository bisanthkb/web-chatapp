<?php
session_start();

// Clear the session so the name is forgotten
$_SESSION = array();
session_destroy();

header('Location: index.php');
exit;
