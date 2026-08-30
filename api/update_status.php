<?php
header('Content-Type: application/json');
$file = __DIR__ . '/orders.json';
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['order_id']) || !isset($input['status'])) {
  echo json_encode(['status'=>'error','message'=>'Missing order_id or status']);
  exit;
}

$order_id = intval($input['order_id']);
$status = $input['status'];

if (!file_exists($file)) {
  echo json_encode(['status'=>'error','message'=>'Orders file not found']);
  exit;
}

$orders = json_decode(file_get_contents($file), true);
$found = false;
foreach ($orders as &$o) {
  if (intval($o['order_id']) === $order_id) {
    $o['status'] = $status;
    $found = true;
    break;
  }
}

if (!$found) {
  echo json_encode(['status'=>'error','message'=>'Order not found']);
  exit;
}

file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT));
echo json_encode(['status'=>'success']);
?>
