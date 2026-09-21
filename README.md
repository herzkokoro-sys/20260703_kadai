# 請書登録アプリ（PHP + MySQL）— PHP02 / PHP03 / PHP04 課題

NAB の請書（せいしょ）を DB に登録・一覧・編集・削除する Web アプリ。
将来的に現行 Access 基幹システムの Web 化のベースにする想定で、
講義の todo リストではなく「請書」をテーマに実装した。

- PHP02：登録（Create）・一覧（Read）
- PHP03：編集・更新（Update）・削除（Delete）を追加し、CRUD がそろった
- PHP04：セッションによるログイン／ログアウトと、画面ごとのアクセス制限を追加

## 機能

- **登録**：客先名・件名・金額・納期を入力して DB に保存（INSERT）
- **一覧**：登録済みの請書を納期の近い順で表示（SELECT + ORDER BY）
- **編集・更新**：一覧の「編集」から1件を呼び出して修正・保存（UPDATE、`WHERE id`）
- **削除**：一覧の「削除」から1件を削除（DELETE、`WHERE id`）。押し間違い防止に確認ダイアログ付き
- **ログイン／ログアウト（PHP04）**：`users_table` と照合してセッションを開始／破棄する
- **アクセス制限（PHP04）**：ログインしていないと登録・編集・削除の画面と処理を実行できない
- 必須項目の入力チェック、バインド変数による SQL インジェクション対策、
  表示・編集画面での `htmlspecialchars` による XSS 対策
- パスワードは平文で保存せず `password_hash()` でハッシュ化し、照合は `password_verify()`
- ローカル（XAMPP）／さくらレンタルサーバの両方で動くよう、`db.php` が接続先を自動切替

### ユーザ種別とアクセスできる画面（PHP04）

| ユーザ種別 | できること | アクセスできる画面 |
| --- | --- | --- |
| ログインしていないユーザ | 請書を見るだけ（登録・編集・削除は不可） | ログイン画面／請書一覧（操作リンクなし） |
| ログイン済みユーザ | 請書の登録・表示・更新・削除 | 上記すべて＋登録画面／編集画面 |

※管理者（`is_admin = 1`）は一覧に「管理者」バッジが出る。管理者専用のユーザ管理画面は今後の拡張。

## ファイル構成

| ファイル | 役割 |
| --- | --- |
| `login.php` | ログイン画面（誰でもアクセス可） |
| `login_act.php` | ログイン処理（DB と照合してセッションを開始。画面表示なし） |
| `logout.php` | ログアウト処理（セッション変数・Cookie・セッション領域を破棄） |
| `functions.php` | 共通関数（`is_logged_in()` / `check_session_id()`） |
| `seisho_input.php` | 作成画面（入力フォーム）※要ログイン |
| `seisho_create.php` | 作成処理（POST を受け取り DB へ INSERT）※要ログイン |
| `seisho_read.php` | 参照・一覧表示（SELECT）。ログイン中のみ編集・削除リンクを表示 |
| `seisho_edit.php` | 編集画面（id で1件取得し、初期値入りフォームを表示）※要ログイン |
| `seisho_update.php` | 更新処理（POST を受け取り DB を UPDATE）※要ログイン |
| `seisho_delete.php` | 削除処理（id を受け取り DB から DELETE）※要ログイン |
| `db.php` | DB 接続（PDO）を 1 か所にまとめたもの（接続先の自動切替あり） |
| `style.css` | 見た目 |
| `gs_seisho_db.sql` | DB エクスポート（テーブル構造＋サンプルデータ） |
| `sakura_import.sql` | さくらサーバ取り込み用 SQL（`seisho_table`） |
| `users_table.sql` | ログイン用 `users_table` の作成＋テストユーザ投入 |
| `users_reset.sql` | テストユーザを作り直す（パスワードをハッシュ値で上書き） |

## セットアップ手順

1. XAMPP で Apache と MySQL を起動する。
2. このフォルダを `xampp/htdocs/gs/` に置く。
3. DB を復元する（phpMyAdmin の「インポート」で `gs_seisho_db.sql` を読み込む。
   または CLI で `mysql -u root < gs_seisho_db.sql`）。
4. 同じ DB に `users_table.sql` を実行してログイン用テーブルとテストユーザを作る。
5. ブラウザで `http://localhost/gs/20260702-php02-seisho/login.php` を開く。

### テストユーザ

| ユーザ名 | パスワード | 権限 |
| --- | --- | --- |
| `admin` | `pass1234` | 管理者（is_admin = 1） |
| `user` | `pass1234` | 一般（is_admin = 0） |

※ DB に入っているのはハッシュ値。phpMyAdmin でパスワード欄に平文を直接書くとログインできなくなる
（その場合は `users_reset.sql` を実行して作り直す）。

## DB / テーブル

- DB 名：`gs_seisho_db`（文字コード utf8mb4）

### `seisho_table`

| カラム | 型 | 説明 |
| --- | --- | --- |
| id | INT(11) PK, AUTO_INCREMENT | 連番 |
| customer | VARCHAR(128) | 客先名 |
| subject | VARCHAR(128) | 件名 |
| amount | INT(11) | 金額（円） |
| deadline | DATE | 納期 |
| created_at | DATETIME | 作成日時 |
| updated_at | DATETIME | 更新日時 |

### `users_table`（PHP04 で追加）

| カラム | 型 | 説明 |
| --- | --- | --- |
| id | INT(12) PK, AUTO_INCREMENT | 連番 |
| username | VARCHAR(128) | ログイン ID |
| password | VARCHAR(128) | `password_hash()` の出力（60 文字） |
| is_admin | INT(1) | 1 = 管理者 / 0 = 一般 |
| created_at | DATETIME | 作成日時 |
| updated_at | DATETIME | 更新日時 |
| deleted_at | DATETIME NULL | 論理削除用。通常は NULL |

## 今後の拡張（メモ）

- 管理者だけがアクセスできるユーザ管理画面（ユーザの登録・一覧・編集・削除）
- 更新・削除の成功メッセージを一覧側に表示（`?msg=updated` など）
- 論理削除（実際には消さず「削除フラグ」で隠す。請書は消さない運用が安全）
- 請書番号の自動採番、発行日
- 客先マスタとの連携、PDF 出力
