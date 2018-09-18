<?php
include ('functions.php');

// Login / Signup
if ($_GET["action"] === 'login') {
  $loginData = getPOSTData();
  $response = [ 'errors' => [] ];

  if (!$loginData->email) {
    $response['errors'][] = "You must enter an email address.";
  }

  if (strlen($loginData->password) < 6) {
    $response['errors'][] = 'You must enter a password of at least 6 characters.';
  }

  if (count($response['errors']) !== 0) {
    echo json_encode($response);
    exit();
  }

  // The passed data has been validated, carry on to log in or sign up with it
  $response = ($loginData->loginActive === '0') ? signup($loginData) : login($loginData);
  
  echo json_encode($response);
}

// Logout
if ($_GET['action'] === 'logout') {
  session_unset();
  header('Location: /');
  exit();
}

// Toggle following
if ($_GET['action'] === 'toggleFollow') {
  $toggleData = getPOSTData();

  $query = "SELECT * FROM `following` WHERE `follower`={$_SESSION['id']} AND `following`=$toggleData->userId";
  $result = mysqli_query($link, $query);

  // Following, so unfollow
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_object($result);

    $query = "DELETE FROM `following` WHERE `id`=$row->id LIMIT 1";
    mysqli_query($link, $query);

    echo '{ "following": false }';
  }
  else {   // Not following
    $query = "INSERT INTO `following` (`follower`, `following`) VALUES ({$_SESSION['id']}, $toggleData->userId)";
    mysqli_query($link, $query);

    echo '{ "following": true }';
  }
}

if ($_GET['action'] === 'newTwinge') {
  $twingeData = getPOSTData();

  $query = "INSERT INTO `tweets` (`tweet`, `user_id`) VALUES ('$twingeData->text', {$_SESSION['id']})";
  mysqli_query($link, $query);

  echo '{ "ok": true }';
}
