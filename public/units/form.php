<?php
require __DIR__ . '/../../src/Auth.php';
require __DIR__ . '/../../src/Unit.php';
Auth::requireLogin('../login.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$unit = ['name' => '', 'rent_amount' => '', 'status' => 'vacant'];

if ($id) {
    $existing = Unit::find($id);
    if (!$existing) {
        http_response_code(404);
        exit('Unit not found.');
    }
    $unit = $existing;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit = [
        'name' => trim($_POST['name'] ?? ''),
        'rent_amount' => $_POST['rent_amount'] ?? '',
        'status' => $_POST['status'] ?? '',
    ];
    $errors = Unit::validate($unit);

    if (!$errors) {
        if ($id) {
            Unit::update($id, $unit);
            $_SESSION['flash'] = 'Unit updated.';
        } else {
            Unit::create($unit);
            $_SESSION['flash'] = 'Unit added.';
        }
        header('Location: index.php');
        exit;
    }
}

$pageTitle = $id ? 'Edit unit' : 'Add unit';
$base = '../';
require __DIR__ . '/../../templates/header.php';
?>
<div class="card card-narrow">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>

    <?php foreach ($errors as $error): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <div class="form-row">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($unit['name']) ?>" required>
        </div>
        <div class="form-row">
            <label for="rent_amount">Monthly rent</label>
            <input type="number" id="rent_amount" name="rent_amount" step="0.01" min="0"
                   value="<?= htmlspecialchars((string) $unit['rent_amount']) ?>" required>
        </div>
        <div class="form-row">
            <label for="status">Status</label>
            <select id="status" name="status">
                <?php foreach (['vacant', 'occupied'] as $s): ?>
                    <option value="<?= $s ?>" <?= $unit['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn">Save</button>
        <a href="index.php">Cancel</a>
    </form>
</div>
<?php require __DIR__ . '/../../templates/footer.php'; ?>