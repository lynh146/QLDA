<?php
require __DIR__ . '/../../config/connect.php';

$MaND = $_POST['MaND'] ?? '';

if ($MaND=="") {
    die("❌ Thiếu mã nông dân");
}

try {
    $sql = "DELETE FROM nongdan WHERE MaND=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$MaND]);

    echo "✅ Xóa nông dân thành công";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
