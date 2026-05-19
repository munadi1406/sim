<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - <?= esc($web->nama_sekolah ?? 'SIMS') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a237e 0%, #283593 40%, #1565c0 70%, #0d47a1 100%);
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -200px; right: -200px;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -100px; left: -100px;
        }
        .login-wrapper {
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
            position: relative;
            z-index: 1;
        }
        .login-left {
            flex: 1;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            color: white;
            text-align: center;
        }
        .login-left .school-logo {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #ffb300, #ff6f00);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 40px; color: white;
            margin-bottom: 24px;
            box-shadow: 0 8px 30px rgba(255,179,0,0.4);
        }
        .login-left h2 { font-size: 26px; font-weight: 800; margin-bottom: 8px; }
        .login-left p { font-size: 14px; opacity: 0.75; line-height: 1.6; }
        .login-left .stats { display: flex; gap: 20px; margin-top: 32px; }
        .login-left .stat { text-align: center; }
        .login-left .stat .num { font-size: 28px; font-weight: 800; color: #ffb300; }
        .login-left .stat .lbl { font-size: 11px; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; }
        .login-right {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
        }
        .login-right h3 { font-size: 24px; font-weight: 800; color: #1a237e; margin-bottom: 6px; }
        .login-right p { color: #888; font-size: 14px; margin-bottom: 32px; }
        .form-group { width: 100%; margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 700; font-size: 13px; color: #444; margin-bottom: 7px; }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #1a237e; font-size: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 13px 15px 13px 42px;
            border: 2px solid #e8eaf6;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s;
            outline: none;
        }
        .form-group input:focus { border-color: #3949ab; box-shadow: 0 0 0 3px rgba(57,73,171,0.1); }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s;
            margin-top: 8px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,35,126,0.4); }
        .btn-login:active { transform: translateY(0); }
        .alert-error {
            width: 100%;
            padding: 12px 16px;
            background: #fdecea;
            border: 1px solid #f5c6cb;
            border-radius: 10px;
            color: #c62828;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .back-link { margin-top: 20px; font-size: 13px; color: #888; }
        .back-link a { color: #3949ab; font-weight: 700; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
        @media(max-width: 650px) {
            .login-left { display: none; }
            .login-right { padding: 40px 30px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Panel -->
        <div class="login-left">
            <div class="school-logo"><i class="fas fa-school"></i></div>
            <h2><?= esc($web->nama_sekolah ?? 'SIMS') ?></h2>
            <p>Sistem Informasi Manajemen Sekolah<br>Terpadu dan Terintegrasi</p>
            <div class="stats">
                <div class="stat">
                    <div class="num">500+</div>
                    <div class="lbl">Siswa</div>
                </div>
                <div class="stat">
                    <div class="num">45+</div>
                    <div class="lbl">Guru</div>
                </div>
                <div class="stat">
                    <div class="num">18</div>
                    <div class="lbl">Kelas</div>
                </div>
            </div>
        </div>
        <!-- Right Panel -->
        <div class="login-right">
            <h3><i class="fas fa-lock mr-2" style="color:#3949ab;"></i>Login Admin</h3>
            <p>Masukkan kredensial Anda untuk melanjutkan</p>

            <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= esc($error) ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('do_login') ?>" method="post" style="width:100%;">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" placeholder="Masukkan username" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk ke Dashboard
                </button>
            </form>
            <div class="back-link">
                <a href="<?= base_url() ?>"><i class="fas fa-arrow-left mr-1"></i>Kembali ke Website</a>
            </div>
        </div>
    </div>
</body>
</html>
