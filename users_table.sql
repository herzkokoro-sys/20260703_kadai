-- users_table.sql ── ログイン用のユーザテーブル（PHP04課題で追加）
-- 使い方（ローカル）：phpMyAdmin → 左で gs_seisho_db を選ぶ → 「SQL」タブ → 貼り付けて実行
-- ※パスワードは平文ではなく password_hash() でハッシュ化した文字列を保存する

CREATE TABLE users_table (
  id         INT(12)      NOT NULL AUTO_INCREMENT,
  username   VARCHAR(128) NOT NULL,
  password   VARCHAR(128) NOT NULL,   -- password_hash() の出力（60文字）
  is_admin   INT(1)       NOT NULL,   -- 1=管理者 / 0=一般
  created_at DATETIME     NOT NULL,
  updated_at DATETIME     NOT NULL,
  deleted_at DATETIME     NULL,       -- 論理削除用。作成時は NULL
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8mb4;

-- テストユーザ2件（パスワードはどちらも pass1234）
--   admin / pass1234 （管理者）
--   user  / pass1234 （一般）
-- ハッシュ値は password_hash('pass1234', PASSWORD_DEFAULT) で生成したもの
INSERT INTO users_table
  (id, username, password, is_admin, created_at, updated_at, deleted_at)
VALUES
  (NULL, 'admin', '$2y$10$PzeYYsX4/EP.vOJNq7Z.d.cP1iFpsd3xlhmdUls8/brWJbmUdfreS', 1, now(), now(), NULL),
  (NULL, 'user',  '$2y$10$t6Az74bz.VMLISvAGalcDuhq6ME74qryw3GfO2g7fdo19545JS8oe',  0, now(), now(), NULL);
