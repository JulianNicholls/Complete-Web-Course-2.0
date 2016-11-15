<?php
  session_start();

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
    $conn       = mysqli_connect('localhost', 'root', 'root', 'web20', 8889);
    $db_error   = $conn ? '' : '<strong>Error connecting to database</strong>: ' . mysqli_connect_errno() . ', ' . mysqli_connect_error();

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

    <title>Secret Diary - Login</title>
  </head>

  <style>
body {
  background: url(images/bay-area.png) no-repeat top center;
  background-size: cover;
}

h1, h2, h3, h4, h5, h6 {
   font-family: 'Fjalla One';
}

#login-form {
  display: none;
}
  </style>

  <body>
    <?php if ($db_error !== '') : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $db_error; ?>
      </div>
    <?php endif; ?>

    <h1 class="my-1 display-4 text-sm-center">Secret Diary - Login</h1>

    <div class="container">
      <?php if ($error !== '') : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <div class="card card-block">
        <form id="signup-form" class="my-1" method="post">
          <div class="form-group">
            <label class="sr-only" for="signup-email">Email</label>
            <input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="Email Address" value="<?php if (isset($signup_email)) echo $signup_email; ?>">
          </div>
          <div class="form-group">
            <label class="sr-only" for="signup-password">Password</label>
            <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Password">
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="checkbox" id="signup-stay" name="signup-stay" class="form-check-input">
              Keep me logged in
            </label>
          </div>
          <button type="submit" id="signup" name="signup" class="btn btn-primary">Sign Up</button>
        </form>

        <form id="login-form" class="my-1" method="post">
          <div class="form-group">
            <label class="sr-only" for="login-email">Email</label>
            <input type="email" class="form-control" id="login-email" name="login-email" placeholder="Email Address" value="<?php if (isset($login_email)) echo $login_email; ?>">
          </div>
          <div class="form-group">
            <label class="sr-only" for="login-password">Password</label>
            <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Password">
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="checkbox" id="login-stay" name="login-stay" class="form-check-input">
              Keep me logged in
            </label>
          </div>
          <button type="submit" id="login" name="login" class="btn btn-primary">Log in</button>
        </form>

        <span id="flip-text">Already have an account?</span> <a id="flip-forms" href="#">Log in</a>
      </div>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
            integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"
            integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script>
$("#flip-forms").on('click', evt => {
  const $login_form  = $("#login-form");
  const $signup_form = $("#signup-form");
  const $flip_text   = $("#flip-text");
  const $flip_forms  = $("#flip-forms");

  if($signup_form.is(':visible')) {
    $signup_form.fadeOut(() => {
      $login_form.fadeIn();
    });
    $flip_text.html('Need an account?')
    $flip_forms.text('Sign up')
  }
  else {
    $login_form.fadeOut(() => {
      $signup_form.fadeIn();
    });
    $flip_text.html('Already have an account?')
    $flip_forms.text('Log in')
  }

  return false;
});
    </script>
  </body>
</html>
