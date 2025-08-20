<?php
session_start();
require __DIR__ . '/../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = trim($_POST['username'] ?? '');
    $password   = trim($_POST['password'] ?? '');
    $repassword = trim($_POST['repassword'] ?? '');
    $tenND      = trim($_POST['TenND'] ?? '');
    $cccd       = trim($_POST['CCCD'] ?? '');
    $diaChi     = trim($_POST['DiaChi'] ?? '');
    $sdt        = trim($_POST['SDT'] ?? '');
    $email      = trim($_POST['Email'] ?? '');

    // 1. Kiểm tra mật khẩu nhập lại
    if ($password !== $repassword) {
        die("❌ Mật khẩu nhập lại không khớp");
    }

    // 2. Kiểm tra username trùng
    $stmt = $conn->prepare("SELECT COUNT(*) FROM nongdan WHERE Username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetchColumn() > 0) {
        die("❌ Tên đăng nhập đã tồn tại");
    }

    // 3. Kiểm tra email trùng (nếu có nhập)
    if (!empty($email)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM nongdan WHERE Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            die("❌ Email đã được sử dụng");
        }
    }

    // 4. Sinh mã ND tự động
    $last = $conn->query("SELECT MaND FROM nongdan ORDER BY MaND DESC LIMIT 1")->fetchColumn();
    $num = $last ? (int)substr($last, 2) + 1 : 1;
    $maND = 'ND' . str_pad($num, 3, '0', STR_PAD_LEFT);

    // 🔑 5. Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 6. Thêm vào DB
    $sql = "INSERT INTO nongdan (MaND, TenND, CCCD, DiaChi, SDT, Email, Username, MatKhau) 
            VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$maND, $tenND, $cccd, $diaChi, $sdt, $email, $username, $hashedPassword]);
        header("Location: ../views/login.html?registered=1");
        exit;
    } catch (PDOException $e) {
        die("❌ Lỗi khi đăng ký: " . $e->getMessage());
    }
}
