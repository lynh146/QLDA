<?php
$host = "103.139.203.43";
$user = "sql_nhom12_itimi";
$pass = "fd30fd1bf6d37";
$dbname = "sql_nhom12_itimi";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}