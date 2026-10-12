<?php
require __DIR__ . '/../../src/Auth.php';
require __DIR__ . '/../../src/Unit.php';
Auth::requireLogin('../login.php');

$units = Unit::all();
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

$pageTitle = 'Units';
$base = '../';
require __DIR__ . '/../../templates/header.php';
?>
<div class="card">
    <h1>Units</h1>

    <?php if ($flash): ?>
        <p class="alert alert-success"><?= htmlspecialchars($flash) ?></p>
    <?php endif; ?>

    <p><a class="btn" href="form.php">Add unit</a></p>

    <?php if (!$units): ?>
        <p>No units yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>Name</th><th>Rent</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($units as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= number_format((float) $u['rent_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($u['status']) ?></td>
                    <td><a href="form.php?id=<?= (int) $u['id'] ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../../templates/footer.php'; ?>