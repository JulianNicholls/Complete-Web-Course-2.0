<?php
session_start();

//                        Host        User       PW          DB
$link = mysqli_connect('localhost', 'twitter', 'twitter', 'twitter');

if(mysqli_connect_errno()) {
  print_r(mysqli_connect_error());
  exit();
}

function getPOSTData() {
  return json_decode(file_get_contents('php://input'));
}
