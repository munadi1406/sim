<?php include __DIR__ . '/_nav.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-money-bill-wave mr-2 text-success"></i>Dashboard Pembayaran</h1>
    <a href="<?= base_url('admin/pembayaran/bayar') ?>" class="btn btn-success shadow-sm"><i class="fas fa-cash-register fa-sm mr-1"></i> Input Pembayaran</a>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto">
                <select name="bulan" class="form-control form-control-sm">
                    <option value="">Semua Bulan</option>
                    <?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>" <?= ($bulan==$i)?'selected':'' ?>><?= date('F',mktime(0,0,0,$i,1)) ?></option><?php endfor; ?>
                </select>
            </div>
            <div class="col-auto"><input type="number" name="tahun" class="form-control form-control-sm" placeholder="Tahun" value="<?= esc($tahun) ?>" style="width:90px;"></div>
            <div class="col-auto"><button type="submit" class="btn btn-success btn-sm"><i class="fas fa-filter"></i> Filter</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/pembayaran') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="row">
    <?php foreach ($rekap as $r): 
        $persen = $r->total_tagihan > 0 ? round(($r->total_lunas / $r->total_tagihan) * 100) : 0;
        $color = $persen >= 80 ? 'success' : ($persen >= 50 ? 'warning' : 'danger');
    ?>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-<?= $color ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-<?= $color ?> text-uppercase mb-1"><?= esc($r->jenis_nama) ?></div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto"><div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $persen ?>%</div></div>
                            <div class="col"><div class="progress progress-sm mr-2"><div class="progress-bar bg-<?= $color ?>" style="width:<?= $persen ?>%"></div></div></div>
                        </div>
                        <div class="small text-muted mt-2">
                            Lunas: <strong><?= $r->total_lunas ?></strong> / <?= $r->total_tagihan ?> |
                            Terbayar: <strong>Rp <?= number_format($r->total_terbayar,0,',','.') ?></strong>
                        </div>
                    </div>
                    <div class="col-auto"><i class="fas fa-wallet fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($rekap)): ?>
    <div class="col-12"><div class="alert alert-info">Belum ada data tagihan. <a href="<?= base_url('admin/pembayaran/generate') ?>">Generate tagihan</a> terlebih dahulu.</div></div>
    <?php endif; ?>
</div>
