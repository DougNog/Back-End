<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$sql="SELECT a.*, m.nome AS membro_nome FROM acessos a JOIN membros m ON a.membro_id=m.id ORDER BY ts DESC";
$res=$conn->query($sql);
$out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; }
echo json_encode($out);
$conn->close();
?>