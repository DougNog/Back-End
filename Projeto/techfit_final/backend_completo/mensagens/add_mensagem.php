<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$dados=json_decode(file_get_contents("php://input"),true);
$sql="INSERT INTO mensagens (titulo,corpo,segmentos,destinatarios) VALUES (?,?,?,?)";
$stmt=$conn->prepare($sql);
$jsonSeg=json_encode($dados['segmentos']);
$stmt->bind_param("sssi",$dados['titulo'],$dados['corpo'],$jsonSeg,$dados['destinatarios']);
if($stmt->execute()){echo json_encode(["success"=>true,"id"=>$stmt->insert_id]);}
else{echo json_encode(["success"=>false,"error"=>$stmt->error]);}
?>