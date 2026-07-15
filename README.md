# 請書登録アプリ（PHP + MySQL）— PHP02 / PHP03 課題

NAB の請書（せいしょ）を DB に登録・一覧・編集・削除する Web アプリ。
将来的に現行 Access 基幹システムの Web 化のベースにする想定で、
講義の todo リストではなく「請書」をテーマに実装した。

- PHP02：登録（Create）・一覧（Read）
- PHP03：編集・更新（Update）・削除（Delete）を追加し、CRUD がそろった

## 機能

- **登録**：客先名・件名・金額・納期を入力して DB に保存（INSERT）
- **一覧**：登録済みの請書を納期の近い順で表示（SELECT + ORDER BY）
- **編集・更新**：一覧の「編集」から1件を呼び出して修正・保存（UPDATE、`WHERE id`）
- **削除**：一覧の「削除」から1件を削除（DELETE、`WHERE id`）。押し間違い防止に確認ダイアログ付き
- 必須項目の入力チェック、バインド変数による SQL インジェクション対策、
  表示・編集画面での `htmlspecialchars` による XSS 対策
- ローカル（XAMPP）／さくらレンタルサーバの両方で動くよう、`db.php` が接続先を自動切替

## ファイル構成

| ファイル | 役割 |
| --- | --- |
| `seisho_input.php` | 作成画面（入力フォーム） |
| `seisho_create.php` | 作成処理（POST を受け取り DB へ INSERT） |
| `seisho_read.php` | 参照・一覧表示（SELECT）。各行に編集・削除リンク |
| `seisho_edit.php` | 編集画面（id で1件取得し、初期値入りフォームを表示） |
| `seisho_update.php` | 更新処理（POST を受け取り DB を UPDATE） |
| `seisho_delete.php` | 削除処理（id を受け取り DB から DELETE） |
| `db.php` | DB 接続（PDO）を 1 か所にまとめたもの（接続先の自動切替あり） |
| `style.css` | 見た目 |
| `gs_seisho_db.sql` | DB エクスポート（テーブル構造＋サンプルデータ） |
| `sakura_import.sql` | さくらサーバ取り込み用 SQL |

## セットアップ手順

1. XAMPP で Apache と MySQL を起動する。
2. このフォルダを `xampp/htdocs/gs/` に置く。
3. DB を復元する（phpMyAdmin の「インポート」で `gs_seisho_db.sql` を読み込む。
   または CLI で `mysql -u root < gs_seisho_db.sql`）。
4. ブラウザで `http://localhost/gs/20260702-php02-seisho/seisho_input.php` を開く。

## DB / テーブル

- DB 名：`gs_seisho_db`（文字コード utf8mb4）
- テーブル：`seisho_table`

| カラム | 型 | 説明 |
| --- | --- | --- |
| id | INT(11) PK, AUTO_INCREMENT | 連番 |
| customer | VARCHAR(128) | 客先名 |
| subject | VARCHAR(128) | 件名 |
| amount | INT(11) | 金額（円） |
| deadline | DATE | 納期 |
| created_at | DATETIME | 作成日時 |
| updated_at | DATETIME | 更新日時 |

## 今後の拡張（メモ）

- 更新・削除の成功メッセージを一覧側に表示（`?msg=updated` など）
- 論理削除（実際には消さず「削除フラグ」で隠す。請書は消さない運用が安全）
- 請書番号の自動採番、発行日
- 客先マスタとの連携、PDF 出力
