<?php
session_start();
require __DIR__ . '/../config/connect.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Admin
$sql = "SELECT MaAdmin, TenAdmin, MatKhau FROM admin WHERE Username=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['MatKhau'])) {
    $_SESSION['role'] = 'admin';
    $_SESSION['id'] = $admin['MaAdmin'];
    $_SESSION['name'] = $admin['TenAdmin'];
    header("Location: ../views/admin/dashboard.html");
    exit;
}

// Nông dân
$sql = "SELECT MaND, TenND, MatKhau FROM nongdan WHERE Username=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$username]);
$nd = $stmt->fetch(PDO::FETCH_ASSOC);

if ($nd && password_verify($password, $nd['MatKhau'])) {
    $_SESSION['role'] = 'nongdan';
    $_SESSION['id'] = $nd['MaND'];
    $_SESSION['name'] = $nd['TenND'];
    header("Location: ../views/user/dashboard.html");
    exit;
}

header("Location: ../views/login.html?error=1");
