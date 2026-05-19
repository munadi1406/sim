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
        table.data td{padding:5px 4px;vertical-align:middle}
        .text-center{text-align:center}.text-right{text-align:right}
        .grade-a{background:#d4edda}.grade-b{background:#d1ecf1}.grade-c{background:#fff3cd}.grade-d{background:#ffeeba}.grade-e{background:#f8d7da}
        .top3{font-weight:bold}.ringkasan{margin-bottom:15px;padding:10px;background:#f0f7ff;border:1px solid #b8daff;font-size:11px}
        .ringkasan strong{margin-right:15px}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<?php
$top10 = array_slice($rows, 0, 10);
$rata_kelas = 0; $tuntas_all = 0; $total_siswa = count($rows);
foreach ($rows as $r) { $rata_kelas += $r->rata_rata; if ($r->mapel_belum_tuntas == 0) $tuntas_all++; }
$rata_kelas = $total_siswa > 0 ? round($rata_kelas / $total_siswa, 2) : 0;
?>

<div class="ringkasan">
    <strong>Total Siswa:</strong> <?= $total_siswa ?> &nbsp;
    <strong>Rata-Rata Kelas:</strong> <?= $rata_kelas ?> &nbsp;
    <strong>Peringkat 1:</strong> <?= isset($rows[0]) ? esc($rows[0]->nama_siswa).' ('.$rows[0]->rata_rata.')' : '-' ?> &nbsp;
    <strong>Siswa Tuntas Semua:</strong> <?= $tuntas_all ?>
</div>

<h3 style="font-size:13px;margin-bottom:5px">A. Top 10 Peringkat Siswa</h3>
<table class="data">
    <thead><tr><th>Rank</th><th>NIS</th><th>Nama Siswa</th><th>JK</th><th>Jml Mapel</th><th class="text-center">Rata-Rata</th><th>Predikat</th><th class="text-center">Grade</th></tr></thead>
    <tbody>
    <?php foreach ($top10 as $r): ?>
        <tr class="<?= $r->ranking <= 3 ? 'top3' : '' ?>">
            <td class="text-center"><?= $r->ranking ?></td>
            <td><?= esc($r->nis) ?></td>
            <td><?= esc($r->nama_siswa) ?></td>
            <td class="text-center"><?= esc($r->jenis_kelamin) ?></td>
            <td class="text-center"><?= $r->jumlah_mapel ?></td>
            <td class="text-center"><?= $r->rata_rata ?></td>
            <td><?= $r->predikat ?></td>
            <td class="text-center grade-<?= strtolower($r->grade) ?>"><?= $r->grade ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h3 style="font-size:13px;margin:20px 0 5px">B. Daftar Lengkap Peringkat</h3>
<table class="data">
    <thead><tr><th>Rank</th><th>NIS</th><th>Nama Siswa</th><th>JK</th><th>Jml Mapel</th><th class="text-center">Rata-Rata</th><th>Predikat</th><th class="text-center">Grade</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td class="text-center"><?= $r->ranking ?></td>
            <td><?= esc($r->nis) ?></td>
            <td><?= esc($r->nama_siswa) ?></td>
            <td class="text-center"><?= esc($r->jenis_kelamin) ?></td>
            <td class="text-center"><?= $r->jumlah_mapel ?></td>
            <td class="text-center"><?= $r->rata_rata ?></td>
            <td><?= $r->predikat ?></td>
            <td class="text-center grade-<?= strtolower($r->grade) ?>"><?= $r->grade ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__.'/_footer.php'; ?>
