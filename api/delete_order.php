<?php
header('Content-Type: application/json');
$file = __DIR__ . '/orders.json';
$input = json_decode(file_get_contents('php://input'), true);

if(!$input || !isset($input['order_id'])) {
  echo json_encode(['status'=>'error','message'=>'Missing order_id']);
  exit;
}

$order_id = intval($input['order_id']);

if (!file_exists($file)) {
  echo json_encode(['status'=>'error','message'=>'Orders file not found']);
  exit;
}

$orders = json_decode(file_get_contents($file), true);
$new = [];
$found = false;
foreach ($orders as $o) {
  if (intval($o['order_id']) === $order_id) { $found = true; continue; }
  $new[] = $o;
}

if (!$found) {
  echo json_encode(['status'=>'error','message'=>'Order not found']);
  exit;
}

file_put_contents($file, json_encode(array_values($new), JSON_PRETTY_PRINT));
echo json_encode(['status'=>'success']);
?>
