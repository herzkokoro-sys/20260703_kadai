<?php
// seisho_input.php ── 請書の作成画面（入力フォーム）

// --- ログインしていない人はここで弾く（PHP04） ---
session_start();
require_once 'functions.php';
check_session_id();

// create.php から戻ってきたときに ?done / ?error が付くので、その表示だけ判定する
$done  = isset($_GET['done']);
$error = isset($_GET['error']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>請書登録｜NAB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrap">
    <h1>請書登録</h1>

    <!-- 完了・エラーメッセージ -->
    <?php if ($done): ?>
      <p class="msg msg-ok">登録しました。</p>
    <?php endif; ?>
    <?php if ($error): ?>
      <p class="msg msg-ng">未入力の項目があります。すべて入力してください。</p>
    <?php endif; ?>

    <!-- 入力フォーム（POST で create.php へ送信） -->
    <form action="seisho_create.php" method="POST">
      <fieldset>
        <div class="field">
          <label>客先名</label>
          <input type="text" name="customer" placeholder="例）株式会社〇〇製作所">
        </div>
        <div class="field">
          <label>件名</label>
          <input type="text" name="subject" placeholder="例）精密シャフト加工 一式">
        </div>
        <div class="field">
          <label>金額（円）</label>
          <input type="number" name="amount" min="0" placeholder="例）480000">
        </div>
        <div class="field">
          <label>納期</label>
          <input type="date" name="deadline">
        </div>
        <div class="actions">
          <button type="submit">登録する</button>
          <a class="link" href="seisho_read.php">一覧を見る →</a>
        </div>
      </fieldset>
    </form>
  </div>
</body>
</html>
