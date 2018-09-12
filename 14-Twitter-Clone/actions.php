<?php
include ('functions.php');

if ($_GET["action"] == 'login') {
  $login_data = getPOSTData();
  $errors = '';

  if (!$login_data->email) {
    $errors = 'You must enter an email address.';
  }

  if (strlen($login_data->password) < 6) {
    $errors .= 'You must enter a password of at least 6 characters.';
  }

  if ($login_data->loginActive === '0') {
    echo "Sign user up:" . $errors;
  }
}
