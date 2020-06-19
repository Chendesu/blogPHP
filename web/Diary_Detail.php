<?php
$database = include "../admin/database.php";
if ($database == 0) {
  $response = array(
    "code" => 500,
    "message" => "连接失败"
  );
  print_r(json_encode($response));
} else {
  $id = $_POST["id"];
  $sql = "select * from diary where id='{$id}'";
  $result = $conn->query($sql);
  $num = mysqli_num_rows($result);
  if($num==1){
    $row = mysqli_fetch_array($result);
    $read = $row["diaryread"]+1;
    $sql_update = "update diary set diaryread={$read} where id={$id}";
    $conn->query($sql_update);
    $data = array(
      "id"=>$row["id"],
      "username"=>$row["username"],
      "title"=>$row["diarytitle"],
      "content"=>$row["diarycontent"],
      "time"=>$row["diarytime"],
      "read"=>$read,
      "label"=>$row["diarylabel"]
    );
    $message = "OK";
  } else {
    $message = "文章不存在";
  }
  $response = array(
    "code"=>200,
    "message"=>$message,
    "data"=>$data
  );
  print_r(json_encode($response));

}
