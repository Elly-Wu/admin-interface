<?php
require __DIR__. '/parts/admin-required.php';
require __DIR__ . '/config/pdo-connect.php';

$sid = isset($_GET['aty_id']) ? intval($_GET['aty_id']) : 0;

if (empty($sid)) {
  header('Location: list4.php');
  exit; # 結束 php 程式, die()
}

$sql = "SELECT * FROM activity WHERE aty_id=$sid";
$row = $pdo->query($sql)->fetch();

# 如果沒有這個編號的資料, 轉向回列表頁
if (empty($row)) {
  header('Location: list4.php');
  exit; # 結束 php 程式, die()
}

$title = '編輯商品';

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style>
  .required {
    color: red;
  }

  .form-text {
    color: red;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">編輯活動資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="aty_id" value="<?= $row['aty_id'] ?>">
            <div class="mb-3">
              <label for="aty_id" class="form-label">編號</label>
              <input type="text" class="form-control" value="<?= $row['aty_id'] ?>" disabled>
            </div>
            <div class="mb-3">
              <label for="aty_name" class="form-label"><span class="required">**</span> 活動名稱</label>
              <input type="text" class="form-control" id="aty_name" name="aty_name" value="<?= $row['aty_name'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="start_time" class="form-label"><span class="required">**</span> 開始時間</label>
              <input type="date" class="form-control" id="start_time" name="start_time" value="<?= date('Y-m-d', strtotime($row['start_time'])) ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="end_time" class="form-label"><span class="required">**</span> 結束時間</label>
              <input type="date" class="form-control" id="end_time" name="end_time" value="<?= date('Y-m-d', strtotime($row['end_time'])) ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="jin_name" class="form-label"><span class="required">**</span> 參加賣家</label>
              <textarea class="form-control" id="jin_name" name="jin_name" rows="3"><?= $row['jin_name'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="pdo_name" class="form-label"><span class="required">**</span> 商品名稱</label>
              <textarea class="form-control" id="pdo_name" name="pdo_name" rows="3"><?= $row['pdo_name'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="pdo_price" class="form-label">商品價格</label>
              <input type="number" class="form-control" id="pdo_price" name="pdo_price" value="<?= $row['pdo_price'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="pdo_count" class="form-label">商品庫存數量</label>
              <input type="number" class="form-control" id="pdo_count" name="pdo_count" value="<?= $row['pdo_count'] ?>">
              <div class="form-text"></div>
            </div>


            <button type="submit" class="btn btn-primary">修改</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">資料修改結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          主題資料修改成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
        <a href="list4.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel2">資料修改結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          資料沒有修改
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
        <a href="list4.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const nameField = document.form1.aty_name;
  const priceField = document.form1.pdo_price;

  function validatePrice(pdo_price) {
    // 檢查價格是否為正數
    return pdo_price > 0;
  }

  const sendData = e => {
    e.preventDefault();

    // 回復沒有提示的狀態
    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerHTML = '';
    priceField.style.border = '1px solid #CCCCCC';
    priceField.nextElementSibling.innerHTML = '';

    let isPass = true; // 有沒有通過檢查

    // TODO: 要做欄位資料檢查
    if (nameField.value.length < 2) {
      isPass = false;
      // 跳提示用戶
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '請填寫正確的商品名稱';
    }

    if (!validatePrice(priceField.value)) {
      isPass = false;
      priceField.style.border = '1px solid red';
      priceField.nextElementSibling.innerHTML = '請填寫正確的商品價格';
    }


    // 如果欄位資料都有通過檢查
    if (isPass) {
      const fd = new FormData(document.form1); // 建立一個只有資料的表單物件

      fetch('edit-activities-api.php', {
          method: 'POST',
          body: fd, // 預設的 Content-Type: multipart/form-data
        })
        .then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
            myModal2.show();
          }
        }).catch(ex => {
          console.log(`fetch() 發生錯誤, 回傳的 JSON 格式是錯的`);
          console.log(ex);
        })
    }
  }

  const myModal = new bootstrap.Modal('#exampleModal');
  const myModal2 = new bootstrap.Modal('#exampleModal2');
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>
