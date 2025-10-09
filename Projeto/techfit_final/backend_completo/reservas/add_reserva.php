<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$dados=json_decode(file_get_contents("php://input"),true);
$sql="INSERT INTO reservas (membro_id,turma_id,data,hora,status) VALUES (?,?,?,?, 'confirmado')";
$stmt=$conn->prepare($sql);
$stmt->bind_param("iiss",$dados['membro_id'],$dados['turma_id'],$dados['data'],$dados['hora']);
if($stmt->execute()){echo json_encode(["success"=>true,"id"=>$stmt->insert_id]);}
else{echo json_encode(["success"=>false,"error"=>$stmt->error]);}
?>