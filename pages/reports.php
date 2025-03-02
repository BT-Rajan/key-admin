<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM account_analytics');
$stmt->execute();
$analytics = $stmt->fetchAll();

include '../includes/header.php';
?>
<h1>Account Analytics Report</h1>
<table>
    <thead>
        <tr>
            <th>Account ID</th>
            <th>Date</th>
            <th>Total API Calls</th>
            <th>Successful API Calls</th>
            <th>Failed API Calls</th>
            <th>Average Response Time</th>
            <th>Peak Response Time</th>
            <th>Error Rate</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($analytics as $analytic): ?>
        <tr>
            <td><?= htmlspecialchars($analytic['account_id']) ?></td>
            <td><?= htmlspecialchars($analytic['date']) ?></td>
            <td><?= htmlspecialchars($analytic['total_api_calls']) ?></td>
            <td><?= htmlspecialchars($analytic['successful_api_calls']) ?></td>
            <td><?= htmlspecialchars($analytic['failed_api_calls']) ?></td>
            <td><?= htmlspecialchars($analytic['average_response_time']) ?></td>
            <td><?= htmlspecialchars($analytic['peak_response_time']) ?></td>
            <td><?= htmlspecialchars($analytic['error_rate']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>