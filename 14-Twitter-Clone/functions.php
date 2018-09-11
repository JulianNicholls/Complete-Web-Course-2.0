<?php
function getPOSTData() {
  return json_decode(file_get_contents('php://input'));
}
