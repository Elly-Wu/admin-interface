<?php
require __DIR__. '/parts/admin-required.php';
require __DIR__ . '/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 是不是編輯成功
  'bodyData' => $_POST, # 檢查用
  'code' => 0, # 追踪功能的編號
];

// TODO: 要做欄位資料檢查

$sid = isset($_POST['aty_id']) ? intval($_POST['aty_id']) : 0;
if (empty($sid)) {
  # 沒有給 primary key
  $output['code'] = 400;
  echo json_encode($output);
  exit;
}

$price = isset($_POST['pdo_price']) ? floatval($_POST['pdo_price']) : 0;
if ($price <= 0) {
  # 價格不得小於等於零
  $output['code'] = 401;
  echo json_encode($output);
  exit;
}

$quantity = isset($_POST['pdo_count']) ? intval($_POST['pdo_count']) : 0;
if ($quantity < 0) {
  # 數量不得小於零
  $output['code'] = 402;
  echo json_encode($output);
  exit;
}

$sql = "UPDATE activity SET 
`aty_name`=?,
`start_time`=?,
`end_time`=?,
`jin_name`=?,
`pdo_name`=?,
`pdo_price`=?,
`pdo_count`=?
  WHERE aty_id=?";

$stmt = $pdo->prepare($sql); # 會先檢查 sql 語法

$stmt->execute([
  $_POST['aty_name'],
  $_POST['start_time'],
  $_POST['end_time'],
  $_POST['jin_name'],
  $_POST['pdo_name'],
  $price,
  $quantity,
  $sid
]);

$output['success'] = !! $stmt->rowCount();

echo json_encode($output);
