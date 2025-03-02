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

$stmt = $pdo->prepare('DELETE FROM accounts WHERE id = ?');
$stmt->execute([$id]);

header('Location: accounts.php');
exit;
?>