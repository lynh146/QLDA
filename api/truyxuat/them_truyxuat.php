<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maTH  = $_POST['MaTH'] ?? '';
$ghiChu = $_POST['GhiChu'] ?? '';

try {
    // Nếu là user thì chỉ thêm truy xuất cho thu hoạch thuộc vườn của mình
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT v.MaND
                                 FROM thuhoach h
                                 JOIN losx l ON h.MaLo = l.MaLo
                                 JOIN vuon v ON l.MaVuon = v.MaVuon
                                 WHERE h.MaTH=?");
        $check->execute([$maTH]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm truy xuất cho thu hoạch này";
            exit;
        }
    }

    // Sinh mã TX mới
    $sqlMax = "SELECT MaTX FROM truyxuat ORDER BY MaTX DESC LIMIT 1";
    $res = $conn->query($sqlMax);
    $last = $res->fetchColumn();
    if ($last) {
        $num = (int)substr($last, 2) + 1;
    } else {
        $num = 1;
    }
    $maTX = "TX" . str_pad($num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO truyxuat (MaTX, MaTH, GhiChu) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTX, $maTH, $ghiChu]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
