<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($web->nama_sekolah) ?> - Sekolah Unggulan Terbaik. Sistem Informasi Manajemen Sekolah Terpadu.">
    <title><?= esc($web->nama_sekolah) ?> - Sekolah Unggulan</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        :root {
            --primary: #1a237e;
            --primary-light: #3949ab;
            --gold: #ffb300;
            --gold-light: #ffc107;
            --dark: #0d0d2b;
        }
        * { margin:0; padding:0; box-sizing:border-box; scroll-behavior:smooth; }
        body { font-family:'Nunito',sans-serif; color:#333; overflow-x:hidden; }

        /* NAVBAR */
        .navbar-custom {
            position: fixed; top:0; left:0; right:0; z-index:1000;
            padding: 16px 0;
            background: transparent;
            transition: all 0.4s;
        }
        .navbar-custom.scrolled {
            background: rgba(26,35,126,0.97);
            padding: 10px 0;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }
        .navbar-brand-name {
            font-size: 20px; font-weight: 800; color: #fff;
            display:flex; align-items:center; gap:10px;
        }
        .navbar-brand-name .logo-icon {
            width:42px; height:42px; background:linear-gradient(135deg,#ffb300,#ff6f00);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-size:20px; color:#fff;
        }
        .nav-links { display:flex; align-items:center; gap:8px; list-style:none; }
        .nav-links a {
            color:rgba(255,255,255,0.85); text-decoration:none; font-weight:600;
            padding:8px 16px; border-radius:8px; transition:all 0.3s; font-size:14px;
        }
        .nav-links a:hover { color:#fff; background:rgba(255,255,255,0.1); }
        .btn-login-nav {
            background: linear-gradient(135deg, #ffb300, #ff6f00) !important;
            color:#fff !important; padding:9px 20px !important; border-radius:25px !important;
        }
        .btn-login-nav:hover { transform:translateY(-2px); box-shadow:0 5px 20px rgba(255,179,0,0.4) !important; }
        .navbar-toggle-btn { background:none; border:none; color:#fff; font-size:22px; cursor:pointer; }

        /* HERO */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d0d2b 0%, #1a237e 40%, #1565c0 70%, #0277bd 100%);
            display: flex; align-items: center; position: relative; overflow: hidden;
        }
        .hero-bg-circles .c {
            position: absolute; border-radius: 50%; opacity: 0.06;
            background: white; animation: float 8s infinite ease-in-out;
        }
        .hero-bg-circles .c1 { width:500px;height:500px; top:-150px; right:-150px; animation-delay:0s; }
        .hero-bg-circles .c2 { width:300px;height:300px; bottom:-50px; left:-50px; animation-delay:2s; }
        .hero-bg-circles .c3 { width:200px;height:200px; bottom:30%; right:20%; animation-delay:4s; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }

        .hero-content { position:relative; z-index:2; padding: 120px 0 80px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,179,0,0.15); border: 1px solid rgba(255,179,0,0.4);
            color: #ffb300; padding: 7px 18px; border-radius: 25px; font-size: 13px;
            font-weight: 700; margin-bottom: 24px; letter-spacing: 0.5px;
        }
        .hero h1 {
            font-size: clamp(36px, 5vw, 58px); font-weight: 900; color: #fff;
            line-height: 1.15; margin-bottom: 20px;
        }
        .hero h1 span { color: #ffb300; }
        .hero p.lead {
            font-size: 17px; color: rgba(255,255,255,0.75); line-height: 1.8;
            max-width: 480px; margin-bottom: 36px;
        }
        .hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 9px;
            background: linear-gradient(135deg, #ffb300, #ff6f00);
            color: #fff; font-weight: 700; font-size: 15px;
            padding: 14px 28px; border-radius: 50px; text-decoration: none;
            transition: all 0.3s; box-shadow: 0 6px 25px rgba(255,179,0,0.35);
        }
        .btn-hero-primary:hover { transform:translateY(-3px); box-shadow:0 12px 35px rgba(255,179,0,0.5); color:#fff; }
        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 9px;
            background: rgba(255,255,255,0.12); backdrop-filter:blur(5px);
            border: 2px solid rgba(255,255,255,0.3);
            color: #fff; font-weight: 700; font-size: 15px;
            padding: 14px 28px; border-radius: 50px; text-decoration: none;
            transition: all 0.3s;
        }
        .btn-hero-secondary:hover { background:rgba(255,255,255,0.2); color:#fff; transform:translateY(-3px); }
        .hero-stats {
            display: flex; gap: 32px; margin-top: 50px; flex-wrap: wrap;
        }
        .hero-stat { text-align:center; }
        .hero-stat .num { font-size: 36px; font-weight: 900; color: #ffb300; }
        .hero-stat .lbl { font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px; }
        .hero-img-side {
            position: relative; text-align: center;
        }
        .hero-card-float {
            background: rgba(255,255,255,0.1); backdrop-filter:blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px; padding: 20px 24px;
            color: #fff; display: inline-block;
            animation: float 4s infinite ease-in-out;
        }
        .hero-card-float.c2 { animation-delay: 2s; }
        .hero-main-img {
            width: 360px; height: 360px; background: rgba(255,255,255,0.08);
            border-radius: 30px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto;
            border: 1px solid rgba(255,255,255,0.15);
        }

        /* SECTION STYLES */
        section { padding: 90px 0; }
        .section-badge {
            display: inline-block; background: #e8eaf6; color: var(--primary);
            padding: 5px 16px; border-radius: 20px; font-size: 12px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px;
        }
        .section-title { font-size: clamp(28px, 3.5vw, 38px); font-weight: 800; color: #1a237e; margin-bottom: 12px; }
        .section-sub { font-size: 16px; color: #666; line-height: 1.7; max-width: 550px; }

        /* FEATURES */
        .features { background: #f8f9ff; }
        .feature-card {
            background: #fff; border-radius: 16px; padding: 32px 26px;
            transition: all 0.3s; border: 2px solid transparent; height: 100%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .feature-card:hover {
            transform: translateY(-8px); border-color: #3949ab;
            box-shadow: 0 20px 50px rgba(57,73,171,0.15);
        }
        .feature-icon {
            width: 60px; height: 60px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 20px;
        }
        .feature-card h5 { font-size: 17px; font-weight: 800; color: #1a237e; margin-bottom: 10px; }
        .feature-card p { font-size: 14px; color: #666; line-height: 1.7; }

        /* STATS SECTION */
        .stats-section {
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: white;
        }
        .stat-box { text-align: center; padding: 20px; }
        .stat-box .number { font-size: clamp(36px, 4vw, 52px); font-weight: 900; color: #ffb300; }
        .stat-box .label { font-size: 15px; color: rgba(255,255,255,0.75); margin-top: 6px; }

        /* ANNOUNCEMENTS */
        .announce-card {
            background: #fff; border-radius: 14px; padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border-left: 4px solid #1a237e; height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .announce-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.12); }
        .announce-date { font-size: 12px; color: #999; margin-bottom: 8px; }
        .announce-card h5 { font-size: 16px; font-weight: 800; color: #1a237e; margin-bottom: 10px; }
        .announce-card p { font-size: 14px; color: #666; line-height: 1.6; }

        /* CONTACT */
        .contact-section { background: #f8f9ff; }
        .contact-item { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 24px; }
        .contact-icon {
            width: 48px; height: 48px; background: #e8eaf6;
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #1a237e; flex-shrink: 0;
        }
        .contact-item h6 { font-weight: 700; color: #1a237e; margin-bottom: 4px; }
        .contact-item p { color: #666; font-size: 14px; margin: 0; }

        /* FOOTER */
        footer {
            background: #0d0d2b; color: rgba(255,255,255,0.7);
            padding: 40px 0 20px; text-align: center;
        }
        footer .footer-logo { font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 8px; }
        footer p { font-size: 14px; }
        footer a { color: #ffb300; text-decoration: none; }

        /* Responsive */
        @media(max-width:768px) {
            .hero-img-side { display: none; }
            .nav-links { display:none; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom" id="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="navbar-brand-name">
            <div class="logo-icon"><i class="fas fa-school"></i></div>
            <div>
                <div style="font-size:16px;line-height:1.1;"><?= esc($web->nama_sekolah) ?></div>
                <div style="font-size:11px;opacity:0.7;font-weight:400;">Sistem Informasi Manajemen</div>
            </div>
        </div>
        <ul class="nav-links mb-0">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#pengumuman">Pengumuman</a></li>
            <li><a href="#kontak">Kontak</a></li>
            <li><a href="<?= base_url('login') ?>" class="btn-login-nav">
                <i class="fas fa-lock mr-1"></i> Login Admin
            </a></li>
        </ul>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="beranda">
    <div class="hero-bg-circles">
        <div class="c c1"></div>
        <div class="c c2"></div>
        <div class="c c3"></div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <div class="hero-badge">
                    <i class="fas fa-star"></i> Sekolah Unggulan Terbaik 2024
                </div>
                <h1>Selamat Datang di<br><span><?= esc($web->nama_sekolah) ?></span></h1>
                <p class="lead">Membangun generasi unggul, berakhlak mulia, dan berdaya saing global melalui pendidikan berkualitas tinggi.</p>
                <div class="hero-btns">
                    <a href="#pengumuman" class="btn-hero-primary">
                        <i class="fas fa-bullhorn"></i> Lihat Pengumuman
                    </a>
                    <a href="<?= base_url('login') ?>" class="btn-hero-secondary">
                        <i class="fas fa-sign-in-alt"></i> Portal Admin
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat"><div class="num">500+</div><div class="lbl">Siswa Aktif</div></div>
                    <div class="hero-stat"><div class="num">45+</div><div class="lbl">Tenaga Pengajar</div></div>
                    <div class="hero-stat"><div class="num">18</div><div class="lbl">Kelas</div></div>
                    <div class="hero-stat"><div class="num">25+</div><div class="lbl">Tahun Berdiri</div></div>
                </div>
            </div>
            <div class="col-lg-6 hero-img-side">
                <div class="hero-main-img">
                    <i class="fas fa-school" style="font-size:120px;color:rgba(255,255,255,0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features" id="fitur">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Keunggulan Kami</span>
            <h2 class="section-title">Mengapa Memilih Kami?</h2>
            <p class="section-sub mx-auto">Kami berkomitmen memberikan pendidikan terbaik dengan fasilitas modern dan tenaga pengajar berpengalaman.</p>
        </div>
        <div class="row">
            <?php
            $features = [
                ['icon'=>'fas fa-chalkboard-teacher','bg'=>'#e8eaf6','color'=>'#3949ab','title'=>'Tenaga Pengajar Berkualitas','desc'=>'Didukung oleh guru-guru berpengalaman, bersertifikat, dan berkomitmen tinggi dalam mendidik.'],
                ['icon'=>'fas fa-flask','bg'=>'#e8f8f2','color'=>'#1cc88a','title'=>'Laboratorium Lengkap','desc'=>'Fasilitas lab fisika, kimia, biologi, dan komputer yang modern untuk mendukung pembelajaran sains.'],
                ['icon'=>'fas fa-trophy','bg'=>'#fff3e0','color'=>'#ffb300','title'=>'Prestasi Gemilang','desc'=>'Ratusan prestasi akademik dan non-akademik di tingkat daerah, nasional, hingga internasional.'],
                ['icon'=>'fas fa-book-open','bg'=>'#fce4ec','color'=>'#e91e63','title'=>'Kurikulum Terkini','desc'=>'Menerapkan Kurikulum Merdeka yang berpusat pada siswa dengan pendekatan pembelajaran inovatif.'],
                ['icon'=>'fas fa-futbol','bg'=>'#e3f2fd','color'=>'#1565c0','title'=>'Ekstrakurikuler Beragam','desc'=>'Lebih dari 15 pilihan ekstrakurikuler untuk mengembangkan bakat dan minat siswa secara optimal.'],
                ['icon'=>'fas fa-shield-alt','bg'=>'#f3e5f5','color'=>'#7b1fa2','title'=>'Lingkungan Kondusif','desc'=>'Sekolah bebas bullying dengan program karakter yang membangun akhlak mulia dan toleransi.'],
            ];
            foreach($features as $f):
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:<?= $f['bg'] ?>;color:<?= $f['color'] ?>;">
                        <i class="<?= $f['icon'] ?>"></i>
                    </div>
                    <h5><?= $f['title'] ?></h5>
                    <p><?= $f['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3"><div class="stat-box">
                <div class="number">500+</div><div class="label">Siswa Aktif</div>
            </div></div>
            <div class="col-6 col-md-3"><div class="stat-box">
                <div class="number">45+</div><div class="label">Guru & Staff</div>
            </div></div>
            <div class="col-6 col-md-3"><div class="stat-box">
                <div class="number">98%</div><div class="label">Tingkat Kelulusan</div>
            </div></div>
            <div class="col-6 col-md-3"><div class="stat-box">
                <div class="number">200+</div><div class="label">Prestasi Diraih</div>
            </div></div>
        </div>
    </div>
</section>

<!-- PENGUMUMAN -->
<section id="pengumuman" style="background:#fff;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <span class="section-badge">Informasi Terkini</span>
                <h2 class="section-title mb-0">Pengumuman</h2>
            </div>
            <a href="<?= base_url('login') ?>" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-lock mr-1"></i> Portal Admin
            </a>
        </div>
        <?php if (!empty($pengumuman)): ?>
        <div class="row">
            <?php foreach ($pengumuman as $p): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="announce-card">
                    <div class="announce-date">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        <?= date('d F Y', strtotime($p->created_at)) ?>
                    </div>
                    <h5><?= esc($p->judul) ?></h5>
                    <p><?= substr(strip_tags(esc($p->isi)), 0, 100) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>Belum ada pengumuman aktif saat ini.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- KONTAK -->
<section class="contact-section" id="kontak">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <span class="section-badge">Hubungi Kami</span>
                <h2 class="section-title">Informasi Kontak</h2>
                <p class="section-sub">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui berbagai saluran komunikasi.</p>
                <div class="mt-4">
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h6>Alamat</h6>
                            <p><?= esc($web->alamat) ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h6>Telepon</h6>
                            <p><?= esc($web->no_kontak) ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h6>Email</h6>
                            <p><?= esc($web->email ?? 'info@sekolah.sch.id') ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p><?= esc($web->jam_operasional ?? 'Senin - Jumat: 07.00 - 15.00 WIB') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg" style="border-radius:20px; overflow:hidden;">
                    <div class="card-body p-5" style="background:linear-gradient(135deg,#1a237e,#3949ab);">
                        <h4 class="text-white font-weight-800 mb-4">
                            <i class="fas fa-school mr-2" style="color:#ffb300;"></i> <?= esc($web->nama_sekolah) ?>
                        </h4>
                        <p class="text-white-50 mb-4">
                            Bergabunglah bersama kami dalam mewujudkan pendidikan berkualitas. Daftarkan putra-putri Anda sekarang!
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="<?= base_url('login') ?>" class="btn text-dark font-weight-bold px-4 py-2" style="background:#ffb300;border-radius:25px;">
                                <i class="fas fa-sign-in-alt mr-1"></i> Login Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-logo"><i class="fas fa-school mr-2" style="color:#ffb300;"></i><?= esc($web->nama_sekolah) ?></div>
        <p class="mb-3"><?= esc($web->alamat) ?></p>
        <p style="font-size:13px;">
            &copy; <?= date('Y') ?> <?= esc($web->nama_sekolah) ?>. All rights reserved. |
            <a href="<?= base_url('login') ?>">Admin Login</a>
        </p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        var nav = document.getElementById('navbar');
        if (window.scrollY > 50) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    });

    // Counter animation
    function animateCounter(el, target) {
        var start = 0, duration = 1500;
        var step = target / (duration / 16);
        var timer = setInterval(function() {
            start += step;
            if (start >= target) { el.textContent = target + (el.dataset.suffix || ''); clearInterval(timer); }
            else el.textContent = Math.floor(start) + (el.dataset.suffix || '');
        }, 16);
    }
    var observed = false;
    var observer = new IntersectionObserver(function(entries) {
        if (entries[0].isIntersecting && !observed) {
            observed = true;
            document.querySelectorAll('.stat-box .number').forEach(function(el) {
                var text = el.textContent;
                var num = parseInt(text.replace(/\D/g,''));
                var suffix = text.replace(/[\d]/g,'');
                el.dataset.suffix = suffix;
                animateCounter(el, num);
            });
        }
    });
    var statsEl = document.querySelector('.stats-section');
    if (statsEl) observer.observe(statsEl);
</script>
</body>
</html>
