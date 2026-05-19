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
        table.data th{background-color:#e8e8e8;font-weight:bold;padding:5px 3px;text-align:center;vertical-align:middle}
        table.data td{padding:4px 3px;vertical-align:middle;text-align:center}
        .text-center{text-align:center}.text-left{text-align:left}
        .trend-naik{background:#d4edda}.trend-turun{background:#f8d7da}.trend-tetap{background:#fff3cd}
        .naik{color:#28a745;font-weight:bold}.turun{color:#dc3545;font-weight:bold}.tetap{color:#856404;font-weight:bold}
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
$naik = 0; $turun = 0; $tetap = 0; $total_trend = 0;
foreach ($rows as $r) {
    if ($r->trend == 'naik') $naik++;
    elseif ($r->trend == 'turun') $turun++;
    elseif ($r->trend == 'tetap') $tetap++;
    if ($r->rata_smt2 !== null) $total_trend++;
}
?>

<div class="ringkasan">
    <strong>Total Perbandingan:</strong> <?= $total_trend ?> Mapel-Kelas &nbsp;
    <strong>Naik:</strong> <?= $naik ?> (<?= $total_trend>0?round(($naik/$total_trend)*100,1):0 ?>%) &nbsp;
    <strong>Turun:</strong> <?= $turun ?> (<?= $total_trend>0?round(($turun/$total_trend)*100,1):0 ?>%) &nbsp;
    <strong>Tetap:</strong> <?= $tetap ?>
</div>

<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Tingkat</th>
            <th>Mata Pelajaran</th>
            <th class="text-center">Rata SMT 1</th>
            <th class="text-center">Rata SMT 2</th>
            <th class="text-center">Selisih</th>
            <th class="text-center">Trend</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($rows as $r): ?>
        <tr class="<?= $r->trend == 'naik' ? 'trend-naik' : ($r->trend == 'turun' ? 'trend-turun' : ($r->trend == 'tetap' ? 'trend-tetap' : '')) ?>">
            <td><?= $no++ ?></td>
            <td class="text-left"><?= esc($r->nama_kelas) ?></td>
            <td><?= esc($r->tingkat) ?></td>
            <td class="text-left"><?= esc($r->nama_mapel) ?></td>
            <td><?= $r->rata_smt1 ?></td>
            <td><?= $r->rata_smt2 ?? '-' ?></td>
            <td>
                <?php if ($r->selisih !== null): ?>
                    <span class="<?= $r->trend ?>"><?= $r->selisih > 0 ? '+' . $r->selisih : $r->selisih ?></span>
                <?php else: ?> - <?php endif; ?>
            </td>
            <td>
                <?php if ($r->trend == 'naik'): ?>
                    <span class="naik">▲ NAIK</span>
                <?php elseif ($r->trend == 'turun'): ?>
                    <span class="turun">▼ TURUN</span>
                <?php elseif ($r->trend == 'tetap'): ?>
                    <span class="tetap">■ TETAP</span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($rows)): ?>
<p class="text-center">Belum ada data untuk tahun ajaran ini. Pastikan ada nilai di Semester 1 dan 2.</p>
<?php endif; ?>

<?php include __DIR__.'/_footer.php'; ?>
