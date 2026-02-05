<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // TODO: lock to your frontend domain later
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
  exit(0);
}
?>
