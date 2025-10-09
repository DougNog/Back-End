<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$dados=json_decode(file_get_contents("php://input"),true);
$sql="INSERT INTO tickets (membro_id,assunto,status) VALUES (?,?, 'aberto')";
$stmt=$conn->prepare($sql);
$stmt->bind_param("is",$dados['membro_id'],$dados['assunto']);
if($stmt->execute()){echo json_encode(["success"=>true,"id"=>$stmt->insert_id]);}
else{echo json_encode(["success"=>false,"error"=>$stmt->error]);}
?>