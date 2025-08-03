<?php
include 'connect.php';

$result = mysqli_query($conn, "SELECT * FROM phanbon");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
?>
