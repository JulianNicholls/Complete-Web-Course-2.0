<?php function db_connect() {
  $conn     = mysqli_connect('localhost', 'root', 'root', 'web20', 8889);
  $db_error = $conn ? '' : '<strong>Error connecting to database</strong>: ' . mysqli_connect_errno() . ', ' . mysqli_connect_error();

  return array($conn, $db_error);
}
