<?php
session_start();
require __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['id'])) {
    echo "❌ Chưa đăng nhập";
    exit;
}

$role = $_SESSION['role'];
$maND = $_SESSION['id'];

$maVuon  = $_POST['MaVuon'] ?? '';
$loaiCP  = $_POST['LoaiCP'] ?? '';
$soTien  = $_POST['SoTien'] ?? 0;
$ngayPhat = $_POST['NgayPhat'] ?? '';

try {
    // Nếu là user thì chỉ được thêm chi phí trong vườn của mình
    if ($role !== 'admin') {
        $check = $conn->prepare("SELECT MaND FROM vuon WHERE MaVuon = ?");
        $check->execute([$maVuon]);
        $row = $check->fetch();
        if (!$row || $row['MaND'] !== $maND) {
            echo "❌ Bạn không có quyền thêm chi phí cho vườn này";
            exit;
        }
    }

    // Sinh mã chi phí mới (CP001, CP002…)
    $sqlMax = "SELECT MaCP FROM chiphi ORDER BY MaCP DESC LIMIT 1";
    $res = $conn->query($sqlMax);
    $last = $res->fetchColumn();

    if ($last) {
        $num = (int)substr($last, 2) + 1; // bỏ "CP"
    } else {
        $num = 1;
    }
    $maCP = "CP" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // Thêm chi phí
    $sql = "INSERT INTO chiphi (MaCP, MaVuon, LoaiCP, SoTien, NgayPhat) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maCP, $maVuon, $loaiCP, $soTien, $ngayPhat]);

    echo "✅ Thêm thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
