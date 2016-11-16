<?php
  session_start();

  require_once("db_connect.php");

  list($conn, $db_error) = db_connect();

  if ($conn) {
    $query = "UPDATE `users` SET `diary`='" . mysqli_real_escape_string($conn, $_POST['diary']) . "' WHERE `id`=" . $_SESSION['id'];
    mysqli_query($conn, $query);

    mysqli_close($conn);
  }
