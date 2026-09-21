<?php
// login.php ── ログイン画面（誰でもアクセスできる。ここだけはガードを掛けない）
// login_act.php から ?error=1 で戻ってくることがあるので、その表示だけ判定する
$error  = isset($_GET['error']);
$logout = isset($_GET['logout']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン｜請書アプリ NAB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrap">
    <h1>ログイン</h1>

    <?php if ($error): ?>
      <p class="msg msg-ng">ユーザ名またはパスワードが違います。</p>
    <?php endif; ?>
    <?php if ($logout): ?>
      <p class="msg msg-ok">ログアウトしました。</p>
    <?php endif; ?>

    <form action="login_act.php" method="POST">
      <fieldset>
        <div class="field">
          <label>ユーザ名</label>
          <input type="text" name="username" autocomplete="username">
        </div>
        <div class="field">
          <label>パスワード</label>
          <input type="password" name="password" autocomplete="current-password">
        </div>
        <div class="actions">
          <button type="submit">ログイン</button>
        </div>
      </fieldset>
    </form>

    <!-- 未ログインでも一覧は閲覧できる（編集・削除は不可）（PHP04） -->
    <p class="msg">ログインしなくても <a class="link" href="seisho_read.php">請書一覧を見る</a> ことはできます（登録・編集・削除はログインが必要）。</p>
  </div>
</body>
</html>
