<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

$admin = $_SESSION['super_admin'];

// Fetch statistics
$stmt = $pdo->query('SELECT COUNT(*) as total_accounts FROM accounts');
$total_accounts = $stmt->fetch()['total_accounts'];

$stmt = $pdo->query('SELECT COUNT(*) as total_api_keys FROM api_keys');
$total_api_keys = $stmt->fetch()['total_api_keys'];

$stmt = $pdo->query('SELECT COUNT(*) as active_api_keys FROM api_keys WHERE status = "active"');
$active_api_keys = $stmt->fetch()['active_api_keys'];

include '../includes/header.php';
?>
<h1>Welcome, <?= htmlspecialchars($admin['username']) ?></h1>
<div class="stats-container">
    <div class="stat-card">
        <h3>Total Accounts</h3>
        <p><?= $total_accounts ?></p>
    </div>
    <div class="stat-card">
        <h3>Total API Keys</h3>
        <p><?= $total_api_keys ?></p>
    </div>
    <div class="stat-card">
        <h3>Active API Keys</h3>
        <p><?= $active_api_keys ?></p>
    </div>
</div>
<?php include '../includes/footer.php'; ?>