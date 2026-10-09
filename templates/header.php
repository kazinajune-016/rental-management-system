<?php
require_once __DIR__ . '/../src/Auth.php';

// Pages can set these before including the header
$pageTitle = $pageTitle ?? 'Rental Management';
$base = $base ?? ''; // use '../' for pages inside public subfolders
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?> | Rental Management</title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= $base ?>dashboard.php">Rental Management</a>
        <?php if (Auth::check()): ?>
            <nav class="nav">
                <a href="<?= $base ?>dashboard.php">Dashboard</a>
                <?php /* Add Units, Tenants, Leases and Payments links as those pages are built */ ?>
                <a href="<?= $base ?>logout.php">Log out</a>
            </nav>
        <?php endif; ?>
    </div>
</header>
<main class="container">