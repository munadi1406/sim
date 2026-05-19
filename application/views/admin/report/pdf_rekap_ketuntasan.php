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
        .tuntas{background:#d4edda}.blm-tuntas{background:#f8d7da}
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
$total_mapel = count($rows);
$total_tuntas = 0; $total_blm = 0; $total_peserta = 0;
foreach ($rows as $r) { $total_tuntas += $r->tuntas; $total_blm += $r->belum_tuntas; $total_peserta += $r->jumlah_peserta; }
$persen_total = $total_peserta > 0 ? round(($total_tuntas / $total_peserta) * 100, 1) : 0;
?>

<div class="ringkasan">
    <strong>KKM:</strong> 75 &nbsp;
    <strong>Total Mapel-Kelas:</strong> <?= $total_mapel ?> &nbsp;
    <strong>Total Tuntas:</strong> <?= $total_tuntas ?> &nbsp;
    <strong>Total Belum Tuntas:</strong> <?= $total_blm ?> &nbsp;
    <strong>Rata-Rata Ketuntasan:</strong> <?= $persen_total ?>%
</div>

<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Tingkat</th>
            <th>Mata Pelajaran</th>
            <th>Guru</th>
            <th>Rata-Rata</th>
            <th>Min</th>
            <th>Max</th>
            <th>Peserta</th>
            <th>Tuntas</th>
            <th>Belum</th>
            <th>% Tuntas</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($rows as $r): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td class="text-left"><?= esc($r->nama_kelas) ?></td>
            <td><?= esc($r->tingkat) ?></td>
            <td class="text-left"><?= esc($r->nama_mapel) ?></td>
            <td class="text-left"><?= esc($r->nama_guru ?: '-') ?></td>
            <td><?= $r->rata_rata ?></td>
            <td><?= $r->nilai_min ?></td>
            <td><?= $r->nilai_max ?></td>
            <td><?= $r->jumlah_peserta ?></td>
            <td><?= $r->tuntas ?></td>
            <td><?= $r->belum_tuntas ?></td>
            <td><?= $r->persen_tuntas ?>%</td>
            <td class="<?= $r->persen_tuntas >= 75 ? 'tuntas' : 'blm-tuntas' ?>"><?= $r->persen_tuntas >= 75 ? 'TUNTAS' : 'PERLU PERBAIKAN' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__.'/_footer.php'; ?>
