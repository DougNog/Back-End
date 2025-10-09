<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$mid=intval($_GET['membro_id']);
$res=$conn->query("SELECT * FROM avaliacoes WHERE membro_id=$mid ORDER BY ts ASC");
$out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; }
echo json_encode($out);
$conn->close();
?>