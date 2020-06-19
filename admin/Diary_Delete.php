<?php
$database = include "./database.php";
if($database == 0){
  $response = array(
    "code" => 500,
    "message" => "连接失败"
  );
  print_r(json_encode($response));
} else {
  $id = $_POST["id"];
  $sql = "delete from diary where id = '{$id}'";
  $result = $conn->query($sql);
  if($result){
    $message = "OK";
  } else {
    $message = "删除失败";
  }
  $response = array(
    "code"=>200,
    "message"=>$message
  );
  print_r(json_encode($response));
}
