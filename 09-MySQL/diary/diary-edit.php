<?php
  session_start();

  require_once('header.php');
  require_once('db_connect.php');

  if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
  }

  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }
  else {
    header('Location: diary-login.php');
  }

  list($conn, $db_error) = db_connect();

  $diary_text = '';

  if ($conn) {
    $query  = 'SELECT `diary` FROM `users` WHERE `id`=' . $_SESSION['id'];
    $result = mysqli_query($conn, $query);
    $row    = mysqli_fetch_assoc($result);

    $diary_text = $row['diary'];

    mysqli_close($conn);
  }

  page_header("Secret Diary - Edit");
?>

  <body>
    <div class="container">
      <h1 class="my-1 display-4 text-sm-center">Edit Diary</h1>
      <a id="logout" class="btn btn-success" href="diary-login.php?logout=1">Log out</a>

      <form action="post">
        <div class="form-group">
          <label class="sr-only" for="diary-text">Diary text</label>
          <textarea class="form-control" id="diary-text" name="diary-text" rows="25"><?php echo $diary_text ?></textarea>
        </div>
      </form>
    </div>

<?php require_once("footer.php");
