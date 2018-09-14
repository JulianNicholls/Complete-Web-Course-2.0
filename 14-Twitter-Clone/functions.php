<?php
  require_once('humantime.php');

// Start the login session
session_start();

// Connect to database
//                        Host        User       PW          DB
$link = mysqli_connect('localhost', 'twitter', 'twitter', 'twitter');

if(mysqli_connect_errno()) {
  print_r(mysqli_connect_error());
  exit();
}

function displayTweets($type) {
  global $link;

  $whereClause = '';

  // if ($type === 'public') {
  //   $whereClause = '';
  // }

  $query = 'SELECT * FROM `tweets` ' . $whereClause . ' ORDER BY `created_at` DESC LIMIT 10';
  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) === 0) {
    echo 'There are no tweets to display';
  }
  else {
    while ($row = mysqli_fetch_object($result)) {
      $query = 'SELECT * FROM `users` WHERE `id`=' . $row->user_id;
      $user_result = mysqli_query($link, $query);
      $user = mysqli_fetch_object($user_result);
      
      echo '<div class="tweet">';
      echo $row->tweet . '<br>';
      echo "<span class=\"user-email\">{$user->email}</span> - ";
      echo '<span class="human-time">' . human_time(strtotime($row->created_at)) . '</span>';
      echo '</div>';
    }

  }
}

function getPOSTData() {
  return json_decode(file_get_contents('php://input'));
}
