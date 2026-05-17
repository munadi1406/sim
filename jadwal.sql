-- ============================================
-- Tambahan tabel untuk fitur Jadwal Pelajaran
-- Jalankan query ini di database sims_db
-- ============================================

USE `sims_db`;

-- Pengaturan waktu sekolah
CREATE TABLE IF NOT EXISTS `pengaturan_jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam_masuk` time NOT NULL DEFAULT '07:00:00',
  `durasi_pelajaran` int(11) NOT NULL DEFAULT 45,
  `jam_pulang` time NOT NULL DEFAULT '14:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Konfigurasi istirahat
CREATE TABLE IF NOT EXISTS `istirahat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `setelah_jam_ke` int(11) NOT NULL,
  `durasi` int(11) NOT NULL DEFAULT 15,
  `urutan` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Slot jam pelajaran (hasil generate otomatis)
CREATE TABLE IF NOT EXISTS `jam_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam_ke` int(11) NOT NULL DEFAULT 0,
  `label` varchar(30) DEFAULT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `is_istirahat` tinyint(1) DEFAULT 0,
  `nama_istirahat` varchar(50) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel jadwal pelajaran
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_pelajaran_id` int(11) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jadwal_unique` (`kelas_id`,`hari`,`jam_pelajaran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal pengaturan
INSERT INTO `pengaturan_jadwal` (`jam_masuk`, `durasi_pelajaran`, `jam_pulang`)
VALUES ('07:00:00', 45, '14:00:00');
