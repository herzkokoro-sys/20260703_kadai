<?php
// functions.php ── ログイン状態のチェックなど、複数ページで使う関数をまとめる
// ※DB接続は db.php（$pdo）が担当。役割を分けている。

// ログインしているかどうかを「判定して返すだけ」の関数（追い出さない）
//   一覧画面のように「未ログインでも見せるが、操作リンクは隠す」画面で使う。
//   呼ぶ側で session_start() を済ませておくこと（$_SESSION を見るため）
function is_logged_in()
{
  return isset($_SESSION['session_id']) && $_SESSION['session_id'] === session_id();
}

// ログインしているかを判定して、していなければ追い出す関数（門番）
//   ・ログインしていない → ログイン画面へ強制送還してここで処理を打ち切る
//   ・ログインしている   → session_id を新しくして、控えも更新してから通す
function check_session_id()
{
  if (!is_logged_in()) {
    header('Location:login.php');
    exit();
  } else {
    // 番号札を新しくする（true で古い番号を無効化）
    session_regenerate_id(true);
    // 控えも新しい番号に書き換える。※この2行はセット。片方だけだと自分で自分を追い出す
    $_SESSION['session_id'] = session_id();
  }
}
