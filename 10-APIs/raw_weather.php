<?php
$location = $argv[1];
$json = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=$location&appid=7d57c695d87b3573619384ec0dd6af50&units=metric");

print_r(json_decode($json, true));
