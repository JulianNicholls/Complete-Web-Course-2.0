<?php
  require_once('functions.php');

  require_once('views/header.php');

  switch ($_GET['page']) {
    case 'timeline':
      include('views/timeline.php');
      break;

    case 'personal':
      include('views/personal.php');
      break;

    default:
      include('views/home.php');
  }

  require_once('views/footer.php');
