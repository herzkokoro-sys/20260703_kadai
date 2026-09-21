<?php
// seisho_read.php ── 請書の一覧参照（DB からデータを取得して表に表示）

// --- 未ログインでも「見るだけ」なら通す画面（PHP04）---
//   ログイン中     → 新規登録・編集・削除のリンクを出す
//   未ログイン     → 一覧の表示だけ。操作リンクは出さない
session_start();
require_once 'functions.php';
$logged_in = is_logged_in();
if ($logged_in) {
  // ログイン中のときだけ番号札を更新する（check_session_id は未ログインだと追い出すので通さない）
  check_session_id();
}

// 1) DB 接続
require_once 'db.php';

// 2) SQL 作成 & 実行（納期の近い順に並べ替え）
$sql = 'SELECT * FROM seisho_table ORDER BY deadline ASC';
$stmt = $pdo->prepare($sql);

try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 3) データ取得 → 行タグを組み立てる
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  // htmlspecialchars で画面表示時の XSS を防ぐ
  $customer = htmlspecialchars($record["customer"], ENT_QUOTES, 'UTF-8');
  $subject  = htmlspecialchars($record["subject"],  ENT_QUOTES, 'UTF-8');
  $amount   = number_format((int)$record["amount"]); // 3 桁区切り
  $deadline = htmlspecialchars($record["deadline"],  ENT_QUOTES, 'UTF-8');
  $id = (int)$record["id"]; // id は数値なのでキャストしてそのまま使う

  // 操作列（編集・削除）はログイン中だけ。未ログインには出さない
  $ops = "";
  if ($logged_in) {
    $ops = "
      <td><a class=\"link\" href=\"seisho_edit.php?id={$id}\">編集</a></td>
      <td><a class=\"link link-del\" href=\"seisho_delete.php?id={$id}\" onclick=\"return confirm('この請書を削除します。よろしいですか？');\">削除</a></td>
    ";
  }

  $output .= "
    <tr>
      <td>{$id}</td>
      <td>{$customer}</td>
      <td>{$subject}</td>
      <td class=\"num\">&yen;{$amount}</td>
      <td>{$deadline}</td>
      {$ops}
    </tr>
  ";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>請書一覧｜NAB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrap">
    <h1>請書一覧</h1>

    <!-- ログイン中のユーザ表示とログアウト（PHP04） -->
    <p class="userbar">
      <?php if ($logged_in): ?>
        <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?> さんでログイン中
        <?php if ((int)$_SESSION['is_admin'] === 1): ?>
          <span class="badge">管理者</span>
        <?php endif; ?>
        <a class="link" href="logout.php">ログアウト</a>
      <?php else: ?>
        未ログイン（閲覧のみ）
        <a class="link" href="login.php">ログイン</a>
      <?php endif; ?>
    </p>

    <p>
      <?php if ($logged_in): ?>
        <a class="link" href="seisho_input.php">← 新規登録</a>　
      <?php endif; ?>
      （納期の近い順）
    </p>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>客先名</th>
          <th>件名</th>
          <th>金額</th>
          <th>納期</th>
          <?php if ($logged_in): ?>
            <th>編集</th>
            <th>削除</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>

    <?php if (count($result) === 0): ?>
      <p class="msg">
        データがまだありません。
        <?php if ($logged_in): ?>
          <a href="seisho_input.php">登録画面へ</a>
        <?php else: ?>
          <a href="login.php">ログインすると登録できます</a>
        <?php endif; ?>
      </p>
    <?php endif; ?>
  </div>
</body>
</html>
