<?php
session_start();
require __DIR__ . '/../config/connect.php';

if (($_SESSION['role'] ?? '') !== 'admin') { exit("Không có quyền"); }

$stmt = $pdo->query("SELECT MaND, TenND FROM nongdan ORDER BY TenND");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
