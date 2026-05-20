# SIMS - Sistem Informasi Manajemen Sekolah

Aplikasi manajemen sekolah berbasis web dengan **CodeIgniter 3**, mencakup data master, akademik, pembayaran SPP, dan laporan analitis PDF.

## Fitur

### Data Master
- **Siswa** — CRUD + foto + filter (kelas, jenis kelamin) + pencarian + pagination
- **Guru** — CRUD + filter (jenis kelamin) + pencarian + pagination
- **Kelas** — CRUD + wali kelas + filter (tingkat) + pencarian
- **Mata Pelajaran** — CRUD + guru pengampu + filter (guru) + pencarian

### Akademik
- **Nilai Siswa** — Input satuan & massal per siswa + filter (kelas, semester, tahun ajaran) + pencarian
  - Formula: NA = (NH × 40%) + (UTS × 30%) + (UAS × 30%)
- **Jadwal Pelajaran** — Grid mingguan, input manual, auto-generate (greedy algorithm), export PDF

### Pembayaran SPP
- **Jenis Pembayaran** — CRUD (SPP, uang gedung, kegiatan, dll)
- **Generate Tagihan** — Batch per kelas × jenis × bulan (centang bulan)
- **Input Pembayaran** — Pilih kelas → siswa → centang tagihan → bayar
- **Invoice** — Bukti bayar otomatis muncul setelah transaksi, bisa cetak ulang kapan saja
- **Riwayat** — Semua transaksi + filter tanggal/kelas/metode
- **Laporan** — Rekap per jenis: total tagihan, lunas, nominal terbayar
- **Dashboard** — Progress bar % lunas per jenis + filter bulan/tahun

### Laporan (PDF)
8 laporan analitis dengan kop surat (logo, alamat, kontak) & TTD kepala sekolah (data dari pengaturan):
1. **Analisis Kinerja Guru** — Ranking + grade + % ketuntasan
2. **Peringkat Akademik Siswa** — Top 10 + daftar lengkap per kelas
3. **Distribusi Nilai** — Sebaran grade A-E per kelas
4. **Perbandingan Antar Kelas** — Komparasi paralel, sorot tertinggi/terendah
5. **Trend Perkembangan Nilai** — SMT 1 vs SMT 2, naik/turun/tetap
6. **Rekapitulasi Ketuntasan** — % tuntas + status TUNTAS/PERLU PERBAIKAN
7. **Statistik Sekolah** — Total + distribusi gender & tingkat
8. **Beban Mengajar Guru** — Mapel diampu, siswa diajar, kategori beban

### Role-Based Access
| Role | Akses |
|---|---|
| **admin** | Semua CRUD + user management + pengaturan + pembayaran |
| **guru** | Dashboard + input/edit nilai |
| **kepala_sekolah** | Dashboard + profil |

### Fitur Tambahan
- Landing page publik (pengumuman, info sekolah)
- Metadata dinamis dari pengaturan (judul, footer, kop surat)
- Pengumuman (aktif/nonaktif)
- Manajemen user dengan password bcrypt
- Pengaturan web (nama sekolah, alamat, logo, kontak, jam operasional)
- Riwayat kepala sekolah (periode aktif)
- Export PDF (jadwal, laporan) via Dompdf
- Invoice pembayaran siap cetak

## Teknologi

- **Backend:** CodeIgniter 3 + PHP 8.x
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap 4 + Chart.js + Font Awesome
- **PDF:** Dompdf 3.1
- **Auth:** Session-based + bcrypt password

## Instalasi

### 1. Clone & Install Dependencies
```bash
git clone https://github.com/munadi1406/sim.git
cd sim
composer install
```

### 2. Buat Database
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sims_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

### 3. Import Schema & Migration (berurutan)
```bash
mysql -u root sims_db < database.sql        # Schema dasar + seed awal
mysql -u root sims_db < migration2.sql       # users guru + pengaturan_web + kepsek
mysql -u root sims_db < migration3.sql       # role kepala_sekolah + kepsek_id
mysql -u root sims_db < migration4.sql       # email + jam_operasional
mysql -u root sims_db < migration5_spp.sql   # tabel pembayaran SPP
```

> Jika menggunakan Laragon, tambahkan `--protocol=TCP` jika koneksi socket gagal.

### 4. Data Dummy (Opsional)
```bash
mysql -u root sims_db < dummy_data.sql       # 92 siswa, 15 guru, 4.692 nilai
```
Data SPP (tagihan + pembayaran) sudah include dummy untuk dicoba.

### 5. Konfigurasi
Edit `application/config/database.php`:
```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'sims_db',
```

Edit `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/sim/';
```

### 6. Setup & Akses
```
http://localhost/sim/setup      → Buat akun admin (admin / admin123)
http://localhost/sim/login      → Halaman login
http://localhost/sim/           → Landing page publik
```

## Pengaturan Awal

Setelah login sebagai admin, isi di **Pengaturan Sistem**:
1. Nama sekolah, alamat, kontak, email, jam operasional
2. Data kepala sekolah aktif (nip, nama, periode, status)
3. Upload logo sekolah

Semua data ini akan muncul di: title browser, kop surat, TTD laporan, footer, sidebar, dan invoice.

## Struktur Folder

```
sim/
├── application/
│   ├── controllers/
│   │   ├── Auth.php              # Login/logout
│   │   ├── Home.php              # Landing page
│   │   ├── Setup.php             # Setup admin user
│   │   └── admin/
│   │       ├── Dashboard.php     # Dashboard
│   │       ├── Siswa.php         # CRUD siswa
│   │       ├── Guru.php          # CRUD guru
│   │       ├── Kelas.php         # CRUD kelas
│   │       ├── Mapel.php         # CRUD mapel
│   │       ├── Nilai.php         # Manajemen nilai
│   │       ├── Jadwal.php        # Jadwal pelajaran
│   │       ├── Report.php        # 8 laporan PDF
│   │       ├── Pembayaran.php    # SPP (6 menu)
│   │       ├── Pengumuman.php
│   │       ├── Pengaturan.php
│   │       ├── Users.php         # Manajemen user
│   │       └── Profil.php
│   ├── models/
│   │   ├── Siswa_model.php
│   │   ├── Guru_model.php
│   │   ├── Kelas_model.php
│   │   ├── Mapel_model.php
│   │   ├── Nilai_model.php
│   │   ├── Report_model.php      # Query 8 laporan
│   │   ├── Jenis_model.php       # Jenis pembayaran
│   │   ├── Tagihan_model.php     # Tagihan SPP
│   │   └── Pembayaran_model.php  # Riwayat pembayaran
│   ├── views/
│   │   └── admin/
│   │       ├── layouts/          # Header, sidebar, footer
│   │       ├── report/           # 8 template PDF + kop + footer
│   │       └── pembayaran/       # 8 halaman SPP + invoice
│   └── core/
│       └── MY_Controller.php     # Base + Admin controller
├── system/                       # CI3 core
├── uploads/                      # Foto siswa & logo
├── vendor/                       # Composer (dompdf)
├── database.sql                  # Schema + seed basic
├── migration2-5_spp.sql          # Migration files
└── dummy_data.sql                # Data contoh
```

## Default Login

| Username | Password | Role |
|---|---|---|
| `admin` | `admin123` | Admin |
| `guru1` | `password` | Guru |
| `guru2` | `password` | Guru |
