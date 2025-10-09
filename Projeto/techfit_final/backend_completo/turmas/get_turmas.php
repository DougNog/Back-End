<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$result = $conn->query("SELECT * FROM turmas");
$out=[]; while($r=$result->fetch_assoc()){ $out[]=$r; }
echo json_encode($out);
$conn->close();
?>