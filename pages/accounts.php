<?php
// accounts.php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

// Create Account
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_account'])) {
    $name = $_POST['name'];
    $contact_email = $_POST['contact_email'];
    $contact_phone = $_POST['contact_phone'];
    $max_licenses = $_POST['max_licenses'];
    $database_name = $_POST['database_name'];
    $database_connection_string = $_POST['database_connection_string'];

    $stmt = $pdo->prepare('INSERT INTO accounts (name, contact_email, contact_phone, max_licenses, database_name, database_connection_string) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $contact_email, $contact_phone, $max_licenses, $database_name, $database_connection_string]);
    echo "<p>Account created successfully.</p>";
}

// Fetch Accounts
$stmt = $pdo->prepare('SELECT * FROM accounts');
$stmt->execute();
$accounts = $stmt->fetchAll();

include '../includes/header.php';
?>
<h1>Manage Accounts</h1>
<form method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="contact_email">Contact Email:</label>
    <input type="email" id="contact_email" name="contact_email" required>
    <label for="contact_phone">Contact Phone:</label>
    <input type="text" id="contact_phone" name="contact_phone">
    <label for="max_licenses">Max Licenses:</label>
    <input type="number" id="max_licenses" name="max_licenses" required>
    <label for="database_name">Database Name:</label>
    <input type="text" id="database_name" name="database_name" required>
    <label for="database_connection_string">Database Connection String:</label>
    <input type="text" id="database_connection_string" name="database_connection_string" required>
    <button type="submit" name="create_account">Create Account</button>
</form>

<h2>Account List</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact Email</th>
            <th>Contact Phone</th>
            <th>Max Licenses</th>
            <th>Database Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?= htmlspecialchars($account['id']) ?></td>
            <td><?= htmlspecialchars($account['name']) ?></td>
            <td><?= htmlspecialchars($account['contact_email']) ?></td>
            <td><?= htmlspecialchars($account['contact_phone']) ?></td>
            <td><?= htmlspecialchars($account['max_licenses']) ?></td>
            <td><?= htmlspecialchars($account['database_name']) ?></td>
            <td>
                <a href="edit_account.php?id=<?= $account['id'] ?>">Edit</a>
                <a href="delete_account.php?id=<?= $account['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>