<?php
$database = include "../admin/database.php";
if ($database == 0) {
  $response = array(
    "code" => 500,
    "message" => "连接失败"
  );
  print_r(json_encode($response));
} else {
  if (isset($_POST["page"])) {
    $page = $_POST["page"]; //页码
  } else {
    $page = 1;
  }
  if (isset($_POST["page"])) {
    $pageSize = $_POST["pageSize"]; //每页显示条数
  } else {
    $pageSize = 20;
  }
  if ($_POST["keywords"] != "") {
    $keywords = $_POST["keywords"];
  } else {
    $keywords = "%%";
  }
  $sql = "select * from diary where diarytitle like binary '%$keywords%' order by id desc limit " . ($page - 1) * $pageSize . ", {$pageSize}";
  $result = $conn->query($sql);
  $data = array();
  while ($row = mysqli_fetch_array($result)) {
    $str = mb_substr(strip_tags($row["diarycontent"]), 0, 100, "utf-8") . "......";
    $sql_icon = "select * from label where labelname='{$row["diarylabel"]}'";
    $result_icon = $conn->query($sql_icon);
    $num = mysqli_num_rows($result_icon);
    if ($num == 1) {
      $row_icon = mysqli_fetch_array($result_icon);
      $icon = $row_icon["labelicon"];
      if ($icon == "") {
        $icon = "md-help";
      }
      $array = array(
        "id" => $row["id"],
        "username" => $row["username"],
        "title" => $row["diarytitle"],
        "content" => $str,
        "time" => $row["diarytime"],
        "read" => $row["diaryread"],
        "label" => $row["diarylabel"],
        "icon" => $icon
      );
      array_push($data, $array);
    }
  }
  $total_sql = "select count(*) from diary where diarytitle like binary '%$keywords%'"; //总条数
  $total_result = mysqli_fetch_array($conn->query($total_sql));
  $total = $total_result[0];
  $total_pages = ceil($total / $pageSize); //总页数
  $response = array(
    "code" => 200,
    "message" => "OK",
    "data" => $data,
    "total" => $total,
    "totalPages" => $total_pages
  );
  print_r(json_encode($response));
}