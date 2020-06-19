<?php
$database = include "./database.php";

if ($database == 0) {
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  $id = $_POST["id"];
  $title = $_POST["title"];
  $content = $_POST["content"];
  $label = $_POST["label"];

  $sql = "select * from photo where id='$id'";
  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);
  if($num==1){
    $sql_update = "update photo set phototitle='$title',photocontent='$content',photolabel='$label' where id='$id'";
    $result_update = $conn->query($sql_update);
    if($result_update){
      $message = "OK";
    } else {
      $message = "fail1";
    }
  } else {
    $message = "fail2";
  }
  $response = array(
    "code"=>200,
    "message"=>$message
  );
  print_r(json_encode($response));
}