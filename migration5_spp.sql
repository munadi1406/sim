-- ============================================
-- SIMS - Modul Pembayaran SPP
-- ============================================
USE `sims_db`;

-- Jenis pembayaran
CREATE TABLE IF NOT EXISTS `jenis_pembayaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0,
  `keterangan` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tagihan per siswa
CREATE TABLE IF NOT EXISTS `tagihan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siswa_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `bulan` int(2) NOT NULL COMMENT '1-12',
  `tahun` int(4) NOT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0,
  `status` enum('belum','lunas') DEFAULT 'belum',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_siswa` (`siswa_id`),
  KEY `idx_jenis` (`jenis_id`),
  KEY `idx_periode` (`bulan`, `tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Riwayat pembayaran
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagihan_id` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL DEFAULT 0,
  `metode` enum('cash','transfer') DEFAULT 'cash',
  `petugas_id` int(11) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tagihan` (`tagihan_id`),
  KEY `idx_tanggal` (`tanggal_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Jenis default
INSERT IGNORE INTO `jenis_pembayaran` (`id`, `nama`, `nominal`, `keterangan`) VALUES
(1, 'SPP Bulanan', 150000, 'Pembayaran SPP rutin setiap bulan'),
(2, 'Uang Gedung', 500000, 'Pembayaran uang gedung per tahun'),
(3, 'Kegiatan Semester', 100000, 'Biaya kegiatan tengah semester');
