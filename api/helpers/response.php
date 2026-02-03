<?php
function returnWithError(string $err, int $id = -1): void {
  echo json_encode(["id" => $id, "error" => $err]);
  exit();
}

function returnWithInfo(string $message, int $id = -1): void {
  echo json_encode(["id" => $id, "message" => $message, "error" => ""]);
  exit();
}

// For endpoints that need to return a custom JSON object/array
function returnWithData($data): void {
  echo json_encode($data);
  exit();
}
?>
