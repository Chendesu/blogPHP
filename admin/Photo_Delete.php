<?php
require '../php-sdk-7.2.10/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

$database = include "./database.php";
if ($database == 0) {
  $response = array(
    "code"=>500,
    "message"=>"连接失败"
  );
  print_r(json_encode($response));
} else {
  $id = $_POST["id"];
  $key = $_POST["url"];

  $sql = "delete from photo where id='$id'";
  $result = $conn->query($sql);
  if($result){
    // 删除七牛云空间上的图片
    $accessKey = "YT9QWg-YYYgZOe8SumLrOC2lxviYlG1Bmn42N0f-";
    $secretKey = "wmm3AS1NL5JlmZ7DMjJmafxZnNN3alV-p0rkGUwn";
    $bucket = "jiu-blog";
    $auth = new Auth($accessKey, $secretKey);
    $config = new \Qiniu\Config();
    $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
    $err = $bucketManager->delete($bucket, $key);
    // if ($err == '') {
      $message = "OK";
    // } 
  } else {
    $message = "删除失败";
  }
  $response = array(
    "code"=>200,
    "message"=>$message
  );
  print_r(json_encode($response));
  
}