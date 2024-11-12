<?php
require __DIR__ . '/config/pdo-connect.php';
$title = '主題活動管理';
$pageName = 'ab_list4';

$t_sql = "SELECT COUNT(1) FROM activity";


$perPage = 25; # 每一頁最多有幾筆資料

# 取得用戶要看第幾頁
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  # 頁碼小於 1 跳轉到頁碼為 1
  header('Location: ?page=1');
  exit;
}

# 取得資料總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
# 預設值
$totalPages = 0;
$rows = [];
if ($totalRows > 0) {
  # 如果有資料才去取得分頁資料
  $totalPages = ceil($totalRows / $perPage);
  if ($page > $totalPages) {
    # 頁碼大於總頁數時
    header('Location: ?page=' . $totalPages);
    exit;
  }

  $sql = sprintf(
    "SELECT * FROM activity ORDER BY aty_id DESC LIMIT %s, %s", //要改
    ($page - 1) * $perPage,
    $perPage
  );
  
  $rows = $pdo->query($sql)->fetchAll();
  
}


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style>
  body {
          background: url("images/clouds-640.jpg")no-repeat;
          @media screen and (min-width: 576px){
              background-image: url("images/clouds-1280.jpg");
          }
          @media screen and (min-width: 768px){
              background-image: url("images/clouds-1920.jpg");
          }
        }
  .aclass:hover {
    color: #6c757d;
    border-bottom: 2px solid #6c757d;
  }
  .aclass{
    font-size:24px;
    font-weight: bold;
    margin-left:auto;
    color: #6c757d;
    text-decoration: none;
  }
  .page-link {
    color: #6c757d;
  }
  .active>.page-link, .page-link.active {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
  }
  .fa-trash, .fa-pen-to-square {
    color: #6c757d;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) :
          ?>
              <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>
          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?>">
              <i class="fa-solid fa-angles-right"></i>
            </a>
          </li>
          <!-- 要改 -->
          <a class="aclass<?= $pageName === 'ab_add' ? 'active' : '' ?>" href="add-activities.php">新增主題資料</a>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><i class="fa-solid fa-trash"></i></th>
            <!-- 要改 -->
            <th>活動編號</th>
            <th>活動名稱</th>
            <th>開始時間</th>
            <th>結束時間</th>
            <th>建立時間</th>
            <th>賣家編號</th>
            <th>賣家名稱</th>
            <th>商品id</th>
            <th>商品名稱</th>
            <th>商品價格</th>
            <th>商品庫存</th>
            <th><i class="fa-solid fa-pen-to-square"></i></th>
        
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              <td>
                <a href="javascript: deleteOne(<?= $r['aty_id'] ?>)">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
              <!-- 要改 -->
              <td><?= $r['aty_id'] ?></td>
              <td><?= $r['aty_name'] ?></td>
              <td><?= $r['start_time'] ?></td>
              <td><?= $r['end_time'] ?></td>
              <td><?= $r['create_time'] ?></td>
              <td><?= $r['jin_id'] ?></td>
              <td><?= $r['jin_name'] ?></td>
              <td><?= $r['pdo_id'] ?></td>
              <td><?= $r['pdo_name'] ?></td>
              <td><?= $r['pdo_price'] ?></td>
              <td><?= $r['pdo_count'] ?></td>
              <td>
                <!-- 要改 -->
                <a href="edit-activities.php?aty_id=<?= $r['aty_id'] ?>"> 
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>



  <?php /*
  <pre><?php
        print_r([
          'perPage' => $perPage,
          'totalRows' => $totalRows,
          'totalPages' => $totalPages,
          'rows' => $rows,
        ]);
        ?></pre>
        */ ?>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const deleteOne = sid => {
    if(confirm(`是否要刪除編號為 ${sid} 的資料?`)){
      location.href = `delete4.php?aty_id=${sid}`; //要改
    }
  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>