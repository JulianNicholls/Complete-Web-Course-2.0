<?php
  require_once('functions.php');

  require_once('views/header.php');

  switch ($_GET['page']) {
    case 'timeline':
    case 'personal':
    case 'search':
      include("views/{$_GET['page']}.php");
      break;

    default:
      include('views/home.php');
  }

  require_once('views/footer.php');
