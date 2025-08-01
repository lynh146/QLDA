<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['MaTT'] ?? '';
    $malo = $_POST['MaLo'] ?? '';
    $ngay = $_POST['Ngay'] ?? '';
    $nhietdo = $_POST['NhietDo'] ?? '';
    $luongmua = $_POST['LuongMua'] ?? '';
    $doam = $_POST['DoAm'] ?? '';

    // Kiểm tra dữ liệu rỗng
    if (empty($id) || empty($malo) || empty($ngay)) {
        echo "❌ Thiếu dữ liệu!";
        exit;
    }

    $sql = "UPDATE thoitiet 
            SET MaLo='$malo', Ngay='$ngay', NhietDo='$nhietdo', 
                LuongMua='$luongmua', DoAm='$doam' 
            WHERE MaTT='$id'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "✅ Đã sửa thành công!";
        } else {
            echo "⚠ Không có dòng nào bị thay đổi (dữ liệu có thể trùng).";
        }
    } else {
        echo "❌ Lỗi SQL: " . $conn->error;
    }
}
?>
