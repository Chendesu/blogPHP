<?php
$database = include "../admin/database.php";
if ($database == 0) {
  $response = array(
    "code" => 500,
    "message" => "连接失败"
  );
  print_r(json_encode($response));
} else {
  if($_POST["labelKey"]!=""){
    $labelKey = $_POST["labelKey"];
  } else {
    $labelKey = "%%";
  }
  
  $sql = "select * from photo where photolabel like binary '%$labelKey%' order by id desc";
  $result = $conn->query($sql);
  $data = array();
  while($row=mysqli_fetch_array($result)){
    $array=array(
      "id" => $row["id"],
      "username" => $row["username"],
      "title" => $row["phototitle"],
      "url" => $row["photourl"],
      "content" => $row["photocontent"],
      "time" => $row["phototime"],
      "label" => $row["photolabel"]
    );
    array_push($data, $array);
  }
  $total_sql = "select count(*) from photo"; //总条数
  $total_result = mysqli_fetch_array($conn->query($total_sql));
  $total = $total_result[0];
  $response = array(
    "code"=>200,
    "message"=>"OK",
    "data"=>$data,
    "total"=> $total
  );
  print_r(json_encode($response));
}