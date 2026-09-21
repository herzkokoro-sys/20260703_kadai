<?php
// login_act.php ── ログインフォームから送られた値を受け取り、DB と照合する
// 画面は出さない。結果によって一覧画面かログイン画面へリダイレクトするだけ。

session_start();
require_once 'db.php';

// 1) 入力チェック（空ならログイン画面に戻す）
if (
  !isset($_POST['username']) || $_POST['username'] === '' ||
  !isset($_POST['password']) || $_POST['password'] === ''
) {
  header('Location:login.php?error=1');
  exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

// 2) username でユーザを1件探す
//    パスワードはハッシュ化して保存してあるので SQL では比較できない。
//    「username が一致し、まだ削除されていない」ユーザを取り出し、照合は PHP 側で行う。
$sql = 'SELECT * FROM users_table WHERE username = :username AND deleted_at IS NULL';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);

try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 3) 照合
//    password_verify(入力された平文, DBのハッシュ) が true ならパスワード一致。
//    ユーザが居ない場合と パスワード違い は、同じメッセージで返す
//    （どちらが違うか教えると、存在するユーザ名を探られてしまうため）
if (!$user || !password_verify($password, $user['password'])) {
  header('Location:login.php?error=1');
  exit();
}

// 4) ログイン成功
//    まず古いセッションの中身を空にしてから、必要な情報だけ入れ直す
$_SESSION = array();
session_regenerate_id(true);           // ログインを機に番号札を作り直す
$_SESSION['session_id'] = session_id(); // ← この控えが「ログイン済み」の証拠になる
$_SESSION['user_id']    = $user['id'];
$_SESSION['username']   = $user['username'];
$_SESSION['is_admin']   = $user['is_admin'];

header('Location:seisho_read.php');
exit();
