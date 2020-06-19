<?php
$database = include "./database.php";
if($database == 0) {
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $power = 1;

  $sql = "select * from user where username='{$username}'";
  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);
  if($num >= 1){
    $message = "用户名已存在，添加失败";
  } else {
    $sql_insert = "insert into user (username,password,power) values('{$username}','{$password}', '{$power}')";
    $result_insert = $conn->query($sql_insert);
    if($result_insert) {
      $message = "OK";
    } else {
      $message = "添加失败";
    }
  }
  $response = array(
    "code" => 200,
    "message" => $message
  );
  print_r(json_encode($response));


}