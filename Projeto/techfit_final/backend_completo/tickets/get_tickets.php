<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$sql="SELECT t.*, m.nome AS membro_nome FROM tickets t JOIN membros m ON t.membro_id=m.id";
$res=$conn->query($sql);
$out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; }
echo json_encode($out);
$conn->close();
?>