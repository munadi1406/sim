USE `sims_db`;
ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin','guru','kepala_sekolah') DEFAULT 'admin';
ALTER TABLE `users` ADD COLUMN `kepsek_id` INT(11) DEFAULT NULL;
