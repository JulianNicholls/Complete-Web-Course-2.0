<?php
  session_start();

  if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
  }

  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }
  else {
    header('Location: diary-login.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
    <script src="https://use.fontawesome.com/3d3a1ab939.js"></script>

    <title>Secret Diary - Edit</title>
  </head>

  <style>
body {
  background: url(images/bay-area.png) no-repeat top center;
  background-size: cover;
}

h1, h2, h3, h4, h5, h6 {
 font-family: 'Fjalla One';
}
  </style>

  <body>
    <h1 class="my-1 display-4 text-sm-center">Edit Diary</h1>

    <div class="container">
      <p>
        Hello User <?php echo $id; ?><br>
        <a href="diary-login.php?logout=1">Log out</a>
      </p>
    </div>
  </body>
</html>
