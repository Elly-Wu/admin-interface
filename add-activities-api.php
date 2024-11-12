<?php
require __DIR__. '/parts/admin-required.php';
require __DIR__ . '/config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 是不是新增成功
  'bodyData' => $_POST, # 檢查用
  'pk' => 0,
];

// TODO: 要做欄位資料檢查

# preg_match() 使用 regular expression
# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL) 檢查是不是 email 格式 
# mb_strlen() 回傳字串的長度, mb_ 表 multi-byte

$price = floatval($_POST['pdo_price']); // 转换价格为浮点数

$sql = "INSERT INTO activity (`aty_name`, `start_time`, `end_time`, `create_time`, `jin_name`, `pdo_name`, `pdo_price`, `pdo_count`) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql); # 會先檢查 sql 語法

$stmt->execute([
  $_POST['aty_name'],
  $_POST['start_time'],
  $_POST['end_time'],
  $_POST['jin_name'],
  $_POST['pdo_name'],
  $price,
  $_POST['pdo_count']
]);

$output['success'] = !!$stmt->rowCount();
$output['pk'] = $pdo->lastInsertId(); # 取得最新新增資料的 primary key (通常是流水號)


echo json_encode($output);
?>
