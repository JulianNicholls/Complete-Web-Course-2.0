<?php
  session_start();

  require_once('header.php');

  if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
  }

  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }
  else {
    header('Location: diary-login.php');
  }

  page_header("Secret Diary - Edit");
?>

  <body>
    <h1 class="my-1 display-4 text-sm-center">Edit Diary</h1>

    <div class="container">
      <p>
        Hello User <?php echo $id; ?><br>
        <a href="diary-login.php?logout=1">Log out</a>
      </p>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
            integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"
            integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>
