<?php
session_start();
require __DIR__ . '/../../config/connect.php';

$name = $_SESSION['name'] ?? 'Admin';

$nongdan = $conn->query("SELECT COUNT(*) FROM nongdan")->fetchColumn();
$vuon = $conn->query("SELECT COUNT(*) FROM vuon")->fetchColumn();
$losx = $conn->query("SELECT COUNT(*) FROM losx")->fetchColumn();
$thuhoach = $conn->query("SELECT SUM(SanLuong) FROM thuhoach")->fetchColumn() ?: 0;

echo json_encode([
  'name' => $name,
  'nongdan' => $nongdan,
  'vuon' => $vuon,
  'losx' => $losx,
  'thuhoach' => $thuhoach
], JSON_UNESCAPED_UNICODE);
