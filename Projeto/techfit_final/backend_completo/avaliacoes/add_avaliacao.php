<?php
header("Content-Type: application/json; charset=UTF-8");
include "../db.php";
$dados=json_decode(file_get_contents("php://input"),true);
$sql="INSERT INTO avaliacoes (membro_id,peso,altura,gordura,cintura,obs) VALUES (?,?,?,?,?,?)";
$stmt=$conn->prepare($sql);
$stmt->bind_param("idddds",$dados['membro_id'],$dados['peso'],$dados['altura'],$dados['gordura'],$dados['cintura'],$dados['obs']);
if($stmt->execute()){echo json_encode(["success"=>true,"id"=>$stmt->insert_id]);}
else{echo json_encode(["success"=>false,"error"=>$stmt->error]);}
?>