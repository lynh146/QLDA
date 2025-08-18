<?php
header("Content-Type: application/json; charset=UTF-8");
require_once("../../php/config.php"); // file chứa $conn

try {
    // Truy vấn danh sách vườn + tên nông dân
    $sql = "SELECT v.MaVuon, v.TenVuon, v.DienTich, v.LoaiDat, v.ViTri, v.TrangThai,
                   nd.TenND AS NongDan
            FROM Vuon v
            LEFT JOIN NongDan nd ON v.MaND = nd.MaND
            ORDER BY v.MaVuon ASC";

    $result = mysqli_query($conn, $sql);

    $rows = [];
    if ($result) {
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
    }

    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
