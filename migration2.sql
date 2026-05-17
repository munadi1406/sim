USE `sims_db`;

-- Update users table to support guru role
ALTER TABLE `users` MODIFY COLUMN `role` enum('admin','guru') DEFAULT 'admin';
ALTER TABLE `users` ADD COLUMN `guru_id` int(11) DEFAULT NULL;

-- Web settings table
CREATE TABLE IF NOT EXISTS `pengaturan_web` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(100) NOT NULL,
  `alamat` text,
  `no_kontak` varchar(20),
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default settings if empty
INSERT IGNORE INTO `pengaturan_web` (`id`, `nama_sekolah`, `alamat`, `no_kontak`) VALUES (1, 'SIMS MTs', 'Jl. Pendidikan No. 1', '081234567890');

-- Principal History table
CREATE TABLE IF NOT EXISTS `kepala_sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `periode_mulai` date NOT NULL,
  `periode_selesai` date DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
