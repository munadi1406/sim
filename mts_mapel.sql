USE `sims_db`;

-- Tambahkan mata pelajaran untuk MTs (Madrasah Tsanawiyah)
INSERT IGNORE INTO `mata_pelajaran` (`kode`, `nama`, `guru_id`) VALUES
('QH', 'Al-Qur''an Hadis', NULL),
('AA', 'Akidah Akhlak', NULL),
('FKH', 'Fikih', NULL),
('SKI', 'Sejarah Kebudayaan Islam', NULL),
('BAR', 'Bahasa Arab', NULL),
('PKN', 'Pendidikan Kewarganegaraan', NULL),
('BIN', 'Bahasa Indonesia', NULL),
('MTK', 'Matematika', NULL),
('IPA', 'Ilmu Pengetahuan Alam', NULL),
('IPS', 'Ilmu Pengetahuan Sosial', NULL),
('BIG', 'Bahasa Inggris', NULL),
('SB', 'Seni Budaya', NULL),
('PJK', 'Pendidikan Jasmani Olahraga dan Kesehatan (PJOK)', NULL),
('PRK', 'Prakarya', NULL),
('MUL', 'Muatan Lokal', NULL);
