<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
  <title>Twitterings</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="http://localhost/">Twitterings</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="?page=timeline">Timeline <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=yours">Your Tweetings</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="?page=profiles">Public Profiles</a>
        </li>
      </ul>
      <div class="form-inline my-2 my-lg-0">
        <?php if ($_SESSION['id']): echo $_SESSION['id']; ?>

          <a href="/actions.php?action=logout" class="btn btn-outline-light my-2 my-sm-0">Logout</a>
        <?php else: ?>
          <button 
            class="btn btn-outline-light my-2 my-sm-0" 
            data-target="#login-modal" 
            data-toggle="modal"
          >
            Log in / Sign up
          </button>
        <?php endif ?>
      </div>
    </div>
  </nav>
