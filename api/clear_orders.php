<?php
header('Content-Type: application/json');
$file = __DIR__ . '/orders.json';

// simple protection: require a secret token in POST (optional)
$input = json_decode(file_get_contents('php://input'), true);
$secret_ok = true;
if (isset($input['secret'])) {
  $secret_ok = ($input['secret'] === 'YOUR_SECRET_KEY'); // change or remove if not needed
}

if (!$secret_ok) {
  echo json_encode(['status'=>'error','message'=>'Unauthorized']);
  exit;
}

file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
echo json_encode(['status'=>'success','message'=>'All orders cleared']);
?>
