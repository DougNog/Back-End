<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$dados=json_decode(file_get_contents("php://input"),true);
$sql="INSERT INTO acessos (membro_id,metodo,resultado,obs) VALUES (?,?,?,?)";
$stmt=$conn->prepare($sql);
$stmt->bind_param("isss",$dados['membro_id'],$dados['metodo'],$dados['resultado'],$dados['obs']);
if($stmt->execute()){echo json_encode(["success"=>true]);}
else{echo json_encode(["success"=>false,"error"=>$stmt->error]);}
?>