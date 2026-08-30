<?php
header('Content-Type: application/json');
$file = __DIR__ . '/menu.json';
if (file_exists($file)) {
  echo file_get_contents($file);
} else {
  echo json_encode([]);
}
?>
