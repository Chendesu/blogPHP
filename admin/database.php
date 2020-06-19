<?php
header("content-type:text/html;charset=utf-8");
$conn = new mysqli("localhost", "root", "root123", "myblog");
if($conn->connect_error){
  return 0;
} else {
  return 1;
}