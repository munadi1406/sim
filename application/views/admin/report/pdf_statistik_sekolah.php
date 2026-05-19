<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body{font-family:Arial,sans-serif;font-size:11px;color:#333;margin:0;padding:20px}
        .kop{text-align:center;border-bottom:3px double #333;padding-bottom:15px;margin-bottom:20px}
        .kop-table{width:100%;border:none}.kop-table td{border:none;padding:5px;vertical-align:middle}
        .kop-logo{width:80px;text-align:center}.kop-logo img{max-width:75px;max-height:75px}
        .kop-sekolah{text-align:center}.kop-sekolah h2{margin:0 0 3px 0;font-size:18px;text-transform:uppercase;font-weight:bold}
        .kop-sekolah p{margin:2px 0;font-size:11px}.kop-alamat{font-size:10px;color:#555;margin-top:5px}
        .judul-laporan{text-align:center;margin:20px 0;font-size:14px;font-weight:bold}
        .judul-laporan .subtitle{font-size:11px;font-weight:normal;margin-top:3px;color:#555}
        table.data{width:100%;border-collapse:collapse;margin-bottom:20px;font-size:11px}
        table.data,table.data th,table.data td{border:1px solid #555}
        table.data th{background-color:#e8e8e8;font-weight:bold;padding:6px 4px;text-align:center;vertical-align:middle}
        table.data td{padding:5px 4px;vertical-align:middle;text-align:center}
        .text-center{text-align:center}.text-left{text-align:left}
        .info-box{margin-bottom:15px;padding:10px;background:#f0f7ff;border:1px solid #b8daff;font-size:11px}
        .info-box p{margin:3px 0}
        h3{font-size:13px;margin-bottom:5px}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<div class="info-box">
    <strong>Total Siswa:</strong> <?= $stats['total_siswa'] ?> &nbsp;|&nbsp;
    <strong>Total Guru:</strong> <?= $stats['total_guru'] ?> &nbsp;|&nbsp;
    <strong>Total Kelas:</strong> <?= $stats['total_kelas'] ?> &nbsp;|&nbsp;
    <strong>Total Mata Pelajaran:</strong> <?= $stats['total_mapel'] ?>
</div>

<h3>A. Distribusi Siswa Berdasarkan Jenis Kelamin</h3>
<table class="data" style="width:60%">
    <thead><tr><th>No</th><th>Jenis Kelamin</th><th>Jumlah</th><th>Persentase</th></tr></thead>
    <tbody>
        <?php $no = 1; foreach ($stats['per_jenis_kelamin'] as $r):
            $persen = $stats['total_siswa'] > 0 ? round(($r->jumlah / $stats['total_siswa']) * 100, 1) : 0;
        ?>
        <tr><td><?= $no++ ?></td><td class="text-left"><?= esc($r->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan') ?></td><td><?= $r->jumlah ?></td><td><?= $persen ?>%</td></tr>
        <?php endforeach; ?>
        <tr style="font-weight:bold;background:#f0f0f0"><td colspan="2">Total</td><td><?= $stats['total_siswa'] ?></td><td>100%</td></tr>
    </tbody>
</table>

<h3>B. Distribusi Siswa Berdasarkan Tingkat</h3>
<table class="data" style="width:50%">
    <thead><tr><th>No</th><th>Tingkat</th><th>Jumlah Siswa</th></tr></thead>
    <tbody>
        <?php $no = 1; foreach ($stats['per_tingkat'] as $r): ?>
        <tr><td><?= $no++ ?></td><td class="text-left">Tingkat <?= esc($r->tingkat) ?></td><td><?= $r->jumlah ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>C. Distribusi Siswa per Kelas</h3>
<table class="data">
    <thead><tr><th>No</th><th>Kelas</th><th>Tingkat</th><th>Jumlah Siswa</th></tr></thead>
    <tbody>
        <?php $no = 1; foreach ($stats['per_kelas'] as $r): ?>
        <tr><td><?= $no++ ?></td><td class="text-left"><?= esc($r->nama_kelas) ?></td><td><?= esc($r->tingkat) ?></td><td><?= $r->jumlah ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__.'/_footer.php'; ?>
