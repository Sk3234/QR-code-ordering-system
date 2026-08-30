<?php
header('Content-Type: application/json');
$file = __DIR__ . '/orders.json';
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['table_no']) || !isset($data['items'])) {
  echo json_encode(['status'=>'error','message'=>'Missing table_no or items']);
  exit;
}

$table_no = htmlspecialchars($data['table_no']);
$items = $data['items'];
$total = isset($data['total']) ? floatval($data['total']) : 0.0;

$orders = [];
if (file_exists($file)) {
  $json = file_get_contents($file);
  $orders = json_decode($json, true);
  if (!is_array($orders)) $orders = [];
}

// new order id - incremental
$order_id = 1;
if (count($orders) > 0) {
  $last = end($orders);
  $order_id = intval($last['order_id']) + 1;
}

$newOrder = [
  'order_id' => $order_id,
  'table_no' => $table_no,
  'items' => $items,
  'total' => $total,
  'status' => 'pending',
  'time' => date('Y-m-d H:i:s')
];

$orders[] = $newOrder;
$res = file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT));

if ($res === false) {
  echo json_encode(['status'=>'error','message'=>'Failed to save order']);
  exit;
}

echo json_encode(['status'=>'success','order_id'=>$order_id]);
?>
