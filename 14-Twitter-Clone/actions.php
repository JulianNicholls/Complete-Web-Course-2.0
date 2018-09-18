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

    $query = "DELETE FROM `following` WHERE ID=$row->id LIMIT 1";
    mysqli_query($link, $query);

    echo '{ "following": false }';
  }
  else {   // Not following
    $query = "INSERT INTO `following` (`follower`, `following`) VALUES ({$_SESSION['id']}, $toggleData->userId)";
    mysqli_query($link, $query);

    echo '{ "following": true }';
  }
}

// Sign up
function signup($loginData) {
  global $link;

  $response = [ 'errors' => [] ];

  $query = "SELECT * FROM `users` WHERE `email`='" . mysqli_real_escape_string($link, $loginData->email) . "' LIMIT 1";
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) > 0) {
    $response['errors'][] = 'That email address has already been signed up.';
    return $response;
  }
  else {
    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('" . 
      mysqli_real_escape_string($link, $loginData->email) . 
      "', '" . 
      password_hash(mysqli_real_escape_string($link, $loginData->password), PASSWORD_DEFAULT) . 
      "')";

    if (mysqli_query($link, $query)) {
      $_SESSION['id'] = mysqli_insert_id($link);
    }
    else {
      $response['errors'][] = mysqli_error($link);
    }
  }

  return $response;
}

// Login
function login($loginData) {
  global $link;

  $response = [ 'errors' => [] ];

  $login_error = 'The email or password was not recognised.';
  $query = "SELECT * FROM `users` WHERE `email`='" . mysqli_real_escape_string($link, $loginData->email) . "' LIMIT 1";
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_object($result);
    
    if (password_verify($loginData->password, $row->password)) {
      $_SESSION['id'] = $row->id;
    }
    else {
      $response['errors'][] = $login_error;
    }
  }
  else {
    $response['errors'][] = $login_error;
  }

  return $response;
}
