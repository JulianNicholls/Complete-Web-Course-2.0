<?php
  session_start();

  require_once('header.php');
  require_once('login_signup.php');

  page_header("Secret Diary - Login");
?>

  <style>
  </style>

  <body>
    <div id="header">
      <h2>Secret Diary</h2>
    </div>

    <?php if ($db_error !== '') : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $db_error; ?>
      </div>
    <?php endif; ?>

    <div class="container">
      <h4 class="my-1 text-sm-center">For you to store your innermost thoughts safely and securely.</h4>

      <?php if ($error !== '') : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <div class="mt-3 row">
        <div class="col-sm-8 offset-sm-2">
          <div class="card card-block">
            <form id="signup-form" method="post">
              <h5 class="text-sm-center mb-1">Interested? Sign up for an account now.</h5>

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

              <p class="mt-1">Already have an account? <a class="flip-forms" href="#">Log in</a>
            </form>

            <form id="login-form" method="post">
              <h5 class="text-sm-center mb-1">Log in with your email address and password.</h5>

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

              <p class="mt-1">Need an account? <a class="flip-forms" href="#">Sign up</a>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php require_once("footer.php");
