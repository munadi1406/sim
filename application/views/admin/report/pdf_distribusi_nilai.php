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
        .a{background:#d4edda}.b{background:#d1ecf1}.c{background:#fff3cd}.d{background:#ffeeba}.e{background:#f8d7da}
        .bar-wrap{background:#e9ecef;height:12px;border-radius:2px;overflow:hidden}
        .bar{height:12px;border-radius:2px}.bar-a{background:#28a745}.bar-b{background:#17a2b8}.bar-c{background:#ffc107}.bar-d{background:#fd7e14}.bar-e{background:#dc3545}
        .ttd{margin-top:40px;width:100%}.ttd-left{float:left;width:45%;text-align:center}
        .ttd-right{float:right;width:45%;text-align:center}.ttd p{margin:3px 0}
        .ttd .nama{margin-top:70px;font-weight:bold;text-decoration:underline}.clear{clear:both}
    </style>
</head>
<body>
<?php include __DIR__.'/_kop.php'; ?>

<table class="data">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kelas</th>
            <th rowspan="2">Tingkat</th>
            <th colspan="5">Distribusi Nilai (Jumlah Siswa)</th>
            <th rowspan="2">Rata-Rata</th>
            <th rowspan="2">% Tuntas</th>
        </tr>
        <tr>
            <th>A<br><small>90-100</small></th>
            <th>B<br><small>80-89</small></th>
            <th>C<br><small>70-79</small></th>
            <th>D<br><small>60-69</small></th>
            <th>E<br><small>&lt;60</small></th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($rows as $r): 
        $max = max($r['A'], $r['B'], $r['C'], $r['D'], $r['E'], 1);
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td class="text-left"><?= esc($r['nama_kelas']) ?></td>
            <td><?= esc($r['tingkat']) ?></td>
            <td class="a"><?= $r['A'] > 0 ? $r['A'] : '-' ?></td>
            <td class="b"><?= $r['B'] > 0 ? $r['B'] : '-' ?></td>
            <td class="c"><?= $r['C'] > 0 ? $r['C'] : '-' ?></td>
            <td class="d"><?= $r['D'] > 0 ? $r['D'] : '-' ?></td>
            <td class="e"><?= $r['E'] > 0 ? $r['E'] : '-' ?></td>
            <td><?= $r['rata_rata'] ?></td>
            <td><?= $r['persen_tuntas'] ?>%</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div style="font-size:10px;margin-top:10px">
    <strong>Keterangan Grade:</strong>
    <span style="background:#d4edda;padding:2px 6px">A: 90-100 (Sangat Baik)</span>
    <span style="background:#d1ecf1;padding:2px 6px">B: 80-89 (Baik)</span>
    <span style="background:#fff3cd;padding:2px 6px">C: 70-79 (Cukup)</span>
    <span style="background:#ffeeba;padding:2px 6px">D: 60-69 (Kurang)</span>
    <span style="background:#f8d7da;padding:2px 6px">E: &lt;60 (Sangat Kurang)</span>
    &nbsp; <strong>KKM:</strong> 75
</div>

<?php include __DIR__.'/_footer.php'; ?>
