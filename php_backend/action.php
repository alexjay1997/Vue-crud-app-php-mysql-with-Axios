<?php
$connect = new PDO("mysql:host=127.0.0.1;dbname=vue_php", "root", "");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
if($received_data->action == 'insert')
{
 $data = array(
  ':fname' => $received_data->fname,
  ':lname' => $received_data->lname,
  ':gender' => $received_data->gender,
  ':username' => $received_data->username,
  ':password' => $received_data->password
 );

 $query = "
 INSERT INTO tbl_users
 (fname,lname,gender,username,password) 
 VALUES (:fname,:lname,:gender,:username,:password)
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Data Inserted'
 );

 echo json_encode($output);
}

//edit fetch

if($received_data->action == 'edit')
{
 $query = "
 SELECT * FROM tbl_users 
 WHERE id = '".$received_data->id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  $data['id'] = $row['id'];
  $data['fname'] = $row['fname'];
  $data['lname'] = $row['lname'];
  $data['gender'] = $row['gender'];
  $data['username'] = $row['username'];
  $data['password'] = $row['password'];
 }
 header("Access-Control-Allow-Origin: *");
 header("content-type: application/json");
  echo json_encode($data);

}

if($received_data->action == 'update')
{
 $data = array(
  ':fname' => $received_data->fname,
  ':lname' => $received_data->lname,
  ':gender' => $received_data->gender,
  ':username' => $received_data->username,
  ':password' => $received_data->password,
  ':id' => $received_data->hiddenId
 );

 $query = "
 Update tbl_users
  set fname =:fname,lname=:lname,gender=:gender,username=:username,password=:password where id=:id
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Data updated successfully'
 );

 echo json_encode($output);
}

if($received_data->action == 'delete_data')
{
 $query = "
 DELETE FROM tbl_users
 WHERE id = '".$received_data->id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $output = array(
  'message' => 'user data has been deleted!'
 );

 echo json_encode($output);
}
?>