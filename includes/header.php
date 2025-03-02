<?php
// header.php
// Don't start session here as it's already started in each page
// session_start();

// Check if the user is logged in
$logged_in = isset($_SESSION['super_admin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php if ($logged_in): ?>
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="../images/logo.png" alt="Logo" width="100">
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="accounts.php">Accounts</a></li>
                    <li><a href="api_keys.php">API Keys</a></li>
                    <li><a href="reports.php">Reports</a></li>
                </ul>
            </nav>
            <div class="profile">
                <span>Welcome, <?= htmlspecialchars($_SESSION['super_admin']['username']) ?></span>
                <a href="profile.php" class="btn">My Profile</a>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
    </header>
    <?php endif; ?>
    <main class="container">