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
        .text-center{text-align:center}.text-left{text-align:left}.text-right{text-align:right}
        .lunas{background:#d4edda}.belum{background:#fff3cd}.blm-semua{background:#f8d7da}
        .info-box{margin-bottom:15px;padding:10px;background:#f0f7ff;border:1px solid #b8daff;font-size:11px}
        .info-box p{margin:3px 0}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<?php
$total_lunas = 0; $total_blm = 0; $total_siswa = count($rows);
foreach ($rows as $r) { $total_lunas += $r->jml_lunas; $total_blm += $r->jml_belum; }
?>

<div class="info-box">
    <p><strong>Total Siswa:</strong> <?= $total_siswa ?> &nbsp;|&nbsp;
       <strong>Tagihan Lunas:</strong> <?= $total_lunas ?> &nbsp;|&nbsp;
       <strong>Belum Lunas:</strong> <?= $total_blm ?></p>
</div>

<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Tingkat</th>
            <th>Total Tagihan</th>
            <th>Lunas</th>
            <th>Belum</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($rows as $r): 
            if ($r->total_tagihan == 0) { $status = 'belum'; $cls = 'blm-semua'; $label = 'BELUM ADA TAGIHAN'; }
            elseif ($r->jml_belum == 0) { $status = 'lunas'; $cls = 'lunas'; $label = 'LUNAS SEMUA'; }
            else { $status = 'belum'; $cls = 'belum'; $label = $r->jml_belum . ' BELUM LUNAS'; }
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= esc($r->nis) ?></td>
            <td class="text-left"><?= esc($r->nama_siswa) ?></td>
            <td><?= esc($r->tingkat) ?></td>
            <td><?= $r->total_tagihan ?></td>
            <td><?= $r->jml_lunas ?></td>
            <td><?= $r->jml_belum ?></td>
            <td><span class="<?= $cls ?>" style="display:inline-block;padding:2px 8px;border-radius:3px;font-size:10px;font-weight:bold"><?= $label ?></span></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($rows)): ?>
        <tr><td colspan="8" class="text-center">Belum ada data tagihan untuk filter ini.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__.'/_footer.php'; ?>
