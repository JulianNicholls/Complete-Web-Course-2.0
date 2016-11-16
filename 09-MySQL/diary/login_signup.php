<?php
require_once('db_connect.php');

if (isset($_GET['logout'])) {
  unset($_SESSION['id']);
  setcookie('id', FALSE, time() - 7200);
}
else {
  if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
  }

  if (isset($_SESSION['id'])) {
    header("Location: diary-edit.php");
  }
}

$db_error  = '';
$error     = '';

if (isset($_POST['signup']) || isset($_POST['login'])) {
  list($conn, $db_error) = db_connect();

  $stay_logged_in = isset($_POST['signup-stay']) || isset($_POST['login-stay']);

  if ($conn && isset($_POST['signup'])) {
    $signup_email = mysqli_real_escape_string($conn, $_POST['signup-email']);

    if ($signup_email !== '' && $_POST['signup-password'] !== '') {
      $signup_password = mysqli_real_escape_string($conn, password_hash($_POST['signup-password'], PASSWORD_DEFAULT));

      $query  = "SELECT `id` FROM `users` WHERE `email`='$signup_email'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        $error = 'That email address has already been signed up';
      }
      else {
        $query  = "INSERT INTO `users` (`email`, `password`) VALUES('$signup_email', '$signup_password')";
        if (mysqli_query($conn, $query)) {
          $id = mysqli_insert_id($conn);
          $_SESSION['id'] = $id;
          if ($stay_logged_in) {
            setcookie('id', $id, time() + 7 * 24 * 60 * 60);
          }
          header('Location: diary-edit.php');
        }
        else {
          $error = "There was a problem signing you up: " . mysqli_connect_errno() . ', ' . mysqli_connect_error();
        }
      }
    }
    else {
      $error = 'You must enter both an email address and password';
    }
  }

  if ($conn && isset($_POST['login'])) {
    $login_email = mysqli_real_escape_string($conn, $_POST['login-email']);

    if ($login_email !== '' && $_POST['login-password'] !== '') {
      $login_password = $_POST['login-password'];

      $query  = "SELECT `id`, `password` FROM `users` WHERE `email`='$login_email'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($login_password, $row['password'])) {
          $id = $row['id'];
          $_SESSION['id'] = $id;
//            print_r($_POST);
          if ($stay_logged_in) {
            setcookie('id', $id, time() + 7 * 24 * 60 * 60);
//              echo 'Written COOKIE';
          }
          header('Location: diary-edit.php');
        }
        else {
          $error = "That password has not been recognised";
        }
      }
      else {
        $error = "That email address or password has not been recognised";
      }
    }
    else {
      $error = 'You must enter both an email address and password';
    }
  }

  if($conn) {
    mysqli_close($conn);
  }
}
