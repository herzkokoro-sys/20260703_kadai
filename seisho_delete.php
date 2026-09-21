<?php
// seisho_delete.php ── 請書の削除処理（DB から DELETE）。画面表示はしない。
// 一覧の「削除」リンク（?id=◯）から呼ばれる。

// --- ログインしていない人はここで弾く（PHP04） ---
session_start();
require_once 'functions.php';
check_session_id();

// 1) id を受け取る（無ければ一覧へ戻す）
$id = $_GET['id'] ?? '';
if ($id === '') {
  header('Location: seisho_read.php');
  exit();
}

// 2) DB 接続
require_once 'db.php';

// 3) SQL 作成 & 実行（必ず WHERE id で 1 件だけ削除）
$sql = 'DELETE FROM seisho_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 4) 完了 → 一覧へ戻る
header('Location: seisho_read.php');
exit();
