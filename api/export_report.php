<?php
// export_report.php
$file = __DIR__ . '/orders.json';
if (!file_exists($file)) { echo "No orders."; exit; }
$orders = json_decode(file_get_contents($file), true);
if (!is_array($orders)) { echo "No orders."; exit; }

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="orders_report_'.date('Ymd_His').'.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['order_id','table_no','time','status','item_name','qty','price','line_total','order_total']);

foreach ($orders as $o) {
  foreach ($o['items'] as $it) {
    $line_total = (isset($it['price']) ? floatval($it['price']) : 0) * (isset($it['qty']) ? intval($it['qty']) : 1);
    fputcsv($out, [
      $o['order_id'],
      $o['table_no'],
      $o['time'],
      $o['status'],
      $it['name'],
      $it['qty'] ?? 1,
      $it['price'] ?? 0,
      $line_total,
      $o['total']
    ]);
  }
}
fclose($out);
exit;
?>
