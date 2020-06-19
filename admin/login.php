<?php
$database = include "./database.php";
if($database == 0){
  $response = array(
    "code" => 500,
    "message" => "连接失败"
  );
  print_r(json_encode($response));
} else {
  session_start();
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql="select * from user where username='{$username}' and password='{$password}'";
  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);
  if($num==1){
    $rows = mysqli_fetch_array($result);
    $_SESSION["username"] = $rows["username"];
    $_SESSION["power"] = $rows["power"];
    $message = "OK";

    $user = $rows["username"];
    $user_power = $rows["power"];
  } else {
    $message = "fail";
  }
  $response = array(
    "code" => 200,
    "message" => $message,
    "username"=> $user,
    "power"=> $user_power
  );
  print_r(json_encode($response));
}