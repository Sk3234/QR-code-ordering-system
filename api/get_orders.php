<?php
header('Content-Type: application/json');
$file = __DIR__ . '/orders.json';
if (file_exists($file)) {
  $json = file_get_contents($file);
  $data = json_decode($json, true);
  if ($data === null) echo json_encode([]);
  else echo json_encode($data);
} else {
  echo json_encode([]);
}
?>
