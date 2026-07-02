<?php
// db.php ── DB 接続を 1 か所にまとめる（各ファイルから require して使う）

// 各種項目設定（XAMPP 既定：root / パスワードなし）
$dbn  = 'mysql:dbname=gs_seisho_db;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd  = '';

// DB 接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
  // エラーを例外として受け取る（try/catch で拾えるようにする）
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
