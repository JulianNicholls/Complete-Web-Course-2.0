<?php
require_once('simple_html_dom.php');

$loc = isset($argv[1]) ? $argv[1] : 'asdf';

$html   = file_get_html("http://www.weather-forecast.com/locations/$loc/forecasts/latest");

if($html === FALSE) {
  echo "Failed to load forecast";
}
else {
  echo "Forecast loaded";  
}
