USE `sims_db`;
ALTER TABLE `pengaturan_web` 
  ADD COLUMN `email` varchar(100) DEFAULT NULL,
  ADD COLUMN `jam_operasional` varchar(100) DEFAULT NULL;
