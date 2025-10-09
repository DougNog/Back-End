<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$sql="SELECT r.*, m.nome AS membro_nome, t.nome AS turma_nome FROM reservas r JOIN membros m ON r.membro_id=m.id JOIN turmas t ON r.turma_id=t.id";
$res=$conn->query($sql);
$out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; }
echo json_encode($out);
$conn->close();
?>