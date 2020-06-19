<?php
require '../php-sdk-7.2.10/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

date_default_timezone_set("PRC");
session_start();

$database = include "./database.php";
if ($database == 0){
  $response = array(
    "code" => 500,
    "message" => "连接失败"
  );
  print_r(json_encode($response));
} else {
  
  $accessKey = 'YT9QWg-YYYgZOe8SumLrOC2lxviYlG1Bmn42N0f-';
  $secretKey = 'wmm3AS1NL5JlmZ7DMjJmafxZnNN3alV-p0rkGUwn';
  $bucket = 'jiu-blog';
  
  $auth = new Auth($accessKey, $secretKey);
  $token = $auth->uploadToken($bucket);
  
  $username = $_SESSION["username"];
  $title = $_POST["title"];
  // $url = $_POST["url"];
  $content = $_POST["content"];
  $time = date("Y-m-d H:i:s");
  $label = $_POST["label"];
  
  $file = $_FILES;
  $filePath = $file['file']['tmp_name'];
  $key = $file['file']['name'];
  $type = pathinfo($key, PATHINFO_EXTENSION);
  $filename = uniqid(time()).'.'. $type;
  $uploadMgr = new UploadManager();
  list($ret, $err) = $uploadMgr->putFile($token, $filename, $filePath);
  if ($err !== null) {
    $message = "图片上传失败";
  } else {
    // $url = 'qa75ul3w1.bkt.clouddn.com/' . $filename;
    $url = 'http://qiniu.ajiuya.cn/'. $filename;
    $sql = "insert into photo (username,phototitle,photourl,photocontent,phototime,photolabel) values ('$username','$title','$url','$content','$time','$label')";
    $result = $conn->query($sql);
    if($result){
      $message = "OK";
    } else {
      $message = "添加失败";
    }
  }
  $response = array(
    "code"=>200,
    "message"=>$message
  );
  print_r(json_encode($response));
}



