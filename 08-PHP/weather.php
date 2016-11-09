<?php
require_once('simple_html_dom.php');

$DAY_ABBREVS = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
$DAYS        = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

// I was going to change the NNE, SSW etc, but I think that they are actually
// more comprehensible kept as abbreviations
$DIR_ABBREVS = array(' N ', ' NE ', ' E ', ' SE ', ' S ', ' SW ', ' W ', ' NW ');
$DIRS        = array(' North ', ' North East ', ' East ', ' South East ', ' South ', ' South West ', ' West ', ' North West ');

$HEADERS = array("Three day forecast", "The rest of the week", "10 day forecast");

$result = '';

if (isset($_GET['location'])) :
  $location       = $_GET['location'];
  $esc_location   = str_replace(' ', '-', $location);  // Escape spaces

  $result = "<h1 class=\"text-sm-center my-1\">$location</h1>";

  $html   = @file_get_html("http://www.weather-forecast.com/locations/$esc_location/forecasts/latest");

  if($html !== FALSE) {
    $spans  = $html->find('span.phrase');    // Three forecasts

    if(count($spans) >= count($HEADERS)) {
      for($i = 0; $i < count($HEADERS); ++$i) {
        $text = str_replace($DAY_ABBREVS, $DAYS, $spans[$i]->innertext);
        $text = str_replace($DIR_ABBREVS, $DIRS, $text);

        $result .= "<p class=\"my-2\"><strong>$HEADERS[$i]</strong>: $text</p>";
      }
    }
    else {
      $result .= "<h5 class=\"my-2 error\">No forecast information was returned for $location.</h5>";
    }
  }
  else {
    $result .= "<h5 class=\"my-2 error\">No forecast found for $location.<br>Is it spelled correctly?</h5>";
  }
endif;
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

    <title>Weather Oracle</title>
  </head>

  <style>
body {
  background: url(images/blue-sky.png) no-repeat top center;
  background-size: cover;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Fjalla One';
}

#result {
  background: #5C6BC0;
  color: white;
  border-radius: 1em;
}

#result strong {
  color: yellow;
}

#location {
  width: 70%;
}

.error {
  text-align: center;
  color: #f88;
}
  </style>

  <body>
    <h1 class="my-1 text-sm-center">Weather Oracle</h1>

    <div class="container">
      <div class="p-2" id="result">
        <?php echo $result; ?>
      </div>

      <div class="mt-3 card card-block">
        <h4 class="card-title text-sm-center">Enter Location</h4>
        <form class="form-inline" method="get">
          <input type="text" class="form-control" id="location" name="location" placeholder="Location, e.g. Bournemouth"/>
          <button type="submit" class="btn btn-primary">Consult the Oracle</button>
        </form>
      </div>
    </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
            integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"
            integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>
