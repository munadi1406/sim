<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= esc($no_invoice) ?></title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;font-size:13px;color:#333;padding:30px;background:#f5f5f5}
        .invoice-box{max-width:800px;margin:0 auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
        .header{display:flex;align-items:center;border-bottom:2px solid #1a237e;padding-bottom:20px;margin-bottom:20px}
        .header img{max-width:70px;margin-right:15px}
        .header-text h2{margin:0;font-size:20px;color:#1a237e}
        .header-text p{margin:2px 0;font-size:11px;color:#666}
        .invoice-title{text-align:center;margin:15px 0;font-size:16px;font-weight:bold;color:#1a237e}
        .invoice-meta{display:flex;justify-content:space-between;margin-bottom:20px}
        .invoice-meta div{width:48%}
        .invoice-meta table{width:100%;font-size:12px}
        .invoice-meta td{padding:3px 0;vertical-align:top}
        .invoice-meta td:first-child{width:110px;color:#666}
        table.data{width:100%;border-collapse:collapse;margin:20px 0}
        table.data th{background:#1a237e;color:#fff;padding:8px;font-size:11px;text-align:left}
        table.data td{padding:8px;border-bottom:1px solid #ddd;font-size:12px}
        .text-right{text-align:right}.text-center{text-align:center}
        .total-row{font-weight:bold;font-size:14px}
        .total-row td{border-top:2px solid #1a237e}
        .footer{margin-top:30px;text-align:center;font-size:11px;color:#666}
        .ttd{display:flex;justify-content:space-between;margin-top:60px}
        .ttd div{width:200px;text-align:center}
        .ttd .nama{margin-top:60px;font-weight:bold}
        .badge{display:inline-block;padding:3px 8px;border-radius:3px;font-size:10px;font-weight:bold}
        .badge-lunas{background:#d4edda;color:#155724}
        .btn-print{display:block;margin:20px auto 0;padding:10px 30px;background:#1a237e;color:#fff;border:none;border-radius:5px;cursor:pointer;font-size:14px}
        .btn-print:hover{background:#283593}
        @media print{
            body{background:#fff;padding:0}
            .invoice-box{box-shadow:none;padding:20px}
            .btn-print{display:none}
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header">
        <?php if (!empty($web->logo)): ?><img src="<?= base_url('uploads/'.$web->logo) ?>" alt="Logo"><?php endif; ?>
        <div class="header-text">
            <h2><?= esc($web->nama_sekolah ?? 'SIMS') ?></h2>
            <p><?= esc($web->alamat) ?></p>
            <p>Telp. <?= esc($web->no_kontak) ?> | <?= esc($web->email) ?></p>
        </div>
    </div>

    <div class="invoice-title">BUKTI PEMBAYARAN</div>

    <div class="invoice-meta">
        <div>
            <table>
                <tr><td>No. Invoice</td><td>: <strong><?= esc($no_invoice) ?></strong></td></tr>
                <tr><td>Tanggal Bayar</td><td>: <?= date('d/m/Y', strtotime($tanggal)) ?></td></tr>
                <tr><td>Metode</td><td>: <span class="badge badge-lunas"><?= esc($list[0]->metode == 'transfer' ? 'TRANSFER' : 'CASH') ?></span></td></tr>
                <tr><td>Petugas</td><td>: <?= esc($list[0]->petugas_nama ?? '-') ?></td></tr>
            </table>
        </div>
        <div>
            <table>
                <tr><td>Nama Siswa</td><td>: <strong><?= esc($list[0]->nama_siswa) ?></strong></td></tr>
                <tr><td>NIS</td><td>: <?= esc($list[0]->nis) ?></td></tr>
                <tr><td>Kelas</td><td>: <?= esc($list[0]->nama_kelas) ?> (<?= esc($list[0]->tingkat) ?>)</td></tr>
            </table>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr><th>No</th><th>Jenis</th><th>Periode</th><th>Jumlah</th></tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($list as $item): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($item->jenis_nama) ?></td>
                <td><?= date('F Y', mktime(0,0,0,$item->bulan,1,$item->tahun)) ?></td>
                <td class="text-right">Rp <?= number_format($item->jumlah_bayar, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL</td>
                <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <div class="ttd">
        <div>
            <p>Petugas,</p>
            <p class="nama"><?= esc($list[0]->petugas_nama ?? '') ?></p>
        </div>
        <div>
            <p>Penerima,</p>
            <p class="nama">&nbsp;</p>
        </div>
    </div>

    <div class="footer">Invoice ini sah dan dicetak secara elektronik. &copy; <?= date('Y') ?> <?= esc($web->nama_sekolah ?? 'SIMS') ?></div>
</div>

<button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Cetak Invoice</button>

</body>
</html>
