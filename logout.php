<?php
// logout.php ── ログアウト。セッションの痕跡を消してログイン画面へ戻す
// 講義どおり「①変数を消す ②ブラウザのCookieを失効させる ③セッション領域を破棄する」の3段階

session_start();

// ① セッション変数を全部消す
$_SESSION = array();

// ② ブラウザに保存されている番号札（Cookie）の有効期限を過去にして失効させる
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 42000, '/');
}

// ③ サーバ側のセッション領域そのものを破棄する
session_destroy();

header('Location:login.php?logout=1');
exit();
