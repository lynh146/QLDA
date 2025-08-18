<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maLo      = $_POST['MaLo'] ?? '';
$ngayTH    = $_POST['NgayTH'] ?? '';
$sanLuong  = $_POST['SanLuong'] ?? 0;
$chatLuong = $_POST['ChatLuong'] ?? '';

try {
    if ($role !== 'admin') {
        // kiểm tra quyền: MaLo có thuộc về nông dân này không?
        $check = $conn->prepare("
            SELECT v.MaND 
            FROM losx l 
            JOIN vuon v ON l.MaVuon = v.MaVuon
            WHERE l.MaLo = ?
        ");
        $check->execute([$maLo]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm thu hoạch cho lô này";
            exit;
        }
    }

    // Sinh mã TH mới (TH001, TH002…)
    $sqlMax = "SELECT MaTH FROM thuhoach ORDER BY MaTH DESC LIMIT 1";
    $res = $conn->query($sqlMax);
    $last = $res->fetchColumn();

    if ($last) {
        $num = (int)substr($last, 2) + 1; // bỏ "TH"
    } else {
        $num = 1;
    }
    $maTH = "TH" . str_pad($num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO thuhoach (MaTH, MaLo, NgayTH, SanLuong, ChatLuong)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTH, $maLo, $ngayTH, $sanLuong, $chatLuong]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
