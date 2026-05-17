<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #555;
        }
        th, td {
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .istirahat {
            background-color: #ffe0b2;
            font-weight: bold;
            font-style: italic;
        }
        .mapel {
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
            font-size: 12px;
        }
        .guru {
            font-size: 10px;
            color: #555;
        }
        .footer {
            margin-top: 30px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-box p {
            margin: 0 0 60px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>JADWAL MATA PELAJARAN</h2>
        <p>Kelas: <strong><?= esc($kelas->nama_kelas) ?> (Tingkat <?= esc($kelas->tingkat) ?>)</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">Jam Ke</th>
                <th style="width: 90px;">Waktu</th>
                <?php foreach ($hari_list as $h): ?>
                    <th><?= $h ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grid as $row): $slot = $row['slot']; ?>
                <?php if ($slot->is_istirahat): ?>
                <tr class="istirahat">
                    <td colspan="8">
                        <?= esc($slot->nama_istirahat) ?> (<?= substr($slot->jam_mulai,0,5) ?> - <?= substr($slot->jam_selesai,0,5) ?>)
                    </td>
                </tr>
                <?php else: ?>
                <tr>
                    <td><?= $slot->jam_ke ?></td>
                    <td><?= substr($slot->jam_mulai,0,5) ?> - <?= substr($slot->jam_selesai,0,5) ?></td>
                    
                    <?php foreach ($hari_list as $h): 
                        $d = $row['hari'][$h];
                    ?>
                    <td>
                        <?php if ($d && $d->mapel_id): ?>
                            <span class="mapel"><?= esc($d->nama_mapel) ?></span>
                            <?php if ($d->nama_guru): ?>
                                <span class="guru"><?= esc($d->nama_guru) ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,<br>Kepala Sekolah</p>
            <p><strong>_________________________</strong><br>NIP. ..............................</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
