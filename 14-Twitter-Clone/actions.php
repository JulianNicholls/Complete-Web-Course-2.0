<?php
include ('functions.php');

if ($_GET["action"] == 'login') {
  $data = getPOSTData();
  print json_encode($data);
}
