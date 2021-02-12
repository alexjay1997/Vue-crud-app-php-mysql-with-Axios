<?php
             

$connect = new PDO("mysql:host=127.0.0.1;dbname=vue_php", "root", "");
//$received_data = json_decode(file_get_contents("php://input"));
$data = array();

 $query = "SELECT * FROM tbl_users 

 ";

 $statement = $connect->prepare($query);
 $statement->execute();
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");
 echo json_encode($data);



?>