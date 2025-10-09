<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$res=$conn->query("SELECT * FROM mensagens ORDER BY ts DESC");
$out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; }
echo json_encode($out);
$conn->close();
?>