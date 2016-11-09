<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP Loops</title>
  </head>
  <body>
    <pre>
<?php
  $people = array("Julian", "Tara", "Clara");

  for($i = 0; $i < sizeof($people); ++$i) {
    echo "$i: $people[$i]\n";

  }

  foreach($people as $key => $person) {
    echo "$key => $person\n";
  }

  for($i = 0; $i < 10; ++$i) {
    echo "$i\n";
  }

  $i = 1;

  while ($i <= 12) {
    echo "$i x 5 = ". $i * 5 . "\n";

    ++$i;
  }

?>
    </pre>
  </body>
</html>
