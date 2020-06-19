<?php
$database = include "./database.php";
if($database == 0){
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  $id = $_POST["id"];
  $label = $_POST["label"];
  $icon = $_POST["icon"];

  $sql = "select * from label where id='$id'";
  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);
  if($num==1){
    $sql_update = "update label set labelname='$label', labelicon='$icon' where id='$id'";
    $result_update = $conn->query($sql_update);
    if ($result_update) {
      $message = "OK";
    } else {
      $message = "修改失败";
    }
  } else {
    $message = "修改失败";
  }
  $response = array(
    "code"=>200,
    "message"=>$message
  );
  print_r(json_encode($response));
}