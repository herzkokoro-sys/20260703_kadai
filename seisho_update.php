<?php
// seisho_update.php ── 請書の更新処理（DB を UPDATE）。画面表示はしない。

// 1) POST 以外で直接アクセスされたら一覧へ戻す
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: seisho_read.php');
  exit();
}

// 2) 値を受け取る
$id       = $_POST['id']       ?? '';
$customer = trim($_POST['customer'] ?? '');
$subject  = trim($_POST['subject']  ?? '');
$amount   = trim($_POST['amount']   ?? '');
$deadline = $_POST['deadline'] ?? '';

// 3) id が無ければ更新できないので一覧へ戻す
if ($id === '') {
  header('Location: seisho_read.php');
  exit();
}

// 4) 入力チェック（必須項目が空なら編集画面へ戻す）
if ($customer === '' || $subject === '' || $amount === '' || $deadline === '') {
  header('Location: seisho_edit.php?id=' . urlencode($id) . '&error=1');
  exit();
}

// 5) DB 接続
require_once 'db.php';

// 6) SQL 作成 & 実行（必ず WHERE id で 1 件だけ更新。updated_at も今の時刻に）
$sql = 'UPDATE seisho_table
        SET customer = :customer,
            subject  = :subject,
            amount   = :amount,
            deadline = :deadline,
            updated_at = now()
        WHERE id = :id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':customer', $customer, PDO::PARAM_STR);
$stmt->bindValue(':subject',  $subject,  PDO::PARAM_STR);
$stmt->bindValue(':amount',   $amount,   PDO::PARAM_INT);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id',       $id,       PDO::PARAM_INT);

try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 7) 完了 → 一覧へ戻る
header('Location: seisho_read.php');
exit();
