<?php
include "connect.php";
$id = $_POST['MaTT'];
$ngay = $_POST['Ngay'];
$nhietdo = $_POST['NhietDo'];
$luongmua = $_POST['LuongMua'];
$doam = $_POST['DoAm'];

$sql = "UPDATE thoitiet 
        SET Ngay='$ngay', NhietDo='$nhietdo', LuongMua='$luongmua', DoAm='$doam' 
        WHERE MaTT='$id'";

echo ($conn->query($sql)) ? "✅ Đã sửa thành công" : "❌ error";
?>
