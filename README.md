# SIMS - Sistem Informasi Manajemen Sekolah

Aplikasi manajemen sekolah berbasis web dengan **CodeIgniter 3**, mencakup manajemen data master, nilai, jadwal, dan laporan analitis.

## Fitur

### Data Master
- **Siswa** — CRUD + foto + filter (kelas, jenis kelamin) + pencarian
- **Guru** — CRUD + filter + pencarian
- **Kelas** — CRUD + wali kelas + filter (tingkat) + pencarian
- **Mata Pelajaran** — CRUD + guru pengampu + filter + pencarian

### Akademik
- **Nilai Siswa** — Input satuan & massal per siswa + filter (kelas, semester, tahun ajaran) + pencarian
  - Formula: NA = (NH × 40%) + (UTS × 30%) + (UAS × 30%)
- **Jadwal Pelajaran** — Grid mingguan, input manual, auto-generate (greedy algorithm), export PDF

### Laporan (PDF)
8 laporan analitis dengan kop surat & TTD kepala sekolah:
1. **Analisis Kinerja Guru** — Ranking + grade + % ketuntasan
2. **Peringkat Akademik Siswa** — Top 10 + daftar lengkap per kelas
3. **Distribusi Nilai** — Sebaran grade A-E per kelas
4. **Perbandingan Antar Kelas** — Komparasi paralel, sorot tertinggi/terendah
5. **Trend Perkembangan Nilai** — SMT 1 vs SMT 2, naik/turun/tetap
6. **Rekapitulasi Ketuntasan** — % tuntas per mapel, status TUNTAS/PERLU PERBAIKAN
7. **Statistik Sekolah** — Total siswa/guru/kelas, distribusi gender & tingkat
8. **Beban Mengajar Guru** — Mapel diampu, siswa diajar, kategori beban

### Role-Based Access
| Role | Akses |
|---|---|
| **admin** | Semua CRUD + user management + pengaturan |
| **guru** | Dashboard + input/edit nilai |
| **kepala_sekolah** | Dashboard + profil |

### Fitur Tambahan
- Landing page publik (pengumuman, info sekolah)
- Pengumuman (aktif/nonaktif)
- Manajemen user dengan password bcrypt
- Pengaturan web (nama sekolah, alamat, logo, kontak)
- Riwayat kepala sekolah (periode aktif)
- Export jadwal ke PDF dengan Dompdf

## Teknologi

- **Backend:** CodeIgniter 3 + PHP 8.x
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap 4 + jQuery + Chart.js + Font Awesome
- **PDF:** Dompdf 3.1
- **Auth:** Session-based + bcrypt password

## Instalasi

### 1. Clone & Setup
```bash
git clone https://github.com/username/sims.git
cd sims
composer install
```

### 2. Database
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sims_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
mysql -u root sims_db < database.sql
mysql -u root sims_db < migration2.sql
mysql -u root sims_db < migration3.sql
mysql -u root sims_db < migration4.sql
mysql -u root sims_db < dummy_data.sql   # data contoh (opsional)
```

### 3. Konfigurasi
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

### 4. Akses
```bash
# Setup akun admin
http://localhost/sim/setup
# Username: admin / Password: admin123

# Login
http://localhost/sim/login

# Landing page
http://localhost/sim/
```

## Pengaturan Awal

Setelah login, isi data berikut di **Pengaturan Sistem**:
1. Nama sekolah, alamat, kontak, email
2. Data kepala sekolah aktif
3. Upload logo sekolah

Data ini akan muncul di kop surat dan TTD laporan PDF.

## Struktur Folder

```
sim/
├── application/
│   ├── controllers/
│   │   ├── Auth.php          # Login/logout
│   │   ├── Home.php          # Landing page
│   │   ├── Setup.php         # Setup admin user
│   │   └── admin/
│   │       ├── Dashboard.php # Dashboard admin
│   │       ├── Siswa.php     # CRUD siswa
│   │       ├── Guru.php      # CRUD guru
│   │       ├── Kelas.php     # CRUD kelas
│   │       ├── Mapel.php     # CRUD mapel
│   │       ├── Nilai.php     # Manajemen nilai
│   │       ├── Jadwal.php    # Jadwal pelajaran
│   │       ├── Report.php    # 8 laporan PDF
│   │       ├── Pengumuman.php
│   │       ├── Pengaturan.php
│   │       ├── Users.php     # Manajemen user
│   │       └── Profil.php
│   ├── models/
│   ├── views/
│   │   └── admin/
│   │       ├── layouts/      # Header, sidebar, footer
│   │       └── report/       # 8 template PDF
│   └── core/
│       └── MY_Controller.php # Base + Admin controller
├── system/                   # CI3 core
├── uploads/                  # Foto siswa & logo
├── vendor/                   # Composer (dompdf)
├── database.sql              # Schema + seed basic
├── migration2-4.sql          # Migration: users, pengaturan, kepsek
└── dummy_data.sql            # Data contoh (92 siswa, 4.692 nilai)
```

## Default Login

| Username | Password | Role |
|---|---|---|
| `admin` | `admin123` | Admin |
| `guru1` | `password` | Guru |
| `guru2` | `password` | Guru |
