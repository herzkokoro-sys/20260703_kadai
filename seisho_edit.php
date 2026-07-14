<?php
// seisho_edit.php ── 請書の編集画面（id で 1 件取得してフォームに初期値を表示）

// 1) URL の ?id= を受け取る（無ければ一覧へ戻す）
$id = $_GET['id'] ?? '';
if ($id === '') {
  header('Location: seisho_read.php');
  exit();
}

// 2) DB 接続
require_once 'db.php';

// 3) id で 1 件だけ取得（バインド変数で渡す）
$sql = 'SELECT * FROM seisho_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

// 4) 該当データが無ければ一覧へ戻す
if (!$record) {
  header('Location: seisho_read.php');
  exit();
}

// 5) 画面（value=）に入れる値は htmlspecialchars で安全にする
$customer = htmlspecialchars($record["customer"], ENT_QUOTES, 'UTF-8');
$subject  = htmlspecialchars($record["subject"],  ENT_QUOTES, 'UTF-8');
$amount   = htmlspecialchars($record["amount"],   ENT_QUOTES, 'UTF-8');
$deadline = htmlspecialchars($record["deadline"], ENT_QUOTES, 'UTF-8');
$id       = (int)$record["id"];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>請書編集｜NAB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrap">
    <h1>請書編集</h1>

    <!-- エラーメッセージ（更新時に空欄があると戻ってくる） -->
    <?php if (isset($_GET['error'])): ?>
      <p class="msg msg-ng">未入力の項目があります。すべて入力してください。</p>
    <?php endif; ?>

    <!-- 更新フォーム（POST で update.php へ送信） -->
    <form action="seisho_update.php" method="POST">
      <fieldset>
        <div class="field">
          <label>客先名</label>
          <input type="text" name="customer" value="<?= $customer ?>">
        </div>
        <div class="field">
          <label>件名</label>
          <input type="text" name="subject" value="<?= $subject ?>">
        </div>
        <div class="field">
          <label>金額（円）</label>
          <input type="number" name="amount" min="0" value="<?= $amount ?>">
        </div>
        <div class="field">
          <label>納期</label>
          <input type="date" name="deadline" value="<?= $deadline ?>">
        </div>

        <!-- どの請書を更新するか（id）を一緒に送る -->
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="actions">
          <button type="submit">更新する</button>
          <a class="link" href="seisho_read.php">← 一覧へ戻る</a>
        </div>
      </fieldset>
    </form>
  </div>
</body>
</html>
