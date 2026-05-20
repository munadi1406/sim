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
$grand_total = 0; $grand_lunas = 0; $grand_belum = 0; $grand_nominal = 0; $grand_terbayar = 0;
foreach ($rekap as $r) {
    $grand_total    += $r->total_tagihan;
    $grand_lunas    += $r->total_lunas;
    $grand_belum    += $r->total_belum;
    $grand_nominal  += $r->total_nominal;
    $grand_terbayar += $r->total_terbayar;
}
?>

<div class="info-box">
    <p><strong>Total Tagihan:</strong> <?= $grand_total ?> &nbsp;|&nbsp;
       <strong>Lunas:</strong> <?= $grand_lunas ?> &nbsp;|&nbsp;
       <strong>Belum:</strong> <?= $grand_belum ?> &nbsp;|&nbsp;
       <strong>Total Nominal:</strong> Rp <?= number_format($grand_nominal,0,',','.') ?> &nbsp;|&nbsp;
       <strong>Terbayar:</strong> Rp <?= number_format($grand_terbayar,0,',','.') ?></p>
</div>

<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Pembayaran</th>
            <th class="text-center">Total Tagihan</th>
            <th class="text-center">Lunas</th>
            <th class="text-center">Belum</th>
            <th class="text-center">% Lunas</th>
            <th class="text-right">Total Nominal</th>
            <th class="text-right">Terbayar</th>
            <th class="text-right">Sisa</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($rekap as $r):
            $persen = $r->total_tagihan > 0 ? round(($r->total_lunas / $r->total_tagihan) * 100) : 0;
            $sisa = $r->total_nominal - $r->total_terbayar;
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td class="text-left"><?= esc($r->jenis_nama) ?></td>
            <td><?= $r->total_tagihan ?></td>
            <td><?= $r->total_lunas ?></td>
            <td><?= $r->total_belum ?></td>
            <td><?= $persen ?>%</td>
            <td class="text-right">Rp <?= number_format($r->total_nominal,0,',','.') ?></td>
            <td class="text-right">Rp <?= number_format($r->total_terbayar,0,',','.') ?></td>
            <td class="text-right">Rp <?= number_format($sisa,0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($rekap)): ?>
        <tr><td colspan="9" class="text-center">Belum ada data pembayaran.</td></tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;background:#f0f0f0">
            <td colspan="2" class="text-right">TOTAL</td>
            <td><?= $grand_total ?></td>
            <td><?= $grand_lunas ?></td>
            <td><?= $grand_belum ?></td>
            <td><?= $grand_total > 0 ? round(($grand_lunas/$grand_total)*100) : 0 ?>%</td>
            <td class="text-right">Rp <?= number_format($grand_nominal,0,',','.') ?></td>
            <td class="text-right">Rp <?= number_format($grand_terbayar,0,',','.') ?></td>
            <td class="text-right">Rp <?= number_format($grand_nominal - $grand_terbayar,0,',','.') ?></td>
        </tr>
    </tfoot>
</table>

<?php include __DIR__.'/_footer.php'; ?>
