<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: accounts.php');
    exit;
}

$id = $_GET['id'];

// Fetch Account
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
$stmt->execute([$id]);
$account = $stmt->fetch();

if (!$account) {
    echo "<p>Account not found.</p>";
    exit;
}

// Update Account
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $name = $_POST['name'];
    $contact_email = $_POST['contact_email'];
    $contact_phone = $_POST['contact_phone'];
    $max_licenses = $_POST['max_licenses'];
    $database_name = $_POST['database_name'];
    $database_connection_string = $_POST['database_connection_string'];

    $stmt = $pdo->prepare('UPDATE accounts SET name = ?, contact_email = ?, contact_phone = ?, max_licenses = ?, database_name = ?, database_connection_string = ? WHERE id = ?');
    $stmt->execute([$name, $contact_email, $contact_phone, $max_licenses, $database_name, $database_connection_string, $id]);
    
    header('Location: accounts.php');
    exit;
}

include '../includes/header.php';
?>

<h1>Edit Account</h1>
<form method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($account['name']) ?>" required>

    <label for="contact_email">Contact Email:</label>
    <input type="email" id="contact_email" name="contact_email" value="<?= htmlspecialchars($account['contact_email']) ?>" required>

    <label for="contact_phone">Contact Phone:</label>
    <input type="text" id="contact_phone" name="contact_phone" value="<?= htmlspecialchars($account['contact_phone']) ?>">

    <label for="max_licenses">Max Licenses:</label>
    <input type="number" id="max_licenses" name="max_licenses" value="<?= htmlspecialchars($account['max_licenses']) ?>" required>

    <label for="database_name">Database Name:</label>
    <input type="text" id="database_name" name="database_name" value="<?= htmlspecialchars($account['database_name']) ?>" required>

    <label for="database_connection_string">Database Connection String:</label>
    <input type="text" id="database_connection_string" name="database_connection_string" value="<?= htmlspecialchars($account['database_connection_string']) ?>" required>

    <button type="submit" name="update_account">Update Account</button>
    <a href="accounts.php" class="btn">Cancel</a>
</form>

<?php include '../includes/footer.php'; ?>