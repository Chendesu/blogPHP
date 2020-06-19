<?php
$database = include "./database.php";
if($database == 0) {
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  $id = $_POST["id"];
  $password = $_POST["password"];
  $sql = "select * from user where id='{$id}'";
  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);
  if($num==1){
    $sql_update = "update user set password='{$password}' where id='{$id}'";
    $result_update = $conn->query($sql_update);
    if($result_update) {
      $message = "OK";
    } else {
      $message = "fail";
    }
  } else {
    $message = "fail";
  }
  $response = array(
    "code" => 200,
    "message" => $message
  );
  print_r(json_encode($response));

}