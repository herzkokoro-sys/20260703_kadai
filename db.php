<?php
// db.php ── DB 接続を 1 か所にまとめる（各ファイルから require して使う）
// ローカル(XAMPP)とさくらレンタルサーバの両方で動くよう、アクセス元で接続先を切り替える。

$host = $_SERVER['SERVER_NAME'] ?? '';

if ($host === 'localhost' || $host === '127.0.0.1') {
  // === ローカル（XAMPP）===
  $db_name = 'gs_seisho_db';
  $db_host = 'localhost';
  $user    = 'root';
  $pwd     = '';
} else {
  // === さくらのレンタルサーバ ===
  $db_name = 'nabestian_seisho';                        // データベース名
  $db_host = 'mysql80.nabestian.sakura.ne.jp';          // データベースサーバ
  $user    = 'nabestian_seisho';                        // ユーザー名
  $pwd     = 'nabexander0905';                          // 接続パスワード
}

$dbn = "mysql:dbname={$db_name};charset=utf8mb4;port=3306;host={$db_host}";

// DB 接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
  // エラーを例外として受け取る（try/catch で拾えるようにする）
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
