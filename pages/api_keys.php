<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

// Issue API Key
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issue_api_key'])) {
    $account_id = $_POST['account_id'];
    $key_hash = password_hash(uniqid(), PASSWORD_DEFAULT);
    $expiry_date = $_POST['expiry_date'];

    $stmt = $pdo->prepare('INSERT INTO api_keys (account_id, key_hash, expiry_date) VALUES (?, ?, ?)');
    $stmt->execute([$account_id, $key_hash, $expiry_date]);
    echo "<p>API Key issued successfully.</p>";
}

// Fetch API Keys
$stmt = $pdo->prepare('SELECT * FROM api_keys');
$stmt->execute();
$api_keys = $stmt->fetchAll();

include '../includes/header.php';
?>
<h1>Manage API Keys</h1>
<form method="post">
    <label for="account_id">Select Account:</label>
    <select name="account_id" id="account_id" required>
        <option value="">Select Account</option>
        <?php
        $stmt = $pdo->prepare('SELECT id, name FROM accounts');
        $stmt->execute();
        $accounts = $stmt->fetchAll();
        foreach ($accounts as $account): ?>
        <option value="<?= $account['id'] ?>"><?= htmlspecialchars($account['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <label for="expiry_date">Expiry Date:</label>
    <input type="datetime-local" name="expiry_date" id="expiry_date" required>
    <button type="submit" name="issue_api_key">Issue API Key</button>
</form>

<h2>API Key List</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Account ID</th>
            <th>Key Hash</th>
            <th>Expiry Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($api_keys as $api_key): ?>
        <tr>
            <td><?= htmlspecialchars($api_key['id']) ?></td>
            <td><?= htmlspecialchars($api_key['account_id']) ?></td>
            <td><?= htmlspecialchars($api_key['key_hash']) ?></td>
            <td><?= htmlspecialchars($api_key['expiry_date']) ?></td>
            <td><?= htmlspecialchars($api_key['status']) ?></td>
            <td>
                <a href="edit_api_key.php?id=<?= $api_key['id'] ?>">Edit</a>
                <a href="delete_api_key.php?id=<?= $api_key['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>