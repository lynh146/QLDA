<?php
include __DIR__ . '/../../config/connect.php';
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
if ($q === '') { echo json_encode(['error'=>'missing q']); exit; }

try {
  $maLo = null; $info = '';

// 1) Lấy tất cả MaLo liên quan
$st = $conn->prepare("
    SELECT DISTINCT l.MaLo
    FROM losx l
    JOIN vuon v ON v.MaVuon = l.MaVuon
    JOIN nongdan nd ON nd.MaND = v.MaND
    JOIN giong g ON g.MaGiong = l.MaGiong
    WHERE nd.TenND LIKE ? OR v.TenVuon LIKE ? OR g.TenGiong LIKE ?
");
$like = "%$q%";
$st->execute([$like, $like, $like]);
$rows = $st->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
  echo json_encode(['queryInfo'=>'Không tìm thấy kết quả cho từ khóa này']); 
  exit;
}

// lấy farmer theo lô đầu tiên
$maLoFirst = $rows[0]['MaLo'];
$st = $conn->prepare("
  SELECT nd.MaND, nd.TenND, nd.SDT, nd.DiaChi, v.MaVuon, v.TenVuon
  FROM losx l
  JOIN vuon v ON v.MaVuon = l.MaVuon
  JOIN nongdan nd ON nd.MaND = v.MaND
  WHERE l.MaLo = ?
  LIMIT 1
");
$st->execute([$maLoFirst]);
$farmer = $st->fetch() ?: null;

// gom tất cả thu hoạch của các MaLo
$thuhoach = [];
$st = $conn->prepare("
  SELECT th.MaTH, th.NgayTH, th.SanLuong, th.ChatLuong, l.MaLo, g.TenGiong
  FROM thuhoach th
  JOIN losx l ON l.MaLo = th.MaLo
  JOIN giong g ON g.MaGiong = l.MaGiong
  WHERE th.MaLo = ?
  ORDER BY th.NgayTH DESC, th.MaTH DESC
  LIMIT 20
");
foreach ($rows as $r) {
  $st->execute([$r['MaLo']]);
  $thuhoach = array_merge($thuhoach, $st->fetchAll(PDO::FETCH_ASSOC));
}

// gom tất cả nhật ký
$nhatky = [];
$st = $conn->prepare("
  SELECT MaCV, TenCV, NgayBD, NgayKT, TrangThai, MaLo
  FROM congviec
  WHERE MaLo = ?
  ORDER BY COALESCE(NgayKT, NgayBD) DESC, MaCV DESC
  LIMIT 20
");
foreach ($rows as $r) {
  $st->execute([$r['MaLo']]);
  $nhatky = array_merge($nhatky, $st->fetchAll(PDO::FETCH_ASSOC));
}

echo json_encode([
  'queryInfo' => "Kết quả theo từ khóa: $q",
  'farmer'    => $farmer,
  'thuhoach'  => $thuhoach,
  'nhatky'    => $nhatky,
], JSON_UNESCAPED_UNICODE);


} catch (Throwable $e) {
  echo json_encode(['queryInfo'=>'Có lỗi khi truy xuất dữ liệu']);
}
