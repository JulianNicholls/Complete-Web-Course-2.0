<?php
include ('functions.php');

if ($_GET["action"] === 'login') {
  $login_data = getPOSTData();
  $response = [
    'errors' => []
  ];

  if (!$login_data->email) {
    $response['errors'][] = "You must enter an email address.";
  }

  if (strlen($login_data->password) < 6) {
    $response['errors'][] = 'You must enter a password of at least 6 characters.';
  }

  if (count($response['errors']) !== 0) {
    echo json_encode($response);
    exit();
  }
  
  // Signup
  if ($login_data->loginActive === '0') {
    $query = "SELECT * FROM `users` WHERE `email`='" . mysqli_real_escape_string($link, $login_data->email) . "' LIMIT 1";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) > 0) {
      $response['errors'][] = 'That email address has already been signed up.';
      echo json_encode($response);
      exit();
    }
    else {
      $query = "INSERT INTO `users` (`email`, `password`) VALUES ('" . 
        mysqli_real_escape_string($link, $login_data->email) . 
        "', '" . 
        password_hash(mysqli_real_escape_string($link, $login_data->password), PASSWORD_DEFAULT) . 
        "')";

      if (mysqli_query($link, $query)) {
        $_SESSION['id'] = mysqli_insert_id($link);
      }
      else {
        $response['errors'][] = mysqli_error($link);
      }
    }
  }
  else {  // Login
    $login_error = 'The email or password was not recognised.';
    $query = "SELECT * FROM `users` WHERE `email`='" . mysqli_real_escape_string($link, $login_data->email) . "' LIMIT 1";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_object($result);
      
      if (password_verify($login_data->password, $row->password)) {
        $_SESSION['id'] = $row->id;
      }
      else {
        $response['errors'][] = $login_error;
      }
    }
    else {
      $response['errors'][] = $login_error;
    }
  }
  
  echo json_encode($response);
}

if ($_GET['action'] === 'logout') {
  session_unset();
  header('Location: /');
  exit();
}
