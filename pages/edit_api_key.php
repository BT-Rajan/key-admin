<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: api_keys.php');
    exit;
}

$id = $_GET['id'];

// Fetch the API key details
$stmt = $pdo->prepare('SELECT * FROM api_keys WHERE id = ?');
$stmt->execute([$id]);
$api_key = $stmt->fetch();

if (!$api_key) {
    echo "API Key not found.";
    exit;
}

// Update the API key
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $expiry_date = $_POST['expiry_date'];

    $stmt = $pdo->prepare('UPDATE api_keys SET status = ?, expiry_date = ? WHERE id = ?');
    $stmt->execute([$status, $expiry_date, $id]);
    header('Location: api_keys.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit API Key</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit API Key</h1>
        <form method="post">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="active" <?= $api_key['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="suspended" <?= $api_key['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
            </select>

            <label for="expiry_date">Expiry Date:</label>
            <input type="datetime-local" name="expiry_date" id="expiry_date" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($api_key['expiry_date']))) ?>" required>

            <button type="submit">Update</button>
            <a href="api_keys.php">Cancel</a>
        </form>
    </div>
</body>
</html>