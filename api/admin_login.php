<?php
header('Content-Type: application/json');
$file = __DIR__ . '/admin.json';

if (!file_exists($file)) {
  echo json_encode(['status'=>'error','message'=>'Admin file missing']);
  exit;
}

$admins = json_decode(file_get_contents($file), true);
if (!is_array($admins)) {
  echo json_encode(['status'=>'error','message'=>'Invalid admin file']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['username']) || !isset($input['password'])) {
  echo json_encode(['status'=>'error','message'=>'Missing username or password']);
  exit;
}

$username = trim($input['username']);
$password = trim($input['password']);

foreach ($admins as $admin) {
  if ($admin['username'] === $username && $admin['password'] === $password) {
    echo json_encode(['status'=>'success','message'=>'Login successful']);
    exit;
  }
}

echo json_encode(['status'=>'error','message'=>'Invalid credentials']);
?>
