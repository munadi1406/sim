<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-money-bill-wave mr-2 text-success"></i>Dashboard Pembayaran</h1>
    <a href="<?= base_url('admin/pembayaran/bayar') ?>" class="btn btn-success shadow-sm"><i class="fas fa-cash-register fa-sm mr-1"></i> Input Pembayaran</a>
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
                            Lunas: <strong><?= $r->total_lunas ?></strong> / <?= $r->total_tagihan ?> tagihan |
                            Terbayar: <strong>Rp <?= number_format($r->total_terbayar, 0, ',', '.') ?></strong>
                        </div>
                    </div>
                    <div class="col-auto"><i class="fas fa-wallet fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($rekap)): ?>
    <div class="col-12"><div class="alert alert-info">Belum ada data tagihan bulan ini. <a href="<?= base_url('admin/pembayaran/generate') ?>">Generate tagihan</a></div></div>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-md-6"><a href="<?= base_url('admin/pembayaran/jenis') ?>" class="btn btn-outline-primary btn-sm btn-block"><i class="fas fa-cog"></i> Kelola Jenis Pembayaran</a></div>
    <div class="col-md-6"><a href="<?= base_url('admin/pembayaran/generate') ?>" class="btn btn-outline-success btn-sm btn-block"><i class="fas fa-sync"></i> Generate Tagihan Massal</a></div>
</div>
