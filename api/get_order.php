<?php
header('Content-Type: application/json');
$file = __DIR__ . '/orders.json';
$input = json_decode(file_get_contents('php://input'), true);
$order_id = null;

// accept GET ?id=123 or POST JSON {order_id:123}
if (isset($_GET['id'])) $order_id = intval($_GET['id']);
if ($input && isset($input['order_id'])) $order_id = intval($input['order_id']);

if ($order_id === null) {
  echo json_encode(['status'=>'error','message'=>'Missing order_id']);
  exit;
}

if (!file_exists($file)) {
  echo json_encode(['status'=>'error','message'=>'No orders file']);
  exit;
}

$orders = json_decode(file_get_contents($file), true);
foreach ($orders as $o) {
  if (intval($o['order_id']) === $order_id) {
    echo json_encode(['status'=>'success','order'=>$o]);
    exit;
  }
}

echo json_encode(['status'=>'error','message'=>'Order not found']);
?>
