<?php
  session_start();

  $db_error  = '';
  $error     = '';
  $message   = '';

  if (isset($_POST['signup-email']) || isset($_POST['login-email'])) {
    $conn       = mysqli_connect('localhost', 'root', 'root', 'web20', 8889);
    $db_error   = $conn ? '' : '<strong>Error connecting to database</strong>: ' . mysqli_connect_errno() . ', ' . mysqli_connect_error();

    $signup_email   = mysqli_real_escape_string($conn, $_POST['signup-email']);
    $login_email    = mysqli_real_escape_string($conn, $_POST['login-email']);

    if (isset($_POST['signup'])) {
      if ($signup_email !== '' && $signup_password !== '') {
        $signup_password = mysqli_real_escape_string($conn, password_hash($_POST['signup-password'], PASSWORD_DEFAULT));

        $query  = "SELECT `id` FROM `users` WHERE `email`='$signup_email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          $error = 'That email address has already been signed up';
        }
        else {
          $query  = "INSERT INTO `users` (`email`, `password`) VALUES('$signup_email', '$signup_password')";
          if (mysqli_query($conn, $query)) {
            $message = "You have been signed up successfully";

            $_SESSION['email'] = $signup_email;
//            header('Location: session.php');
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

    if (isset($_POST['login'])) {
      if ($login_email !== '' && $login_password !== '') {
        $login_password = $_POST['login-password'];

        $query  = "SELECT `id`, `password` FROM `users` WHERE `email`='$login_email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
          $row = mysqli_fetch_assoc($result);

          if (password_verify($login_password, $row['password'])) {
            $_SESSION['email'] = $login_email;
//            header('Location: session.php');
            $message = 'Logged in successfully';
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

    <title>Secret Diary</title>
  </head>

  <style>
 h1, h2, h3, h4, h5, h6 {
   font-family: 'Fjalla One';
 }
  </style>

  <body>
    <?php if ($db_error !== '') : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $db_error; ?>
      </div>
    <?php endif; ?>

    <h1 class="my-1 text-sm-center">Secret Diary</h1>

    <div class="container">
      <?php if ($error !== '') : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <?php if ($message !== '') : ?>
        <div class="alert alert-success" role="alert">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form class="form-inline mt-1" method="post">
        <div class="form-group">
          <label for="signup-email">Email</label>
          <input type="text" class="form-control" id="signup-email" name="signup-email" placeholder="Email Address">
        </div>
        <div class="form-group">
          <label for="signup-password">Password</label>
          <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Password">
        </div>
        <button type="submit" id="signup" name="signup" class="btn btn-primary">Sign Up</button>
      </form>

      <form class="form-inline mt-1" method="post">
        <div class="form-group">
          <label for="login-email">Email</label>
          <input type="text" class="form-control" id="login-email" name="login-email" placeholder="Email Address">
        </div>
        <div class="form-group">
          <label for="login-password">Password</label>
          <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Password">
        </div>
        <button type="submit" id="login" name="login" class="btn btn-primary">Log in</button>
      </form>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
            integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"
            integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>
