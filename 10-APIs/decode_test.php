<?php

$json = '{
  "top-value": 1,
  "top-struct": {
    "second-value": 2,
    "second-struct": {
      "third-value": 3
    },
    "second-second": 22
  },
  "first-second": 12
}';

print_r(json_decode($json));
print_r(json_decode($json, true));
