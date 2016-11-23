<?php
$DAY_ABBREVS = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
$DAYS        = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

$DIRECTIONS = array(
  array(-11.25,  11.25, 'N'),
  array( 11.25,  33.75, 'NNE'),
  array( 33.75,  56.25, 'NE'),
  array( 56.25,  78.75, 'ENE'),
  array( 78.75, 101.25, 'E'),
  array(101.25, 123.75, 'ESE'),
  array(123.75, 146.25, 'SE'),
  array(146.25, 168.75, 'SSE'),
  array(168.75, 191.25, 'S'),
  array(191.25, 213.75, 'SSW'),
  array(213.75, 236.25, 'SW'),
  array(236.25, 258.75, 'WSW'),
  array(258.75, 281.25, 'W'),
  array(281.25, 303.75, 'WNW'),
  array(303.75, 326.25, 'NW'),
  array(326.25, 348.75, 'NNW'),
  array(348.75, 359.95, 'N')
);
$result = '';

if (isset($_GET['location'])) :
  $location  = $_GET['location'];
  $url       = 'http://api.openweathermap.org/data/2.5/weather?q=' . urlencode($location) . '&appid=7d57c695d87b3573619384ec0dd6af50&units=metric';

  $result    = "<h1 class=\"text-sm-center my-1\">$location</h1>";

  $raw_data  = @file_get_contents($url);

  if ($raw_data !== FALSE) {
    $forecast = json_decode($raw_data, true);

    $result = "<h1 class=\"text-sm-center my-1\">{$forecast['name']}</h1>";

    $wind = '';

    if (isset($forecast['wind'])) {
      if (isset($forecast['wind']['deg'])) {
        $direction = $forecast['wind']['deg'];
        $wind      = " ($direction&deg;)";

        foreach($DIRECTIONS as $dir) {
          if ($direction >= $dir[0] && $direction < $dir[1]) {
            $wind = $dir[2] . $wind;
            break;
          }
        }
      }

      if (isset($forecast['wind']['speed'])) {
        // 2.23704 = 3.6 * 0.6214 => ms-1 -> kmh-1 -> mph
        $speed = round($forecast['wind']['speed'] * 2.23704, 1);

        if ($wind === '') {
          $wind = "$speed mph";
        }
        else {
          $wind .= " at $speed mph";
        }
      }
    }

    $result .= "<p>Summary: <strong>{$forecast['weather'][0]['description']}</strong></p>";
    $result .= "<p>Temperature: <strong>{$forecast['main']['temp']}&deg;C</strong></p>";
    if ($wind !== '') {
      $result .= "<p>Wind: <strong>$wind</strong></p>";
    }
    $result .= '<p>Sunrise: <strong>' . strftime("%H:%M", $forecast['sys']['sunrise']) . '</strong><br>';
    $result .= 'Sunset: <strong>' . strftime("%H:%M", $forecast['sys']['sunset']) . '</strong></p>';
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
  background: url(images/weather.png);
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
      <?php if ($result !== '') : ?>
        <div class="p-1" id="result">
          <?php echo $result; ?>
        </div>
      <?php endif; ?>

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
