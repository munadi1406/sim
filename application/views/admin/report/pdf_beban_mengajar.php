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
        .ringkasan{margin-bottom:15px;padding:10px;background:#f0f7ff;border:1px solid #b8daff;font-size:11px}
        .ringkasan strong{margin-right:15px}
        .tinggi{background:#d4edda}.sedang{background:#fff3cd}.rendah{background:#f8d7da}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<?php
$total_mapel_diampu = 0; $total_siswa_ajar = 0; $total_rata = 0; $cnt_guru = 0;
foreach ($rows as $r) {
    $total_mapel_diampu += $r->jumlah_mapel;
    $total_siswa_ajar += $r->jumlah_siswa;
    if ($r->rata_nilai > 0) { $total_rata += $r->rata_nilai; $cnt_guru++; }
}
$avg_rata = $cnt_guru > 0 ? round($total_rata / $cnt_guru, 2) : 0;
?>

<div class="ringkasan">
    <strong>Total Guru:</strong> <?= count($rows) ?> &nbsp;
    <strong>Total Mapel Diampu:</strong> <?= $total_mapel_diampu ?> &nbsp;
    <strong>Total Siswa Diajar:</strong> <?= $total_siswa_ajar ?> &nbsp;
    <strong>Rata-Rata Nilai Global:</strong> <?= $avg_rata ?>
</div>

<table class="data">
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Guru</th>
            <th>JK</th>
            <th>Jml Mapel</th>
            <th>Mata Pelajaran</th>
            <th>Jml Siswa</th>
            <th>Rata Nilai</th>
            <th>Beban</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($rows as $r):
        $mapel_names = [];
        if (!empty($r->mapel)) { foreach ($r->mapel as $m) { $mapel_names[] = $m->nama; } }
        $beban = $r->jumlah_siswa > 150 ? 'Tinggi' : ($r->jumlah_siswa > 75 ? 'Sedang' : 'Rendah');
        $cls = strtolower($beban);
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= esc($r->nip) ?></td>
            <td class="text-left"><?= esc($r->nama) ?></td>
            <td><?= esc($r->jenis_kelamin) ?></td>
            <td><?= $r->jumlah_mapel ?></td>
            <td class="text-left" style="font-size:9px"><?= !empty($mapel_names) ? implode(', ', $mapel_names) : '-' ?></td>
            <td><?= $r->jumlah_siswa ?></td>
            <td><?= $r->rata_nilai ? $r->rata_nilai : '-' ?></td>
            <td class="<?= $cls ?>"><?= $beban ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__.'/_footer.php'; ?>
