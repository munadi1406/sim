<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body{font-family:Arial,sans-serif;font-size:10px;color:#333;margin:0;padding:20px}
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
        .tertinggi{background:#d4edda;font-weight:bold}.terendah{background:#f8d7da}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
        .page-break{page-break-after:always}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<?php
$grouped = [];
foreach ($rows as $r) {
    $grouped[$r->tingkat][$r->nama_mapel][] = $r;
}
ksort($grouped);
?>

<?php foreach ($grouped as $tingkat => $mapels): ksort($mapels); ?>
<h3 style="font-size:13px;margin:15px 0 5px">Tingkat <?= esc($tingkat) ?></h3>
<table class="data">
    <thead>
        <tr>
            <th>Mata Pelajaran</th>
            <?php foreach ($mapels as $nama_mapel => $kelas_rows):
                usort($kelas_rows, function($a,$b) { return $a->nama_kelas <=> $b->nama_kelas; });
                foreach ($kelas_rows as $kr): ?>
                <th><?= esc(substr($kr->nama_kelas, 0, 8)) ?></th>
                <?php endforeach; break; ?>
            <?php endforeach; ?>
            <th>Rata-Rata</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($mapels as $nama_mapel => $kelas_rows):
        usort($kelas_rows, function($a,$b) { return $a->nama_kelas <=> $b->nama_kelas; });
        $mapel_avg = 0; $cnt = 0; $max_val = 0; $min_val = 100;
        foreach ($kelas_rows as $kr) { $mapel_avg += $kr->rata_rata; $cnt++; $max_val = max($max_val, $kr->rata_rata); $min_val = min($min_val, $kr->rata_rata); }
        $mapel_avg = $cnt > 0 ? round($mapel_avg / $cnt, 2) : 0;
    ?>
        <tr>
            <td class="text-left"><?= esc($nama_mapel) ?></td>
            <?php foreach ($kelas_rows as $kr): ?>
            <td class="<?= $kr->rata_rata == $max_val && $max_val != $min_val ? 'tertinggi' : ($kr->rata_rata == $min_val && $max_val != $min_val ? 'terendah' : '') ?>">
                <?= $kr->rata_rata ?>
                <br><small>(<?= $kr->tuntas ?>/<?= $kr->jumlah_siswa ?> tuntas)</small>
            </td>
            <?php endforeach; ?>
            <td><strong><?= $mapel_avg ?></strong></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endforeach; ?>

<?php include __DIR__.'/_footer.php'; ?>
