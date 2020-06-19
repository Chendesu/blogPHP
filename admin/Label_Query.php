<?php
$database = include "./database.php";
if($database == 0){
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
    $pageSize = $_POST("page");
  } else {
    $page = 1;
  }
  if(isset($_POST["pageSize"])){
    $pageSize = $_POST["pageSize"];
  } else {
    $pageSize = 10;
  }
  // $sql = "select * from label order by id desc limit ".($page-1)*$pageSize.", {$pageSize}";
  $sql = "select * from label order by id desc";
  $result = $conn->query($sql);
  $data = array();
  while($row=mysqli_fetch_array($result)){
    if($row["labelicon"]==""){
      $row["labelicon"] = "md-help";
    }
    $array = array(
      "id"=>$row["id"],
      "label"=>$row["labelname"],
      "icon"=>$row["labelicon"],
      "username"=>$row["username"]
    );
    array_push($data, $array);
  }
  // $total_sql = "select count(*) from label";
  // $total_result = mysqli_fetch_array($conn->query($total_sql));
  // $total = $total_result[0];
  // $total_pages = ceil($total/$pageSize);
  $response = array(
    "code"=>200,
    "message"=>"OK",
    "data"=>$data,
    // "total"=>$total,
    // "totalPages"=>$total_pages,
    "username" => $user,
    "power" => $user_power
  );
  print_r(json_encode($response));
}