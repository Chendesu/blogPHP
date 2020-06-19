<?php
$database = include "./database.php";
if($database == 0) {
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  date_default_timezone_set("PRC");
  session_start();

  $username = $_SESSION["username"];
  $title = $_POST["title"];
  $content = addslashes($_POST["content"]);
  $label = $_POST["label"];
  $time = date("Y-m-d H:i:s");
  $read = 0;

  $sql = "insert into diary (username, diarytitle, diarycontent, diarytime, diaryread, diarylabel) values ('{$username}','{$title}','{$content}','{$time}','{$read}','{$label}')";

  $result = $conn->query($sql);
  if($result) {
    $message = "OK";
  } else {
    $message = "添加失败";
  }
  
  $response = array(
    "code" => 200,
    "message" => $message
  );
  print_r(json_encode($response));

}