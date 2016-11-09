<?php
  session_start();

  $db_error  = '';
  $error     = '';
  $message   = '';

  if (isset($_POST['email'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
      $error = "You must enter your email address and password";
    }
    else {
      $db        = mysqli_connect('localhost', 'root', 'root', 'web20', 8889);
      $db_error  = $db ? '' : '<strong>Error connecting to database</strong>: ' . mysqli_connect_errno() . ', ' . mysqli_connect_error();

      if ($db) {
        $email    = mysqli_real_escape_string($db, $email);

        $query  = "SELECT `id`, `password` FROM `users` WHERE `email`='$email'";
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) === 1) {
          $row = mysqli_fetch_assoc($result);

          if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            header('Location: session.php');
          }

          $error = "That password has not been recognised";          
        }
        else {
          $error = "That email address or password has not been recognised";
        }

        mysqli_close($db);
      }
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

    <title>User Login</title>
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
    <h1 class="my-1 text-sm-center">User Login</h1>

    <div class="container">
      <?php if ($error !== '') : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <form class="my-2" method="post">
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo $email; ?>">
          </div>
        </div>

        <div class="form-group row">
          <label for="password" class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
        </div>

        <div class="form-group row">
          <div class="offset-sm-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Log in</button>
          </div>
        </div>
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
