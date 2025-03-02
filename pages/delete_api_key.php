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

// Delete the API key
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('DELETE FROM api_keys WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: api_keys.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete API Key</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Delete API Key</h1>
        <p>Are you sure you want to delete the API key for account ID <?= htmlspecialchars($api_key['account_id']) ?>?</p>
        <form method="post">
            <button type="submit">Delete</button>
            <a href="api_keys.php">Cancel</a>
        </form>
    </div>
</body>
</html>