<?php
require __DIR__ . '/../src/Auth.php';
Auth::requireLogin();

$pageTitle = 'Dashboard';
require __DIR__ . '/../templates/header.php';
?>
<div class="card">
    <h1>Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>.</p>
</div>
<?php require __DIR__ . '/../templates/footer.php'; ?>