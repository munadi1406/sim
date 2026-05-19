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
        table.data{width:100%;border-collapse:collapse;margin-bottom:20px;font-size:10px}
        table.data,table.data th,table.data td{border:1px solid #555}
        table.data th{background-color:#e8e8e8;font-weight:bold;padding:6px 4px;text-align:center;vertical-align:middle}
        table.data td{padding:5px 4px;vertical-align:middle}
        .text-center{text-align:center}.text-right{text-align:right}
        .grade-a{background:#d4edda}.grade-b{background:#d1ecf1}.grade-c{background:#fff3cd}.grade-d{background:#ffeeba}.grade-e{background:#f8d7da}
        .trend-naik{color:#28a745;font-weight:bold}.trend-turun{color:#dc3545;font-weight:bold}
        .ringkasan{margin-bottom:15px;padding:10px;background:#f0f7ff;border:1px solid #b8daff;font-size:11px}
        .ringkasan strong{margin-right:15px}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<?php
$guru_rank = []; $rank = 1;
$current_guru = '';
$guru_rows = [];
foreach ($rows as $r) { $guru_rows[$r->nama_guru][] = $r; }
$guru_avg = [];
foreach ($guru_rows as $nama => $mapels) {
    $sum = 0; $cnt = 0; $ttl_tuntas = 0; $ttl_siswa = 0;
    foreach ($mapels as $m) { $sum += $m->rata_rata; $cnt++; $ttl_tuntas += $m->tuntas; $ttl_siswa += ($m->tuntas + $m->belum_tuntas); }
    $guru_avg[$nama] = ['rata' => round($sum/$cnt,2), 'tuntas' => $ttl_tuntas, 'siswa' => $ttl_siswa, 'mapel' => $cnt];
}
uasort($guru_avg, function($a,$b) { return $b['rata'] <=> $a['rata']; });
?>

<div class="ringkasan">
    <strong>Total Guru:</strong> <?= count($guru_avg) ?> &nbsp;
    <strong>Rata-rata Tertinggi:</strong> <?= reset($guru_avg)['rata'] ?> (<?= array_key_first($guru_avg) ?>) &nbsp;
    <strong>Rata-rata Terendah:</strong> <?= end($guru_avg)['rata'] ?> (<?= array_key_last($guru_avg) ?>)
</div>

<h3 style="font-size:13px;margin:15px 0 5px">A. Ranking Guru Berdasarkan Rata-Rata Nilai</h3>
<table class="data" style="width:70%">
    <thead><tr><th>Rank</th><th>Nama Guru</th><th>Mapel Diampu</th><th class="text-center">Rata-Rata Nilai</th><th class="text-center">% Ketuntasan</th><th class="text-center">Grade</th></tr></thead>
    <tbody>
    <?php $rank = 1; foreach ($guru_avg as $nama => $d): ?>
        <tr>
            <td class="text-center"><?= $rank++ ?></td>
            <td><?= esc($nama) ?></td>
            <td class="text-center"><?= $d['mapel'] ?></td>
            <td class="text-center"><?= $d['rata'] ?></td>
            <td class="text-center"><?= $d['siswa'] > 0 ? round(($d['tuntas']/$d['siswa'])*100,1) : 0 ?>%</td>
            <td class="text-center grade-<?= strtolower($d['rata'] >= 90 ? 'a' : ($d['rata'] >= 80 ? 'b' : ($d['rata'] >= 70 ? 'c' : ($d['rata'] >= 60 ? 'd' : 'e')))) ?>"><?= $d['rata'] >= 90 ? 'A' : ($d['rata'] >= 80 ? 'B' : ($d['rata'] >= 70 ? 'C' : ($d['rata'] >= 60 ? 'D' : 'E'))) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h3 style="font-size:13px;margin:20px 0 5px">B. Detail per Mata Pelajaran</h3>
<table class="data">
    <thead><tr><th>No</th><th>Guru</th><th>Mata Pelajaran</th><th class="text-center">Rata-Rata</th><th class="text-center">Min</th><th class="text-center">Max</th><th class="text-center">Siswa</th><th class="text-center">Tuntas</th><th class="text-center">% Tuntas</th><th class="text-center">Grade</th></tr></thead>
    <tbody>
    <?php $no = 1;
    foreach ($rows as $r):
        $total = $r->tuntas + $r->belum_tuntas;
        $pTuntas = $total > 0 ? round(($r->tuntas / $total) * 100, 1) : 0;
    ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= esc($r->nama_guru) ?></td>
            <td><?= esc($r->nama_mapel) ?></td>
            <td class="text-center"><?= $r->rata_rata ?></td>
            <td class="text-center"><?= $r->nilai_min ?></td>
            <td class="text-center"><?= $r->nilai_max ?></td>
            <td class="text-center"><?= $total ?></td>
            <td class="text-center"><?= $r->tuntas ?></td>
            <td class="text-center"><?= $pTuntas ?>%</td>
            <td class="text-center grade-<?= strtolower($r->grade) ?>"><?= $r->grade ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__.'/_footer.php'; ?>
