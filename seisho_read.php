<?php
// seisho_read.php ── 請書の一覧参照（DB からデータを取得して表に表示）

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
  $output .= "
    <tr>
      <td>{$id}</td>
      <td>{$customer}</td>
      <td>{$subject}</td>
      <td class=\"num\">&yen;{$amount}</td>
      <td>{$deadline}</td>
      <td><a class=\"link\" href=\"seisho_edit.php?id={$id}\">編集</a></td>
      <td><a class=\"link link-del\" href=\"seisho_delete.php?id={$id}\" onclick=\"return confirm('この請書を削除します。よろしいですか？');\">削除</a></td>
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
    <p><a class="link" href="seisho_input.php">← 新規登録</a>　（納期の近い順）</p>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>客先名</th>
          <th>件名</th>
          <th>金額</th>
          <th>納期</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>

    <?php if (count($result) === 0): ?>
      <p class="msg">データがまだありません。<a href="seisho_input.php">登録画面へ</a></p>
    <?php endif; ?>
  </div>
</body>
</html>
