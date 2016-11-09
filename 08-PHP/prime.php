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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type='text/css'>
    <script src="https://use.fontawesome.com/3d3a1ab939.js"></script>

    <title>PHP Primes</title>
  </head>

  <style>
body {
  font-family: 'Open Sans', Helvetica, Arial, sans-serif;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Fjalla One';
}

#result {
  background: #C5CAE9;
  padding: 2em;
  font-size: 2em;
  text-align: center;
}
  </style>

  <body>
    <h1 class="my-1 text-sm-center">Is it Prime?</h1>

    <div class="container">
      <div id="result">
        <div class="spinner">
          <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span>
        </div>
      </div>

      <form class="mt-3" action="prime.php" method="get">
        <div class="form-group row">
          <label for="number" class="col-sm-2 col-form-label">Number</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="number" name="number" />
          </div>
        </div>
        <div class="form-group row">
          <div class="offset-sm-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Check</button>
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

<?php
if (isset($_GET['number'])) :
  $number  = $_GET['number'];
  list($isPrime, $factors) = prime($number);

  $text = "$number is ";

  if($isPrime) {
    $text .= 'prime.';
  }
  else {
    $text .= 'not prime.<br>Factors: '. join(', ', $factors);
  }

  echo "
  <script>
    $('#result').html('$text');
  </script>
  ";
endif;

function prime($number) {
  $limit   = ceil(sqrt($number));
  $factors = array();

  $div = 2;

  while($div <= $limit && $number > 1) {
    if($number % $div == 0) {
      $factors[] = $div;
      $number /= $div;
    }
    else {
      $div = ($div == 2) ? 3 : $div + 2;
    }
  }

  if (sizeof($factors) == 0) {
    return array(true, array());
  }

  if($number > 1) { $factors[] = $number; }

  return array(false, $factors);
}
?>
  </body>
</html>
