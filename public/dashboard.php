<?php
require __DIR__ . '/../src/Auth.php';
Auth::requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>.</p>
    <p><a href="logout.php">Log out</a></p>
</body>
</html>
