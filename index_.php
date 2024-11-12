<?php
if(! isset($_SESSION)) {
  # 如果沒有設定 $_SESSION, 才啟動
  session_start();
}
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
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
</style>
<?php include __DIR__ . '/parts/navbar.php' ?>
<div class="container">
  <h1 style="color: #6c757d; margin-left: 16px;">Admin</h1>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>