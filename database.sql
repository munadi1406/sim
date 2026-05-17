-- ============================================
-- Sistem Informasi Manajemen Sekolah (SIMS)
-- Database: sims_db
-- Default Login: admin / admin123
-- ============================================

CREATE DATABASE IF NOT EXISTS `sims_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sims_db`;

-- Tabel session CI3
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin') DEFAULT 'admin',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel kelas
CREATE TABLE `kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(5) NOT NULL,
  `wali_kelas_id` int(11) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel guru
CREATE TABLE `guru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text,
  `no_hp` varchar(15),
  `email` varchar(100),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel siswa
CREATE TABLE `siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50),
  `tanggal_lahir` date,
  `alamat` text,
  `no_hp` varchar(15),
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nis` (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel mata_pelajaran
CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel nilai
CREATE TABLE `nilai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siswa_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `nilai_harian` float DEFAULT NULL,
  `nilai_uts` float DEFAULT NULL,
  `nilai_uas` float DEFAULT NULL,
  `nilai_akhir` float DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pengumuman
CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- DATA AWAL
-- ============================================

-- Kelas
INSERT INTO `kelas` (`nama_kelas`, `tingkat`) VALUES
('X IPA 1', 'X'), ('X IPA 2', 'X'), ('X IPS 1', 'X'),
('XI IPA 1', 'XI'), ('XI IPA 2', 'XI'), ('XI IPS 1', 'XI'),
('XII IPA 1', 'XII'), ('XII IPA 2', 'XII'), ('XII IPS 1', 'XII');

-- Guru
INSERT INTO `guru` (`nip`, `nama`, `jenis_kelamin`, `no_hp`, `email`) VALUES
('197001011990011001', 'Budi Santoso, S.Pd', 'L', '08123456789', 'budi@sekolah.sch.id'),
('197205152000122001', 'Siti Rahayu, S.Pd', 'P', '08234567890', 'siti@sekolah.sch.id'),
('198003102005011003', 'Ahmad Fauzi, M.Pd', 'L', '08345678901', 'ahmad@sekolah.sch.id'),
('198506202010012004', 'Dewi Lestari, S.Pd', 'P', '08456789012', 'dewi@sekolah.sch.id');

-- Siswa
INSERT INTO `siswa` (`nis`, `nama`, `kelas_id`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`) VALUES
('2024001', 'Andi Firmansyah', 1, 'L', 'Jakarta', '2008-03-15', 'Jl. Merdeka No. 1', '08111222333'),
('2024002', 'Bela Putri Sari', 1, 'P', 'Bandung', '2008-07-22', 'Jl. Sudirman No. 5', '08222333444'),
('2024003', 'Cahyo Nugroho', 2, 'L', 'Surabaya', '2008-01-10', 'Jl. Pahlawan No. 8', '08333444555'),
('2024004', 'Dian Pertiwi', 4, 'P', 'Yogyakarta', '2007-11-05', 'Jl. Gajah Mada No. 3', '08444555666'),
('2024005', 'Eko Prasetyo', 7, 'L', 'Semarang', '2006-09-18', 'Jl. Diponegoro No. 12', '08555666777');

-- Mata Pelajaran
INSERT INTO `mata_pelajaran` (`kode`, `nama`, `guru_id`) VALUES
('MTK', 'Matematika', 1),
('BIN', 'Bahasa Indonesia', 2),
('FIS', 'Fisika', 3),
('KIM', 'Kimia', 1),
('BIG', 'Bahasa Inggris', 4);

-- Nilai
INSERT INTO `nilai` (`siswa_id`, `mapel_id`, `semester`, `tahun_ajaran`, `nilai_harian`, `nilai_uts`, `nilai_uas`, `nilai_akhir`) VALUES
(1, 1, '1', '2024/2025', 85, 80, 88, 84.5),
(1, 2, '1', '2024/2025', 90, 85, 92, 89.5),
(2, 1, '1', '2024/2025', 78, 75, 80, 77.8),
(3, 3, '1', '2024/2025', 88, 90, 85, 87.8);

-- Pengumuman
INSERT INTO `pengumuman` (`judul`, `isi`, `status`) VALUES
('Penerimaan Siswa Baru 2024/2025', 'Kami membuka pendaftaran siswa baru untuk tahun ajaran 2024/2025. Pendaftaran dibuka mulai 1 Juni hingga 30 Juni 2024. Hubungi TU sekolah untuk informasi lebih lanjut.', 'aktif'),
('Ujian Tengah Semester Ganjil', 'Ujian Tengah Semester (UTS) akan dilaksanakan pada tanggal 15-20 Oktober 2024. Siswa diharap mempersiapkan diri dengan baik dan membawa kartu ujian.', 'aktif'),
('Libur Hari Kemerdekaan RI', 'Diberitahukan kepada seluruh warga sekolah bahwa pada tanggal 17 Agustus 2024, sekolah libur dalam rangka peringatan HUT RI ke-79.', 'aktif'),
('Kegiatan Ekstrakurikuler', 'Pendaftaran ekstrakurikuler semester ganjil 2024/2025 dibuka mulai 1 Agustus 2024. Tersedia: Pramuka, PMR, Basket, Voli, dan Seni Musik.', 'aktif');
