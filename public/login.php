<?php
require __DIR__ . '/../src/Auth.php';

if (Auth::check()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (Auth::attempt($email, $password)) {
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid email or password.';
}

$pageTitle = 'Login';
require __DIR__ . '/../templates/header.php';
?>
<div class="card card-narrow">
    <h1>Landlord Login</h1>

    <?php if ($error): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-row">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-row">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Log in</button>
    </form>
</div>
<?php require __DIR__ . '/../templates/footer.php'; ?>