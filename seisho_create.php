<?php
// seisho_create.php ── 請書の作成処理（DB へ INSERT）。画面表示はしない。

// 1) POST 以外で直接アクセスされたら入力画面へ戻す
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: seisho_input.php');
  exit();
}

// 2) 値を受け取る
$customer = trim($_POST['customer'] ?? '');
$subject  = trim($_POST['subject']  ?? '');
$amount   = trim($_POST['amount']   ?? '');
$deadline = $_POST['deadline'] ?? '';

// 3) 入力チェック（必須項目が空なら入力画面へ戻す）
if ($customer === '' || $subject === '' || $amount === '' || $deadline === '') {
  header('Location: seisho_input.php?error=1');
  exit();
}

// 4) DB 接続
require_once 'db.php';

// 5) SQL 作成 & 実行（ユーザ入力はバインド変数で渡す＝SQL インジェクション対策）
$sql = 'INSERT INTO seisho_table (id, customer, subject, amount, deadline, created_at, updated_at)
        VALUES (NULL, :customer, :subject, :amount, :deadline, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':customer', $customer, PDO::PARAM_STR);
$stmt->bindValue(':subject',  $subject,  PDO::PARAM_STR);
$stmt->bindValue(':amount',   $amount,   PDO::PARAM_INT);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);

try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 6) 完了 → 入力画面へ戻る
header('Location: seisho_input.php?done=1');
exit();
