# 請書登録アプリ（PHP + MySQL）— PHP02 課題

NAB の請書（せいしょ）を DB に登録・一覧表示する Web アプリ。
将来的に現行 Access 基幹システムの Web 化のベースにする想定で、
講義の todo リストではなく「請書」をテーマに実装した。

## 機能

- **登録**：客先名・件名・金額・納期を入力して DB に保存（INSERT）
- **一覧**：登録済みの請書を納期の近い順で表示（SELECT + ORDER BY）
- 必須項目の入力チェック、バインド変数による SQL インジェクション対策、
  表示時の `htmlspecialchars` による XSS 対策

## ファイル構成

| ファイル | 役割 |
| --- | --- |
| `seisho_input.php` | 作成画面（入力フォーム） |
| `seisho_create.php` | 作成処理（POST を受け取り DB へ INSERT） |
| `seisho_read.php` | 参照・一覧表示（SELECT） |
| `db.php` | DB 接続（PDO）を 1 か所にまとめたもの |
| `style.css` | 見た目 |
| `gs_seisho_db.sql` | DB エクスポート（テーブル構造＋サンプルデータ） |

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

- 請書番号の自動採番、発行日、UPDATE / DELETE（編集・削除）
- 客先マスタとの連携、PDF 出力
