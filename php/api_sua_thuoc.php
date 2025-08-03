<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['MaThuoc'] ?? '';
    $malo = $_POST['MaLo'] ?? '';
    $tenthuoc = $_POST['TenThuoc'] ?? '';
    $soluong = $_POST['SoLuong'] ?? '';
    $donvi = $_POST['DonVi'] ?? '';
    $ngaysd = $_POST['NgaySD'] ?? '';

    if (empty($id) || empty($malo) || empty($tenthuoc)) {
        echo "❌ Thiếu dữ liệu!";
        exit;
    }

    $sql = "UPDATE thuoc 
            SET MaLo='$malo', TenThuoc='$tenthuoc', SoLuong='$soluong', 
                DonVi='$donvi', NgaySD='$ngaysd' 
            WHERE MaThuoc='$id'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "✅ Đã sửa thành công!";
        } else {
            echo "⚠ Không có thay đổi (dữ liệu có thể trùng).";
        }
    } else {
        echo "❌ Lỗi SQL: " . $conn->error;
    }
}
?>
