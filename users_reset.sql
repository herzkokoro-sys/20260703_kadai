-- users_reset.sql ── テストユーザを作り直す（ハッシュ化したパスワードで上書き）
-- ※ password は password_hash() の出力（60文字）でなければログインできない。
--   phpMyAdmin で平文を直接打ち込むと password_verify() が必ず失敗する点に注意。

DELETE FROM users_table;
ALTER TABLE users_table AUTO_INCREMENT = 1;

-- テストユーザ2件（パスワードはどちらも pass1234）
--   admin / pass1234 （管理者）
--   user  / pass1234 （一般）
INSERT INTO users_table
  (id, username, password, is_admin, created_at, updated_at, deleted_at)
VALUES
  (NULL, 'admin', '$2y$10$PzeYYsX4/EP.vOJNq7Z.d.cP1iFpsd3xlhmdUls8/brWJbmUdfreS', 1, now(), now(), NULL),
  (NULL, 'user',  '$2y$10$t6Az74bz.VMLISvAGalcDuhq6ME74qryw3GfO2g7fdo19545JS8oe',  0, now(), now(), NULL);
