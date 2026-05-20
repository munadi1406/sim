<?php include __DIR__ . '/_nav.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-chart-line mr-2 text-dark"></i>Laporan Pembayaran</h1>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto">
                <select name="bulan" class="form-control form-control-sm">
                    <option value="">Semua Bulan</option>
                    <?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>" <?= ($bulan_f==$i)?'selected':'' ?>><?= date('F',mktime(0,0,0,$i,1)) ?></option><?php endfor; ?>
                </select>
            </div>
            <div class="col-auto"><input type="number" name="tahun" class="form-control form-control-sm" placeholder="Tahun" value="<?= esc($tahun_f) ?>" style="width:90px;"></div>
            <div class="col-auto">
                <select name="kelas_id" class="form-control form-control-sm">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?><option value="<?= $k->id ?>" <?= ($kelas_f==$k->id)?'selected':'' ?>><?= esc($k->nama_kelas) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-dark btn-sm"><i class="fas fa-search"></i> Tampilkan</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/pembayaran/laporan') ?>" class="btn btn-light btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="row">
    <?php 
    $grand_total_tagihan = 0; $grand_total_terbayar = 0; $grand_total_lunas = 0; $grand_total_belum = 0;
    foreach ($rekap as $r):
        $grand_total_tagihan += $r->total_tagihan;
        $grand_total_terbayar += $r->total_terbayar;
        $grand_total_lunas += $r->total_lunas;
        $grand_total_belum += $r->total_belum;
        $persen = $r->total_tagihan > 0 ? round(($r->total_lunas / $r->total_tagihan) * 100) : 0;
        $c = $persen >= 80 ? 'success' : ($persen >= 50 ? 'warning' : 'danger');
    ?>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-<?= $c ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="h6 font-weight-bold"><?= esc($r->jenis_nama) ?></div>
                <div class="small">
                    <table class="w-100">
                        <tr><td>Tagihan</td><td class="text-right"><?= $r->total_tagihan ?></td></tr>
                        <tr><td>Lunas</td><td class="text-right text-success"><?= $r->total_lunas ?></td></tr>
                        <tr><td>Belum</td><td class="text-right text-danger"><?= $r->total_belum ?></td></tr>
                        <tr><td><strong>% Tuntas</strong></td><td class="text-right"><strong class="text-<?= $c ?>"><?= $persen ?>%</strong></td></tr>
                    </table>
                </div>
                <hr class="my-2">
                <div class="small">Total: <strong>Rp <?= number_format($r->total_nominal,0,',','.') ?></strong></div>
                <div class="small">Terbayar: <strong class="text-success">Rp <?= number_format($r->total_terbayar,0,',','.') ?></strong></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if (!empty($rekap)): ?>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="h6 font-weight-bold">Total Keseluruhan</div>
                <div class="small">
                    <table class="w-100">
                        <tr><td>Total Tagihan</td><td class="text-right"><?= $grand_total_tagihan ?></td></tr>
                        <tr><td>Lunas</td><td class="text-right text-success"><?= $grand_total_lunas ?></td></tr>
                        <tr><td>Belum</td><td class="text-right text-danger"><?= $grand_total_belum ?></td></tr>
                        <tr><td><strong>Terbayar</strong></td><td class="text-right"><strong class="text-primary">Rp <?= number_format($grand_total_terbayar,0,',','.') ?></strong></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if (empty($rekap)): ?>
<div class="alert alert-info">Pilih filter bulan/tahun/kelas untuk melihat laporan.</div>
<?php endif; ?>
