<?php
$database = include "./database.php";
if ($database == 0) {
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  session_start();
  $user = $_SESSION["username"];
  $user_power = $_SESSION["power"];
  if(isset($_POST["page"])){
    $page = $_POST["page"];
  } else {
    $page = 1;
  }
  if (isset($_POST["pageSize"])) {
    $pageSize = $_POST["pageSize"];
  } else {
    $pageSize = 10;
  }
  $keywords = $_POST["keywords"];

  $sql = "select * from photo where phototitle like binary '%$keywords%' order by id desc limit ".($page-1)*$pageSize.", {$pageSize}";
  $result = $conn->query($sql);
  $data=array();
  while($row=mysqli_fetch_array($result)){
    $array=array(
      "id"=>$row["id"],
      "username"=>$row["username"],
      "title"=>$row["phototitle"],
      "url"=>$row["photourl"],
      "content"=>$row["photocontent"],
      "time"=>$row["phototime"],
      "label"=>$row["photolabel"]
    );
    array_push($data, $array);
  }
  $total_sql="select count(*) from photo where phototitle like binary '%$keywords%'";
  $total_result=mysqli_fetch_array($conn->query($total_sql));
  $total=$total_result[0];
  $total_pages=ceil($total/$pageSize);
  $response=array(
    "code"=>200,
    "message"=>"OK",
    "data"=>$data,
    "total"=>$total,
    "totalPages"=>$total_pages,
    "username"=>$user,
    "power"=>$user_power
  );
  print_r(json_encode($response));
}