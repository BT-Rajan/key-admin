<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['super_admin'])) {
    header('Location: login.php');
    exit;
}

$admin = $_SESSION['super_admin'];

// Handle password change
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    if (!password_verify($current_password, $admin['password_hash'])) {
        $error = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } elseif (strlen($new_password) < 8) {
        $error = "New password must be at least 8 characters long.";
    } else {
        // Update password
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE group_admins SET password_hash = ? WHERE id = ?');
        $result = $stmt->execute([$password_hash, $admin['id']]);
        
        if ($result) {
            // Update session with new password hash
            $_SESSION['super_admin']['password_hash'] = $password_hash;
            $message = "Password updated successfully.";
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}

include '../includes/header.php';
?>

<div class="profile-container">
    <h1>My Profile</h1>
    
    <?php if ($message): ?>
        <div class="message success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <div class="profile-info">
        <h2>Account Information</h2>
        
        <div class="profile-field">
            <label>Name</label>
            <span><?= htmlspecialchars($admin['name'] ?? 'Not set') ?></span>
        </div>
        
        <div class="profile-field">
            <label>Username</label>
            <span><?= htmlspecialchars($admin['username']) ?></span>
        </div>
        
        <div class="profile-field">
            <label>Email</label>
            <span><?= htmlspecialchars($admin['email'] ?? 'Not set') ?></span>
        </div>
        
        <div class="profile-field">
            <label>Role</label>
            <span>Super Administrator</span>
        </div>
    </div>
    
    <div class="password-form">
        <h2>Change Password</h2>
        
        <form method="post">
            <div>
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            
            <div>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            
            <div>
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="change_password">Update Password</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>